<?php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Nota.php");

class NotaMapper {
	
	private $db;
	/**
	* El contructor obtiene la conexion con la base de datos del core
	**/
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}
	
	/**save
	* Añade una nueva nota a la bbdd
	**/
	public function save($note) {
		$stmt = $this->db->prepare("SELECT idUsuario FROM usuario WHERE alias=?");
		$stmt->execute(array($_SESSION["currentuser"]));
		$fk_idUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($fk_idUsuario as $id){
		$stmtN = $this->db->prepare("INSERT INTO nota (titulo, contenido, fecha ,fk_idUsuario) values (?,?,?,?)");
		$stmtN->execute(array($note->getTitulo(), $note->getContenido(), $note->getFecha(), $id["idUsuario"]));
		}
	}

	/*getNoteByID
	* devuelve una nota a partir de un id
	*/
	public function getNoteByID($idNota){
		if(self::noteExists($idNota)){//comprobamos que la nota exista por seguridad
			$stmt = $this->db->prepare("SELECT * FROM nota WHERE idNota=?");
			$stmt->execute(array($idNota));
			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nota=$stmt["0"];
			return $nota=new Nota($nota["idNota"],$nota["titulo"],$nota["contenido"],$nota["fecha"],$nota["fk_idUsuario"]);//devuelvo la única nota con ese id
			}
			return NULL;
		}
	
	/*listNote
	* Obtiene una lista con las notas publicadas de ese usuario
	* Controla el tamaño del formulario para que no se desajuste el titulo en el legend
	* No se ha creado en un .js aparte por que sólo para eso no merecía la pena crear un .js
	*/
	public function listNote(){
		$stmt = $this->db->prepare("SELECT idUsuario FROM usuario WHERE alias=?");
		$stmt->execute(array($_SESSION["currentuser"]));
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$idUsuario=$stmt["0"];//id del usuario Actual
		//obtenemos todas las notas para ese usuario
		$stmt = $this->db->prepare("SELECT nota.* FROM nota,usuario WHERE fk_idUsuario=usuario.idUsuario AND usuario.idUsuario=?");
		$stmt->execute(array($idUsuario["idUsuario"]));
		$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$listaNotas=array();//lista con notas para ese usuario
		foreach($notas as $nota){
			if(strlen($nota["titulo"])>13){//para que no se desajuste el tamaño de formulario
				$titulo=substr($nota["titulo"], 0, 10)."...";
			}else{
				$titulo=$nota["titulo"];
			}
			array_push($listaNotas, new Nota($nota["idNota"],$titulo, $nota["contenido"], $nota["fecha"],$nota["fk_idUsuario"], $_SESSION["currentuser"]));
		}
		return $listaNotas;
	}

	/*listShare
	* Retorna una lista con las notas que un usurio ha compartido el usuario actural.
	*/
	public function listShare($idUsuario){
		$stmt = $this->db->prepare("SELECT fk_idNota FROM compartida WHERE fk_idUsuario=?");
		$stmt->execute(array($idUsuario));
		$idCompartidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$listaCompartidas=array();//lista con notas compartidas
		foreach ($idCompartidas as $id) {//recorreo los ids de las notas y las obtengo
			$stmt = $this->db->prepare("SELECT * FROM nota WHERE idNota=?");
			$stmt->execute(array(intval($id["fk_idNota"])));
			$compartida=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$compartida=$compartida["0"];//nota compartida con todos sus datos
			if(strlen($compartida["titulo"])>13){//para que no se desajuste el tamaño de formulario
				$titulo=substr($compartida["titulo"], 0, 10)."...";
			}else{
				$titulo=$compartida["titulo"];
			}//guardo la nota en una lista
			array_push($listaCompartidas, new Nota($compartida["idNota"],$titulo, $compartida["contenido"], $compartida["fecha"],$compartida["fk_idUsuario"], self::getAutor($compartida["idNota"])));
		}
		return $listaCompartidas;
	}

	/*editar
	* Permite editar el titulo y el contenido de una nota
	* No se podrá editar la fecha, el autor o el id
	* Es necesario que la nota exista y seamos el autor
	*/
	public function editar($nota){
		if(self::noteExists($nota->getIdNota()) && self::permisoNota($nota->getIdNota())){
			$stmt=$this->db->prepare("UPDATE nota SET titulo=?, contenido=? WHERE idNota=?");
			$stmt->execute(array($nota->getTitulo(),$nota->getContenido(),$nota->getIdNota()));
			return true;
		}
		return false;
	}

	/*compartir
	* Permite compartir una nota con un usuario
	* Es necesario que la nota exista y ser el propietario para poder compartirla
	*/
	public function compartir($idUsuario, $idNota){
		if(self::noteExists($idNota) && self::permisoNota($idNota)){
			$stmt=$this->db->prepare("INSERT INTO compartida(fk_idUsuario,fk_idNota ) VALUES(?,?)");
			$stmt->execute(array(intval($idUsuario),intval($idNota)));
			return true;
		}
		return false;
	}
	
	/*drop
	* Elimina una nota en la bbdd
	* Es necesario ser el autor
	**/
	public function drop($idNota) {
		if(self::permisoNota($idNota)){
			$stmt = $this->db->prepare("DELETE FROM nota WHERE idNota =?");
			$stmt->execute(array($idNota));
			return true;
		}
		return false;
	}

	/* getAutor
	* Obtiene el Alias del autor de una nota pasandole el id de la nota
	*/
	private function getAutor($idNota){
		$stmt=$this->db->prepare("SELECT fk_idUsuario FROM nota WHERE idNota=?");
		$stmt->execute(array($idNota));
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);//id usuario de la nota
		$idPropietario=$stmt["0"];//id del propietario de la nota
		$stmt=$this->db->prepare("SELECT alias FROM usuario WHERE idUsuario=?");
		$stmt->execute(array(intval($idPropietario["fk_idUsuario"])));
		$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);//alias usuario $autor=de la nota
		$autor=$stmt["0"];
		return $autor["alias"];
	}
	
	/**noteExists
	* comprueba si la nota existe
	**/
	private function noteExists($idNota) {
		$stmt = $this->db->prepare("SELECT count(idNota) FROM nota where idNota=?");
		$stmt->execute(array($idNota));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
		return false;
	}

	/*permisoNota
	* Es una funcion privada
	* Sólo se llama desde la propia clase
	* Devuelve true si el autor de una nota es el actual
	* Es necesario estar logeado en el sistema si no se dará por supuesto que no es el autor
	*/
	private function permisoNota($idNota){
		if(isset($_SESSION["currentuser"])){
			$stmt = $this->db->prepare("SELECT fk_idUsuario FROM nota WHERE idNota=?");
			$stmt -> execute(array($idNota));
			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);//id usuario de la nota
			$stmt2 = $this->db->prepare("SELECT idUsuario FROM usuario WHERE alias=?");
			$stmt2->execute(array($_SESSION["currentuser"]));
			$stmt2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);//id usuario actual
			$idPropietario=$stmt["0"];//id del propietario de la nota
			$idUsuario=$stmt2["0"];//id del usuario Actual
			if ($idUsuario["idUsuario"]==$idPropietario["fk_idUsuario"]) {
				return true;
			}
		}
		return false;
	}
}
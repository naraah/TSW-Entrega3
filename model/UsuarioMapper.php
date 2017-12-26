<?php

require_once(__DIR__."/../core/PDOConnection.php");

class UsuarioMapper {

	private $db;
	/**
	*el contructor obtiene la conexion con la base de datos del core
	**/
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}
	/**
	*A�ade un nuevo usuario en la bbdd
	**/
	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO usuario (nombre,apellidos,alias,password) values (?,?,?,?)");
		$stmt->execute(array($user->getNombre(), $user->getApellidos(), $user->getAlias(), $user->getPassword()));
	}
	/**
	*Elimina un usuario en la bbdd
	**/
	public function drop($user) {
		$stmt = $this->db->prepare("DELE FROM usuario WHERE idUsuario=?");
		$stmt->execute(array($user->getUsername(), $user->getPasswd()));
	}
	/**
	* comprueba si el alias existe
	**/
	public function userAliasExists($alias) {
		$stmt = $this->db->prepare("SELECT count(alias) FROM usuario where alias=?");
		$stmt->execute(array($alias));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/*getAlias
	* Obtiene todos los alias de los usuarios menos del usuario actual
	* Cualquier usuario del sistema podra compartir con los demas sus notas
	* No se ha pensado en retringir a los usuarios, todos son publicos para no complicar la l�gica
	*/
	public function getAlias(){
		$stmt = $this->db->prepare("SELECT alias FROM usuario WHERE alias<>? ");
		$stmt->execute(array($_SESSION["currentuser"]));
		$listaAlias = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $listaAlias;
	}

	/*getAliasCompartirNota
	* Devuelveuna lista con los usuarios con los que no se compartio esa nota
	* Es necesario pasarle el id de la nota
	*/
	public function getAliasCompartirNota($idNota){
		$stmt = $this->db->prepare("SELECT fk_idUsuario FROM compartida WHERE fk_idNota=? ");
		$stmt->execute(array($idNota));
		//los id de los usuarios con los que se compartio la nota
		$yaCompartida = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$aliasNoCompartir=array();//tendra los alias con los que no compartir la nota
		foreach($yaCompartida as $id){
			$stmt = $this->db->prepare("SELECT alias FROM usuario WHERE idUsuario=? ");
			$stmt->execute(array($id["fk_idUsuario"]));
			$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
			array_push($aliasNoCompartir,$stmt[0]["alias"]);
		}
		$listaAlias=self::getAlias();//todos los usuarios del sistema
		$lista=array();//donde se guardara la lista de alias con los que se puede compartir la nota
		foreach($listaAlias as $alias){//se comprueba si ese usuario tiene compartida la nota
			$bool=true;//si es true se puede compartir la nota con ese usuario
			foreach ($aliasNoCompartir as $compartida) {
				if($compartida == $alias["alias"] ){
					$bool=false;//si es false no se puede compartir la nota
				}
			}
			if($bool){//si no estaba compartida con ese alias lo añado a la lista
				array_push($lista,$alias);
			}
		}
		return $lista;//lista con los alias de los usuarios con los que se puede compartir la nota
	}

	/*getIdByAlias
	* Devuelve el id de un usuario buscandolo por el alias
	* En el sistema no puede haber mas de un usuario con el mismo alias
	*/
	public function getIdByAlias($idUsuario){
		$stmt = $this->db->prepare("SELECT idUsuario FROM usuario WHERE alias=?");
		$stmt->execute(array($idUsuario));
		$id = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return ($id["0"])["idUsuario"];
	}

	/**
	*compruba si existe el alias y la contrase�a de un susuario
	*/
	public function isValidUser($alias, $password) {
		$stmt = $this->db->prepare("SELECT count(alias) FROM usuario where alias=? and password=?");
		$stmt->execute(array($alias, $password));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}
}

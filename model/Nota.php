<?php
require_once(__DIR__."/../core/ValidationException.php");


class Nota {

	private $idNota;
	private $titulo;
	private $contenido;
	private $fecha;
	//La clave foránea
	private $idUsuario;
	private $nombreAutor;

	public function __construct($idNota=NULL, $titulo=NULL, $contenido=NULL, $fecha=NULL, $idUsuario=NULL, $nombreAutor=NULL) {
		$this->idNota = $idNota;
		$this->titulo = $titulo;
		$this->contenido = $contenido;
		$this->fecha = $fecha;
		$this->idUsuario=$idUsuario;
		$this->nombreAutor=$nombreAutor;
	}

	public function getIdNota() {
		return $this->idNota;
	}
	
	public function getTitulo() {
		return $this->titulo;
	}
	
	public function getContenido() {
		return $this->contenido;
	}
	
	public function getFecha() {
		return $this->fecha;
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function getAutor() {
		return $this->nombreAutor;
	}
	
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	
	public function setContenido($contenido) {
		$this->contenido = $contenido;
	}
	
	public function setFecha($fecha) {
		$this->fecha = $fecha;
	}
	
	public function setIdUsuario(){
		$this->idUsuario = $idUsuario;
	}

	public function setAutor($nombreAutor){
		$this->nombreAutor = $nombreAutor;
	}
	
	public function checkIsValidForUpdate() {
		$errors = array();
		if (!isset($this->idNota)) {
			$errors["idNota"] = "El id es obligatorio";
			throw new ValidationException($errors, "Nota no válida");
		}
	}
}
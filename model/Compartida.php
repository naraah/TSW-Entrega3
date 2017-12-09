<?php
require_once(__DIR__."/../core/ValidationException.php");

class Nota {

	private $idCompartida;
	//Las claves foráneas
	private $idUsuario;
	private $idNota;

	public function __construct($idCompartida=NULL, Usuario $idUsuario=NULL, Nota $idNota=NULL) {
		$this->idCompartida = $idCompartida;
		$this->idUsuario = $idUsuario;
		$this->idNota = $idNota;
	}

	public function getIdCompartida() {
		return $this->idCompartida;
	}
	
	public function getIdUsuario() {
		return $this->idUsuario;
	}
	
	public function getIdNota() {
		return $this->idNota;
	}
	
	public function setIdCompartida($idCompartida) {
		$this->idCompartida = $idCompartida;
	}
	
	public function setIdUsuario(Usuario $idUsuario) {
		$this->idUsuario = $idUsuario;
	}
	
	public function setIdNota(Nota $idNota) {
		$this->idNota = $idNota;
	}
	
		public function checkIsValidForUpdate() {
		$errors = array();
		if (!isset($this->idCompartida)) {
			$errors["idCompartida"] = "El id es obligatorio";
		}
		try{
			$this->checkIsValidForCreate();
		}catch(ValidationException $ex) {
			foreach ($ex->getErrors() as $key=>$error) {
				$errors[$key] = $error;
			}
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException($errors, "No se puede compartir");
		}
	}
}
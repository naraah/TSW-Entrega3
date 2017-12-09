<?php
require_once(__DIR__."/../core/ValidationException.php");

class Usuario {

	private $idUsuario;
	private $nombre;
	private $apellidos;
	private $alias;
	private $password;

	public function __construct($idUsuario=NULL, $nombre=NULL, $apellidos=NULL, $alias=NULL, $password=NULL) {
		$this->idUsuario = $idUsuario;
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->alias = $alias;
		$this->password = $password;
	}

	public function getIdUsuario() {
		return $this->idUsuario;
	}
	
	public function getNombre() {
		return $this->nombre;
	}
	
	public function getApellidos() {
		return $this->apellidos;
	}
	
	public function getAlias() {
		return $this->alias;
	}
	
	public function getPassword() {
		return $this->password;
	}

	public function setIdUsuario($idUsuario) {
		$this->idUsuario = $idUsuario;
	}
	
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	
	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}
	
	public function setAlias($alias) {
		$this->alias = $alias;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	* Comprueba que el usuario sea valido
	*
	* @throws ValidationException 
	*
	* @return void
	*/
	public function checkIsValidForRegister() {
		$errors = array();
		if (strlen($this->alias) < 4) {
			$errors["alias"] = "El alias debe tener mas de 5 caracteres";
		}
		if (strlen($this->password) < 4) {
			$errors["password"] = "La password debe tener mas de 5 caracteres";
		}
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "Usuario no valido");
		}
	}
}
?>
<?php

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
* Class UsuarioRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class UsuarioRest extends BaseRest {
	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UsuarioMapper();
	}

	public function getUsuarios($idNota) {
	        $currentUser = parent::authenticateUser();

	        $users = $this->userMapper->findAll($currentUser,$idNota);

	        $users_array = array();
	        foreach($users as $user) {
	            array_push($users_array, array(
	                "idUsuario" => $user->getIdUsuario(),
	                "alias" => $user->getAlias()
	            ));
	        }

	        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
	        header('Content-Type: application/json');
	        echo(json_encode($users_array));
	    }

	public function notaUsuario($data) {
		$user = new Usuario($data->alias, $data->nombre, $data->apellidos, $data->password);
		try {
			$user->checkIsValidForRegister();

			$this->userMapper->save($user);

			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			header("Location: ".$_SERVER['REQUEST_URI']."/".$data->alias);
		}catch(ValidationException $e) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function login($alias) {
		$currentLogged = parent::authenticateUser();
		if ($currentLogged->getAlias() != $alias) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to login as anyone but you");
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
			echo("Hello ".$alias);
		}
	}
}

// URI-MAPPING for this Rest endpoint
$userRest = new UsuarioRest();
URIDispatcher::getInstance()
->map("GET",	"/usuario/$1", array($userRest,"login"))
->map("GET", "/usuarios/$1", array($userRest,"getUsusarios"))
->map("POST", "/usuario", array($userRest,"notaUsuario"));

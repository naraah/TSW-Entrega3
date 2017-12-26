<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
*Controller to users, logout and user registration
**/
class UsuarioController extends BaseController {

	private $UsuarioMapper;

	/**
	* Obtiene la conexion
	* Crea el mapper del usuario
	**/
	public function __construct() {
		parent::__construct();/*llama al contructor pade 'BaseController de gestion de la sesion*/
		$this->UsuarioMapper = new UsuarioMapper();
		// different to the "default" layout where the internal
	}

	public function login() {
		if(isset($_POST["alias"]) && isset($_POST["password"])){
				if($this->UsuarioMapper->isValidUser($_POST["alias"],$_POST["password"])){
					$_SESSION["currentuser"]=$_POST["alias"];
					$this->view->redirect("Notas","listarNotas");
				}else{
					$this->view->setFlash("NOTICE: "." The user/password not exits");
				}
		}
		$this->view->render("users", "logIn");
	}

	public function register() {
		$user = new Usuario();
		if (isset($_POST["alias"])){
			$user->setNombre($_POST["nombre"]);
			$user->setApellidos($_POST["apellidos"]);
			$user->setAlias($_POST["alias"]);
			$user->setPassword($_POST["password"]);
				try{
				$user->checkIsValidForRegister();
					if (!$this->UsuarioMapper->userAliasExists($_POST["alias"])){
						// save the User object into the database
						$this->UsuarioMapper->save($user);
						$this->view->setFlash("The user ".$user->getAlias()." successfully added.");
						$this->view->redirect("Usuario", "login");
					} else {
						$errors = array();
						$errors["username"] = "Username already exists";
						$this->view->setFlash("errors: ".$errors["username"]);
					}
				}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		// Put the User object visible to the view
		$this->view->setVariable("user", $user);
		// render the view (/view/users/register.php)
		$this->view->render("users", "registroUsuario");
	}

	public function logout() {
		session_destroy();
		$this->view->redirect("main", "index");
	}
}
?>

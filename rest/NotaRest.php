<?php

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");

require_once(__DIR__."/../model/Nota.php");
require_once(__DIR__."/../model/NotaMapper.php");

require_once(__DIR__."/../model/Compartida.php");

require_once(__DIR__."/BaseRest.php");

/**
* Class PostRest
*
* It contains operations for creating, retrieving, updating, deleting and
* listing posts, as well as to create comments to posts.
*
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class NotaRest extends BaseRest {
	private $notaMapper;

	public function __construct() {
		parent::__construct();

		$this->$notaMapper = new NotaMapper();
	}

	public function getNotas() {
		$notas = $this->notaMapper->listNote();

		// json_encode Post objects.
		// since Post objects have private fields, the PHP json_encode will not
		// encode them, so we will create an intermediate array using getters and
		// encode it finally
		$posts_array = array();
		foreach($notas as $nota) {
			array_push($posts_array, array(
				"idNota" => $nota->getIdNota(),
				"titulo" => $nota->getTitulo(),
				"contenido" => $nota->getContenido(),
        "fecha" => $nota->getFecha(),
				"usuario" => $nota->getAutor()
			));
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($posts_array));
	}

	public function crearNota($data) {
		$currentUser = parent::authenticateUser();
		$nota = new Nota();

		if (isset($data->titulo) && isset($data->contenido)) {
			$nota->setTitulo($data->titulo);
			$nota->setContenido($data->contenido);
      $nota->setFecha($data->fecha);

			$nota->setAutor($currentUser);
		}

		try {
			// validate Post object
			$nota->checkIsValidForCreate(); // if it fails, ValidationException

			// save the Post object into the database
			$idNota = $this->notaMapper->save($note);

			// response OK. Also send post in content
			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			header('Location: '.$_SERVER['REQUEST_URI']."/".$idNota);
			header('Content-Type: application/json');
			echo(json_encode(array(
				"idNota"=>$idNota,
				"titulo"=>$nota->getTitulo(),
				"contenido" => $nota->getContenido(),
        "fecha" => $nota->getFecha()
			)));

		} catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function readNota($idNota) {
		// find the Post object in the database
		$nota = $this->notaMapper->getNoteByID($idNota);
		if ($nota == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$idNota." not found");
		}

		$post_array = array(
			"idNota" => $nota->getIdNota(),
			"titulo" => $nota->getTitulo(),
			"contenido" => $nota->getContenido(),
			"usuario" => $nota->getAutor()

		);

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($post_array));
	}

	public function updateNota($postId, $data) {
		$currentUser = parent::authenticateUser();

			$post = $this->notaMapper->editar($nota);
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		}catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function deleteNota($idNota) {
		$currentUser = parent::authenticateUser();
		$nota = $this->notaMapper->getNoteByID($idNota);

		if ($nota == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Nota with id ".$nota." not found");
			return;
		}
		// Check if the Post author is the currentUser (in Session)
		if ($nota->getAutor() != $currentUser) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this post");
			return;
		}

		$this->notaMapper->delete($nota);

		header($_SERVER['SERVER_PROTOCOL'].' 204 No Content');
	}

}

// URI-MAPPING for this Rest endpoint
$notaRest = new NotaRest();
URIDispatcher::getInstance()
->map("GET",	"/nota", array($notaRest,"getNotas"))
->map("GET",	"/nota/$1", array($notaRest,"readNota"))
->map("POST", "/nota", array($notaRest,"createNota"))
->map("PUT",	"/nota/$1", array($notaRest,"updateNota"))
->map("DELETE", "/nota/$1", array($notaRest,"deleteNota"));

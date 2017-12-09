<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$nota = $view->getVariable("nota");
$alias=$view->getVariable("alias");
?>
<!doctype html>
<html>
<body>
<div id="contenedor">
	<section>
			<article>
				<meta charset="utf-8">
				<link rel="stylesheet" href="./css/formularios.css">
				<title>registroUsuario</title>
			</article>
			<div class="container">
				<form class="formCrearNota" action="">
					<fieldset>
							<legend align="center"><h1><span class="icon-eye2"></span><?= i18n("Ver Nota")?></h1></legend>
							<div class="form">
							<div class="formDatos">
								<label class="labelId"><span class="icon-npm"></span><?= i18n("Id. Nota")?> <?=$nota->getIdNota()?></label>
								<label class="labelAutor"><span class="icon-id-card"></span><?= i18n("Autor")?><?=$alias?></label>
								<label class="labelFecha"><span class="icon-sun-o"></span><?= i18n("Fecha")?> <?=$nota->getFecha()?></label>
								<input class="inputTitulo" type="text" placeholder="Título" readonly value="<?=$nota->getTitulo()?>">
								<textarea class="inputContenido" type="text" readonly> <?= $nota->getContenido()?></textarea>
					</fieldset>
				</form>
			</div>
	</section>
</div>
</body>
</html>

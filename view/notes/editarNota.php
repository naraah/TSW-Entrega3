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
				<form class="formEditarNota" action="index.php?controller=Notas&amp;action=editar" method="POST">
					<fieldset>
						<label class="labelId"><span class="icon-npm"></span><?= i18n("Id. Note ")?> <?=$nota->getIdNota()?></label>
						<label class="labelAutor"><span class="icon-id-card"></span><?= i18n("Alias ")?> <?=$alias?></label>
						<label class="labelFecha"><span class="icon-sun-o"></span><?= i18n("Date ")?> <?=$nota->getFecha()?></label>
						<input class="inputidNota" name="idNota" type="text" hidden="true" required="true" value="<?=$nota->getIdNota()?>">
						<input class="inputTitulo" name="titulo" type="text" placeholder="Título" required="true" value="<?=$nota->getTitulo()?>">
						<textarea class="inputContenido" name="contenido" type="text" required="true"> <?= $nota->getContenido()?></textarea>
						<div class="btnForm">
							<input class="btnSubmit" type="submit" value="<?= i18n("Edit")?>">
						</div>
					</fieldset>
				</form>
			</div>
	</section>
</div>
</body>
</html>

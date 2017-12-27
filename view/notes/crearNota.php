<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$listaAlias = $view->getVariable("listaAlias");
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
				<form class="formCrearNota" action="index.php?controller=Notas&amp;action=nueva" method="POST">
					<fieldset>
							<legend align="center"><h1><span class="icon-file-symlink-file"></span><?= i18n("Create Note")?></h1></legend>
							<div class="form">
							<input class="inputTitulo" type="text" name="titulo" placeholder="<?= i18n("Title")?>" required>
							<textarea class="inputContenido" type="text" name="contenido" placeholder="<?= i18n("Content")?>" required></textarea>
							</div>
							<div class="btnForm">
								<input class="btnSubmit" type="submit" value="<?= i18n("Create")?>">
								<input class="btnReset" type="reset" value="<?= i18n("Clear")?>">
							</div>
							<div class="btnForm">
								 <a href="index.php?controller=Notas&amp;action=listarNotas"><input class="btnCancel" value="<?= i18n("Cancel")?>">
							</div>
					</fieldset>
				</form>
			</div>
	</section>
</div>
</body>
</html>

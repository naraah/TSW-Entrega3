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
							<legend align="center"><h1><span class="icon-file-symlink-file"></span><?= i18n("Crear Nota")?></h1></legend>
							<div class="form">
							<input class="inputTitulo" type="text" name="titulo" placeholder="<?= i18n("Título")?>" required>
							<textarea class="inputContenido" type="text" name="contenido" placeholder="<?= i18n("Contenido")?>" required></textarea>
							</div>
							 <select multiple>
							 	<?php foreach($listaAlias as $alias) { ?>
							 		<option value="<?=$alias["alias"] ?>"><?= $alias["alias"] ?></option>
							 	<?php }?>
							</select>
							<div class="btnForm">
								<input class="btnSubmit" type="submit" value="<?= i18n("Crear")?>">
								<input class="btnReset" type="reset" value="<?= i18n("Limpiar")?>">
							</div>
					</fieldset>
				</form>
			</div>
	</section>
</div>
</body>
</html>

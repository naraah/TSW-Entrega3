<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$listaNotas = $view->getVariable("listaCreadas");
$listaCompartidas = $view->getVariable("listaCompartidas");
$creadas = $view->getVariable("creadas");
$compartidas = $view->getVariable("compartidas");
?>
<body>
	<div id="contenedor">
		<section>
				<article>
					<meta charset="utf-8">
					<link rel="stylesheet" href="./css/formularios.css">
					<title>registroUsuario</title>
				</article>
				<div class="container">
					<div class="tituloListar"><h1><?= i18n("Published Notes")?></h1></div>
					<div id="creadas"><?=$creadas?></div>
					<?php if(!empty($listaNotas)){
						foreach($listaNotas as $nota){
					?>
						<form class="formListarNota" action="index.php?controller=Notas&amp;action=listarNotas" method="POST">
							<fieldset>
									<legend align="center"><h1> <?=$nota->getTitulo()?></h1></legend>
									<div class="form">
										<label class="labelId"><span class="icon-npm"></span><?= i18n("Id. Note ")?> <?=$nota->getIdNota()?></label>
										<label class="labelAutor"><span class="icon-id-card"></span><?= i18n("Author ")?> <?=$nota->getAutor()?></label>
										<label class="labelFecha"><span class="icon-sun-o"></span><?= i18n("Date ")?> <?=$nota->getFecha()?></label>
										<textarea class="inputContenido" type="text" readonly> <?= $nota->getContenido()?></textarea>
									</div>
									<div class="btnOpcionesNotas">
										<a class="btnVer" href='./index.php?controller=Notas&amp;action=verNota&amp;idNota=<?php echo $nota->getIdNota() ?>'><span class="icon-eye2"></span>
										</a>
										<a class="btnEditar" href='./index.php?controller=Notas&amp;action=editar&amp;idNota=<?php echo $nota->getIdNota() ?>'><span class="icon-pencil22"></span>
										</a>
										<a class="btnCompartir" href='./index.php?controller=Notas&amp;action=compartir&amp;idNota=<?php echo $nota->getIdNota() ?>'><span class="icon-share-alt"></span>
										</a>
										<a class="btnEliminar" href='./index.php?controller=Notas&amp;action=eliminarNotas&amp;idNota=<?php echo $nota->getIdNota() ?>'><span class="icon-trash"></span>
										</a>
									</div>
							</fieldset>
						</form>
					<?php }
					}?>
					<div><h1><?= i18n("Shared Notes")?></h1></div>
					<div id="compartidas"><?=$compartidas?></div>
					<?php if(!empty($listaCompartidas)){
						foreach($listaCompartidas as $compartida){
					?>
						<form class="formListarNota" action="index.php?controller=Notas&amp;action=listarNotas" method="POST">
							<fieldset>
									<legend align="center"><h1> <?=$compartida->getTitulo()?></h1></legend>
									<div class="form">
										<label class="labelId"><span class="icon-npm"></span><?= i18n("Id. Note")?><?=$compartida->getIdNota()?></label>
										<label class="labelAutor"><span class="icon-id-card"></span><?= i18n("Author")?> <?=$compartida->getAutor()?></label>
										<label class="labelFecha"><span class="icon-sun-o"></span><?= i18n("Date")?><?=$compartida->getFecha()?></label>
										<textarea class="inputContenido" type="text" readonly> <?= $compartida->getContenido()?></textarea>
									</div>
									<div class="btnOpcionesNotas">
										<a class="btnVer" href='./index.php?controller=Notas&amp;action=verNotaCompartida&amp;idNota=<?php echo $compartida->getIdNota() ?>'><span class="icon-eye2"></span>
										</a>
										<a class="btnEliminar" href='./index.php?controller=Notas&amp;action=deleteCompartida&amp;idNota=<?php echo $compartida->getIdNota() ?>'><span class="icon-trash"></span>
										</a>
									</div>
							</fieldset>
						</form>
					<?php }
					}?>
				</div>
		</section>
	</div>
</body>

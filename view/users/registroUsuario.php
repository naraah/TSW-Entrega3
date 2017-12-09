<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="./css/formularios.css">
		<title>registroUsuario</title>
	</head>
		<body>
			<div class="container">
				<form class="formRegister" action="index.php?controller=Usuario&amp;action=register" method="POST">
					<fieldset class="fieldSingIn">
							<legend align="center"><h1><span class="icon-file-media"></span><?= i18n("Registro")?></h1></legend>
							<div class="form">
							<input class="input" type="text" name="nombre" placeholder="&#128100; <?= i18n("Nombre")?>" autofocus required>
							<input class="input" type="text" name="apellidos" placeholder="&#128100; <?= i18n("Apellidos")?>" required>
							<input class="input" type="text" name="alias" placeholder="&#9772; <?= i18n("Alias")?>" required autofocus>
							<input class="input" type="password" name="password" placeholder="&#9919; <?= i18n("Contraseña")?>" required>
							</div>
							<div class="btnForm">
								<input class="btnSubmit" type="submit" value="<?= i18n("Registrar")?>">
								<input class="btnReset" type="reset" value="<?= i18n("Borrar")?>">
							</div>
					</fieldset>
				</form>
			</div>
		</body>
</body>
</html>

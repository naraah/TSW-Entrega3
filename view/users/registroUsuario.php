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
							<legend align="center"><h1><span class="icon-file-media"></span><?= i18n("Sing in")?></h1></legend>
							<div class="form">
							<input class="input" type="text" name="nombre" placeholder="&#128100; <?= i18n("Name")?>" autofocus required>
							<input class="input" type="text" name="apellidos" placeholder="&#128100; <?= i18n("Surname")?>" required>
							<input class="input" type="text" name="alias" placeholder="&#9772; <?= i18n("Alias")?>" required autofocus>
							<input class="input" type="password" name="password" placeholder="&#9919; <?= i18n("Password")?>" required>
							</div>
							<div class="btnForm">
								<input class="btnSubmit" type="submit" value="<?= i18n("Sing in")?>">
								<input class="btnReset" type="reset" value="<?= i18n("Delete")?>">
							</div>
					</fieldset>
				</form>
			</div>
		</body>
</body>
</html>

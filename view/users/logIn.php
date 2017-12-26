<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="./css/formularios.css">
		<title>registroUsuario</title>
	</head>
		<body>
			<div class="container">
				<div class="logIn">
					<form class="formRegister" action="index.php?controller=Usuario&amp;action=login" method="POST">
					<fieldset>
							<legend align="center"><h1><span class="icon-file-media"></span><?= i18n("Login")?></h1></legend>
							<div class="formLogin">
								<input class="input" type="text" name="alias" placeholder="&#9919; <?= i18n("Alias")?>" autofocus required>
								<input class="input" type="password" name="password" placeholder="&#9919; <?= i18n("Password")?>" required>
							</div>
							<div class="btnForm">
								<input class="btnSubmit" type="submit" value="<?= i18n("Accept")?>">
								<input class="btnReset" type="reset" value="<?= i18n("Delete")?>">
							</div>
					</fieldset>
				</form>
				</div>
			</div>
		</body>
</html>

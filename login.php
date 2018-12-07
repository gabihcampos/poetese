<?php
	$msgemail = $msgusername = $msglogin = $msgcadastro = $msgerro = null;

	if(isset($_POST['email'])){
		require('acao_login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/grid.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset="UTF-8">
	<title>Cadastre-se ou entre</title>
</head>
<body>
	<div class="logincadastro">
			<div class="cadastro grid-8">
				<form name="form1" method="post" class="form1">
					nome <br> <input type="text" name="nome" required> <br>

					data de nascimento <br> <input type="date" name="data_nascimento" required/> <br>

					nome de usuário <br> <input type="text" name="username" required> <br>

					email <br> <input type="email" name="email" required> <br>

					senha <br> <input type="password" name="senha" required> <br>

					confirmar senha <br> <input type="password" name="conf_senha" required> <br>

					<input type="submit" value="cadastrar-se →">
				</form>

				<?=$msgemail;?>
				<?=$msgusername;?>
				<?=$msgerro?>
				<?=$msgcadastro?>
			</div>
			<div class="login grid-8">
				<form name="form2" method="post" class="form2">
					email <br> <input type="email" name="email" required> <br>

					senha <br> <input type="password" name="senha" required> <br>

					<input type="submit" value="entrar →">
				</form>

				<?=$msglogin?>
			</div>
		</div>
</body>
</html>
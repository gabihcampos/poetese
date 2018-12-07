<?php
	if(isset($_POST['sugestao']) || isset($_POST['duvida'])){
		require('acao_duv_ou_sug.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dúvidas ou Sugestões</title>
</head>
<body>
	<?php if(isset($_SESSION['email'])){
	 ?>
		<div class="container">

			<div class="grid-8">
				<h4>Alguma dúvida?</h4>
				<form action="mailto:contatopoetese@gmail.com" method="post" enctype="text/plain">
				<!-- Name:<br>
				<input type="text" name="name"><br>
				E-mail:<br>
				<input type="text" name="mail"><br> -->
				Pergunte aqui:<br>
				<textarea name="Pergunta " required></textarea>
				<input type="submit" value="Send">
				<input type="reset" value="Reset">
				</form>
			<!-- <h4>Alguma dúvida?</h4>
			<form name="form_duv" method="post">
				<input type="text" id="duvida" name="duvida" required>
				<input type="submit" id="submit" value="Enviar">
			</form> -->
		</div>
		<div class="grid-8">
			<h4>Sugestões</h4>
			<form name="form_sug" method="post">
				<input type="text" id="sugestao" name="sugestao" required>
				<input type="submit" id="submit" value="Enviar">
			</form>
		</div>
	<?php
		}else{
	?>
	Para nos contatar, você precisa se identificar.
	<br><br>
	Já tem uma conta? Sim. Não.

	<?php } ?>
</body>
</html>
<?php
	$comentario = $_POST['comentario'];

	if (isset($_SESSION['email'])) {
		$poe_id = $_GET['poe_id'];
		$email = $_SESSION['email'];

		$usu_id = "SELECT usu_id FROM usuario WHERE email = '$email'";
		$usu_id = mysqli_query($con, $usu_id);
		$usu_id = mysqli_fetch_array($usu_id);
		$usu_id = $usu_id['usu_id'];

		$sql = "INSERT INTO comentario(com_texto, usu_id, poe_id) 
						VALUES('$comentario', '$usu_id', '$poe_id')";
		mysqli_query($con, $sql) or die("Não foi possível salvar seu comentário");
	}else{
		echo "Faça login para comentar.";
	}
	
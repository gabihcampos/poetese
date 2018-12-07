<?php
	require('conexao/acao-gostar.php');

	$poe_id = $_POST['poe_id'];
	$email = $_SESSION['email'];
	$sql = "SELECT usu_id FROM usuario WHERE email = " . $email;
	$usu_id = mysqli_query($con, $sql);
	$usu_id = mysqli_fetch_array($usu_id);
	$usu_id = $usu_id['usu_id'];

	$sql = "SELECT gostar FROM avaliacao WHERE poe_id = " . $poe_id;
	$gostar = mysqli_query($con, $sql);
	$gostar = mysqli_fetch_array($gostar);
	$gostar = $gostar['gostar'];

	if ($gostar == 1) {
		$gostar = 0;
	}

	$sql = "INSERT INTO avaliacao(gostar, usu_id, poe_id)
	VALUES ('$gostar', '$usu_id', '$poe_id')";
	mysqli_query($con, $sql) or die("Desculpe, não foi possível avaliar.");
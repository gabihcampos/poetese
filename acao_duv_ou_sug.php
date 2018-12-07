<?php
	$email = $_SESSION['email'];
	$sql = "SELECT nome FROM usuario WHERE email = '$email'";
	$nome = mysqli_query($con, $sql);
	$nome = mysqli_fetch_array($nome);
	$nome = $nome['nome'];

	$para = "contatopoetese@gmail.com";
	$email_headers = implode ( "\n",array ( "From: $email", "Reply-To: $email", "Return-Path: $email","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );

	if(isset($_POST['sugestao'])){ //se o usuário quiser enviar uma sugestão
		$sug = $_POST['sugestao'];
		$assunto = "Sugestão";
		$texto = $sug;
	}else{
		$duv = $_POST['duvida'];
		$assunto = "Dúvida";
		$texto = $duv;
	}
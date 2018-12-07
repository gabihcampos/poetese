<?php
	require_once('conexao/conecta.php');

	if(empty($_POST['nome'])){ // quer dizer que a pessoa quer logar
		$email = $_POST['email'];
		$senha = $_POST['senha'];

		$sql = "SELECT * FROM usuario
		WHERE email = '$email' AND senha = md5('$senha')";

		$result = mysqli_query($con, $sql) or die("Houve um problema no banco de dados.");

		if($login = mysqli_fetch_array($result)){
			$_SESSION['email'] = $email;
			$_SESSION['senha'] = md5('$senha');

			$msglogin = "Você está logado.";
			header('Location: /poetese');
		}else{
			$msglogin = "Os dados não coincidem.";
			unset($_SESSION['email']);
			unset($_SESSION['senha']);
		}
	}else{ // o usuário deseja se cadastrar
		$nome = $_POST['nome'];
		$data = $_POST['data_nascimento'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$conf_senha = $_POST['conf_senha'];

		if(strcmp($senha, $conf_senha) == 0){
			$ver_email = "SELECT * FROM usuario WHERE email = '$email'"; // procurar email no bd
			$result1 = mysqli_query($con, $ver_email); // chama acao bd
			$qtd_email = mysqli_num_rows($result1); // retorna quantos resultados teve para essa busca
			
			$ver_username = "SELECT * FROM usuario WHERE username = '$username'"; // verificacao nome de usuario
			$result2 = mysqli_query($con, $ver_username);
			$qtd_username = mysqli_num_rows($result2);

			if($qtd_username != 0){
				$msgusername = "Esse nome de usuário já está cadastrado.";
			}elseif($qtd_email != 0){
				$msgemail = "Esse email já está sendo usado.";
			}else{
				$sql = "INSERT INTO usuario (nome, data_nascimento, email, username, senha, tip_id) VALUES ('$nome', '$data', '$email', '$username', md5('$senha'), '2')";

				mysqli_query($con, $sql);

				$msgcadastro = "Você está cadastrada(o).";
			}
		}else{
			$msgerro = "As senhas não coincidem."; 
		}
	}
?>
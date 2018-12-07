<?php 
	$email = $_SESSION['email'];
	
	$usu = "SELECT usu_id FROM usuario WHERE email = '$email'";
	$usu = mysqli_query($con, $usu) or die("Não foi possível reconhecer o usuário.");
	$usu = mysqli_fetch_array($usu);
	$usu_id = $usu['usu_id'];

	$titulo = $_POST['titulo'];
	$texto = $_POST['texto'];
	$audio = $_POST['audio'];
	$video = $_POST['video'];
	$cat_id = $_POST['categorias'];

	if (isset($_GET['poe_id'])) { //usuario quer editar o poema
		$id = $_GET['poe_id'];

		$update = "UPDATE poema
							SET titulo = '$titulo', texto = '$texto', audio = '$audio', video = '$video', data = current_timestamp()
							WHERE poe_id = $id";

		mysqli_query($con, $update) or die("Desculpe, não foi possível modificar o poema.");
		$msg = "O poema foi editado.";

		$update = "UPDATE categoria_poema
							SET cat_id = '$cat_id'
							WHERE poe_id = $id";
		mysqli_query($con, $update) or die("Não conseguimos atualizar a categoria.");

	}elseif (isset($_POST['texto'])) { //usuario quer publicar o poema
		$sql = "SELECT count(*) FROM poema WHERE texto = '" . $texto . "'";
		$ver_texto = mysqli_query($con, $sql); //verificar se o texto já existe
		$ver_texto = mysqli_fetch_array($ver_texto);
		$ver_texto = $ver_texto['count(*)'];

		if($ver_texto > 0){
			$msg = "Esse texto já foi publicado.";
		}else{
			$sql_poema = "INSERT INTO poema(titulo, texto, audio, video, data, autor_id) values('$titulo', '$texto', '$audio', '$video', current_timestamp(), '$usu_id')";
			mysqli_query($con, $sql_poema) or die("Não foi possível publicar."); //colocando o poema e suas informações no bd

			$procurar_poema = "SELECT poe_id FROM poema WHERE autor_id = '$usu_id' AND texto = '$texto'";
			$procurar_poema = mysqli_query($con, $procurar_poema);
			$poe_id = mysqli_fetch_array($procurar_poema);
			$poe_id = $poe_id['poe_id'];

			$sql_cat = "INSERT INTO categoria_poema(cat_id, poe_id) VALUES ('$cat_id', '$poe_id')";
			mysqli_query($con, $sql_cat) or die('Não foi possível salvar a categoria');
			$msg = "Seu poema foi publicado!";
		}
	}
?>


	<?=$msg?>

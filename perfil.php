<?php
	require('conexao/conecta.php');

	$email = $_SESSION['email'];
	$usu = "SELECT usu_id, nome, username, descricao FROM usuario WHERE email = '$email'";
	$usu = mysqli_query($con, $usu);
	$usuario = mysqli_fetch_array($usu);
	$usu_id = $usuario['usu_id'];
	$usu_nome = $usuario['nome'];
	$usu_desc = $usuario['descricao'];
	$username = $usuario['username'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
	<div class="container">

	<div class="introducao">
		<?=$usu_nome?><br>
		<?=$username?> <br>
		<?php if($usu_desc != NULL){
			echo "Descrição <br>";
			echo $usu_desc;
		} 

		$sql = "SELECT count(*) FROM poema WHERE autor_id = '$usu_id'";
		$num_poemas = mysqli_query($con, $sql);
		$num_poemas = mysqli_fetch_array($num_poemas);
		$num_poemas = $num_poemas['count(*)'];

		if ($num_poemas > 0) {
			echo "Quantidade de poemas: " . $num_poemas;
		}
		?>
		
		<a href="?pag=perfil&usu_id=<?=$usu_id?>"><i>Mudar informações do perfil</i></a><br>
	</div>

<?php

	$sql = "SELECT * FROM categoria";
  $cat_desc = mysqli_query($con, $sql) or die("Não achamos as categorias :c");

	if(isset($_GET['poe_id'])){ 
		?>
<?php } 

	if(isset($_POST['texto'])){ //quando o usuario colocou as informações para editar a poesia
    require('acao_escrever.php');
  }

	if (isset($_GET['poe_id'])) { //quando o usuario clicou para editar a poesia
		$poe_id = $_GET['poe_id'];

    $sql = "SELECT * FROM poema WHERE poe_id = " . $poe_id; //pegando informações do poema
    $poema = mysqli_query($con, $sql) or die("Não encontramos o poema.");
    $poema = mysqli_fetch_array($poema);
    $titulo = $poema['titulo'];
    $texto = $poema['texto'];
    $audio = $poema['audio'];
    $video = $poema['video'];
	?>

		<form name="escrever" method="post">
			Categoria:
	    <select name="categorias" required>
	      <?php

	      $poe_id = $_GET['poe_id'];

	        $sql = "SELECT cat_id FROM categoria_poema WHERE poe_id = " . $poe_id;
			    $cat_id = mysqli_query($con, $sql);
			    $cat_id = mysqli_fetch_array($cat_id);
			    $cat_id = $cat_id['cat_id'];

			    $sql = "SELECT cat_desc FROM categoria WHERE cat_id = " . $cat_id;
			    $cat_atual = mysqli_query($con, $sql);
			    $cat_atual = mysqli_fetch_array($cat_atual);
			    $cat_atual = $cat_atual['cat_desc'];

	        echo '<option value="' . $cat_id . '">' . $cat_atual . '</option>';
	        
	            while ($categorias = mysqli_fetch_array($cat_desc)) {
	               	echo '<option value="' . $categorias['cat_id'] . '">' . $categorias['cat_desc'] . '</option>';
	            }
	      ?>
	    </select> <br> <br>

	    Título:<br>
	    <input name="titulo" value="<?=$titulo?>"><br>

	    Texto:<br>
	    <textarea name="texto" id="texto" required><?=$texto?></textarea>
	    <br>

	    Áudio:<br> 
	    <input name="audio" value="<?=$audio?>"> <br>

	    Vídeo:<br>
	    <input name="video" value="<?=$video?>"> <br>

	    <input type="submit" value="Editar">
	    <input type="submit" name="Voltar">
		</form>
		<?php
	}else{
		$titulo = $texto = $audio = $video = null;
	}

	if (isset($_GET['usu_id'])) { //editar informações do usuário
		require('editar_perfil.php');

		$usu_id = $_GET['usu_id'];

		if (isset($_POST['e_nome'])) {
			$senha = $_POST['e_senha'];
			$senha = md5($senha);
			$conf_senha = $_POST['e_conf_senha'];
			$conf_senha = md5($conf_senha);

			$sql = "SELECT senha FROM usuario WHERE usu_id = " . $usu_id;
			$ver_senha = mysqli_query($con, $sql) or die("Não foi possível conectar com o banco de dados");
			$ver_senha = mysqli_fetch_array($ver_senha);
			$ver_senha = $ver_senha['senha'];

			if (strcmp($senha, $conf_senha) == 0 && strcmp($senha, $ver_senha) == 0){ //se as senhas estiverem corretas
				$nome = $_POST['e_nome'];
				$data_nascimento = $_POST['e_data_nascimento'];
				$username = $_POST['e_username'];
				$email = $_POST['e_email'];
				$descricao = $_POST['descricao'];

				$update = "UPDATE usuario
									SET nome = '$nome', data_nascimento = '$data_nascimento', descricao='$descricao', username ='$username', senha = '$senha'
									WHERE usu_id = " . $usu_id;
				mysqli_query($con, $update) or die("Não foi possível alterar as informações");
			}else{
				echo "As senhas não coincidem ou estão incorretas.";
			}
   }
	}else{
		$nome = $data_nascimento = $email = $audio = $video = null;
	}

	$sql = "SELECT count(*) FROM poema WHERE autor_id = '$usu_id'";
	$num_poemas = mysqli_query($con, $sql);
	$num_poemas = mysqli_fetch_array($num_poemas);
	$num_poemas = $num_poemas['count(*)'];
	

	if ($num_poemas > 0) { // se o usuario tiver poemas publicados
?>
		<?php
			$poema = "SELECT * FROM poema WHERE autor_id = " . $usu_id;
			$poema = mysqli_query($con, $poema);
			while($result = mysqli_fetch_array($poema)){ //faz isso para todos os poemas do usuário
				$pag = $_GET['pag'];
				$url = "?pag=" . $pag . "&poe_id=" . $result['poe_id'];

				$usu_id = $result['autor_id'];

				$sql2 = "SELECT nome FROM usuario WHERE usu_id = $usu_id";
				$autor = mysqli_query($con, $sql2);
				$autor = mysqli_fetch_array($autor);

				$poe_id = $result['poe_id'];
				
				$sql_cat = "SELECT cat_id FROM categoria_poema WHERE poe_id = $poe_id";
				$cat_id = mysqli_query($con, $sql_cat) or die("Ops! Algo deu errado.");
				$cat_id = mysqli_fetch_array($cat_id);
				$cat_id = $cat_id['cat_id'];

				$sql = "SELECT cat_desc FROM categoria WHERE cat_id = $cat_id";
				
				$cat_desc = mysqli_query($con, $sql) or die("Não encontramos a categoria.");
				$cat_desc = mysqli_fetch_array($cat_desc);
				$cat_desc = $cat_desc['cat_desc'];

				?>
				<a href="?pag=categorias&poe_id=<?=$poe_id?>">
				
				<div class="poema grid-5">
			<?php
				echo '	<div class="titulo">' . $result['titulo'] . ' <a href="' . $url . '"><img id="edit" src="img/edit-icon.png"></a></div>';
				echo '	<div class="texto rollbar">' . nl2br($result['texto']) . "</div>"; //função que reconhece quebra de linha
				echo '	<div class="autor">' . $autor['nome'] . "</div>";
			?>
			</div>
			</a>
		<?php	} ?>
<?php }else{ ?>

		Você ainda não tem nada publicado.<br>

		<a href="?pag=escrever"><i>Publicar?</i></a>

<?php } 

?>
	</div>
</body>
</html>
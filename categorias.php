<?php
	require('conexao/conecta.php');

	if (isset($_POST['comentario'])) {
		require('acao_comentario.php');
	}

	if (isset($_GET['poe_id'])){ //se a pessoa clicar em um poema, mostrar só ele
		$poe_id = $_GET['poe_id'];
		$sql = "SELECT * FROM poema WHERE poe_id = " . $poe_id;
		$poema = mysqli_query($con, $sql) or die("Não achamos o poema.");
		$poema = mysqli_fetch_array($poema);

		$autor_id = $poema['autor_id'];

		$sql = "SELECT nome FROM usuario WHERE usu_id = '$autor_id'";
		$autor = mysqli_query($con, $sql);
		$autor = mysqli_fetch_array($autor);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="iso-8859-1" />
	<title>Escrever</title>
</head>
<body>
	<div class="poema_unico">
	<div>
		<?php
			$video = $poema['video'];

			if ($video != NULL) { //se o poema tiver vídeo
				echo '<div class="bg-poema-unico">';
				echo '	<div class="titulo_ind">' . $poema['titulo'] . "</div>";
				echo '	<div class="texto_ind">' . nl2br($poema['texto']) . "</div>"; //função que reconhece quebra de linha
				echo '	<div class="autor_ind">' . $autor['nome'] . "</div>";
				echo '	<div class="data">' . $poema['data'] . "</div>";
				echo '</div>';

				$sql = "SELECT SUBSTRING('" . $video . "', 33)"; //Substring corta a URL do vídeo no caracter 33
				$cod_video = mysqli_query($con, $sql);
				$cod_video = mysqli_fetch_array($cod_video);
				$substring = "SUBSTRING('" . $video . "', 33)";
				$cod_video = $cod_video[$substring];
		?>	
		<div class="bg-video">
			<iframe id="video" width="100%" height="340" src="https://www.youtube.com/embed/<?=$cod_video?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<div class="bg-comentario">
			<h3>Comentários</h3>
			<?php
				include('lista_comentarios.php'); ?>
		</div>
			<?php
			}else{ //se não tiver vídeo
				echo '<div class="bg-poema-unico">';
				echo '	<div class="titulo_ind">' . $poema['titulo'] . "</div>";
				echo '	<div class="texto_ind">' . nl2br($poema['texto']) . "</div>"; //função que reconhece quebra de linha
				echo '	<div class="autor_ind">— ' . $autor['nome'] . '</div>';
				echo '</div>';
			?>
			<div class="bg-comentario">
			<h3>Comente</h3>
			<form name="comentario" method="post">
				<textarea name="comentario" id="texto_comentario" placeholder="Digite aqui" required></textarea>

				<input type="submit" value="Enviar">
			</form>

			<h3>Comentários</h3>
			<?php
				include('lista_comentarios.php'); ?>
			</div>
		<?php
			}
		}else{ //se não tiver nenhum poema selecionado
			$sql = "SELECT * FROM poema
							ORDER BY poe_id DESC";
			$poemas = mysqli_query($con, $sql) or die("Não achamos os poemas.");
			$num_res = mysqli_num_rows($poemas);
			$res_por_pag = 12;
			$num_de_pag = ceil($num_res/$res_por_pag); //numero de resultados obtidos dividido pelo numero que desejo por página, ceil arredonda o numero para cima

			if (isset($_GET['pag_num'])) {
				$pag_num = $_GET['pag_num'];
			}else{
				$pag_num = 1;
			}

			$inicio_res = ($pag_num-1)*$res_por_pag;
			
			$sql = "SELECT * FROM poema
								ORDER BY poe_id DESC LIMIT " . $inicio_res . ", " . $res_por_pag;
			$poemas = mysqli_query($con, $sql) or die("Não achamos os poemas.");

			if(isset($_SESSION['email'])){ //se o usuario estiver logado
			?>

		<div class="container">
		<h3>Poesias publicadas</h3>
		<?php
			while($result = mysqli_fetch_array($poemas)){
				$usu_id = $result['autor_id'];
				$poe_id = $result['poe_id'];

				$sql = "SELECT gostar FROM avaliacao WHERE poe_id = " . $poe_id;
				$ver_avaliacao = mysqli_query($con, $sql);
				$ver_avaliacao = mysqli_fetch_array($ver_avaliacao);
				$ver_avaliacao = $ver_avaliacao['gostar'];

				if ($ver_avaliacao == 0) {
					$icon = "img/heart-icon.png";
				}else{
					$icon = "img/heart-icon-color.png";
				}

				$url = "?pag=categorias&poe_id=" . $poe_id;

				$sql2 = "SELECT nome FROM usuario WHERE usu_id = $usu_id";
				$autor = mysqli_query($con, $sql2);
				$autor = mysqli_fetch_array($autor);
		?>
		
			<div class="poema grid-5">
			<?php
				echo '<a href="<?=$url?>">	<div class="titulo">' . $result['titulo'] . "</div>";
				echo '	<div class="texto rollbar">' . nl2br($result['texto']) . "</div></a>"; //função que reconhece quebra de linha
				echo '	<div class="autor">' . $autor['nome'] . '<img class="gostar ' . $icon . '" id="' . $poe_id . '" src="' . $icon . '"></img></a></div>';
			?>
			</div>
		
			<?php }
				for ($pag=1; $pag <= $num_de_pag; $pag++) { 
				echo ' <a href="/poetese/?pag=categorias&pag_num=' . $pag . '">' . $pag . '</a> ';
				}
			}else{ //se o usuario nao estiver logado
				$sql = "SELECT * FROM poema
								ORDER BY poe_id DESC LIMIT " . $inicio_res . ", " . $res_por_pag;
				$poemas = mysqli_query($con, $sql) or die("Não achamos os poemas.");
			?>
		</div>
		
		<div class="container">
		<h3>Poesias publicadas</h3>
		<?php
			while($result = mysqli_fetch_array($poemas)){
				$usu_id = $result['autor_id'];
				$poe_id = $result['poe_id'];

				$url = "?pag=categorias&poe_id=" . $poe_id;

				$sql2 = "SELECT nome FROM usuario WHERE usu_id = $usu_id";
				$autor = mysqli_query($con, $sql2);
				$autor = mysqli_fetch_array($autor);
		?>
		<a href="<?=$url?>">
			<div class="poema grid-5">
			<?php
				echo '	<div class="titulo">' . $result['titulo'] . "</div>";
				echo '	<div class="texto rollbar">' . nl2br($result['texto']) . "</div>"; //função que reconhece quebra de linha
				echo '	<div class="autor">' . $autor['nome'] . "</div>";
			?>
			</div>
		</a>
			<?php } //fecha o while
			for ($pag=1; $pag <= $num_de_pag; $pag++) { 
				echo ' <a href="/poetese/?pag=categorias&pag_num=' . $pag . '">' . $pag . '</a> ';
				}
			}
			
			} //fecha o else ?>
	</div>
</body>
</html>
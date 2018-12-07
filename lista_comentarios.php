<form name="comentario" method="post">
	<textarea name="comentario" id="texto_comentario" placeholder="Deixe seu comentário" required></textarea> <br>

	<input id="enviar" type="submit" value="Enviar">
</form>

<?php
	$sql = "SELECT count(*) FROM comentario";
	$qtd_com = mysqli_query($con, $sql) or die("Os comentários não foram encontrados");
	$qtd_com = mysqli_fetch_array($qtd_com);
	$qtd_com = $qtd_com['count(*)'];

	$sql = "SELECT nome FROM usuario u
					INNER JOIN comentario AS c ON u.usu_id = c.usu_id";
	$nome = mysqli_query($con, $sql) or die("O autor do comentário não foi encontrado");
	$nome = mysqli_fetch_array($nome);
	$nome = $nome['nome'];

	$poe_id = $_GET['poe_id'];

	if ($qtd_com != 0){
		$sql = "SELECT * FROM comentario WHERE poe_id = " . $poe_id ;
		$result = mysqli_query($con, $sql);

		while($com = mysqli_fetch_array($result)){
			echo '<div class="comentarios">';
			
			echo '<div id="com_texto">' . $com['com_texto'] . "</div><br>";
			echo '<div id="com_autor">' . $nome . "</div>";
			
			echo "</div>";
		}
	}else{
		echo "Sem comentários.";
	}
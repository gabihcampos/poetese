<!--Mostrar categorias cadastradas-->

<?php

	$sql = "SELECT * FROM categoria";

	$result = mysqli_query($con, $sql);

	echo "<table class='tabela grid-8' >";
	echo "<tr>";
	echo "<td>Id</td>";
	echo "<td>Nome</td>";
	echo "<td>Editar</td>";
	echo "</tr>";

	while ($categoria = mysqli_fetch_array($result)) {
		$pag = $_GET['pag'];
		$url = "?pag=" . $pag . "&cat_id=" . $categoria['cat_id'];
		echo "<tr>";
    echo "	<td>" . $categoria['cat_id'] . "</td>";
    echo "	<td>" . $categoria['cat_desc'] . "</td>";
    echo '	<td><a href="' . $url . '"><img id="edit-icon" src="img/edit-icon.png"></a></td>';
    //echo "	<td><a>Excluir</a></td>";
    echo "</tr>";
	}

	echo "</table>";
?>
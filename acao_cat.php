<?php
    //require_once('conecta.php');

    $cat_desc = $_POST['cat_desc'];

    $verificacao = "SELECT * FROM categoria WHERE cat_desc = '$cat_desc'";
		$result = mysqli_query($con, $verificacao);
		$ver = mysqli_num_rows($result); // número de resultados

    if(isset($_GET['cat_id'])){
        $cat_id = $_GET['cat_id'];

    	$update = "UPDATE categoria
                SET cat_desc = '$cat_desc'
                WHERE cat_id = " . $cat_id . ";"; 

        mysqli_query($con, $update) or die("Não foi possível mudar o nome da categoria.");
    }else if ($ver == 0) {
    	$sql = "INSERT INTO categoria(cat_desc) values ('$cat_desc')";

    	mysqli_query($con, $sql) or die('Não foi possível cadastrar');

    	echo "A categoria <i>" . $cat_desc . "</i> foi cadastrada com sucesso.";
    }else{ // se já tiver essa informação no banco
        echo "A categoria já está cadastrada.";
    }
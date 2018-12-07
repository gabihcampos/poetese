<?php
    require_once('conexao/conecta.php');

    $sql = "SELECT * FROM categoria";
    $cat_desc = mysqli_query($con, $sql) or die("Não achamos as categorias :c");

    if(isset($_POST['texto'])){
        require('acao_escrever.php');
    }else{
        $msg = null;
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Escrever</title>
</head>
<body>
    <div class="container">
        <?php
            if (isset($_SESSION['email'])) {
        ?>
    	
        <h3>Escreva</h3>
    	<form name="escrever" method="post" class="escrever">

            <div class="escrever_texto">
                <input name="titulo" id="titulo" placeholder="Título (opcional)"><br>
                <textarea name="texto" id="texto_form" placeholder="Digite aqui" required></textarea>
            </div> <br>
            <b>O que você mais sentiu escrevendo este poema?</b><br>
            <select id="sel_cat" name="categorias" required>
                <option value="">Selecione</option>
                <?php
                    while ($categorias = mysqli_fetch_array($cat_desc)) {
                        echo '<option value="' . $categorias['cat_id'] . '">' . $categorias['cat_desc'] . '</option>';
                    }
                ?>
            </select> <br> <br>

            áudio <br>
            <input type="text" name="audio"> <br>

            vídeo <br>
            <input type="text" name="video"> <br>

            <input type="submit" value="Publicar →" id="botao_publicar">
    	</form> <br>

        <?php
            }else{
                echo '<a href="/poetese/?pag=login">Entre</a> para publicar.';
            }
        ?>
    </div>
</body>
</html>
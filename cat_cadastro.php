<!--Cadastrar categorias-->

<?php
    if(isset($_POST['cat_desc'])){
        require('acao_cat.php');
    }

    if(isset($_GET['cat_id'])){
        require('conexao/conecta.php');

        $sql = "SELECT cat_desc FROM categoria WHERE cat_id = " . $_GET['cat_id'];
        $cat = mysqli_query($con, $sql) or die("Não encontramos a categoria.");
        $cat = mysqli_fetch_array($cat);
        $cat_desc = $cat['cat_desc'];
    }else{
        $cat_desc = null;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cadastro de categorias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="main.css" />-->
    <link rel="stylesheet" type="text/css" href="css/grid.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h3>Cadastro de categorias</h3>
        <form name="form1" method="post">
            Nome da categoria:
            <input type="text" name="cat_desc" value="<?=$cat_desc?>" required>

            <input type="submit" value="Cadastrar">
        </form>

        <br>

        <h3>Categorias Cadastradas</h3>
        <?php include('lista_cat.php'); ?>
    </div>
</body>
</html>
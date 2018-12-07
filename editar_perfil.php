<?php
    require('conexao/conecta.php');

    $sql = "SELECT * FROM usuario WHERE email = '" . $_SESSION['email'] . "'";
    $dados = mysqli_query($con, $sql) or die("Não foi possível conectar com o banco de dados.");
    $dados = mysqli_fetch_array($dados);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar Informações</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="main.css" />-->
    <link rel="stylesheet" type="text/css" href="css/grid.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <form name="form1" method="post">
        nome <br> <input name="e_nome" value="<?=$dados['nome']?>" required> <br> <!-- e de editar -->

        descricao <br> <textarea name="descricao" placeholder="Fale um pouco sobre você ou deixe algumas informações para contato."></textarea>

        data de nascimento <br> <input type="date" name="e_data_nascimento" value="<?=$dados['data_nascimento']?>" required/> <br>

        nome de usuário <br> <input name="e_username" value="<?=$dados['username']?>" required> <br>

        email <br> <input type="email" name="e_email" value="<?=$dados['email']?>" required> <br>

        senha <br> <input type="password" name="e_senha" required> <br>

        confirmar senha <br> <input type="password" name="e_conf_senha" required> <br>

        <input type="submit" value="editar" required>
    </form>
</body>
</html>
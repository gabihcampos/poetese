<?php
  session_start();
  require_once('conexao/conecta.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="js/gostar.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Alice|Average+Sans|Libre+Baskerville|Scada|Cambay|Mallanna|Noto+Sans+SC|Asap:500|Lusitana|Lusitana:700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/grid.css">
  <meta content="text/html; charset=iso-8859-1" />
	<title>Poete-se</title>
</head>
<?php
    if (isset($_SESSION['email'])){
      $email = $_SESSION['email'];

      $sql = "SELECT tip_id FROM usuario WHERE email = '$email'";
      $tip_id = mysqli_query($con, $sql);
      $tip_id = mysqli_fetch_array($tip_id);
      $tip_id = $tip_id['tip_id'];

      if($tip_id == 1){
        include('menu_adm.php');
      }else if($tip_id == 2){
        include('menu_logado.php');
      }
    }else{
      include('menu.php');
    }
  ?>
<body>
  

    <?php
  		if(isset($_GET['pag'])) {
      	$link = $_GET['pag'];

        if($link == 'login')
          include('login.php'); 
        else if($link == 'escrever')
          include('escrever.php');
        else if($link == 'cat_cadastro')
          include('cat_cadastro.php');
        else if($link == 'categorias')
          include('categorias.php');
        else if($link == 'pesquisar')
          include('pesquisar.php');
        else if($link == 'duv_ou_sug')
          include('duv_ou_sug.php');
        else if($link == 'sobre')
          include('sobre.php');
        else if($link == 'perfil')
          include('perfil.php');
  	  }else{
      ?>

      <div class="container">
        <div class="inicio">
          <div class="grid-1-3 escreva">
            <img id="img_escreva" src="img/escreva.png"><br> 
            <h2>escreva</h2>
            O poete-se é uma plataforma exclusiva para apreciadores de poesias e permite a publicação de poemas em texto, áudio e vídeo.
          </div>
          <div class="grid-1-3 inspirese">
            <img id="img_inspirese" src="img/inspirese.png"><br> 
            <h2>inspire-se</h2>

          </div>
          <div class="grid-1-3 divulgue">
            <img id="img_divulgue" src="img/divulgue.png"><br> 
            <h2>divulgue</h2></div>

        </div>

        <h3>Escolhidos ao acaso</h3>
       <?php 
        $sql = "SELECT * FROM poema ORDER BY RAND() LIMIT 6";
        $sorteio_poema = mysqli_query($con, $sql) or die("Desculpe, tivemos um probleminha, tente recarregar a página.");

        while ($poemas = mysqli_fetch_array($sorteio_poema)) {
          $usu_id = $poemas['autor_id'];
          $poe_id = $poemas['poe_id'];

          $url = "?pag=categorias&poe_id=" . $poe_id;

          $sql2 = "SELECT nome FROM usuario WHERE usu_id = $usu_id";
          $autor = mysqli_query($con, $sql2);
          $autor = mysqli_fetch_array($autor);
      
          echo '<a href="' . $url . '">';

          echo '<div class="poema grid-5">';

          $autor = $poemas['autor_id'];
          $sql = "SELECT nome FROM usuario WHERE usu_id = $autor";
          $nome_autor = mysqli_query($con, $sql);
          $nome_autor = mysqli_fetch_array($nome_autor);

          echo '  <div class="titulo">' . $poemas['titulo'] . "</div>";
          echo '  <div class="texto rollbar">' . nl2br($poemas['texto']) . "</div>"; //função que reconhece quebra de linha
          echo '  <div class="autor">' . $nome_autor['nome'] . "</div>";
          echo "</div>";

          echo '</a>';
        }
       ?>
      </div>

    <?php
      }
    ?>
</body>
</html>
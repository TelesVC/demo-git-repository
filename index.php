<?php
require "conexaoMysql.php";
require "autenticacao.php";


session_start();
$mysqli = conectaAoMySQL();
//checkUsuarioLogadoOrDie($mysqli);

function filtraEntrada($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $msgErro = "";

    // Define e inicializa as variáveis
    $login = $senha = "";

    $senha     = filtraEntrada($_POST["senha"]);     
    $login     = filtraEntrada($_POST["login"]);

    loginUsuario($login, $senha, $mysqli);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

     <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- HTMLShiv -->
    <!--[if lt IE 9]>
	  <script src="bower_components/html5shiv/dist/html5shiv.js"></script>
    <![endif]-->
		<style>
	body {
		background-image: url(imagens/bg1.jpg);		
		background-repeat: repeat-x;
	}
	#procurar {
        display: flex;
        justify-content: center;
        align-items: center;
    }
     
	</style>

    <title>Mega Market</title>

</head>
<body>

<?php include "header.php"; ?>


 <!-- Busca -->
    <div class="container" id="procurar">
        <form action="pesquisar.php" method="GET">
            <div class="form-group row p-2">
                <div class="col-md-8">
                    <input class="form-control" type="text" name="pesquisar" id="pesquisar" placeholder="Procurar">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success" class="form-control" type="submit">Procurar</button>
                </div>
            </div>
        </form>
    </div>

    <section id="produtosOferta"><!-- Inicio Ofertas -->

        <div class="container">
    		<h2>Nossos Produtos</h2>
    		<span id="conteudo"></span>
    	</div>
        <div class="resultados"></div>

   		<script>
    		$(document).ready(function () {
    			$.post('listar_Produto.php', function(retorna){
    				//Subtitui o valor no seletor id="conteudo"
    				$("#conteudo").html(retorna);
    			});
    		});
	   </script>
    </section><!-- Fim Ofertas -->

<?php include "footer.php"; ?>

</body>
</html>
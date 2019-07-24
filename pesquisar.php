<?php 
require "conexaoMysql.php";
session_start();
$mysqli = conectaAoMySQL();
//checkUsuarioLogadoOrDie($mysqli);

function filtraEntrada($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$valor_pesquisar = filtraEntrada($_GET['pesquisar']);

if ($valor_pesquisar === 'bicicletas') {
    $sql = "SELECT * FROM Produto WHERE tipoproduto = '$valor_pesquisar' ";
    $resultado_produto = $mysqli->query($sql);
}elseif($valor_pesquisar === 'componentes') {
    $sql = "SELECT * FROM Produto WHERE tipoproduto = '$valor_pesquisar' ";
    $resultado_produto = $mysqli->query($sql); 
}elseif($valor_pesquisar === 'acessorios') {
    $sql = "SELECT * FROM Produto WHERE tipoproduto = '$valor_pesquisar' ";
    $resultado_produto = $mysqli->query($sql); 
}elseif($valor_pesquisar === 'vestuario') {
    $sql = "SELECT * FROM Produto WHERE tipoproduto = '$valor_pesquisar' ";
    $resultado_produto = $mysqli->query($sql); 
}else{
    $sql = "SELECT * FROM Produto WHERE UPPER(nome) LIKE UPPER('%$valor_pesquisar%')";
    $resultado_produto = $mysqli->query($sql);
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
	    #img_produtos {
            width: 200px;
            height: 200px;
        }
        a.link {
            display: block;
            height: 100%;
            width: 100%;
            text-decoration: none;
        }

        #div_produtos {
            padding: 20px;
        }
     
	</style>

    <title>Mega Market</title>

</head>
<body>

<?php include "header.php"; ?>


 <!-- Busca -->
    <div class="container" id="procurar">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
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

    <section id="produtosBuscados"><!-- Inicio Produtos Buscados -->

        <div class="container">
    		<h2>Resultado da busca</h2>
    		<div class="row">

<?php while ($rows = $resultado_produto->fetch_assoc()){ ?>
		    <div class="col-lg-3 col-md-6" id="div_produtos">
		        <div  class="img-thumbnail">
		            <div class="caption text-center">
		                <a href="detalhes.php?id=<?= $rows['codigo'] ?>">
		                    <img src="<?=$rows['pro_img']?>" id="img_produtos">
		                </a>
		                <a><h5><?php echo $rows['nome']; ?></h5></a>
		                <a><h5><?php echo $rows['preco_venda']; ?></h5></a>
		                <a class="btn btn-primary" onclick="addCarrinho()">Comprar</a>
		            </div>
		        </div>
		    </div>
<?php }//fim while ?>
			</div>
		</div>
        
    </section><!-- Fim Ofertas -->

<?php include "footer.php"; ?>

</body>
</html>
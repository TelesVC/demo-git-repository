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

$valor_pesquisar = filtraEntrada($_GET['id']);

$sql = "SELECT * FROM Produto WHERE codigo = $valor_pesquisar ";
$resultado_produto = $mysqli->query($sql);
$rows = $resultado_produto->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- HTMLShiv -->
    <!--[if lt IE 9]>-->
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
            width: 400px;
            height: 400px;
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
         #preco {
            color: red;
        }
        
        
     
	</style>

    <title>Mega Market</title>

</head>
<body>

<?php include "header.php"; ?>


 <!-- Busca -->
    <div class="container" id="procurar">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET"></form>
            <div class="form-group row p-2">
                <div class="col-md-8">
                    <input class="form-control" type="text" name="pesquisar" id="pesquisar" placeholder="Procurar">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success" class="form-control" type="submit">Procurar</button>
                </div>
            </div>
        
    </div>

    <section id="produtosBuscados"><!-- Inicio Produtos Buscados -->

        <div class="container">
    		<h2 class="font-weight-bold" ><?php echo $rows['nome']; ?></h2>


		    <div class="media" id="div_produtos">
                    
                        <img class="mr-3" src="<?=$rows['pro_img']?>" id="img_produtos">
                                <div class="media-body">
                                        <h5><?php echo $rows['descricao']; ?></h5>
                                        <br>
                                        <h1 id="preco">R$ <?php echo $rows['preco_venda']; ?></h1>
                                        <a class="btn btn-success" class="card-link" onclick="addCarrinho()">Comprar</a>
                                </div>
		    </div>
	</div>
     </section>
<?php include "footer.php"; ?>

</body>
</html>
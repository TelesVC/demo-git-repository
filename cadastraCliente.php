<?php

//echo "<pre>";
//print_r($_POST);
//echo "<pre>";

require "conexaoMysql.php";

// Valida uma string removendo alguns caracteres
// especiais que poderiam ser provenientes
// de ataques do tipo HTML/CSS/JavaScript Injection
function filtraEntrada($dado) 
{
	$dado = trim($dado);               // remove espaços no inicio e no final da string
	$dado = stripslashes($dado);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
	$dado = htmlspecialchars($dado);   // caracteres especiais do HTML (como < e >) são codificados

	return $dado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$msgErro = "";

	// Define e inicializa as variáveis
	$nome = $email = $estadoCivil  = $cpf = $senha = $cep = $rua = $complemento = $bairro = $cidade = $estado = "";

	$nome             = filtraEntrada($_POST["nome"]);     
	$email            = filtraEntrada($_POST["email"]);
	$estadoCivil      = filtraEntrada($_POST["estadoCivil"]);
	$cep   	          = filtraEntrada($_POST["cep"]);
    $rua              = filtraEntrada($_POST["rua"]);
    $complemento      = filtraEntrada($_POST["complemento"]);
    $bairro           = filtraEntrada($_POST["bairro"]);
    $cidade           = filtraEntrada($_POST["cidade"]);
    $estado           = filtraEntrada($_POST["estado"]);
	$senha            = filtraEntrada($_POST["senha"]);
	$cpf              = filtraEntrada($_POST["cpf"]);

	try{    
		// Função definida no arquivo conexaoMysql.php
		$conn = conectaAoMySQL();

        //avaliar se já existe email cadastrado
        $SQL = " SELECT emailCliente FROM Cliente WHERE emailCliente = '$email' ";
  
        if (!$resultado = $conn->query($SQL))
            throw new Exception('Falha ao buscar usuario: ' . $conn->error);
        
        if ($resultado->num_rows > 0){
            throw new Exception('Email ja cadastrado');
        }else{
            //insere o novo cliente no banco
            $sql = "
                INSERT INTO Cliente (idCliente, nomeCliente, emailCliente, estadoCivilCliente, cpfCliente, senhaCliente, cepCliente, ruaCliente, complCliente, bairroCliente, cidadeCliente, estadoCliente)
                VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
            ";

            // prepara a declaração SQL (stmt é uma abreviação de statement)
            if (!$stmt = $conn->prepare($sql))
                throw new Exception("Falha na operacao prepare: " . $conn->error);

            // Faz a ligação dos parâmetros em aberto com os valores.
            if (!$stmt->bind_param("sssssssssss", $nome, $email, $estadoCivil, $cpf, $senha, $cep, $rua, $complemento, $bairro, $cidade, $estado))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);

            if (!$stmt->execute())
                throw new Exception("Falha na operacao execute: " . $stmt->error);

            $formProcSucesso = true;

            header('location:index.php');

        }	
	}
	catch (Exception $e){
		$msgErro = $e->getMessage();
	}
}
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <!-- Estilo personalizado -->
    <link rel="stylesheet" type="text/css" href="css/estiloCadastrarUsuario.css">

    <!-- HTMLShiv -->
    <!--[if lt IE 9]>
	  <script src="bower_components/html5shiv/dist/html5shiv.js"></script>
    <![endif]-->
    <!-- Estilo personalizado 

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
    </style>-->


    <script>
        function getDadosEndereco(cep){

            let url = 'https://viacep.com.br/ws/' + cep + '/json/unicode/'

            let xmlHttp = new XMLHttpRequest()
            xmlHttp.open('GET', url)
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
                    let dadosJASONText = xmlHttp.responseText
                    let dadosJASONObj = JSON.parse(dadosJASONText)
                    console.log(dadosJASONObj)
                    document.getElementById('rua').value = dadosJASONObj.logradouro
                    document.getElementById('bairro').value = dadosJASONObj.bairro
                    document.getElementById('cidade').value = dadosJASONObj.localidade
                    document.getElementById('estado').value = dadosJASONObj.uf
                }
            }
            xmlHttp.send()
        }
    </script>


    <title>Mega Market</title>
</head>
<body>
    <header> <!-- Inicio Header -->
        <nav><!-- Inicio Navegação -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
                <!-- Botão que acolhe todos os link quando diminui a tela -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-principal">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    
                <!-- Links a serem recolhidos -->
                <div class="collapse navbar-collapse" id="nav-principal">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="navbar-brand" href="index.php"><img src="imagens/logo.png" alt="logo" style="width:80px;"><span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cesta Básica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Limpeza</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bebidas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Vestuário</a>
                        </li>
                    </ul>
                    
                    <div class="form-inline my-2 my-lg-0">
                        <!-- Botão para abrir a janela modal ENTRAR-->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEntrar">
                                Entrar
                        </button>
                            
                        <!-- Modal -->
                        <div class="modal fade" id="modalEntrar">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Insira os seus dados.</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="container">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="login">Login:</label> <br>
                                                        <input class="form-control" name="login" type="email" placeholder="ex: xxx@gmail.com" required>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="senha">Senha:</label><br>
                                                        <input class="form-control" name="senha" type="password" placeholder="senha" required>
                                                    </div>
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <button class="btn btn-success" type="submit">Entrar</button>
                                                </div>    
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </nav>
    </header><!-- Fim Header -->

	<div class="container">
        <h2> Já é cadastrado? <a class="btn btn-success" href="index.php">Click aqui!</a></h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <fieldset>
                <legend>Informações Pessoais</legend>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" placeholder="Informe seu nome" name="nome" id="nome" required>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" placeholder="Informe seu CPF" name="cpf" id="cpf" required>
                    </div> 

                    <div class="col-md-3 form-group">
                        <label for="estadoCivil">Estado Civil:</label>
                        <select name="estadoCivil" id="estadoCivil" class="form-control" required>
                            <option value="solteiro">Solteiro</option>
                            <option value="casado">Casado</option>
                            <option value="viuvo">Viuvo</option>
                        </select>
                    </div>  
                </div>
            </fieldset>

    		<br>

            <fieldset>
                <legend>Endereço de Entrega</legend>	            
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="cep">CEP:</label>
                        <input type="text" class="form-control" placeholder="Informe o CEP" name="cep" id="cep" onblur="getDadosEndereco(this.value)" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="rua">Rua:</label>
                        <input type="text" class="form-control" name="rua" id="rua" required>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label for="complemento">Complemento:</label>
                        <input type="text" class="form-control" name="complemento" id="complemnto" required>
                    </div>

                    <br>

                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 form-group">
                        <label for="bairro">Bairro:</label>
                        <input type="text" class="form-control" name="bairro" id="bairro" required>
                    </div>

                    <br>
                    
                    <div class="col-md-4 form-group">
                        <label for="cidade">Cidade:</label>
                        <input type="text" class="form-control" name="cidade" id="cidade" required>
                    </div>

                    <br>
                    
                    <div class="col-md-4 form-group">
                        <label for="estado">Estado:</label>
                        <input type="text" class="form-control" name="estado" id="estado" required>
                    </div>
                </div>
            </fieldset>
    		
			<br>

            <fieldset>
                <legend>Login e Senha</legend>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" placeholder="Informe o e-mail" name="email" id="email" required>
                    </div>

                    <br>
                    
                    <div class="col-md-6 form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" placeholder="Digite sua senha" name="senha" id="senha" required>
                    </div>
                </div>
            </fieldset>

			<br>

            <div class="row">
                <div>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </div>

            <br>
            <br>

		</form>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {  
                if ($msgErro == "")
                echo "<h3 class='text-success'>Cadastrado realizado com sucesso!</h3>";
                else
                echo "<h3 class='text-danger'>Cadastro não realizado: $msgErro</h3>";
            }
        ?>
	</div>
</body>
</html>
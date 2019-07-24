<?php
require "conexaoMysql.php";
require "autenticacao.php";
require "receberdados.php";
require "receberEnderecoAlternativo.php";
require "receberPedidosCliente.php";
session_start();
$arrayClientes = null;
$arrayEnderecos = null;
$arrayPedCliente = null;


if (!isset($_SESSION['logado']) || $_SESSION['logado'] == false){
    header('location:index.php');
}

try{
	$mysqli = conectaAoMySQL();
	$arrayClientes = receberdados($_SESSION['idCliente'],$mysqli);
	$arrayEnderecos = receberEnderecos($_SESSION['idCliente'],$mysqli);
	$arrayPedCliente = getPedidosCliente($_SESSION['idCliente'],$mysqli);


}catch (Exception $e){
	$msgErro = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Área do Cliente</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	 <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<style>
	body {
		background-color: #e6eeff ;
	}
	body {
		padding: 30px;
	}
	.tab {
		padding: 20px;
		display: none;
		border: 0.5px solid lightgray;
	}
	#Modalform { 
		padding: 20px;
	}
	</style>

	<script>

		$(function () {
			$("#paginaHome").fadeIn(200);
			});

		function openPage(idPagina, link){
			$(".tab").hide();      
			$("ul.navbar-nav li").removeClass("active");          

			$("#" + idPagina).fadeIn(500);     
				if (link != null)
				link.parentNode.className += " active";
		}
		function editar(){
			//cirar um form de edição
			let form = document.createElement('form');
			form.action = '#'
			form.method = 'post'
			form.className = 'row'

			//criar um input para entrada do texto
			let inputTarefa = document.createElement('input');
			inputTarefa.type = 'text'
			inputTarefa.name = 'tarefa'
			inputTarefa.className = 'col-9 form-control'
			inputTarefa.value = txt_tarefa

			//criar um input hidden para guardar o id da tarefa
			let inputId = document.createElement('input')
			inputId.type = 'hidden'
			inputId.name = 'id'
			inputId.value = id

			//cirar um button para envio do form			
			let button = document.createElement('button');
			button.type = 'submit'
			button.className = 'col-3 btn btn-info'
			button.innerHTML = 'Atualizar'

			//criar a tag form
			document.getElementById('divteste').appendChild(form);

			//inputTarefa  no form
			form.appendChild(inputTarefa)

			//incluir o inputId no form
			form.appendChild(inputId)

			//incluir o button no form
			form.appendChild(button)

		}	

	</script>
  
</head>
<body>

	<div class="container bg-secondary"> <!-- Inicio Container-->
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Mega Market</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a class="navLink" href="#" onclick="openPage('paginaHome', this);">Dados cadastrais</a></li>
					<li><a class="navLink" href="#" onclick="openPage('pagina2', this);">Meus pedidos</a></li>
					<li><a class="navLink" href="#" onclick="openPage('pagina3', this);">concluir pedido</a></li>
				</ul>
			</div>
	  	</nav>

	  	<div class="tab" id="paginaHome"><!-- Pagina de dados do Cliente-->
	  		<div class="page-header">
				<h1>Dados do Cliente</h1>
			</div>
			<div class="form-group row text-center">
				<div class="form-group col-md-12">
					<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>Nome</th>
					        <th>E-mail</th>
					        <th>Estado Civil</th>
					        <th>Rua</th>
					        <th>Complemento</th>
					        <th>Bairro</th>
					        <th>Cidade</th>
					        <th>Estado</th>
					        <th>Alterar</th>
					      </tr>
					    </thead>
					    
					    <tbody>
						
							<?
								if ($arrayClientes != ""){
									foreach ($arrayClientes as $cliente){?>       
										<tr>
											<td><?= $cliente->nome ?></td>
											<td><?= $cliente->email ?></td>
											<td><?= $cliente->estadoCivil ?></td>
											<td><?= $cliente->rua ?></td>
											<td><?= $cliente->complemento ?></td>
											<td><?= $cliente->bairro ?></td>
											<td><?= $cliente->cidade ?></td>
											<td><?= $cliente->estado ?></td>
											<td><i class="fas fa-edit fa-lg text-info" onclick="editar() "></i></td>
										</tr>
										<div id="divteste">
											
										</div> 
									<?}
								}
							?>    
							
					    </tbody>
					  </table>	
				</div>
			</div>
			<div class="page-header">
				<h1>Endereço de Entrega</h1>
			</div>
			<div class="form-group row text-center">
				<div class="form-group col-md-12">
					<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>Rua</th>
					        <th>Complemento</th>
					        <th>Bairro</th>
					        <th>Cidade</th>
					        <th>Estado</th>
					        <th>Excluir</th>
					      </tr>
					    </thead>
					    
					    <tbody>
						
							<?
								if ($arrayEnderecos != ""){
									foreach ($arrayEnderecos as $endereco){ ?>       
										<tr>
											<td><?= $endereco->rua ?></td>
											<td><?= $endereco->complemento ?></td>
											<td><?= $endereco->bairro ?></td>
											<td><?= $endereco->cidade ?></td>
											<td><?= $endereco->estado ?></td>
											<td><td><i class="fas fa-trash-alt fa-lg text-danger"></i></td></td>
										</tr> 
									<?}
								}
							?>    
							
					    </tbody>
					  </table>	
				</div>
			</div>		
	  	</div><!-- Fim Pagina de dados do Cliente-->

	  	<div class="tab" id="pagina2"><!-- Pagina de pedidos do Cliente-->
			<div class="page-header">
				<h1>Meus Pedidos</h1>
			</div>
			<div class="form-group row text-center">
				    <div class="form-group col-md-12">
					<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>Pedido</th>
					        <th>Data de emissão</th>
					        <th>Data de entrega</th>
					        <th>Forma de pagamento</th>
					        <th>Valor Total</th>
					      </tr>
					    </thead>
					    
					    <tbody>
						
							<?
								if ($arrayPedCliente != ""){
									foreach ($arrayPedCliente as $pedcliente){?>       
										<tr>
											<td><?= $pedcliente->nro ?></td>
											<td><?= $pedcliente->dataemissao ?></td>
											<td><?= $pedcliente->dataentrega ?></td>
											<td><?= $pedcliente->formpagamento ?></td>
											<td><?= $pedcliente->valortotal ?></td>
										</tr> 
									<?}
								}
							?>    
							
					    </tbody>
					  </table>
				</div>
			</div>		
	  	</div><!-- Fim Pagina de pedidos do Cliente-->

		<div class="tab" id="pagina3"><!-- Pagina de pedido do Cliente-->

			<div class="page-header">
				<h1>Pedidos</h1>
			</div>
			<div class="form-group row text-center">
				    <div class="form-group col-md-10">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Produtos solicitados</th>
								<th>Valor do produto</th>
								
							</tr>
						</thead>
						<tbody>
							<?php while($rows_cliente = mysqli_fetch_assoc($resultado_cliente)){ ?><!-- inicio do while -->
								<tr>
									<td><?php echo $rows_cliente['id']; ?></td>
									<td><?php echo $rows_cliente['nome']; ?></td>
								</tr>
							<?php } ?><!-- fim do while -->
							<tr>
								<th>Endereço de entrega:</th>
							</tr>
						</tbody>
					</table>
						<div class="col-xs-12">
							<button type="submit" class="btn btn-success" value="Concluir">Concluir pedido</button>
						</div>	
				</div>
			</div>		
		</div><!-- Fim Pagina de pedido do Cliente-->

	</div><!-- Fim Container-->

</body>
</html>
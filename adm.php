<?php
require "conexaoMysql.php";
require "receberclientes.php";
require "receberproduto.php";
require "receberpedidos.php";

$arrayClientes = null;
$arrayProdutos = null;
$arrayPedidos = null;
$msgErro = "";

try{
	$mysqli = conectaAoMySQL();
	$arrayClientes = getClientes($mysqli);
	$arrayProdutos = getProdutos($mysqli);  
	$arrayPedidos = getPedidos($mysqli);

}catch (Exception $e){
	$msgErro = $e->getMessage();
}



?>


<!DOCTYPE html>
<html>
	<head>
		<title>Área do Administrador</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
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
			
			function openPage(idPagina, link)
			{
				$(".tab").hide();      
				$("ul.navbar-nav li").removeClass("active");          

				$("#" + idPagina).fadeIn(500);     
				if (link != null)
					link.parentNode.className += " active";
			}

			function completar(){
			    valor = document.getElementById('Nome').value
			    document.getElementById('imagem').value = "imagens/" + valor + ".png"
			}

			function testeexclusao(id,numero){
				if (numero == 1) {
					if (confirm('Deseja realemnte exlucir o produto?')){
						location.href = 'excluiProduto.php?Id='+id;
					}
				}else if (numero == 2) {
					if (confirm('Deseja realemnte exlucir o produto?')){
						location.href = 'excluiCliente.php?Id='+id;
					}
				}
			}
			
		</script>
		
	</head>
	<body>

		<div class="container"><!-- Inicio Container-->

			<nav class="navbar navbar-inverse"><!-- Inicio nevegacao-->
				<div class="container-fluid">
				
					<div class="navbar-header">
						<a class="navbar-brand" href="index.php">Mega Market</a>
					</div>
					
					<ul class="nav navbar-nav">
						<li class="active"><a class="navLink" href="#" onclick="openPage('paginaHome', this);">Cadastro de produtos</a></li>
						<li><a class="navLink" href="#" onclick="openPage('pagina2', this);">Listagem de pedidos</a></li>
						<li><a class="navLink" href="#" onclick="openPage('pagina3', this);">Listagem de clientes</a></li>
						<li><a class="navLink" href="#" onclick="openPage('pagina4', this);">Listagem de produtos</a></li>
					</ul>
				</div>
			</nav><!-- Fim nevegacao-->

			<div class="tab" id="paginaHome"><!-- Inicio Pagina Produtos-->

				<!-- Inicio Pagina Produtos<form action="cadastraproduto.php" method="POST">-->
                                <form method="POST" action="cadastraproduto.php" enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="nome">Nome:</label>
							<input type="text" class="form-control" id="Nome" name="nome">
						</div>

						<div class="form-group col-md-6">
							<label for="nome_fabricante">fabricante:</label>
							<input type="text" class="form-control" id="nome_fabricante" name="nome_fabricante">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="descricao">descrição:</label>
							<input type="text" class="form-control" id="descricao" name="descricao">
						</div>

						<div class="form-group col-md-6">
							<label for="preco_venda">Preço de venda:</label>
							<input type="text" class="form-control" id="preco_venda" name="preco_venda">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="quantidade">Quantidade em estoque:</label>
							<input type="number" class="form-control" id="quantidade" name="quantidade">
						</div>

						<div class="form-group col-md-6">
							<label for="imagem">Imagem:</label>
							<input type="text" class="form-control" id="imagem" name="imagem" onfocus="completar()">
                            Imagem: <input name="arquivo" type="file"><br><br>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 form-group">
	                        <label for="tipoproduto">Tipo de produto:</label>
	                        <select name="tipoproduto" class="form-control" required>
	                            <option value="bicicletas">Bicicletas</option>
	                            <option value="componentes">Componentes</option>
	                            <option value="acessorios">Acessórios</option>
	                            <option value="vestuario">Vestuário</option>
	                        </select>
	                    </div> 

					</div>

					<button type="submit" class="btn btn-success">Cadastrar</button>
				</form>
			</div><!-- Fim Pagina Produtos-->
			<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------- -->
			<div class="tab" id="pagina2"><!-- Inicio Pagina Listagem de Pedidos-->
				<div class="page-header">
					<h1>Pedidos</h1>
				</div>
				<div class="form-group row text-center">
					<div class="form-group col-xs-12">
						<table class="table table-striped">
						    <thead>
						      <tr>
						      	<th>Num. Pedido</th>
						        <th>Cliente</th>
						        <th>Data de emissão</th>
						        <th>Data de entrega</th>
						        <th>Forma de Pagamento</th>
						        <th>Valor Total</th>
						      </tr>
						    </thead>
						    
						    <tbody>
							
								<?php
									if ($arrayPedidos != ""){
										foreach ($arrayPedidos as $pedido){ ?>       
											<tr>
												<td><?= $pedido->id ?></td>
												<td><?= $pedido->cliente ?></td>
												<td><?= $pedido->dataemissao ?></td>
												<td><?= $pedido->dataentrega ?></td>
												<td><?= $pedido->formpagamento ?></td>
												<td><?= $pedido->valortotal ?></td>
											</tr> 
										<?}
									}
								?>    
						    </tbody>
						</table>			
					</div>
				</div>				
			</div><!-- Fim Pagina Listagem de Pedidos-->

			<div class="tab" id="pagina3"><!-- Inicio Pagina Listagem de Clientes-->

				<div class="page-header">
					<h1>Clientes</h1>
				</div>
				<div class="form-group row text-center">
					<div class="form-group col-md-12">
						<table class="table table-striped">
						    <thead>
						      <tr>
						      	<th>ID</th>
						        <th>Nome</th>
						        <th>E-mail</th>
						        <th>Estado Civil</th>
						        <th>Rua</th>
						        <th>Complemento</th>
						        <th>Bairro</th>
						        <th>Cidade</th>
						        <th>Estado</th>
						        <th>Excluir</th>
						      </tr>
						    </thead>
						    
						    <tbody>
							
								<?php
									if ($arrayClientes != ""){
										foreach ($arrayClientes as $cliente){ ?>

											<tr>
												<td><?= $cliente->id ?></td>
												<td><?= $cliente->nome ?></td>
												<td><?= $cliente->email ?></td>
												<td><?= $cliente->estadoCivil ?></td>
												<td><?= $cliente->rua ?></td>
												<td><?= $cliente->complemento ?></td>
												<td><?= $cliente->bairro ?></td>
												<td><?= $cliente->cidade ?></td>
												<td><?= $cliente->estado ?></td>
												<td><i class="fas fa-trash-alt fa-lg text-danger" onclick="testeexclusao(<?= $cliente->id ?>,2)"> </i></td>
											</tr> 
										<?}
									}
								?>    
								
						    </tbody>
						  </table>	
					</div>
				</div>							
			</div><!-- Inicio Pagina Listagem de Clientes-->


			<div class="tab" id="pagina4"><!-- Inicio Pagina Listagem de Produtos-->

				<div class="page-header">
					<h1>Produtos</h1>
				</div>
				<div class="form-group row text-center">
					<div class="form-group col-md-12">
						<table class="table table-striped">
						    <thead>
						      <tr>
						      	<th>ID</th>
						        <th>Nome</th>
						        <th>Fabricante</th>
						        <th>Descrição</th>
						        <th>Preço de venta</th>
						        <th>Quantidade em estoque</th>
						        <th>Tipo</th>
						        <th>Imagem</th>
						        <th>Excluir</th>
						      </tr>
						    </thead>
						    <img src="" alt="" style="width: 10px">
						    <tbody>
							
								<?
									if ($arrayProdutos != ""){
									
										foreach ($arrayProdutos as $produto){?>

											<tr>
												<td><?= $produto->id ?></td>
												<td><?= $produto->nome ?></td>
												<td><?= $produto->fabricante ?></td>
												<td><?= $produto->descricao ?></td>
												<td><?= $produto->preco_venda ?></td>
												<td><?= $produto->quant_estoque ?></td>
												<td><?= $produto->tipo ?></td>
												<td><img src="<?= $produto->imagem ?>" style="width: 50px"></td>
												<td><i class="fas fa-trash-alt fa-lg text-danger" onclick="testeexclusao(<?= $produto->id ?>,1)"></i> </td>
											</tr> 
											
										<?}
									}
								?>    
								
						    </tbody>
						  </table>	
					</div>
				</div>		
												
			</div><!-- Inicio Pagina Listagem de produtos-->

		</div><!-- Fim Container-->
	</body>
</html>
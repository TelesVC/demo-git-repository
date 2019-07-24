<?php
session_start();
$mysqli = conectaAoMySQL();
	if(isset($_POST['busca']) && $_POST['busca'] == 'sim'){
		include_once "../conexaoMysql.php";
		$textoBusca = strip_tags($_POST['texto']);
		$buscar = $mysqli->prepare("SELECT * FROM `Produtos` WHERE `nome` LIKE '%$textoBusca%'");
		$buscar->execute();

		$retorno = array();
		$retorno['dados'] = '';
		$retorno['qtd'] = $buscar->rowCount();
		if($retorno['qtd'] >= 0){
			while($conteudo = $buscar->fetchObject()){
				$retorno['dados'] .= '<a href="#" id="'.$conteudo->id.':'.$conteudo->valor.'">'.utf8_encode($conteudo->titulo).'</a>';
			}
		}

		echo json_encode($retorno);
	}

	if(isset($_POST['add_produto'])){
		include_once "../conexaoMysql.php";
		$retorno = array();
		$retorno['dados'] = '';

		$produtoId = (int)$_POST['Produto'];
		if(isset($_SESSION['carrinho'][$produtoId])){
			$_SESSION['carrinho'][$produtoId] += 1;
		}else{
			$_SESSION['carrinho'][$produtoId] = 1;
		}
		$total = 0;
		foreach($_SESSION['carrinho'] as $idProd => $qtd){
			$pegaProduto = $mysqli->prepare("SELECT * FROM `Produtos` WHERE `codigo` = ?");
			$pegaProduto->execute(array($idProd));
			$dadosProduto = $pegaProduto->fetchObject();
			$subTotal = ($dadosProduto->valor*$qtd);
			$total += $subTotal;
			
			$retorno['dados'] .= '<tr><td>'.utf8_encode($dadosProduto->titulo).'</td><td>Valor</td><td><input type="text" id="qtd" value="'.$qtd.'" size="3" /></td>';
			$retorno['dados'] .= '<td>R$ '.number_format($subTotal, 2, ',', '.').'</td></tr>';
			
		}
		$retorno['dados'] .= '<tr><td colspan="3">Total</td><td id="total">R$ '.number_format($total, 2, ',','.').'</td></tr>';
		echo json_encode($retorno);
	}
?>
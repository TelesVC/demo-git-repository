<?php
require "conexaoMysql.php";

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

function filtraEntrada($dado) 
{
	$dado = trim($dado);               // remove espaços no inicio e no final da string
	$dado = stripslashes($dado);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
	$dado = htmlspecialchars($dado);   // caracteres especiais do HTML (como < e >) são codificados

	return $dado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$msgErro = "";

	// Define e inicializa as variáveis
	$descricao = $nome = $nome_fabricante = $imagem = $quantidade = $preco_venda = $tipoproduto = "";

	$descricao          = filtraEntrada($_POST["descricao"]);
	$nome               = filtraEntrada($_POST["nome"]);
	$nome_fabricante   	= filtraEntrada($_POST["nome_fabricante"]);
	$pro_img             = filtraEntrada($_POST["imagem"]);
    $quantidade         = filtraEntrada($_POST["quantidade"]);
    $preco_venda        = filtraEntrada($_POST["preco_venda"]);
    $tipoproduto        = filtraEntrada($_POST["tipoproduto"]);

	try
	{    
		// Função definida no arquivo conexaoMysql.php
		$conn = conectaAoMySQL();

		$sql = "
		  INSERT INTO Produto (codigo, descricao, nome, nome_fabricante, preco_venda, pro_img, quantidade,  tipoproduto)
		  VALUES (null, ?,?,?,?,?,?,?);
		";

		// prepara a declaração SQL (stmt é uma abreviação de statement)
        if (!$stmt = $conn->prepare($sql))
            throw new Exception("Falha na operacao prepare: " . $conn->error);

        // Faz a ligação dos parâmetros em aberto com os valores.
        if (!$stmt->bind_param("sssssss", $descricao, $nome, $nome_fabricante, $preco_venda, $pro_img, $quantidade,  $tipoproduto))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);

        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);

        $formProcSucesso = true;

        header('location:adm.php');
	}
	catch (Exception $e)
	{
		$msgErro = $e->getMessage();
	}
}
  
?>
<?php
			include_once("conexaoMysql.php");
			$arquivo 	= $_FILES['arquivo']['name'];
			
			//Pasta onde o arquivo vai ser salvo
			$_UP['pasta'] = 'imagens/';
			
			//Tamanho máximo do arquivo em Bytes
			$_UP['tamanho'] = 1024*1024*100; //5mb
			
			//Array com a extensões permitidas
			$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
			
			//Renomeiar
			$_UP['renomeia'] = false;
			
			//Array com os tipos de erros de upload do PHP
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
			$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
			
			//Verifica se houve algum erro com o upload. Sem sim, exibe a mensagem do erro
			if($_FILES['arquivo']['error'] != 0){
				die("Não foi possivel fazer o upload, erro: <br />". $_UP['erros'][$_FILES['arquivo']['error']]);
				exit; //Para a execução do script
			}
			
			//Faz a verificação da extensao do arquivo
			$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
			if(array_search($extensao, $_UP['extensoes'])=== false){		
				echo "
					<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://ambientedeteste.atwebpages.com/upload_imagem.php'>
					<script type=\"text/javascript\">
						alert(\"A imagem não foi cadastrada extesão inválida.\");
					</script>
				";
			}
			
			//Faz a verificação do tamanho do arquivo
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size']){
				echo "
					<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://ambientedeteste.atwebpages.com/upload_imagem.php'>
					<script type=\"text/javascript\">
						alert(\"Arquivo muito grande.\");
					</script>
				";
			}
			
			//O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto
			else{
				//Primeiro verifica se deve trocar o nome do arquivo
				if($UP['renomeia'] == true){
					//Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
					$nome_final = time().'.jpg';
				}else{
					//mantem o nome original do arquivo
					$nome_final = $_FILES['arquivo']['name'];
				}
				//Verificar se é possivel mover o arquivo para a pasta escolhida
				if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta']. $nome_final)){
					//Upload efetuado com sucesso, exibe a mensagem
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://ambientedeteste.atwebpages.com/upload_imagem.php'>
						<script type=\"text/javascript\">
							alert(\"Imagem cadastrada com Sucesso.\");
						</script>
					";	
				}else{
					//Upload não efetuado com sucesso, exibe a mensagem
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://ambientedeteste.atwebpages.com/upload_imagem.php'>
						<script type=\"text/javascript\">
							alert(\"Imagem não foi cadastrada com Sucesso.\");
						</script>
					";
				}
			}
			
			
		?>
	
<?php

require "conexaoMysql.php";

function filtraEntrada($dado) 
{
	$dado = trim($dado);               // remove espaços no inicio e no final da string
	$dado = stripslashes($dado);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
	$dado = htmlspecialchars($dado);   // caracteres especiais do HTML (como < e >) são codificados

	return $dado;
}
 
if (isset($_GET["Id"]))
{
	try
	{
		// Função definida no arquivo conexaoMysql.php
		$conn = conectaAoMySQL();

		$id = filtraEntrada($_GET["Id"]);
		$sql = "
			DELETE 
			FROM Cliente
			WHERE idCliente = $id 
		";

		if (! $conn->query($sql))
			throw new Exception("Falha na remocao: " . $conn->error);
    
		// Redireciona para o script mostraClientes
		header("Location: adm.php");
	}
	catch (Exception $e)
	{
    echo "Nao foi possivel excluir o cliente: ", $e->getMessage();
	}
}
  
?>
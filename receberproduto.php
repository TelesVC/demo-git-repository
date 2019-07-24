<?php

class Produto{

	public $id;
	public $nome;
	public $fabricante;
	public $descricao;
	public $preco_venda;
	public $quant_estoque;
	public $tipo;
	public $imagem;
}

function getProdutos($conn)
{
	$arrayProdutos = [];

	$SQL = "
		SELECT *
		FROM Produto
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$produto = new Produto();

			$produto->id                = $row["codigo"];
			$produto->nome              = $row["nome"];
			$produto->fabricante        = $row["nome_fabricante"];
			$produto->descricao         = $row["emailCliente"];
			$produto->preco_venda       = $row["preco_venda"];
			$produto->quant_estoque     = $row["quantidade"];
			$produto->tipo              = $row["tipoproduto"];
			$produto->imagem            = $row["pro_img"];


			$arrayProdutos[] = $produto;
		}
	}

	return $arrayProdutos;
}

?>
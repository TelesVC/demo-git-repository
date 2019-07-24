<?php

class Pedido{

	public $id;
	public $cliente;
	public $dataemissao;
	public $dataentrega;
	public $formpagamento;
	public $valortotal;
}

function getPedidos($conn)
{
	$arrayPedidos = [];

	$SQL = "
		SELECT *
		FROM Pedido
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$pedido = new Pedido();

			$pedido->id             = $row["nro"];
			$pedido->cliente        = $row["cliente"];
			$pedido->dataemissao    = $row["dataemissao"];
			$pedido->dataentrega    = $row["dataentrega"];
			$pedido->formpagamento  = $row["condpag"];
			$pedido->valortotal     = $row["valortotal"];



			$arrayPedidos[] = $pedido;
		}
	}

	return $arrayPedidos;
}

?>
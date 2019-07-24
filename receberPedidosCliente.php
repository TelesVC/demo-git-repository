<?php

class pedidoCliente{

	public $id;
	public $condpag;
	public $dataefetuada;
	public $dataemissao;
	public $dataentrega;
	public $nro;
	public $valortotal;
	
}

function getPedidosCliente($id, $mysqli){

	$SQL = "
		SELECT condpag, dataefetuada, dataemissao, dataentrega, nro, valortotal
		FROM Pedido
		WHERE cliente = $id
	";

	$result = $mysqli->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $mysqli->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc()){

			$pedcliente = new pedidoCliente();

			$pedcliente->nro            = $row["nro"];
			$pedcliente->dataemissao    = $row["dataemissao"];
			$pedcliente->dataefetuada   = $row["dataefetuada"];
			$pedcliente->dataentrega    = $row["dataentrega"];
			$pedcliente->formpagamento  = $row["condpag"];
			$pedcliente->valortotal     = $row["valortotal"];


			$arrayPedCliente[] = $pedcliente;
		}
	}
	return $arrayPedCliente;
}

?>
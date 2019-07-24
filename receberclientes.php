<?php

class Cliente{

	public $id;
	public $nome;
	public $cpf;
	public $email;
	public $estadoCivil;
	public $bairro;
	public $cidade;
	public $rua;
	public $complemento;
	public $cep;
	public $estado;
	
}

function getClientes($conn){

	$arrayClientes = [];

	$SQL = "
		SELECT *
		FROM Cliente
	";

	$result = $conn->query($SQL);
	if (! $result)
		throw new Exception('Ocorreu uma falha ao gerar o relatorio de testes: ' . $conn->error);

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$cliente = new Cliente();

			$cliente->id            = $row["idCliente"];
			$cliente->nome          = $row["nomeCliente"];
			$cliente->cpf           = $row["cpfCliente"];
			$cliente->email         = $row["emailCliente"];
			$cliente->estadoCivil   = $row["estadoCivilCliente"];
			$cliente->bairro        = $row["bairroCliente"];
			$cliente->cidade        = $row["cidadeCliente"];
			$cliente->rua           = $row["ruaCliente"];
			$cliente->complemento   = $row["complCliente"];
			$cliente->cep           = $row["cepCliente"];
			$cliente->estado        = $row["estadoCliente"];

			$arrayClientes[] = $cliente;
		}
	}

	return $arrayClientes;
}

?>
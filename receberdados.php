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

function receberdados($id, $mysqli){

	$SQL = "
		SELECT nomeCliente, cpfCliente, emailCliente, estadoCivilCliente, bairroCliente, cidadeCliente, ruaCliente, complCliente, cepCliente, estadoCliente
		FROM Cliente
		WHERE idCliente = ?
		LIMIT 1
	";

  $stmt = $mysqli->prepare($SQL);
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $stmt->bind_result($nomeCliente, $cpfCliente, $emailCliente, $estadoCivilCliente, $bairroCliente, $cidadeCliente, $ruaCliente, $complCliente, $cepCliente, $estadoCliente);
  $stmt->store_result();
  $stmt->fetch();
  //teste se a linha existe
	if ($stmt->num_rows == 1){

			$cliente = new Cliente();

			$cliente->id            = $id;
			$cliente->nome          = $nomeCliente;
			$cliente->cpf           = $cpfCliente;
			$cliente->email         = $emailCliente;
			$cliente->estadoCivil   = $estadoCivilCliente;
			$cliente->bairro        = $bairroCliente;
			$cliente->cidade        = $cidadeCliente;
			$cliente->rua           = $ruaCliente;
			$cliente->complemento   = $complCliente;
			$cliente->cep           = $cepCliente;
			$cliente->estado        = $estadoCliente;

			$arrayClientes[] = $cliente;
	}
	return $arrayClientes;
}

?>
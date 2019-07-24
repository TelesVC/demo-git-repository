<?php

class Endereco{

	public $id;
	public $bairro;
	public $cidade;
	public $rua;
	public $complemento;
	public $cep;
	public $estado;
	
}

function receberEnderecos($id, $mysqli){

	$SQL = "
		SELECT bairro, cidade, rua, complemento, cep, estado
		FROM Endereco_aternativo
		WHERE cliente = ?
		LIMIT 1
	";

  $stmt = $mysqli->prepare($SQL);
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $stmt->bind_result($bairro, $cidade, $rua, $complemento, $cep, $estado);
  $stmt->store_result();
  $stmt->fetch();
  //teste se a linha existe
	if ($stmt->num_rows == 1){

			$endereco = new Endereco();

			$endereco->id            = $cliente;
			$endereco->bairro        = $bairro;
			$endereco->cidade        = $cidade;
			$endereco->rua           = $rua;
			$endereco->complemento   = $complemento;
			$endereco->cep           = $cep;
			$endereco->estado        = $estado;

			$arrayEnderecos[] = $endereco;
	}
	return $arrayEnderecos;
}

?>
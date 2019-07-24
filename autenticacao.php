<?php

function filtraEntradaForm($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function loginUsuario($login, $senha, $mysqli){

  $SQL = "
    SELECT idCliente, nomeCliente 
    FROM Cliente
    WHERE emailCliente = ? AND senhaCliente = ?
    LIMIT 1
  ";

  $stmt = $mysqli->prepare($SQL);
  $stmt->bind_param("ss", $login, $senha);
  $stmt->execute();
  $stmt->bind_result($idCliente, $nomeCliente);
  $stmt->store_result();
  $stmt->fetch();
  //teste se a linha existe
  if ($stmt->num_rows == 1){
    $_SESSION['idCliente'] = $idCliente;
    $_SESSION['nomeCliente'] = $nomeCliente;
    $_SESSION['logado'] = true;
    //echo "login realizado com sucesso!!";
  }else{
    $_SESSION['logado'] = false;
    //echo "Senha ou Login incorretos!!";
  }
}

function checkUsuarioLogado($mysqli){
  // checa se existe a variável $_SESSION['logado'] ou se a variável $_SESSION['logado'] é igual a false
  if (!isset($_SESSION['logado']) || $_SESSION['logado'] == false){
    return true;
  }
}

function checkUsuarioLogadoOrDie($mysqli){
  if (!checkUsuarioLogado($mysqli)){
    $mysqli->close();
    die();
  }
}
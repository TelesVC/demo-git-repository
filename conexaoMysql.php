<?php

define("HOST", "fdb24.awardspace.net"); 
define("USER", "3035372_mm");
define("PASSWORD", "1qazxcvbnm"); 
define("DATABASE", "3035372_mm");

function conectaAoMySQL()
{
	$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($conn->connect_error)
	throw new Exception('Falha na conexão com o MySQL: ' . $conn->connect_error);

	return $conn;   
}

?>
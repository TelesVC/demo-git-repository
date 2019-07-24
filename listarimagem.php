<?php

$smarty = new Template();

$produtos = new Produtos();
$produtos - > GetProdutos();


$smarty - > assign('PRO', $produtos - > GetItens());
$smarty - > display('listar_produtos.php');

echo '<pre>';
var_dump($produtos - > GetItens());
echo '<pre>';
?>
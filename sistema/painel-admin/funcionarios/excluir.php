<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

//BUSCAR O REGISTRO JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM funcionarios WHERE  id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_banco = @$res[0]['cpf'];


$pdo->query("DELETE from funcionarios WHERE id = '$id'");
$pdo->query("DELETE from usuarios WHERE cpf = '$cpf_banco'");

echo 'Excluído com Sucesso!';
?>
<?php 
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$cargo = $_POST['cargo'];
$endereco = $_POST['endereco'];
$id = $_POST['id'];

//BUSCAR O REGISTRO JÁ CADASTRADO NO BANCO
$query = $pdo->query("SELECT * FROM funcionarios WHERE  id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_banco = @$res[0]['cpf'];
$email_banco = @$res[0]['email'];

if($cpf != $cpf_banco){
	$query = $pdo->prepare("SELECT * FROM funcionarios WHERE  cpf = :cpf");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'CPF já Cadastrado!';
		exit();
	}
}


if($email != $email_banco){
	$query = $pdo->prepare("SELECT * FROM funcionarios WHERE  email = :email");
	$query->bindValue(":email", "$email");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'Email já Cadastrado!';
		exit();
	}
}




if($id == ""){
	$query = $pdo->prepare("INSERT INTO funcionarios SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, data = curDate(), cargo = :cargo");
}else{
	$query = $pdo->prepare("UPDATE funcionarios SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, data = curDate(), cargo = :cargo WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":cargo", "$cargo");
$query->execute();



//trazer o nome do cargo
$query = $pdo->query("SELECT * FROM cargos WHERE  id = '$cargo'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_cargo = @$res[0]['nome'];

//LANÇAR OU EDITAR DADOS NA TABELA DOS USUÁRIOS
if($id == ""){
	$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = '123', nivel = :cargo");
}else{
	$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = '123', nivel = :cargo WHERE cpf = '$cpf_banco'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":email", "$email");
$query->bindValue(":cargo", "$nome_cargo");
$query->execute();


echo 'Salvo com Sucesso!';
?>
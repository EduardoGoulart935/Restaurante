<?php 
require_once("../conexao.php");
@session_start();
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$query = $pdo->prepare("SELECT * FROM usuarios WHERE (email = :usuario OR cpf = :usuario) AND senha = :senha");
$query->bindValue(":usuario", $usuario);
$query->bindValue(":senha", $senha);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg > 0){
	$nome = $_SESSION['nome'] = $res[0]['nome'];
	$email = $_SESSION['email'] = $res[0]['email'];
	$_SESSION['cpf'] = $res[0]['cpf'];
	$_SESSION['nivel'] = $res[0]['nivel'];
	$_SESSION['id'] = $res[0]['id'];

	if(($nome == $usuario || $email == $usuario) && $res[0]['nivel'] == 'Administrador'){
		echo "<script language='javascript'> window.location='painel-admin' </script>";
	}else{
		header('Location: index.php');
	}
} else {
	header('Location: index.php');
	exit(); 
}
?>

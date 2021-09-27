<?php
	//require_once("modelo/ResponsableModel.php");
	session_start();
	require_once("modelo/UsuarioModel.php");
	$UsuarioModel = new UsuarioModel();
	$usuario = $_SESSION['usuario'];
	$set = array('conectado_usu' => 0);
	$modificar = $UsuarioModel->modificar('usuarios', $set, "usuario_usu=\"$usuario\" AND status_usu=1");
if(isset($_SESSION['usuario']) && isset($_SESSION['token'])) 
{
	session_destroy();
	session_unset();
	$_SESSION = array();
	header("Location:index.php?controlador=Usuario&accion=iniciarSession");
	exit;
}else
{
	//session_destroy();
	//header("Location:index.php");
	exit;
}
?>

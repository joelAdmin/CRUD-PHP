<?php
//@session_start();
class Session
{
	Public function validaSession() 
	{
		//session_start();
		if(!empty($_SESSION['usuario']) && !empty($_SESSION['token'])) 
		{
			require_once 'modelo/UsuarioModel.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');
			//quitamos el posible SQLInjection del user y password
			$_SESSION['usuario'] = $_SESSION['usuario'];//mysql_real_escape_string($_SESSION['usuario']);
			$_SESSION['token'] =  $_SESSION['token'];//mysql_real_escape_string($_SESSION['token']);
			$usuario = $_SESSION['usuario'];
			$token = $_SESSION['token'];
			$consulta =  $UsuarioModel->consultar("usuarios", "usuario_usu =\"$usuario\" AND token_usu=\"$token\" AND status_usu=1");
			$_SESSION['usuario'] = $consulta['usuario_usu'];
				//$_SESSION['nivel'] = $consulta['nivel_usu'];
				
			if(!empty($consulta))
			{
				$set = array('token_usu' => $_SESSION['token']);
				//$postEditar = array('token_usu' => $_SESSION['token'], 'conectado_usu' => 1);
				$modificar = $UsuarioModel->modificar('usuarios', $set, "usuario_usu=\"$usuario\" AND status_usu=1");
				return true;
			}else
			{
				/*
				$set = array('conectado_usu' => 0);
				$modificar = $UsuarioModel->modificar('usuarios', $set, "usuario_usu=\"$usuario\" AND status_usu=1");
				*/
				session_destroy();
				session_unset();
				$_SESSION = array();
				//$_SESSION["bandera"]=false;
				return false;
				//header("Location:index.php");
				//exit;
			}
			
		}else
		{
			
			return false;
		}
		
	}

/*
	Public function protegerVista() 
	{
		//session_start();
		if(!empty($_SESSION['usuario']) && !empty($_SESSION['token'])) 
		{
			require_once 'modelo/UsuarioModel.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');
			//quitamos el posible SQLInjection del user y password
			$_SESSION['usuario'] = $_SESSION['usuario'];//mysql_real_escape_string($_SESSION['usuario']);
			$_SESSION['token'] =  $_SESSION['token'];//mysql_real_escape_string($_SESSION['token']);
			$usuario = $_SESSION['usuario'];
			$token = $_SESSION['token'];
			$consulta =  $UsuarioModel->consultar("usuarios", "usuario_usu =\"$usuario\" AND token_usu=\"$token\" AND status_usu=1");
			$_SESSION['usuario'] = $consulta['usuario_usu'];
				//$_SESSION['nivel'] = $consulta['nivel_usu'];
				
			if(!empty($consulta))
			{
				$set = array('token_usu' => $_SESSION['token']);
				//$postEditar = array('token_usu' => $_SESSION['token'], 'conectado_usu' => 1);
				$modificar = $UsuarioModel->modificar('usuarios', $set, "usuario_usu=\"$usuario\" AND status_usu=1");
				header("Location:index.php?controlador=Usuario&accion=entrar");
				//return true;
			}else
			{
				
				session_destroy();
				session_unset();
				$_SESSION = array();
				//$_SESSION["bandera"]=false;
				//return false;
				header("Location:index.php?controlador=Usuario&accion=iniciarSession");
				//exit;
			}
			
		}else
		{
			
			header("Location:index.php?controlador=Usuario&accion=iniciarSession");
			//return false;
		}
		
	}*/

	/*
	Public function validaSession2() 
	{
		//session_start();
		
		if(isset($_SESSION['usuario']) && isset($_SESSION['token'])) 
		{
			
			require_once 'modelo/UsuarioModel.php';
			
		}else
		{
			session_destroy();
			session_unset();
			$_SESSION = array();
			//$_SESSION["bandera"]=false;
			//header("Location:index.php");
			return false;
		}
		
	}*/
	
}
?>

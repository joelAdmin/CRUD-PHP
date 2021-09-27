<?php
class FrontController
{
	static function main()
	{
		//Incluimos algunas clases:
		/*
		require 'Config.php'; //de configuracion
		require 'SPDO.php'; //PDO con singleton
		require 'ControllerBase.php'; //Clase controlador base
		require 'ModelBase.php'; //Clase modelo base
		require 'View.php'; //Mini motor de plantillas*/
		require 'config.php'; //Archivo con configuraciones.
		//Con el objetivo de no repetir nombre de clases, nuestros controladores
		//terminaran todos en Controller. Por ej, la clase controladora Items, será ItemsController
		//Formamos el nombre del Controlador o en su defecto, tomamos que es el IndexController
		
		if(! empty($_GET['controlador']))
		      $controllerName = $_GET['controlador'] . 'Controller';
		else
		      $controllerName = "IndexController";
		
		//Lo mismo sucede con las acciones, si no hay accion, tomamos index como accion
		if(! empty($_GET['accion']))
		      $actionName = $_GET['accion'];
		else
		      $actionName = "index";
		
		$controllerPath = $config->get('controllersFolder') . $controllerName . '.php';
			
		//Incluimos el fichero que contiene nuestra clase controladora solicitada	
		if(is_file($controllerPath))
		      require $controllerPath;
		else
		     die('El controlador no existe - 404 not found');
		  	 //header("Location:index.php");
		
		//Si no existe la clase que buscamos y su accion, tiramos un error 404
		if (is_callable(array($controllerName, $actionName)) == false) 
		{
			trigger_error ($controllerName . '->' . $actionName . '` no existe', E_USER_NOTICE);
			//header("Location:index.php");
			return false;
		}
		//Si todo esta bien, creamos una instancia del controlador y llamamos a la accion
		if(!empty($_GET['dato']) AND !empty($_GET['dato1']))
		{
			$dato = $_GET['dato'];
			$dato1 = $_GET['dato1'];
			$controller = new $controllerName();
			$controller->$actionName($dato, $dato1);
			
		}elseif(!empty($_GET['dato']))//si se envian variables por la funcion show()
		{   
			$dato = $_GET['dato'];
			$controller = new $controllerName();
			$controller->$actionName($dato);
		}else
		{
			$controller = new $controllerName();
			$controller->$actionName();
		}
		     
	}
}
?>

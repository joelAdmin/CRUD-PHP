<?php
class View
{
	function __construct() 
	{
	}

	// se tiene que modificar esta funcion
	public function show($name, $vars = array(), $vars2 = array(), $vars3 = array(), $vars4 = array()) 
	{
		//$name es el nombre de nuestra plantilla, por ej, listado.php
		//$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.
		
		//Traemos una instancia de nuestra clase de configuracion.
		$config = Config::singleton();
                
		//Armamos la ruta a la plantilla
		$path = $config->get('viewsFolder') . $name;

		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false) 
		{
			trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
			return false;
		}
		
		//Si hay variables para asignar, las pasamos una a una.
		if(is_array($vars))
		{
			//$arreglo=array();
                    foreach ($vars as $key => $value) 
                    {
						$$key = $value;
						//$arreglo[$key]=$value;
                    }
        }
        
        if(is_array($vars2))
		{
			//$arreglo=array();
                    foreach ($vars2 as $key => $value) 
                    {
						$$key = $value;
						//$arreglo[$key]=$value;
                    }
        }
        
          if(is_array($vars3))
		  {
			//$arreglo=array();
                    foreach ($vars3 as $key => $value) 
                    {
						$$key = $value;
						//$arreglo[$key]=$value;
                    }
          }
          
          if(is_array($vars4))
		  {
			//$arreglo=array();
                    foreach ($vars4 as $key => $value) 
                    {
						$$key = $value;
						//$arreglo[$key]=$value;
                    }
          }
          
          //nalmente, incluimos la plantilla.
		include($path);
	}
}
/*
 El uso es bastante sencillo:
 $vista = new View();
 $vista->show('listado.php', array("nombre" => "Juan"));
*/
?>

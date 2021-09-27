<?php
class Funcion
{
	Public function redondear_dos_decimal($valor) 
	{
	   $float_redondeado=round($valor * 100) / 100;
	   return $float_redondeado;
	}
	
	Public function vacio($var)
	{
		if(!empty($var) AND ($var==null))
		{
			return $var;
		}
	}

	Public function evento($arreglo=array())
	{
		$j=0;
		$i=0;
		//$longitud = count($parametros);
		$cadena = null;
		//$evento = array('evento'=>'onclick', 'nombre'=>'editar' ,'parametros'=>array(6, 'usuario', 2, 4, 5, 'juan'));
                       
		foreach ($arreglo as $clave => $valor) 
        {
        	$j++;
        	//$funcion .=$clave.'='.$valor;
        	if($clave == 'evento')
        	{
        		$cadena .= $valor.'="';
        	}elseif($clave == 'nombre')
        	{
        		$cadena .= $valor.'(';
        	}elseif($clave == 'parametros')
        	{
        		$long = count($valor);
        		foreach ($valor as $key =>$value) 
            	{
            		$i++;
	                if($long != $i) 
	                {

	                   if(is_numeric($value)) 
	                   {
	                       $cadena .=''.$value.',';
	                   }else
	                   {
	                        $cadena .='\''.$value.'\',';
	                   }
	                                 
	                }elseif($long==$i) 
	                {
	                    if(is_numeric($value)) 
	                    {
	                        $cadena .= $value.');"';
	                    }else
	                    {
	                        $cadena .= '\''.$value.'\');"';
	                    }
	                }
            	}
        	}

        	/*
        	 if($longitud != $j) 
             {
	            $funcion .= $event;
	            $long = count($parametros);
	            $i=0;

             }elseif($longitud == $j)
             {
             	$funcion .='='.$event.'(';
             }*/

            /*
            foreach ($parametros as $key => $value) 
            {
            	$i++;
                if($long != $i) 
                {

                   if(is_numeric($value)) 
                   {
                       $funcion .=''.$value.',';
                   }else
                   {
                        $funcion .='"'.$value.'",';
                   }
                                 
                }elseif($long==$i) 
                {
                    if(is_numeric($value)) 
                    {
                        $funcion .= $value.');';
                    }else
                    {
                        $funcion .= '"'.$value.'");';
                    }
                }
            }*/
        }

        return $cadena;
	}

	Public function ckEditor_getData($id)
	{
		return  '<script type="text/javascript">CKEDITOR.instances.Mcontenido_men.getData();</script>';
	}

	Public function fecha_formulario($fecha)
	{
		$arreglo = explode("-", $fecha);
		return $arreglo;
	}
	
	public function comprobarArray($arreglo)
	{
		$i=0;
		foreach($arreglo as $key=>$valor)
		{
			$i++;
			$mostrar .='<br>'.$i.' - '.$key.' : '.$valor;
		}
		
		return $mostrar;
	}
	
	Public function genera_random($longitud)
	{ 
		$exp_reg="[^A-Z0-9]"; 
		return substr(eregi_replace($exp_reg, "", md5(rand())) . 
		   eregi_replace($exp_reg, "", md5(rand())) . 
		   eregi_replace($exp_reg, "", md5(rand())), 
		   0, $longitud); 
	}

	Public function fechaMysql($fecha, $signo)
	{
		
		$cadena = explode($signo, $fecha);
		$fecha_Salida = $cadena[2].'-'.$cadena[1].'-'.$cadena[0];
		return $fecha_Salida;
	}

	Public function fecha_datepicker($fecha)
	{
		$cadena = explode('-', $fecha);
		$fecha_Salida = $cadena[2].'/'.$cadena[1].'/'.$cadena[0];
		return $fecha_Salida;
	}

	Public function fecha()
	{
		$fecha_reg = @date( "Y-m-d" );
		return $fecha_reg;
		
	}
	
	Public function fechaReporte()
	{
		$fecha_reg = @date( "d/m/Y" );
		return $fecha_reg;
	}
	Public function formato_fecha($dia, $mes, $ano)
	{
		$fecha_Salida=$ano.'-'.$mes.'-'.$dia;
		return $fecha_Salida;
	} 
	
	function hora()
	{
		$hora= @getdate(time());
		$hora_reg=$hora["hours"].":".$hora["minutes"].":".$hora["seconds"];
		return $hora_reg;
		
	}

	Public function contadorVisita()
	{
		 // fichero donde se guardaran las visitas
		 $fichero = "visitas.txt";
		 if (file_exists($fichero)) 
		 {
		 	# code...
			 $fptr = fopen($fichero,"r");
			 // sumamos una visita
			 $num = fread($fptr,filesize($fichero));
			 $num++;
			 
			 $fptr = fopen($fichero,"w+");
			 fwrite($fptr,$num);
			 
			 return $num;
		}
	}
	
	function BuscarArreglo($array, $find)
	{
		$exists = FALSE;
		if(!is_array($array))
		{
		   return;
		}
		foreach ($array as $key => $value) 
		{
		  if($find == $value)
		  {
			   $exists = TRUE;
		  }
		}
		return $exists;
	}
	
	Public function mayusculasEscape($cadena)
	{
		$cadenaEscape = mysql_real_escape_string($cadena);
		$cadena_resul =  htmlentities(mb_strtoupper($cadenaEscape, 'utf-8'), ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function sinFormato($cadena)
	{
		$cadena_resul =  htmlentities($cadena, ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function mayusculas($cadena)
	{
		$cadena_resul =  htmlentities(mb_strtoupper($cadena, 'utf-8'), ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function minusculasEscape($cadena)
	{
		$cadenaEscape = mysql_real_escape_string($cadena);
		$cadena_resul =  htmlentities(mb_strtolower($cadenaEscape, 'utf-8'), ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function minusculas($cadena)
	{
		$cadena_resul =  htmlentities(mb_strtolower($cadena, 'utf-8'), ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function validateEscape($cadena)
	{
		$cadenaEscape = mysql_real_escape_string($cadena);
		$cadena_resul =  htmlentities($cadenaEscape, ENT_QUOTES, "UTF-8");
		return $cadena_resul;
	}
	
	Public function crearArrayStr($cadena, $signo)//hacerle modificacion para que cree un array asociativo
	{
		$cadenaArray = explode($signo, $cadena);
		return $cadenaArray;
	}
	
	Public function edad($edad)
	{
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0)
		$anio_dif--;
		return $anio_dif;
	}

	Public function mesString($dato){
		$mes=sprintf("%01d",$dato);
		$arrayMeses=array("01"=>"enero", "02"=>"febrero", "03"=>"marzo", "04"=>"abril", "05"=>"mayo", "06"=>"junio", "07"=>"julio", "08"=>"agosto",
		"09"=>"septiembre", "10"=>"octubre", "11"=>"noviembre", "12"=>"diciembre");
		foreach($arrayMeses as $meses=>$mesesString){
			if($mes==$meses){
				return $mesesString;
				break;
			}
			
		}
	}
	
	Public function enviarArrayUrl($array)
	{ 
		$tmp = serialize($array); 
		$tmp = urlencode($tmp); 
		return $tmp; 
	} 
	
	Public function recibirArrayUrl($url_array=array()) 
	{ 
		$tmp = stripslashes($url_array); 
		$tmp = urldecode($tmp); 
		$tmp = unserialize($tmp); 
	   
	   return $tmp; 
	}
	
	Public function dameURL()
	{
		$url="http://".$_SERVER['HTTP_HOST']."/".$_SERVER['REQUEST_URI'];
		return $url;
	} 
	/*
	Public function variable($var, $post)
	{
		if(!empty($var) && empty($post))
		{
			return $var;
		}else
		{
			return $post;
		}
	}
	*/
	Public function variable($var, $post)
	{
		if(!empty($var) && empty($post))
		{
			return $var;
		}elseif((empty($var)) && (!empty($post)))
		{
			return $post;
		}else
		{
			return $var;
		}
	}
	
	Public function variableTelf($var, $post)
	{
		if(!empty($var) && empty($post))
		{
			$cadena = explode('-', $var);
			return $cadena[1];
		}else
		{
			return $post;
		}
	}
	
	Public function variableTelfArea($var, $post)
	{
		if(!empty($var) && empty($post))
		{
			$cadena = explode('-', $var);
			return $cadena[0];
		}else
		{
			return $post;
		}
	}
	
	Public function telefono($area, $numero)
	{
		if((!empty($area) && empty($numero) || empty($area) && !empty($numero)))
		{
			return false;
		}elseif(!empty($area) && !empty($numero))
		{
			return $area.'-'.$numero;
		}
	}
	
	Public function copiarArchivo($archivo, $nuevoArchivo)
	{
		if(is_file($archivo)){ //indica si es un fichero normal
		$permisos = fileperms($archivo); //obtener los permisos de un archivo
		return copy($archivo, $nuevoArchivo) && chmod($nuevoArchivo, $permisos);
		}
		else if(is_dir($archivo)){
		copiarCarpeta($archivo, $nuevoArchivo);
		}
		else{
		die("Cannot copy file: $archivo (it's neither a file nor a directory)");
		} 
	}

	Public function copiarCarpeta($archivo, $nuevoArchivo) 
	{
		if(!is_dir($nuevoArchivo)){
		mkdir($nuevoArchivo);
		chmod("$nuevoArchivo", 0777);
		}
		$dir = opendir($archivo);
		while($file = readdir($dir)){
		if($file == "." || $file == ".."){
		continue;
		}
		copiarArchivo("$archivo/$file", "$nuevoArchivo/$file");
		}
		closedir($dir);
	}
	
	Public function cleanInput($value, $link = '')
	{
		if(is_array($value))
		{
			foreach($value as $key => $val)
			{
				$value[$key] = cleanInput($val);
			}

			return $value;
		}
		else
		{
			return strip_tags(trim($value), $link);
		}
	}
	
	Public function urlImagen($campo, $carpeta, $prefijo)
	{

		$codigo=$prefijo.''.$this->genera_random(4);
		$nombreArchivo=$codigo.'.png'; //para que todas la imagenes esten en el mismo formato
		$name = "cargarImg";
		@rename($_FILES["$campo"]['name'], $nombreArchivo);//renombramos el archivo
		$directorio = $carpeta.'/'.$nombreArchivo;

		return $directorio;
		
	}

	Public function cambiarImagen($campo, $directorio)
	{

		/*$codigo=$prefijo.''.$this->genera_random(4);
		$nombreArchivo=$codigo.'.png'; //para que todas la imagenes esten en el mismo formato
		$name = "cargarImg";*/
		$arreglo = explode('/',  $directorio);
		$nombreArchivo = array_pop($arreglo);
		/*
		@rename($_FILES["$campo"]['name'], $nombreArchivo);//renombramos el archivo
		$directorio = $carpeta.'/'.$nombreArchivo;
		*/
		if(@copy($_FILES["$campo"]['tmp_name'], $directorio))
		{
			return $directorio;
		}else
		{
			return false;
		}
	
	}

	Public function cargarImagenUrl($campo, $directorio)
	{

		/*$codigo=$prefijo.''.$this->genera_random(4);
		$nombreArchivo=$codigo.'.png'; //para que todas la imagenes esten en el mismo formato
		$name = "cargarImg";
		@rename($_FILES["$campo"]['name'], $nombreArchivo);//renombramos el archivo
		$directorio = $carpeta.'/'.$nombreArchivo;*/
		
		if(@copy($_FILES["$campo"]['tmp_name'], $directorio))
		{
			return $directorio;
		}else
		{
			return false;
		}
	
	}

	Public function cargarImagen($campo, $carpeta, $prefijo)
	{

		$codigo=$prefijo.''.$this->genera_random(4);
		$nombreArchivo=$codigo.'.png'; //para que todas la imagenes esten en el mismo formato
		$name = "cargarImg";
		@rename($_FILES["$campo"]['name'], $nombreArchivo);//renombramos el archivo
		$directorio = $carpeta.'/'.$nombreArchivo;
		
		if(@copy($_FILES["$campo"]['tmp_name'], $directorio))
		{
			return $directorio;
		}else
		{
			return false;
		}
	
	}
	
	Public function cargarImagen_2($campo, $carpeta, $prefijo)
	{

		$tot = count($_FILES["$campo"]["name"]);
		if (isset ($_FILES["$campo"]))
        {
			for ($i = 0; $i < $tot; $i++)
			{
				$codigo=$prefijo.''.$this->genera_random(4);
				$nombreArchivo=$codigo.'.png'; //para que todas la imagenes esten en el mismo formato
				$name = "cargarImg";
				
				//$tmp_name = $_FILES["archivos"]["tmp_name"][$i];
				@rename($_FILES["$campo"]['name'][$i], $nombreArchivo);//renombramos el archivo
				$directorio = $carpeta.'/'.$nombreArchivo;
				
				if(@copy($_FILES["$campo"]['tmp_name'][$i], $directorio))
				{
					if($i>1)
					{
						$cadena .= ';'.$directorio;
					}else
					{
						$cadena .= $directorio.';';
					}
				}else
				{
					return false;
				}		
			}
			
			return $cadena;
			
		  }else
		  {
			 return false;
		  }
			
	}
	
	Public function esPar($numero)
	{ 
	   $resto = $numero%2; 
	   if (($resto==0) && ($numero!=0)) 
	   { 
			return true ;
	   }else
	   { 
			return false ;
	   }
	}
	
	Public function redimensionarImagen($rutaOriginal, $rutaCrear, $max_ancho, $max_alto)
	{
		function get_image_extension($filename, $include_dot = true, $shorter_extensions = true) {
		  $image_info = @getimagesize($filename);
		  if (!$image_info || empty($image_info[2])) {
			return false;
		  }

		  if (!function_exists('image_type_to_extension')) {
		
			function image_type_to_extensiona ($imagetype, $include_dot = true) {
			  $extensions = array(
				1  => 'gif',
				2  => 'jpeg',
				3  => 'png',
				4  => 'swf',
				5  => 'psd',
				6  => 'bmp',
				7  => 'tiff',
				8  => 'tiff',
				9  => 'jpc',
				10 => 'jp2',
				11 => 'jpf',
				12 => 'jb2',
				13 => 'swc',
				14 => 'aiff',
				15 => 'wbmp',
				16 => 'xbm',
			  );

			  // We are expecting an integer between 1 and 16.
			  $imagetype = (int)$imagetype;
			  if (!$imagetype || !isset($extensions[$imagetype])) {
				return false;
			  }

			  return ($include_dot ? '.' : '') . $extensions[$imagetype];
			}
		  }

		  $extension = image_type_to_extension($image_info[2], $include_dot);
		  if (!$extension) {
			return false;
		  }

		  if ($shorter_extensions) {
			$replacements = array(
			  'jpeg' => 'jpg',
			  'tiff' => 'tif',
			);
			$extension = strtr($extension, $replacements);
		  }
		  return $extension;
		}
		//Ruta de la imagen original
		$rutaImagenOriginal=$rutaOriginal;
		$exten = get_image_extension($rutaImagenOriginal);
		//Creamos una variable imagen a partir de la imagen original
		if($exten=='.gif' OR $exten=='.GIF')
		{
			$img_original = imagecreatefromgif($rutaImagenOriginal);
		}elseif($exten=='.png' OR $exten=='.PNG')
		{
			$img_original = imagecreatefrompng($rutaImagenOriginal);
		}elseif(($exten=='.jpg') OR ($exten=='.JPG') OR ($exten=='.jpeg') OR ($exten=='.JPEG'))
		{
			$img_original = imagecreatefromjpeg($rutaImagenOriginal);
		}
		//Se define el maximo ancho o alto que tendra la imagen final
		//$max_ancho = 400;
		//$max_alto = 300;
		
		//Ancho y alto de la imagen original
		list($ancho,$alto)=getimagesize($rutaImagenOriginal);
		
		//Se calcula ancho y alto de la imagen final
		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;
		
		//Si el ancho y el alto de la imagen no superan los maximos, 
		//ancho final y alto final son los que tiene actualmente
		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
			$ancho_final = $ancho;
			$alto_final = $alto;
		}
		/*
		 * si proporcion horizontal*alto mayor que el alto maximo,
		 * alto final es alto por la proporcion horizontal
		 * es decir, le quitamos al alto, la misma proporcion que 
		 * le quitamos al alto
		 * 
		*/
		elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		}
		/*
		 * Igual que antes pero a la inversa
		*/
		else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}
		//Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
		$tmp=imagecreatetruecolor($ancho_final,$alto_final);	
		//Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
		imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		//Se destruye variable $img_original para liberar memoria
		imagedestroy($img_original);
		//Definimos la calidad de la imagen final
		$calidad=95;
		
		//Se crea la imagen final en el directorio indicado
		imagejpeg($tmp, $rutaCrear, $calidad);
		
	}
	
	Public function mensaje($mensaje, $notificacion)
	{
		return array("id" => "1", "mensaje" => "$mensaje", "notificacion" => "$notificacion");
	}

	function ceros($numero, $largo) 
    { 
        $resultado = $numero;
        while(strlen($resultado) < $largo) 
        { 
             $resultado = "0".$resultado;  
        } 
        return $resultado;
    }

   
}
?>

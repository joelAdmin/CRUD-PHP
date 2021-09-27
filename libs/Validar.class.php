<?php
class Validar 
{
		Public function validarFile($campo, $formatos)
		{ //echo 'archivo:'.$formatos;
			$count = count($formatos);
			$i=0;
			foreach ($formatos as $key => $value) 
			{
				$i++;
				if( $_FILES[$campo]['type'] == $value )
				{
					//echo $_FILES[$campo]['type'].'>='.$value.'<br>';
					return true;
				}
			}
		}

		Public function vacio($caneda)
		{
			//NO hay nada escrito
			if(strlen($caneda) == 0)
				return true;
			else
				return false;
		}

		Public function longitudMax($caneda, $num)
		{
			//NO cumple longitud minima
			if(strlen($caneda) > $num)
				return false;
			else
				return true;
		}

		Public function longitudMenor($caneda, $num)
		{
			//NO cumple longitud minima
			if(strlen($caneda) < $num)
				return true;
			else
				return false;
		}

		Public function numerico($caneda)
		{
			//NO cumple longitud minima
			if(strlen($caneda) > 0)
			{
				if(!preg_match("/^(\d+[\.]?)+$/", $caneda))
					return true;
				// SI longitud, SI caracteres A-z
				else
					return false;
			}else
			{
				return false;
			}
		}

		Public function confirmarPassword($password1, $password2)
		{
			//NO coinciden
			if($password1 != $password2)
				return true;
			else
				return false;
		}

		Public function validateEmail($email)
		{
			if(strlen($email) > 0)
			{
				if(!preg_match("/[a-z0-9!#$%&'*+\/=?\^_`{|}~\-]+(?:\.[a-z0-9!#$%&'*+\/=?\^_`{|}~\-]+)*@(?:[a-z0-9](?:[a-z0-9\-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9\-]*[a-z0-9])/i", $email))
				{
					return true;
				}else
				{
					return false;
				}
			}
			

			/*if(strlen($email) > 0)
			{
				//NO hay nada escrito
				if(strlen($email) == 0)
					return false;
				// SI escrito, NO VALIDO email
				else if(!preg_match("/[a-z0-9!#$%&'*+\/=?\^_`{|}~\-]+(?:\.[a-z0-9!#$%&'*+\/=?\^_`{|}~\-]+)*@(?:[a-z0-9](?:[a-z0-9\-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9\-]*[a-z0-9])/i", $email))
					return false;
				// SI rellenado, SI email valido
				else
					return true;
			}elseif(strlen($email)==0)
			{
				return true;
			}*/
		}
		
		function validateEspacioBlanco($usuario)
		{
	
			if(!preg_match("/^([0-9a-zA-Z])+$/",$usuario))
			{ 
				return true; 
			} 
		}
		
		
		Public function validateHacker($var)
		{
			//Array con las posibles cadenas a utilizar por un hacker
			$CadenasProhibidas = array("Content-Type:",
			"MIME-Version:", //evita email injection
			"Content-Transfer-Encoding:",
			"Return-path:",
			"Subject:",
			"From:",
			"Envelope-to:",
			"To:",
			"bcc:",
			"cc:",
			"UNION", // evita sql injection
			"DELETE",
			"DROP",
			"SELECT",
			"INSERT",
			"UPDATE",
			"CRERATE",
			"TRUNCATE",
			"ALTER",
			"INTO",
			"DISTINCT",
			"GROUP BY",
			"WHERE",
			"RENAME",
			"DEFINE",
			"UNDEFINE",
			"PROMPT",
			"ACCEPT",
			"VIEW",
			"COUNT",
			"HAVING",
			
			"'",
			'"',
			"{",
			"}",
			"[",
			"]",
			"HOTMAIL", // evita introducir direcciones web
			"WWW",
			".COM",
			"@",
			"W W W",
			". c o m",
			"http://",
			"$", //variables y comodines
			"&",
			"*"
			); 
			//Comprobamos que entre los datos no se encuentre alguna de 
			//las cadenas del array. Si se encuentra alguna cadena se 
			//dirige a una página de Forbidden 
			$vandera="";
			foreach($CadenasProhibidas as $valor)
			{ 
				if((strpos(strtolower($var), strtolower($valor)) !== false))
				{ 
					return true;
				}
			}
		}
		
		Public function buscarCadena($var)
		{
			$CadenasProhibidas = array("id=&quot;div_contenido&quot;","id=&quot;div_contenido&quot;"); 
			$vandera="";
			foreach($CadenasProhibidas as $valor)
			{ 
				if((strpos(strtolower($var), strtolower($valor)) !== false))
				{ 
					return true;
				}
			}
		}

		Public function calculaEdad($fechanacimiento)
		{
		   /***************************************************************
		   	Modo de uso echo calculaEdad ('1979-10-15'); // Imprimirá: 30
		   ***************************************************************/
		    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
		    $ano_diferencia  = date("Y") - $ano;
		    $mes_diferencia = date("m") - $mes;
		    $dia_diferencia   = date("d") - $dia;
		    if ($dia_diferencia < 0 || $mes_diferencia < 0)
		        $ano_diferencia--;
		    return $ano_diferencia;
		}
}
?>

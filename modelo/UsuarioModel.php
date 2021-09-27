<?php
	class UsuarioModel extends ModelBase 
	{
	
		protected $Modelo;
		
		public function __construct()
		{
			$this->Modelo = new ModelBase();
			
			return parent ::__construct(); //reutilizar el constructor del padre
		}

		Public Function consultar($tabla, $where=null, $condicion=null, $cabeceras=null)
		{
			$array = $this->Modelo->consultarSQL($tabla, $where, $condicion, $cabeceras);
			return $array;
		}
		
		/*
		Public Function modificar($tabla, $set=array(), $where=1)
		{
			//$postEditar = array('token_usu' => $_SESSION['token']);
			$modificar = $this->Modelo->editarSQL($tabla, $set, $where);
			return $modificar;
		}
		*/

		Public Function modificar($tabla, $set=array(), $where=1)
		{
			
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$i=0;
			foreach ($set as $key => $value) 
			{
				$i++;
				$postEditar[substr($key, (1-strlen($key)))] = $value;
				if ($i==sizeof($_POST)) 
				{
					//$postInsert['token_usu'] = md5('1234');
					$postEditar['fecha_mod_usu'] = $Funcion->fecha();
					$postEditar['hora_mod_usu'] =  $Funcion->hora();
							
				}
			}
			$modificar = $this->Modelo->editarSQL($tabla, $postEditar, $where);
			return $modificar;
		}

		Public function registrar()
		{
			$Funcion = new Funcion();
			$i=0;
			foreach ($_POST as $key => $value) 
			{
				$i++;
				if($key != 'clave_usu2')
				{
					if($key == 'password_usu') 
					{
						$postInsert[$key] = md5($value);
					}else
					{
						$postInsert[$key] = $value;
					}
				}
				
				if ($i==sizeof($_POST)) 
				{
					$postInsert['token_usu'] = md5('1234');
					$postInsert['conectado_usu'] = 0;
					$postInsert['fecha_reg_usu'] = $Funcion->fecha();
					$postInsert['hora_reg_usu'] =  $Funcion->hora();
					$postInsert['fecha_mod_usu'] = $Funcion->fecha();
					$postInsert['hora_mod_usu'] =  $Funcion->hora();
					$postInsert['status_usu'] = 1;
				}

			}
			
			$id = $this->Modelo->insertarSQL_2('usuarios', $postInsert);
			if(!empty($id)){
				return true;
			}else
			{
				return false;
			}
		}

		Public Function iniciarSession()
		{
			
			//require_once 'libs/Funciones.class.php';
			$i=0;
			$Funcion = new Funcion();
			$usuario = $_POST["usuario"];//$Funciones->validateEscape($post["usuario"]);
			$clave = md5($_POST["clave"]);//md5(md5($Funciones->validateEscape($post["clave"])));
			/*
			if(!empty($_SESSION['usuario']))
			{
				echo "iniciar";
			}*/

			$rowUsuario = $this->Modelo->consultarSQL("usuarios", "(password_usu=\"$clave\" AND usuario_usu=\"$usuario\" AND status_usu=1)");
			if(!empty($rowUsuario))
			{
				//session_start();
				$_SESSION['id'] = session_id();
				/*
				echo 'id:'.session_id();
				echo'<br/>';
				echo 'id:'.$_SESSION['id'];*/
				$_SESSION['bandera'] = true;
				$_SESSION['id'] = session_id();
				$_SESSION['usuario'] = $usuario;
				$_SESSION['tipo_usu'] = $rowUsuario['tipo_usu'];
				$_SESSION['id_usuarios'] = $rowUsuario['id_Usuario'];
					
				$_SESSION['token'] = md5(rand().$_SESSION['usuario']);
					
				//actualizamos el token para qu sean iguales el de la db
				$postEditar = array('token_usu' => $_SESSION['token'], 'conectado_usu' => 1);
				$modificar = $this->Modelo->editarSQL('usuarios', $postEditar, "usuario_usu=\"$usuario\" AND status_usu=1");
					 //todo bien
				return true;
			}else
			{
				return false;
			}
		}


		Public function __destruct()
		{
			$this->Modelo = new ModelBase();
			
			return parent ::__destruct();
		}
		
	}
?>
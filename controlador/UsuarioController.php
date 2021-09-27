<?php 
	class UsuarioController extends ControllerBase
	{
		Public function validarSession()
		{
			require_once 'libs/Session.class.php';
			$Session = new Session('libs/Session.class.php');

	        if(!$Session->validaSession())
	        { 
	        	$this->view->show("Vadmin.php"); 
	        	exit; 
	        }
		}

		Public function guardar()
		{
			$this->validarSession();
			$this->view->show("VnuevoUsuario.php", array('tipo'=>'success', "msj"=>'Los Datos fueron guardados correctamente.'));      		
		}

		Public function nuevoUsuario()
		{
			$this->validarSession();
			$this->view->show("VnuevoUsuario.php");
		}
		
		Public function iniciarSession()
		{
			require_once 'libs/Validar.class.php';
			require_once 'libs/Funciones.class.php';
			require_once 'modelo/UsuarioModel.php';
			require_once 'libs/Session.class.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');
			$Validar = new Validar('libs/Validar.class.php');
			$Funcion = new Funcion('libs/Funciones.class.php');
			$Session = new Session('libs/Session.class.php');

	        if($Session->validaSession())
	        { 
	        	$this->view->show("VpanelAdmin.php", array('msn' => session_id())); 
	        	exit; 
	        }

	        
	        if(isset($_POST) && $_POST != null)
	        {
	            $i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	              /*  $error_usuario = null;
	                $error_clave = null;*/
	                if($key == 'usuario')
	                {
	                    $indice = 'error_'.$i;

	                    if($Validar->vacio($value))
	                    {
	                        $error_usuario = $Funcion->enviarArrayUrl(array($key="El campo usuario no puede estar vacio"));
	                        $arreglo = array($indice=>$error_usuario);
	                        //$this->view->show("Vadmin.php", array($enviar=>$error));

	                    }elseif($Validar->validateEspacioBlanco($value)) 
	                    {
	                        $error_usuario = $Funcion->enviarArrayUrl(array($key="No puede contener espacios en blanco"));
	                        $arreglo = array($indice=>$error_usuario);
	                       // $this->view->show("Vadmin.php", array($enviar=>$error));
	                    }

	                    
	                }elseif($key == "clave") 
	                {
	                    $indice = 'error_'.$i;
	                    if($Validar->vacio($value))
	                    {
	                        $error_clave = $Funcion->enviarArrayUrl(array($key="El campo no puede estar vacio"));
	                        $arreglo[$indice] = $error_clave; 

	                    }

	                    
	                }
	            }
	            //echo 'los datos fueron enviados';
	            if (isset($arreglo))
	            {
	            	$this->view->show("Vadmin.php", array("campo"=>$arreglo));
	            	$_POST = array();
	            }else
	            {
	              //echo 'arreglo:'.$arreglo;
	              if($UsuarioModel->iniciarSession())
	              {
	              		$this->view->show("VpanelAdmin.php");  
	              }else
	              {
	              		//echo 'eeeeeeee';
	              		$this->view->show("Vadmin.php", array('tipo'=>'danger', "msj"=>'usuario o clave incorrecta.'));
	              }
	            }
	            
	            
	        }else
	        {
	           // echo 'cccccccc';
	            $this->view->show("Vadmin.php");
	        }
    
		}
		
		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			if($_SESSION['tipo_usu']<>1) 
			{
				$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			}
			require_once 'modelo/UsuarioModel.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	                if($key == 'usuario_usu')
	                {
	                    $indice = 'error_'.$i;

	                    $reglas = $ValidarForm->validar($value, array('vacio', 'validateEspacioBlanco'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo = array($indice=>$reglas);
	                    	
	                    }else
	                    {

	                    	$consultar = $UsuarioModel->consultar('usuarios', 'status_usu=1 and usuario_usu="'.$value.'"');
	                    	if(!empty($consultar)){
	                    		$arreglo = array($indice => $ValidarForm->texto_url(' Este usuario ya existe.'));

	                    	}
	                    }
	                    
	                }elseif($key == "password_usu") 
	                {
	                    $indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio', 'validateEspacioBlanco', array('longitudMenor', $value, 4)));
	                    if(!empty($reglas)){$arreglo[$indice] = $reglas; }
	                   

	                }elseif($key == "clave_usu2") 
	                {
	                    $indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio', 'validateEspacioBlanco', array('confirmarPassword', $value, $_POST['password_usu'])));
	                   	if(!empty($reglas)){$arreglo[$indice] = $reglas;  }
	                   
	                }elseif($key == "tipo_usu") 
	                {
	                    $indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$indice] = $reglas;}

	                }

  
	            }

	           	if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoUsuario.php", array("campo"=>$arreglo));
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	
	            	if($UsuarioModel->registrar())
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Usuario&accion=guardar');
	            		//$this->view->show("VnuevoUsuario.php", array('tipo'=>'success', "msj"=>'los Datos fueron guardados correctamente'));	            		
	            	}
	            }
	           
	        }else
	        {
	        	$this->view->show("VnuevoUsuario.php");
	        }
		}
		
		Public function procesar_editar_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/UsuarioModel.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');
			#$consulta = $UsuarioModel->consultar('usuarios', "id_Usuario=22 AND status_usu=1", 1);
			         	
			//echo json_encode($consulta);

			if(isset($_POST) && $_POST != null)
	        {
	        	$nombre = addslashes(htmlspecialchars(@$_POST["Musuario_usu"]));
				$id = addslashes(htmlspecialchars(@$_POST["Mid_Usuario"]));
				#$consultar = $UsuarioModel->consultar('usuarios', "status_usu=1 and id_Usuario<>$id and usuario_usu='$nombre' ");
	          
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;

	                if($key == 'Musuario_usu')
	                {
	                    $indice = 'error_'.$i;

	                    $reglas = $ValidarForm->validar($value, array('vacio', 'validateEspacioBlanco'));
	                    if(!empty($reglas))
	                    {
	                    	$ValidarForm->mostrar_error('Musuario_usu', 'EL CAMPO NO PUEDE ESTAR VACIO');
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $UsuarioModel->consultar('usuarios', "status_usu=1 and id_Usuario<>$id and usuario_usu='$value' ");
	                    	if(!empty($consultar)){
								$ValidarForm->mostrar_error('Musuario_usu', 'EL USUARIO ESTA REPETITO');
								$error = true;
	                    	}else{
	                    		$ValidarForm->limpiar_error('Musuario_usu');
	                    	}
	                    }
	                    
	                }elseif($key == "Mtipo_usu") 
	                {
	                    $indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	//$arreglo[$indice] = $reglas;
	                    	$ValidarForm->mostrar_error('Mtipo_usu', 'SELECCIONE UNA OPCION');
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mtipo_usu');
	                    }

	                }
	            }

	            if (!isset($error)) 
	            {
	            	$i=0;
	            	
	            	$modificar = $UsuarioModel->modificar('usuarios', $_POST, "id_Usuario=$id");
	            	$consultar = $UsuarioModel->consultar('usuarios', "status_usu=1 and id_Usuario=$id", 4, "usuario_usu, conectado_usu, status_usu");
	            	
	            	if(@$modificar)
	            	{
	            		//$ValidarForm->actualizar_text($id, 'td', $consultar);
	            		//$ValidarForm->mensaje_jquery('respuesta', "LOS DATOS FUERON  MODIFICADO CORRECTAMENT", 'success');
	            		$ValidarForm->edit_tr($id, 'Usuario', $consultar);
	            		$ValidarForm->cerrar_modal('modal_2');
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery('respuesta', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger');
	            
	            	}
	            }
	        }

		}

		Public function mostrar_editar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/UsuarioModel.php';
			$UsuarioModel = new UsuarioModel('modelo/UsuarioModel.php');
			$consulta = $UsuarioModel->consultar('usuarios', "id_Usuario=$id AND status_usu=1", 1);

			echo json_encode($consulta);
			return json_encode($consulta);
		}


		Public function salir()
		{
			$this->view->show("salir.php");
		}
		
	}
?>

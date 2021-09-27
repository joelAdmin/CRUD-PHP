<?php 
	class PaginaController extends ControllerBase
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
			$this->view->show("VnuevoUsuario.php", array('tipo'=>'success', "msj"=>'los Datos fueron guardados correctamente'));      		
		}
		
		Public function procesar_enviar_msj_ajax()
		{
			//$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/PaginaModel.php';
			$PaginaModel = new PaginaModel('modelo/PaginaModel.php');
			#$consulta = $UsuarioModel->consultar('usuarios', "id_Usuario=22 AND status_usu=1", 1);
			//echo json_encode($consulta);

			if(isset($_POST) && $_POST != null)
	        {
	        	$nombre = addslashes(htmlspecialchars(@$_POST["nombre_con"]));
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;

	                if($key == 'nombre_con')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
			            {
			                $mensaje = $Funcion->recibirArrayUrl($reglas); 
			                $ValidarForm->mostrar_error('nombre_con', $mensaje[0]);
			                $error = true;
			            }else
			            {
			                $ValidarForm->limpiar_error('nombre_con');
			        	}
	                    
	                }elseif($key == 'correo_con')
		            {
		                $reglas = $ValidarForm->validar($value, array('vacio', 'correo'));
		                if(!empty($reglas))
			            {
			                $mensaje = $Funcion->recibirArrayUrl($reglas); 
			                $ValidarForm->mostrar_error('correo_con', $mensaje[0]);
			                $error = true;
			            }else
			            {
			                $ValidarForm->limpiar_error('correo_con');
			        	}
			        }elseif($key == 'comentario_con')
		            {
		                $reglas = $ValidarForm->validar($value, array('vacio'));
		                if(!empty($reglas))
			            {
			                $mensaje = $Funcion->recibirArrayUrl($reglas); 
			                $ValidarForm->mostrar_error('comentario_con', $mensaje[0]);
			                $error = true;
			            }else
			            {
			                $ValidarForm->limpiar_error('comentario_con');
			        	}
			        }
	            }

	            if (!isset($error)) 
	            {
	            	$i=0;
	            	
	            	$insertar = $PaginaModel->registrar('contactos', $_POST);
	            	$consultar = $PaginaModel->consultar('usuarios', "status_usu=1 and id_Usuario=$id ORDER BY posicion_men ASC", 4, "usuario_usu, conectado_usu, status_usu");
	            	
	            	if(@$insertar)
	            	{
	            		$ValidarForm->mensaje_jquery('respuesta', "los datos fueron enviados correctamente", 'success');
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery('respuesta', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger');
	            
	            	}
	            }
	        }

		}
	}
?>

<?php 
	class PermisoController extends ControllerBase
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
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			//$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);

			require_once 'modelo/PermisoModel.php';
			$PermisoModel = new PermisoModel('modelo/PermisoModel.php');
			
			$result_usuario = $PermisoModel->consultar('usuarios as U', 'U.status_usu=1', 4, 'U.id_Usuario, U.usuario_usu');
			while($row = $result_usuario->fetch())
			{
				$usuario[$row['id_Usuario']] = $row['usuario_usu'];
			}
			$usuarios['usuario'] = $usuario;
			$this->view->show("VaccesoSeguridad.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'), $usuarios); 	
		}

		Public function registrar()
		{
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			if($_SESSION['tipo_usu']<>1) 
			{
				$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			}
			require_once 'modelo/PermisoModel.php';
			$PermisoModel = new PermisoModel('modelo/PermisoModel.php');
			
			$result_usuario = $PermisoModel->consultar('usuarios as U', 'U.status_usu=1', 4, 'U.id_Usuario, U.usuario_usu');
			while($row = $result_usuario->fetch())
			{
				$usuario[$row['id_Usuario']] = $row['usuario_usu'];
			}

			$usuarios['usuario'] = $usuario;
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	if($key == 'id_Usuario')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key == 'nombre_prm')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='controlador_prm')
		            {
		               	$reglas = $ValidarForm->validar($value, array('vacio'));
		                if(!empty($reglas))
		                {
		                   $arreglo[$key] = $reglas;
		                }else
		                {
		                	$codigo_prm = $_POST['controlador_prm'].''.$_POST['accion_prm'];
		                	$id_Usuario = $_POST['id_Usuario'];
		                	$consultar = $PermisoModel->consultar('permisos as P', 'P.status_prm=1 && P.codigo_prm="'.$codigo_prm.'" && P.id_Usuario='.$id_Usuario.'');
	                    	if(!empty($consultar))
	                    	{
	                    		$arreglo[$key] = $ValidarForm->texto_url('El Usuario ya tiene creado este permiso con el codigo <b>'.$codigo_prm.'</b>, por favor utilzar un <b>Controlador</b> o <b>Accion</b> diferente.');
	                    		$arreglo['accion_prm'] = $ValidarForm->texto_url('El Usuario ya tiene creado este permiso con el codigo <b>'.$codigo_prm.'</b>, por favor utilzar un <b>Controlador</b> o <b>Accion</b> diferente.');
	                    
	                    	}
		                }
		            }elseif($key=='accion_prm')
		            {
		                $reglas = $ValidarForm->validar($value, array('vacio'));
		                if(!empty($reglas))
		                {
		                    $arreglo[$key] = $reglas;
		                }
		            }
	           	}

	           	if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VaccesoSeguridad.php", array("campo"=>$arreglo), $usuarios);
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	if($PermisoModel->registrar($_POST))
	            	{
	            		header('Location:index.php?controlador=Permiso&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VaccesoSeguridad.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Error al intentar guardar los datos.'), $usuarios);      		
	            	}
	            }
	        }else
	        {
	        	$this->view->show("VaccesoSeguridad.php", $usuarios);  
	        }	
		}
		
		Public function mostrar_permiso_ajax($id)
		{
			 require_once 'modelo/PermisoModel.php';
			$PermisoModel = new PermisoModel('modelo/PermisoModel.php');
			$result_usuario = $PermisoModel->consultar('permisos as P', "P.id_Usuario=$id && P.status_prm=1", 2, null);
			$rawdata = array(); //creamos un array
		    $i=0;
		    while($ro =$result_usuario->fetch())
		    {
		        $rawdata[$i] = $ro;
		        $i++;
		    }

			echo json_encode($rawdata);

	    }

		Public function procesar_permiso_ajax($id_Permiso)
		{
			 require_once 'modelo/PermisoModel.php';
			$PermisoModel = new PermisoModel('modelo/PermisoModel.php');
			$result_permiso = $PermisoModel->consultar('permisos as P', "P.id_Permiso=$id_Permiso && P.status_prm=1", 'assoc', null);
			
			if ($result_permiso['estado_prm']==1) 
			{
				$actualizar = $PermisoModel->modificarSQL('permisos', array('estado_prm'=>0), "id_Permiso=$id_Permiso && status_prm=1");
			}else if($result_permiso['estado_prm']==0)
			{
				$actualizar = $PermisoModel->modificarSQL('permisos', array('estado_prm'=>1), "id_Permiso=$id_Permiso && status_prm=1");
			} 

			$result_permiso_f5 = $PermisoModel->consultar('permisos as P', "P.id_Permiso=$id_Permiso && P.status_prm=1", 'assoc', null);
			echo json_encode($result_permiso_f5);
	    }

		Public function bloqueado()
		{
			$this->view->show("VaccesoBloqueado.php"); 
		}
	}
?>
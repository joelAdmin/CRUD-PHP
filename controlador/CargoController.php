<?php 
	class CargoController extends ControllerBase
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
			$this->view->show("VnuevoCargo.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'));      		
		}

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/CargoModel.php';
			$CargoModel = new CargoModel('modelo/CargoModel.php');
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	                if($key == 'nombre_car')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif ($key=='tipo_car') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }

	                }
	            }
	            /************ FIN DE CICLO FOR *****************/

	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoCargo.php", array("campo"=>$arreglo));
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	// header('Location:index.php?controlador=Cargo&accion=guardar');
	            	if($CargoModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Cargo&accion=guardar');
	            	}else
	            	{
	            		 $this->view->show("VnuevoCargo.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'));      		
	            	}
	            }
	        }else
	        {
	        	$this->view->show("VnuevoCargo.php");
	        }

			
		}

		Public function procesar_editar_ajax()
		{
			
	    }

		Public function mostrar_editar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/MenuModel.php';
			$MenuModel = new MenuModel('modelo/MenuModel.php');
			$consulta = $MenuModel->consultar('menus', "id_Menu=$id AND status_men=1", 1);

			echo json_encode($consulta);
			
		}

	}

?>
<?php 
	class MenuController extends ControllerBase
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
			require_once 'modelo/MenuModel.php';
			$MenuModel = new MenuModel('modelo/MenuModel.php');
			$consultar = $MenuModel->consultar('menus', 'status_men=1 ORDER BY posicion_men ASC', 4, 'id_Menu, etiqueta_men');
			while($row = $consultar->fetch())
			{
				$arreg[$row['id_Menu']] = $row['etiqueta_men'];
			}
			$data['menu'] = $arreg;
			$this->view->show("VnuevoMenu.php", array('tipo'=>'success', "msj"=>'Los Datos fueron guardados correctamente'), $data);      		
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

			
			require_once 'modelo/MenuModel.php';
			$MenuModel = new MenuModel('modelo/MenuModel.php');
			$consultar = $MenuModel->consultar('menus', 'status_men=1 ORDER BY posicion_men ASC', 4, 'id_Menu, etiqueta_men');

            while($row = $consultar->fetch())
			{
				$arreg[$row['id_Menu']] = $row['etiqueta_men'];
			}
			$data['menu'] = $arreg;

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;

	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	              // echo $key.':'.$_POST['posicion_men'].'<br>';
	                if($key == 'etiqueta_men')
	                {
	                    //$indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo = array($key=>$reglas);
	                    	
	                    }
	                }elseif ($key == 'url_men') 
	                {
	                	//$indice = 'error_'.$i;
	                	//echo '<script type="text/javascript">alert("'.$key.'");</script>';
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }

	                }elseif ($key == 'activar_men') 
	                {
	                	
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }
	                }elseif ($key == 'menu_men') 
	                {
	                	
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }
	                }elseif(!isset($_POST['posicion_men'])) 
	                {
	                   // echo 'posi:'.$value;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo['posicion_men'] = $reglas; }
	                }
	            }

	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoMenu.php", array("campo"=>$arreglo), $data);
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	//header('Location:index.php?controlador=Menu&accion=guardar');
	            	
	            	if($MenuModel->registrar())
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Menu&accion=guardar');
	            		//$this->view->show("VnuevoUsuari.php", array('tipo'=>'success', "msj"=>'los Datos fueron guardados correctamente'));	            		
	            	}
	            }

	        }else
	        {
	        	$this->view->show("VnuevoMenu.php", $data);
	        }
			
		}

		Public function procesar_editar_ajax()
		{
			
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/MenuModel.php';
			$MenuModel = new MenuModel('modelo/MenuModel.php');	
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');		     

			if(isset($_POST) && $_POST != null)
	        {
	        	$id = addslashes(htmlspecialchars(@$_POST["Mid_Menu"]));
	        	$consulta = $MenuModel->consultar('menus', "id_Menu=$id AND status_men=1", 1);
	        	$i=0;
	        	foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	
	            	if ($key == 'Metiqueta_men') 
	            	{
	            		
	            		$indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	
							$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Metiqueta_men', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Metiqueta_men');
	                    }
	            	}elseif ($key == 'Murl_men') 
	            	{
	            		
	            		$indice = 'error_'.$i;
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	//$arreglo[$indice] = $reglas;
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Murl_men', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Murl_men');
	                    }
	            	}elseif ($key == 'Mmenu_men') 
	            	{
	            		
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                   // $ValidarForm->mostrar_error('Mmenu_men', 'El campo no puede estar vacio');
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mmenu_men', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mmenu_men');
	                    }
	            	}elseif ($key == 'Mactivar_men') 
	            	{
	            		
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                   // $ValidarForm->mostrar_error('Mmenu_men', 'El campo no puede estar vacio');
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas);
	                    	$ValidarForm->mostrar_error('Mactivar_men', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mactivar_men');
	                    }
	            	}elseif (!isset($_POST['Mposicion_men'])) 
	            	{
	            		
	            		if (/*$consulta['posicion_men']*/ $id != $_POST['Mmenu_men']) 
	            		{
	            			$ValidarForm->mostrar_error('Mposicion_men', 'El campo no puede estar vacioss');
	            			$error = true;
	            		}else
	            		{
	            			$ValidarForm->limpiar_error('Mposicion_men');
	            		}

	            		
	            	}
	            }

	            if (!isset($error)) 
	            {
	            	$modificar = $MenuModel->modificar('menus', $_POST, "id_Menu=$id", $id);
	            	$consultar_td = $MenuModel->consultar('menus', "status_men=1 AND id_Menu=$id", 4, "etiqueta_men, posicion_men, activar_men, url_men");
	            	
	            	if(@$modificar)
	            	{
	            		$ValidarForm->actualizar_text($id, 'td', $consultar_td);
	            		$ValidarForm->mensaje_jquery('respuesta', "LOS DATOS FUERON  MODIFICADO CORRECTAMENT", 'success');
	            
	            	}else
	            	{
	            		//$ValidarForm->mensaje_jquery('respuesta', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger');
	            
	            	}
	            }

	        }
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
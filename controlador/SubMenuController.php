<?php 
	class SubMenuController extends ControllerBase
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
			$this->view->show("VnuevoSubMenu.php", array('tipo'=>'success', "msj"=>'Los Datos fueron guardados correctamente'), $data);      		
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
			require_once 'modelo/SubMenuModel.php';
			$SubMenuModel = new SubMenuModel('modelo/SubMenuModel.php');
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
	               // echo @$key.':'.@$_POST['posicion_sub'].'<br>';
	                if($key == 'etiqueta_sub')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo = array($key=>$reglas);
	                    	
	                    }
	                }elseif ($key == 'url_sub') 
	                {
	                	//$indice = 'error_'.$i;
	                	//echo '<script type="text/javascript">alert("'.$key.'");</script>';
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }

	                }elseif ($key == 'activar_sub') 
	                {
	                	
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }
	                }elseif ($key == 'id_Menu') 
	                {
	                	
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }
	                }
	                elseif ($key == 'subMenu_sub') 
	                {
	                	
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas)){$arreglo[$key] = $reglas; }
	                }
	                elseif(!empty($_POST['subMenu_sub']) )  //compruebo que el submenu este seleccionnado para validar el vacio del campo
	                {
	                  
	                	if(empty($_POST['posicion_sub']))
	                	{
	                		$reglas = $ValidarForm->validar($value, array('vacio'));
	                    	if(!empty($reglas)){$arreglo['posicion_sub'] = $reglas; }
	                	}
	                    
	                }
	            }

	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoSubMenu.php", array("campo"=>$arreglo), $data);
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	//header('Location:index.php?controlador=SubMenu&accion=guardar');
	            	
	            	if($SubMenuModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=SubMenu&accion=guardar');
	            	}
	            	
	            }

	        }else
	        {
	        	$this->view->show("VnuevoSubMenu.php", $data);
	        }
			
		}

		Public function procesar_editar_ajax()
		{
			
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/SubMenuModel.php';
			$SubMenuModel = new SubMenuModel('modelo/SubMenuModel.php');	
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');		     

			if(isset($_POST) && $_POST != null)
	        {
	        	$id = addslashes(htmlspecialchars(@$_POST["Mid_SubMenu"]));
	        	//echo $id.'='.$_POST['MsubMenu_sub'];
	        	//$consulta = $SubMenuModel->consultar('submenus', "id_SubMenu=$id AND status_sub=1", 1);
	        	$i=0;
	        	foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	//echo $key.'<br>';
	            	if ($key == 'Metiqueta_sub') 
	            	{
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
							$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Metiqueta_sub', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Metiqueta_sub');
	                    }
	            	}elseif ($key == 'Murl_sub') 
	            	{
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	//$arreglo[$indice] = $reglas;
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Murl_sub', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Murl_sub');
	                    }
	            	}elseif ($key == 'Mid_Menu') 
	            	{
	            		
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                   // $ValidarForm->mostrar_error('Mmenu_men', 'El campo no puede estar vacio');
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Menu', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mmenu_men');
	                    }
	            	}elseif ($key == 'Mactivar_sub') 
	            	{
	            		
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                   // $ValidarForm->mostrar_error('Mmenu_men', 'El campo no puede estar vacio');
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas);
	                    	$ValidarForm->mostrar_error('Mactivar_sub', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mactivar_sub');
	                    }
	            	}elseif(!empty($_POST['MsubMenu_sub']) )  //compruebo que el submenu este seleccionnado para validar el vacio del campo
	                {
	                	
	                	if(empty($_POST['Mposicion_sub']))
	                	{
	                		$post_submenu = (int) $_POST['MsubMenu_sub'];
	                		if(is_numeric($post_submenu)){
	                			//echo $id.'=='.$_POST['MsubMenu_sub'].'<br>';
	                		}
	                		
	                		if( $id != $post_submenu) 
	            			{
	                			$reglas = $ValidarForm->validar(@$_POST['Mposicion_sub'], array('vacio'));
	                    		if(!empty($reglas))
	                    		{
	                    			$mensaje = $Funcion->recibirArrayUrl($reglas);
	                    			$ValidarForm->mostrar_error('Mposicion_sub', $mensaje[0]);
	                    			$error = true;
	                    		}else
			                    {
			                    	$ValidarForm->limpiar_error('Mposicion_sub');
			                    }
	                		}else
	                		{
	                			$ValidarForm->limpiar_error('Mposicion_sub');
	                		}
	                	
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mposicion_sub');
	                    }
	                }
	                /*
	            	elseif (!isset($_POST['Mposicion_sub'])) 
	            	{
	            		
	            		if ( $id != $_POST['MsubMenu_sub']) 
	            		{
	            			$ValidarForm->mostrar_error('Mposicion_sub', 'El campo no puede estar vacioss');
	            			$error = true;
	            		}else
	            		{
	            			$ValidarForm->limpiar_error('Mposicion_sub');
	            		}

	            	}*/
	            }

	            if (!isset($error)) 
	            {
	            	$modificar = $SubMenuModel->modificar('submenus', $_POST, "id_SubMenu=$id", $id);
	            	$consultar_td = $SubMenuModel->consultar('submenus', "status_sub=1 AND id_SubMenu=$id", 4, "etiqueta_sub, posicion_sub, activar_sub, url_sub");
	            	if($modificar)
	            	{
	            		
	            		$ValidarForm->actualizar_text($id, 'td', $consultar_td);
	            		$ValidarForm->mensaje_jquery('respuesta', "LOS DATOS FUERON  MODIFICADO CORRECTAMENT", 'success');
	            		
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery('respuesta', "Error 00DB01 JOEL los datos no fueron guardados, por favor contactar su administrador  ", 'danger');
	            
	            	}
	            }

	        }
	    }

		Public function mostrar_submenu_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/SubMenuModel.php';
			$SubMenuModel = new SubMenuModel('modelo/SubMenuModel.php');
			$consulta = $SubMenuModel->consultar('submenus', "id_Menu=$id AND status_sub=1", 2);
			//$consulta = $SubMenuModel->consultar('submenus', "id_SubMenu=$id AND status_sub=1", 2);

			$rawdata = array(); //creamos un array
 
    		//guardamos en un array multidimensional todos los datos de la consulta
		    $i=0;
		    while($row =$consulta->fetch())
		    {
		        $rawdata[$i] = $row;
		        $i++;
		    }
			echo json_encode($rawdata);
			//return json_encode($consulta);
		}

		Public function mostrar_editar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/SubMenuModel.php';
			$SubMenuModel = new SubMenuModel('modelo/SubMenuModel.php');
			//$consulta = $SubMenuModel->consultar('submenus', "id_SubMenu=$id AND status_sub=1", 2);
			$consulta = $SubMenuModel->consultar('submenus as sub, menus as men', "sub.id_Menu=men.id_Menu AND sub.id_SubMenu=$id AND status_sub=1", 2);
			$rawdata = array();
			$i=0;
		    while($row =$consulta->fetch())
		    {
		        $rawdata[$i] = $row;
		        $i++;
		    }
			echo json_encode($rawdata);
		}

	}

?>
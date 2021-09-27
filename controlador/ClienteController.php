<?php 
	class ClienteController extends ControllerBase
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
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			$resul_estados = $ClienteModel->consultar('estados', 1, 4, 'id_Estado, estado');
			$resul_cargos = $ClienteModel->consultar('cargos', 1, 4, 'id_Cargo, nombre_car');

			while($row = $resul_estados->fetch())
			{
				$estado[$row['id_Estado']] = $row['estado'];
			}
			$estados['estado'] = $estado;
			$this->view->show("VnuevoCliente.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'), $estados); 	
		}

		Public function registrar_cliente_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');


			require_once 'modelo/ClienteModel.php';
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');	
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	                if($key == 'cedula_per')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('cedula_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $ClienteModel->consultar('clientes as C, personas as P', 'P.id_Persona=C.id_Persona AND (P.status_per=1 AND P.cedula_per="'.$value.'")');
	                    	if(!empty($consultar)){
	                    		//$arreglo[$key] = $ValidarForm->texto_url(' El número de cédula ya esta registrado.');
	                    		$ValidarForm->mostrar_error('cedula_per', ' El número de cédula ya esta registrado.');
	                    		$error = true;
	                    	}else
	                    	{
	                    		$ValidarForm->limpiar_error('cedula_per');
	                    	}
	                    }
	                }elseif($key=='nombre_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('nombre_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('nombre_per');
	                    }
	                }elseif($key=='apellido_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('apellido_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('apellido_per');
	                    }
	                }elseif($key=='sexo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('sexo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('sexo_per');
	                    }
	                }elseif($key=='id_Estado')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Estado', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Estado');
	                    }
	                }elseif($key=='id_Ciudad')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Ciudad', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Ciudad');
	                    }
	                }elseif($key=='id_Municipio')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Municipio', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Municipio');
	                    }
	                }elseif($key=='id_Parroquia')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Parroquia', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Parroquia');
	                    }
	                }elseif($key=='correo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('correo'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('correo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('correo_per');
	                    }
	                }elseif($key=='fecha_nac_per')
	                {
	                	
	                	$reglas = $ValidarForm->validar($value, array('vacio'/*, 'MayorEdad'*/));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('fecha_nac_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('fecha_nac_per');
	                    }
	                }elseif($key=='telefono_movil_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('telefono_movil_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('telefono_movil_per');
	                    }
	                }elseif($key=='telefono_fijo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('telefono_fijo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('telefono_fijo_per');
	                    }
	                }
	            }

	            //AQUI TERMINA BLOQUE FOR
	            if(!isset($error)) 
	            {
	            	if($ClienteModel->registrar($_POST))
	            	{
	            		$ValidarForm->limpiar_form('form_nuevo_cliente_ajax'); //TIENE QUE IR PRIME QUE EL MENSAJE
	            		$ValidarForm->cerrar_modal('modal_nuevo_cliente');
	            		$ValidarForm->mensaje_jquery_2('respuesta2', "Los datos fueron guardados correctamente.", 'success', 'fa-save');
	            		
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery_2('respuesta_nuevo_cliente', " Error al intentar guardar los datos.", 'success', 'fa-save');
	            		 
	            	}
	            }
	        }
		}

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			$resul_estados = $ClienteModel->consultar('estados', 1, 4, 'id_Estado, estado');
			$resul_cargos = $ClienteModel->consultar('cargos', 1, 4, 'id_Cargo, nombre_car');

			while($row = $resul_cargos->fetch()){$cargo[$row['id_Cargo']] = $row['nombre_car'];}
			$cargos['cargo'] = $cargo;

			while($row = $resul_estados->fetch()){$estado[$row['id_Estado']] = $row['estado'];}
			$estados['estado'] = $estado;

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	            	 $i++;
	                if($key == 'cedula_per')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }else
	                    {
	                    	$consultar = $ClienteModel->consultar('clientes as C, personas as P', 'P.id_Persona=C.id_Persona AND (P.status_per=1 AND P.cedula_per="'.$value.'")');
	                    	if(!empty($consultar)){
	                    		$arreglo[$key] = $ValidarForm->texto_url(' El número de cédula ya esta registrado.');
	                    	}
	                    }
	                }elseif($key=='nombre_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='apellido_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='sexo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='id_Estado')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='id_Ciudad')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='id_Municipio')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='id_Parroquia')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='correo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('correo'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='fecha_nac_per')
	                {
	                	
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'MayorEdad'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='telefono_movil_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='telefono_fijo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }
	            }
	            /************ FIN DE CICLO FOR *****************/

	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoCliente.php", array("campo"=>$arreglo), $estados, $cargos);
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	 //header('Location:index.php?controlador=Empleado&accion=guardar');
	            	if($ClienteModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Cliente&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VnuevoCliente.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Error al intentar guardar los datos.'), $estados);      		
	            	}
	            }

	        }else
	        {
	        	$this->view->show("VnuevoCliente.php", $estados);
	        }
			
		}

		Public function procesar_editar_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	$id_Cliente = $_POST['Mid_Cliente'];
	            foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	
	                if($key == 'Mcedula_per')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mcedula_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $ClienteModel->consultar('clientes as cli, personas as per', "(per.id_Persona=cli.id_Persona) AND (per.status_per=1 AND per.cedula_per='$value' AND cli.id_Cliente<>$id_Cliente)");
	                    	if(!empty($consultar)){
	                    		$ValidarForm->mostrar_error('Mcedula_per', 'El número de cédula ya esta registrado.');
	                    		$error = true;
	                    	}else
	                    	{
	                    		$ValidarForm->limpiar_error('Mcedula_per');
	                    	}
	                    }
	                }elseif($key=='Mnombre_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                     if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mnombre_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mnombre_per');
	                    }
	                }elseif($key=='Mapellido_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                     if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mapellido_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mapellido_per');
	                    }
	                }elseif($key=='Msexo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Msexo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Msexo_per');
	                    }
	                }elseif($key=='Mid_Estado')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                     if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Estado', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Estado');
	                    }
	                }elseif($key=='Mid_Ciudad')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                     if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Ciudad', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Ciudad');
	                    }
	                }elseif($key=='Mid_Municipio')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Municipio', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Municipio');
	                    }
	                }elseif($key=='Mid_Parroquia')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Parroquia', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Parroquia');
	                    }
	                }elseif($key=='Mcorreo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('correo'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mcorreo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mcorreo_per');
	                    }
	                }elseif($key=='Mfecha_nac_per')
	                {
	                	
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'MayorEdad'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mfecha_nac_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mfecha_nac_per');
	                    }
	                }elseif($key=='Mtelefono_movil_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mtelefono_movil_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mtelefono_movil_per');
	                    }
	                }elseif($key=='Mtelefono_fijo_per')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico', 'telefono'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mtelefono_fijo_per', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mtelefono_fijo_per');
	                    }
	                }
	            } /************ FIN DE CICLO FOR *****************/

	            if(!isset($error)) 
	            {
	            	$modificar = $ClienteModel->modificar($_POST, $id_Cliente);
	            	$consultar_td = $ClienteModel->consultar("personas as P, clientes as C", "(P.id_Persona=C.id_Persona AND C.id_Cliente=$id_Cliente) AND (C.status_cli=1)",  4, "P.cedula_per, P.nombre_per, P.apellido_per, P.telefono_movil_per");
	            	//echo '<script type="text/javascript">alert("'.$modificar.'");</script>';
	            	if(@$modificar)
	            	{
	            		//$ValidarForm->actualizar_text($id_Cliente, 'td', $consultar_td)
	            		$ValidarForm->edit_tr($id_Cliente, 'Cliente', $consultar_td);
	            		$ValidarForm->cerrar_modal('modal_modificar_cliente');
	            		//$ValidarForm->mensaje_jquery_2('respuesta', " Los datos fueron guardados correctamente.", 'success', 'fa-save');
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery_2('respuesta', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger', 'fa-save');
	            	}
	            }
	        }
	    }

		Public function mostrar_editar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			$consulta = $ClienteModel->consultar('personas as P, clientes as C, estados as ES, ciudades as CI, municipios as MU, parroquias as PA', "(P.id_Estado=ES.id_Estado AND P.id_Ciudad=CI.id_Ciudad AND P.id_Municipio=MU.id_Municipio AND P.id_Parroquia=PA.id_Parroquia AND P.id_Persona=C.id_Persona) AND (C.id_Cliente=$id AND C.status_cli=1)", 1);

			echo json_encode($consulta);
			
		}

		Public function eliminar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/ClienteModel.php';
			$ClienteModel = new ClienteModel('modelo/ClienteModel.php');
			$bandera = $ClienteModel->editarSQL('clientes', array('status_cli'=>0), "id_Cliente=$id AND status_cli=1");

			if($bandera) 
			{
				$consulta = $id;
			}
			echo $consulta;	
		}

	}

?> 
<?php 
	class EmpleadoController extends ControllerBase
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
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$resul_estados = $EmpleadoModel->consultar('estados', 1, 4, 'id_Estado, estado');
			$resul_cargos = $EmpleadoModel->consultar('cargos', 'status_car=1 && id_Cargo<>1', 4, 'id_Cargo, nombre_car');

			while($row = $resul_cargos->fetch())
			{
				$cargo[$row['id_Cargo']] = $row['nombre_car'];
			}
			$cargos['cargo'] = $cargo;

			while($row = $resul_estados->fetch())
			{
				$estado[$row['id_Estado']] = $row['estado'];
			}
			$estados['estado'] = $estado;
			$this->view->show("VnuevoEmpleado.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'), $cargos, $estados); 	
		}

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);

			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$resul_estados = $EmpleadoModel->consultar('estados', 1, 4, 'id_Estado, estado');
			$resul_cargos = $EmpleadoModel->consultar('cargos', 'status_car=1 && id_Cargo<>1', 4, 'id_Cargo, nombre_car');
			


			while($row = $resul_cargos->fetch())
			{
				$cargo[$row['id_Cargo']] = $row['nombre_car'];
			}
			$cargos['cargo'] = $cargo;

			while($row = $resul_estados->fetch())
			{
				$estado[$row['id_Estado']] = $row['estado'];
			}
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
	                    	$consultar = $EmpleadoModel->consultar('empleados as emp, personas as per', 'per.id_Persona=emp.id_Persona AND (per.status_per=1 AND per.cedula_per="'.$value.'")');
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
	                }elseif($key=='id_Cargo')
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
	            	$this->view->show("VnuevoEmpleado.php", array("campo"=>$arreglo), $estados, $cargos);
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	 //header('Location:index.php?controlador=Empleado&accion=guardar');
	            	if($EmpleadoModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Empleado&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VnuevoEmpleado.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'), $estados, $cargos);      		
	            	}
	            }

	        }else
	        {
	        	$this->view->show("VnuevoEmpleado.php", $estados, $cargos);
	        }
			
		}

		Public function procesar_editar_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			//$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);

			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			//$resul_estados = $EmpleadoModel->consultar('estados', 1, 4, 'id_Estado, estado');
			//$resul_cargos = $EmpleadoModel->consultar('cargos', 1, 4, 'id_Cargo, nombre_car');
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	$id_Empleado = $_POST['Mid_Empleado'];
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
	                    	$consultar = $EmpleadoModel->consultar('empleados as emp, personas as per', "(per.id_Persona=emp.id_Persona) AND (per.status_per=1 AND per.cedula_per='$value' AND emp.id_Empleado<>$id_Empleado)");
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
	                }elseif($key=='Mid_Cargo')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Cargo', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Cargo');
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
	            	$modificar = $EmpleadoModel->modificar($_POST, $id_Empleado);
	            	$consultar_td = $EmpleadoModel->consultar("personas as P, empleados as E, cargos as C", "(P.id_Persona=E.id_Persona AND E.id_Cargo=C.id_Cargo AND E.id_Empleado=$id_Empleado) AND (E.status_emp=1)",  4, "P.cedula_per, P.nombre_per, P.apellido_per, P.telefono_movil_per, C.nombre_car");
	            	//echo '<script type="text/javascript">alert("'.$modificar.'");</script>';
	            	if(@$modificar)
	            	{
	            		//$ValidarForm->actualizar_text($id_Empleado, 'td', $consultar_td); //modificar aqui
	            		$ValidarForm->edit_tr($id_Empleado, 'Empleado', $consultar_td);
	            		$ValidarForm->cerrar_modal('modal_modificar_empleado');
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery_2('respuesta', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger', 'fa-save');
	            	}
	            }
	        }
	    }

	    Public function ajax_cargar_ciudad($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$consulta = $EmpleadoModel->consultar('ciudades', "id_Estado=$id", 4, 'id_Ciudad, ciudad');
			$rawdata = array(); //creamos un array
		    $i=0;
		    while($ro =$consulta->fetch())
		    {
		        $rawdata[$i] = $ro;
		        $i++;
		    }

			echo json_encode($rawdata);
			
		}

		 Public function ajax_cargar_municipio($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$consulta = $EmpleadoModel->consultar('municipios', "id_Estado=$id", 4, 'id_Municipio, municipio');
			$rawdata = array(); //creamos un array
		    $i=0;
		    while($ro =$consulta->fetch())
		    {
		        $rawdata[$i] = $ro;
		        $i++;
		    }

			echo json_encode($rawdata);
			
		}

		 Public function ajax_cargar_parroquia($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$consulta = $EmpleadoModel->consultar('parroquias', "id_Municipio=$id", 4, 'id_Parroquia, parroquia');
			$rawdata = array(); //creamos un array
		    $i=0;
		    while($ro =$consulta->fetch())
		    {
		        $rawdata[$i] = $ro;
		        $i++;
		    }

			echo json_encode($rawdata);
			
		}

		
		Public function mostrar_editar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$consulta = $EmpleadoModel->consultar('personas as P, empleados as E, cargos as C, estados as ES, ciudades as CI, municipios as MU, parroquias as PA', "(P.id_Estado=ES.id_Estado AND P.id_Ciudad=CI.id_Ciudad AND P.id_Municipio=MU.id_Municipio AND P.id_Parroquia=PA.id_Parroquia AND P.id_Persona=E.id_Persona AND E.id_Cargo=C.id_Cargo) AND (E.id_Empleado=$id AND E.status_emp=1)", 1);

			echo json_encode($consulta);
			
		}

		Public function eliminar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/EmpleadoModel.php';
			$EmpleadoModel = new EmpleadoModel('modelo/EmpleadoModel.php');
			$bandera = $EmpleadoModel->editarSQL('empleados', array('status_emp'=>0), "id_Empleado=$id AND status_emp=1");

			if($bandera) 
			{
				$consulta = $id;
			}
			echo $consulta;	
		}

	}

?> 
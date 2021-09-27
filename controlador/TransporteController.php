<?php 
	class TransporteController extends ControllerBase
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
			$this->view->show("VnuevoTransporte.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.')); 	
		}

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			require_once 'modelo/TransporteModel.php';
			$TransporteModel = new TransporteModel('modelo/TransporteModel.php');

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	if($key=='tipo_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='matricula_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }else
	                    {
	                    	$consultar = $TransporteModel->consultar('transportes', 'status_tra=1 AND matricula_tra="'.$value.'"');
	                    	if(!empty($consultar))
	                    	{
	                    		$arreglo[$key] = $ValidarForm->texto_url(' El número de matricula ya esta registrado.');
	                    	}
	                    }
	                }elseif($key=='marca_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='modelo_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='precio_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='capacidad_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif($key=='anio_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }
	            }
	            /************ FIN DE CICLO FOR *****************/
	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoTransporte.php", array("campo"=>$arreglo));
	            	$_POST = array();
	            }else # una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	//header('Location:index.php?controlador=Empleado&accion=guardar');
	            	if($TransporteModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Transporte&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VnuevoTransporte.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'));      		
	            	}
	            }
	        }else
	        {
	        	$this->view->show("VnuevoTransporte.php");
	        }
			
		}

		Public function procesar_editar_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/TransporteModel.php';	
			$TransporteModel = new TransporteModel('modelo/TransporteModel.php');
			
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	$id_Transporte = $_POST['Mid_Transporte'];
	        	// AQUI EMPIEZA LA LA VALIDACION 
	            foreach ($_POST as $key => $value) 
	            {
	            	$i++;
	            	if($key=='Mtipo_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mtipo_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mtipo_tra');
	                    }
	                }elseif($key=='Mmatricula_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                	if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mmatricula_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $TransporteModel->consultar('transportes', "status_tra=1 AND matricula_tra='$value' AND id_Transporte<>id_Transporte");
	                    	if(!empty($consultar))
	                    	{
	                    		$ValidarForm->mostrar_error('Mmatricula_tra', ' El número de matricula ya esta registrado.');
	                    	}else
	                    	{
	                    		$ValidarForm->limpiar_error('Mmatricula_tra');
	                    	}
	                    }
	                }elseif($key=='Mmarca_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mmarca_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mmarca_tra');
	                    }
	                }elseif($key=='Mmodelo_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mmodelo_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mmodelo_tra');
	                    }
	                }elseif($key=='Mprecio_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mprecio_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mprecio_tra');
	                    }
	                }elseif($key=='Mcapacidad_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mcapacidad_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mcapacidad_tra');
	                    }
	                }elseif($key=='Manio_tra')
	                {
	                	$reglas = $ValidarForm->validar($value, array('numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Manio_tra', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Manio_tra');
	                    }
	                }
	            }
	            // FIN DE LA VALIDACION

	            if(!isset($error)) 
	            {
	            	$modificar = $TransporteModel->modificar('transportes', $_POST, "id_Transporte=$id_Transporte", $id_Transporte);
	            	$consultar_td = $TransporteModel->consultar('transportes', "status_tra=1 AND id_Transporte=$id_Transporte", 4, "tipo_tra, matricula_tra, marca_tra, precio_tra");
	            	
	            	if(@$modificar)
	            	{
	            		//$ValidarForm->actualizar_text($id_Transporte, 'td', $consultar_td);
	            		$ValidarForm->edit_tr($id_Transporte, 'Transporte', $consultar_td);
	            		$ValidarForm->cerrar_modal('modal_editar_transporte');
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
			require_once 'modelo/TransporteModel.php';
			$TransporteModel = new TransporteModel('modelo/TransporteModel.php');
			$consulta = $TransporteModel->consultar('transportes', "id_Transporte=$id AND status_tra=1", 1);

			echo json_encode($consulta);
			
		}

		Public function eliminar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/TransporteModel.php';
			$TransporteModel = new TransporteModel('modelo/TransporteModel.php');
			$bandera = $TransporteModel->editarSQL('transportes', array('status_tra'=>0), "id_Transporte=$id AND status_tra=1");

			if($bandera) 
			{
				$consulta = $id;
			}
			echo $consulta;	
		}

		Public function reporteTransporte()
		{
			$this->validarSession();
			require_once 'libs/ConvertToPDF.class.php';
			$ConvertToPDF = new ConvertToPDF('libs/ConvertToPDF.class.php');
			require_once 'libs/ValidarForm.class.php';
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/TransporteModel.php';
			$TransporteModel = new TransporteModel('modelo/TransporteModel.php');

			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			
			$html = '
				<?php
					require_once \'libs/Funciones.class.php\';
					$Funcion = new Funcion(\'libs/Funciones.class.php\');
					require_once \'modelo/TransporteModel.php\';
					$Transporte = new TransporteModel(\'modelo/TransporteModel.php\');

					$consulta = $Transporte->consultar(\'transportes\', \'status_tra=1\', 2, null);

				?>
				<table>
					 <tr><th colspan=\'5\'>LISTADO DE TRANSPORTES</th></tr>
					<tr>
						<th>TIPO</th>
						<th>PLACA</th>
						<th>MARCA</th>
						<th>FLETE</th>
						<th >ESTADO</th>
					</tr>
					<?php 
						while($row = $consulta->fetch()) 
						{
							echo "
							<tr>
								<td>".$row["tipo_tra"]."</td>
								<td>".$row["matricula_tra"]."</td>
								<td>".$row["marca_tra"]."</td>
								<td>".$row["precio_tra"]."</td>
								<td>".$row["estado_tra"]."</td>
							</tr>";
						}
					?>
					
				</table>
			';
			$ConvertToPDF->doPDF('REPORTES DE TRANSPORTES', $html, true, 'librerias/dompdf/tabla1.css');
			
		}
	}
?>
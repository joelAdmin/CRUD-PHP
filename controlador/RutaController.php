<?php 
	class RutaController extends ControllerBase
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
			require_once 'modelo/RutaModel.php';
			$RutaModel = new RutaModel('modelo/RutaModel.php');
			$resul_estados = $RutaModel->consultar('estados', 1, 4, 'id_Estado, estado');
			while($row = $resul_estados->fetch())
			{
				$estado[$row['id_Estado']] = $row['estado'];
			}
			$estados['estado'] = $estado;
			$this->view->show("VnuevoRuta.php", array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'), $estados);      		
		}

		Public function registrar_ruta_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/RutaModel.php';	
			$RutaModel = new RutaModel('modelo/RutaModel.php');

			//$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	                if($key == 'nombre_rut')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('nombre_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $RutaModel->consultar('rutas', "status_rut=1 AND nombre_rut='$value'");
	                    	if(!empty($consultar))
	                    	{
	                    		$ValidarForm->mostrar_error('nombre_rut', ' El nombre de la ruta ya esta se encuentra registrado.');
	                    		$error = true;
	                    		//$arreglo[$key] = $ValidarForm->texto_url(' El nombre de la ruta ya esta se encuentra registrado.');
	                    	}else
	                    	{
	                    		$ValidarForm->limpiar_error('nombre_rut');
	                    	}
	                    }
	                }elseif ($key=='tipo_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('tipo_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('tipo_rut');
	                    }
	                }elseif ($key=='precio_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('precio_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('precio_rut');
	                    }
	                }elseif($key=='id_Estado_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Estado_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Estado_rut');
	                    }
	                }elseif($key=='id_Ciudad_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Ciudad_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Ciudad_rut');
	                    }
	                }elseif($key=='id_Municipio_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Municipio_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Municipio_rut');
	                    }
	                }elseif($key=='id_Parroquia_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('id_Parroquia_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('id_Parroquia_rut');
	                    }
	                }
	            }
				//FIN DEL BLOQUE FOR{}
				if(!isset($error)) 
	            {
	            	$id_Ruta = $RutaModel->registrar_ajax($_POST);
	            	if($id_Ruta)
	            	{
	            		//$ValidarForm->limpiar_form('form_nueva_ruta_ajax'); //TIENE QUE IR PRIME QUE EL MENSAJE form_nueva_ruta_ajax
	            		$consultar_tr = $RutaModel->consultar('rutas as r, estados as e, ciudades as c, municipios as m, parroquias as p', "(r.status_rut=1 && id_Ruta=$id_Ruta) AND (r.id_Estado=e.id_Estado AND r.id_Ciudad=c.id_Ciudad AND r.id_Municipio=m.id_Municipio AND r.id_parroquia=p.id_parroquia)", 'cabecera_assoc', "e.estado, c.ciudad,  m.municipio, p.parroquia, r.direccion_rut, r.precio_rut");
	            		$ValidarForm->add_tr_ruta($id_Ruta, 'td', $consultar_tr);
	            		$ValidarForm->cerrar_modal('modal_nueva_ruta');
	            		//$ValidarForm->mensaje_jquery_2('respuesta_nueva_ruta', "  Los datos fueron guardados correctamente.", 'success', 'fa-save');	
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery_2('respuesta_nueva_ruta', " Error al intentar guardar los datos.", 'danger', 'fa-save'); 
	            	}
	            }
	        }
	    }

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/RutaModel.php';
			$RutaModel = new RutaModel('modelo/RutaModel.php');
			$resul_estados = $RutaModel->consultar('estados', 1, 4, 'id_Estado, estado');

			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			
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
	                if($key == 'nombre_rut')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }else
	                    {
	                    	$consultar = $RutaModel->consultar('rutas', "status_rut=1 AND nombre_rut='$value'");
	                    	if(!empty($consultar))
	                    	{
	                    		$arreglo[$key] = $ValidarForm->texto_url(' El nombre de la ruta ya esta se encuentra registrado.');
	                    	}
	                    }
	                }elseif ($key=='tipo_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }
	                }elseif ($key=='precio_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
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
	                }
	            }
	            /************ FIN DE CICLO FOR *****************/
	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoRuta.php", array("campo"=>$arreglo), $estados);
	            	$_POST = array();
	            }else #una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	// header('Location:index.php?controlador=Cargo&accion=guardar');
	            	if($RutaModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Ruta&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VnuevoRuta.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'), $estados);      		
	            	}
	            }
	        }else
	        {
	        	$this->view->show("VnuevoRuta.php", $estados);
	        }	
		}

		Public function procesar_editar_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/RutaModel.php';	
			$RutaModel = new RutaModel('modelo/RutaModel.php');
			
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	$id_Ruta = $_POST['Mid_Ruta'];
	        	// AQUI EMPIEZA LA LA VALIDACION 
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	                if($key == 'Mnombre_rut')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mnombre_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$consultar = $RutaModel->consultar('rutas', "status_rut=1 AND nombre_rut='$value' AND id_Ruta<>$id_Ruta");
	                    	if(!empty($consultar))
	                    	{
	                    		$ValidarForm->mostrar_error('Mnombre_rut', ' El nombre de la ruta ya esta se encuentra registrado.');
	                    		$error = true;
	                    		//$arreglo[$key] = $ValidarForm->texto_url(' El nombre de la ruta ya esta se encuentra registrado.');
	                    	}else
	                    	{
	                    		$ValidarForm->limpiar_error('Mnombre_rut');
	                    	}
	                    }
	                }elseif ($key=='Mtipo_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mtipo_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mtipo_rut');
	                    }
	                }elseif ($key=='Mprecio_rut') 
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio', 'numerico'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mprecio_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mprecio_rut');
	                    }
	                }elseif($key=='Mid_Estado_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Estado_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Estado_rut');
	                    }
	                }elseif($key=='Mid_Ciudad_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Ciudad_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Ciudad_rut');
	                    }
	                }elseif($key=='Mid_Municipio_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Municipio_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Municipio_rut');
	                    }
	                }elseif($key=='Mid_Parroquia_rut')
	                {
	                	$reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Parroquia_rut', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Parroquia_rut');
	                    }
	                }
	            }
				//FIN DEL BLOQUE FOR{}
				if(!isset($error)) 
	            {
	            	$modificar = $RutaModel->modificar('rutas', $_POST, "id_Ruta=$id_Ruta", $id_Ruta);
	            	$consultar_td = $RutaModel->consultar('rutas as R, estados as E, ciudades as C, municipios as M, parroquias as P', "(R.id_Estado=E.id_Estado AND R.id_Ciudad=C.id_Ciudad AND R.id_Municipio=M.id_Municipio AND R.id_Parroquia=P.id_Parroquia) AND (R.id_Ruta=$id_Ruta AND R.status_rut=1)", 4, "E.estado, C.ciudad, M.municipio, P.parroquia, R.direccion_rut, R.precio_rut");
	            	
	            	if(@$modificar)
	            	{
	            		//$ValidarForm->actualizar_text($id_Ruta, 'td', $consultar_td);
	            		$ValidarForm->edit_tr($id_Ruta, 'Ruta', $consultar_td);
	            		$ValidarForm->cerrar_modal('modal_editar_ruta');
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
			require_once 'modelo/RutaModel.php';
			$RutaModel = new RutaModel('modelo/RutaModel.php');
			$consulta = $RutaModel->consultar('rutas as R, estados as E, ciudades as C, municipios as M, parroquias as P', "(R.id_Estado=E.id_Estado AND R.id_Ciudad=C.id_Ciudad AND R.id_Municipio=M.id_Municipio AND R.id_Parroquia=P.id_Parroquia) AND (R.id_Ruta=$id AND R.status_rut=1)", 1);

			echo json_encode($consulta);
		}

		Public function eliminar_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/RutaModel.php';
			$RutaModel = new RutaModel('modelo/RutaModel.php');
			$bandera = $RutaModel->editarSQL('rutas', array('status_rut'=>0), "id_Ruta=$id AND status_rut=1");

			if($bandera) 
			{
				$consulta = $id;
			}
			echo $consulta;	
		}

		Public function reporteRuta()
		{
			$this->validarSession();
			require_once 'libs/ConvertToPDF.class.php';
			$ConvertToPDF = new ConvertToPDF('libs/ConvertToPDF.class.php');
			require_once 'libs/ValidarForm.class.php';
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/RutaModel.php';
			$Ruta = new RutaModel('modelo/RutaModel.php');

			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			$html = '
				<?php
					require_once \'libs/Funciones.class.php\';
					$Funcion = new Funcion(\'libs/Funciones.class.php\');
					require_once \'modelo/RutaModel.php\';
					$Ruta = new RutaModel(\'modelo/RutaModel.php\');

					$consulta = $Ruta->consultar(\'rutas as r, estados as e, ciudades as c, municipios as m, parroquias as p \', \'status_rut=1 AND r.id_Estado=e.id_Estado AND r.id_Ciudad=c.id_Ciudad AND r.id_Municipio=m.id_Municipio AND r.id_Parroquia=p.id_Parroquia\', 2, null);

				?>
				<table>
					 <tr><th colspan=\'6\'>LISTADO DE RUTAS </th></tr>
					<tr>
						<th>ESTADO</th>
						<th>CIUDAD</th>
						<th>MUNICIPIO</th>
						<th>PARRROQUIA</th>
						<th>DIRECCI&Oacute;N</th>
						<th >FLETE</th>
					</tr>
					<?php 
						while($row = $consulta->fetch()) 
						{
							echo "
							<tr>
								<td>".$row["estado"]."</td>
								<td>".$row["ciudad"]."</td>
								<td>".$row["municipio"]."</td>
								<td>".$row["parroquia"]."</td>
								<td>".$row["direccion_rut"]."</td>
								<td>".$row["precio_rut"]."</td>
							</tr>";
						}
					?>
					
				</table>
			';
			$ConvertToPDF->doPDF('REPORTES', $html, true, 'librerias/dompdf/tabla1.css');
			
		}

	}

?>
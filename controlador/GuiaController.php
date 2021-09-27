<?php 
	class GuiaController extends ControllerBase
	{
		
		/*Public function __construct()
		{
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
		}*/

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

		Public function ver_factura($id_factura)
		{
			echo '<script type="text/javascript">$(function(){ver_factura('.$id_factura.');});</script>';	
		}

		Public function guardar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$id_Usuario = $_SESSION['id_usuarios'];
			$resul_pago = $GuiaModel->consultar('pagofacturas', 1, 4, 'id_PagoFactura, nombre_pag');
			while($row = $resul_pago->fetch()){$pagoFactura[$row['id_PagoFactura']] = $row['nombre_pag'];}
			$pagoFacturas['pagoFactura'] = $pagoFactura;
			$resul_estados = $GuiaModel->consultar('estados', 1, 4, 'id_Estado, estado');
			while($row = $resul_estados->fetch()){$estado[$row['id_Estado']] = $row['estado'];}
			$estados['estado'] = $estado;
			$this->view->show("VnuevoGuia.php", $pagoFacturas, $estados, array('tipo'=>'success', "msj"=>'<i class="fa-info-circle fa"></i>   Los datos fueron guardados correctamente.'));      		
		}

		Public function registrar()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$resul_pago = $GuiaModel->consultar('pagofacturas', 1, 4, 'id_PagoFactura, nombre_pag');

			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			
			while($row = $resul_pago->fetch()){$pagoFactura[$row['id_PagoFactura']] = $row['nombre_pag'];}
			$pagoFacturas['pagoFactura'] = $pagoFactura;

			$resul_estados = $GuiaModel->consultar('estados', 1, 4, 'id_Estado, estado');
			while($row = $resul_estados->fetch()){$estado[$row['id_Estado']] = $row['estado'];}
			$estados['estado'] = $estado;
			
			//VERIFICO LOS CAMIONES QUEB ESTAN EN RUTA 
			if(isset($_POST) && $_POST != null)
	        {
	        	/*
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
	           
	            if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VnuevoGuia.php", array("campo"=>$arreglo));
	            	$_POST = array();
	            }else #una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	// header('Location:index.php?controlador=Cargo&accion=guardar');
	            	if($GuiaModel->registrar($_POST))
	            	{
	            		$_POST = array();
	            		foreach ($_POST as $key => $value) {$_POST[$key] == '';}
	            		header('Location:index.php?controlador=Guia&accion=guardar');
	            	}else
	            	{
	            		$this->view->show("VnuevoGuia.php", array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'));      		
	            	}
	            }
	            */
	        }else
	        {
	        	//$this->view->show("VnuevoGuia.php", $transportes, $chofers);
	        	$this->view->show("VnuevoGuia.php", $pagoFacturas, $estados);
	        }	
		}

		Public function procesar_pedido()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$id_Usuario = $_SESSION['id_usuarios'];

			$resul_pago = $GuiaModel->consultar('pagofacturas', 1, 4, 'id_PagoFactura, nombre_pag');
			while($row = $resul_pago->fetch()){$pagoFactura[$row['id_PagoFactura']] = $row['nombre_pag'];}
			$pagoFacturas['pagoFactura'] = $pagoFactura;

			$resul_estados = $GuiaModel->consultar('estados', 1, 4, 'id_Estado, estado');
			while($row = $resul_estados->fetch()){$estado[$row['id_Estado']] = $row['estado'];}
			$estados['estado'] = $estado;

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	            foreach ($_POST as $key => $value) 
	            {
	                
	                $i++;
	                if($key == 'cedula_cli')
	                {
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
	                    	$arreglo[$key] = $reglas;
	                    }else
	                    {
	                    	$resul_clientes = $GuiaModel->consultar('personas as P, clientes as C', '(P.id_Persona=C.id_Persona) AND P.cedula_per="'.$value.'" AND P.status_per=1', 1, null);
	                    	if(!$resul_clientes) 
	                    	{
	                    		$arreglo[$key] = $ValidarForm->texto_url('El numero de cedula que intena ingresar, no se encuetra registrado por favor hacer clic en el boton <+Cliente> .');
	                    	}
	                    	
	                    }
	                }elseif($key == 'id_PagoFactura')
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
	            	$this->view->show("VnuevoGuia.php", array("campo"=>$arreglo), $pagoFacturas, $estados);
	            	$_POST = array();
	            }else #una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	$resul_pedidos_cache = $GuiaModel->consultar('pedidos_cache as PC', "PC.id_Usuario=$id_Usuario", 1, null);
	            	
	            	if(!$resul_pedidos_cache) //si no se encuentra ningun pedido mando el mensaje de error
	            	{
	            		$this->view->show("VnuevoGuia.php", $pagoFacturas, $estados, array('tipo'=>'warning', "msj"=>'<i class="fa-exclamation-triangle fa"></i>  No se ha seleccionado ning&uacute;na ruta, por favor sleccione una ruta.'));      		
	            		
	            	}else // el caso contrario, si encontramos pedido procedemos a procesar
	            	{
	            		$id_factura = $GuiaModel->procesar_pedido($_POST);
	            		if($id_factura)
		            	{
		            		//aqui va el modulo para imprimir por la maquina fiscal

		            		$this->view->show("VnuevoGuia.php", $pagoFacturas, $estados, array('tipo'=>'success', "msj"=>'<i class="fa-save fa"></i> Los datos fueron guardados correctamente <a href="javascript:void(0)" onclick="PrintElem(\'#respueta_ver_factura\');"><i class="fa fa-print fa-fw"></i>  Imprimir</a>.')); 
		            		$this->ver_factura($id_factura);
		            		//echo '<script type="text/javascript">$(function(){ver_factura('.$id_factura.');});</script>';
		            		//header('Location:index.php?controlador=Guia&accion=guardar');
		            	}else
		            	{
		            		$this->view->show("VnuevoGuia.php", $pagoFacturas, $estados, array('tipo'=>'danger', "msj"=>'<i class="fa-exclamation-triangle fa"></i>   Se produjo un error al intentar guardar los datos.'));      		
		            	}
		            }
	            }
	        }
		}

		Public function ajax_cargar_transporte_chofer($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$id_Usuario = $_SESSION['id_usuarios'];

			$resul_pedidos = $GuiaModel->consultar('pedidos as P', 'P.status_ped=1 AND P.estado_ped<>"DISPONIBLE"', 1, null);
			$resul_pedidos_cache = $GuiaModel->consultar('pedidos_cache as PC', "PC.id_Usuario=$id_Usuario", 1, null);
			
			//$resul_pedidos = $GuiaModel->consultar('pedidos as P, pedidos_cache as PC', '(PC.id_Usuario=$id_Usuario) AND (P.status_ped=1 AND P.estado_ped<>"DISPONIBLE")', 1, null);
			if($resul_pedidos) //SI HAY CAMIONES EN RUTA SELECCIONO SOLO LOS DISPONIBLES
			{
				if($resul_pedidos_cache) //SI HAY PEDIDOS SELECCIONADOS EN LA TABLA PEDIDO_CACHE
				{
					$resul_transporte = $GuiaModel->consultar('transportes as T', "T.status_tra=1 AND (T.id_Transporte <> ALL (SELECT id_Transporte FROM pedidos_cache WHERE id_Usuario=$id_Usuario)) AND (T.id_Transporte <> ALL (SELECT id_Transporte FROM pedidos WHERE status_ped=1 AND estado_ped<>'DISPONIBLE'))", 2, null);
					$resul_chofer = $GuiaModel->consultar('empleados as E, personas as P', "( E.id_Persona=P.id_Persona AND E.id_Cargo in(SELECT id_Cargo FROM cargos WHERE status_car=1 AND nombre_car='CHOFER')) AND (E.id_Empleado <> ALL (SELECT id_Empleado FROM pedidos_cache WHERE id_Usuario=$id_Usuario)) AND (E.id_Empleado <> ALL (SELECT id_Empleado FROM pedidos WHERE status_ped=1 AND estado_ped<>'DISPONIBLE'))", 2, null);
				}else // SI NO HAY PEDIDOS SELECCIONADOS EN LA TABLA PEDIDOS_CACHE
				{
					$resul_transporte = $GuiaModel->consultar('transportes as T', 'T.status_tra=1 AND T.id_Transporte <> ALL (SELECT id_Transporte FROM pedidos WHERE status_ped=1 AND estado_ped<>"DISPONIBLE")', 2, null);
					$resul_chofer = $GuiaModel->consultar('empleados as E, personas as P', "( E.id_Persona=P.id_Persona AND E.id_Cargo in(SELECT id_Cargo FROM cargos WHERE status_car=1 AND nombre_car='CHOFER')) AND (E.id_Empleado <> ALL (SELECT id_Empleado FROM pedidos WHERE status_ped=1 AND estado_ped<>'DISPONIBLE'))", 2, null);
				}

			}else // SI NO HAY CAMIONES EN RUTA MUESTRO TODOS LOS DEMAS CAMIONES EN EL ESTADO DE DISPONIBLE 
			{ 
				if($resul_pedidos_cache) //SI HAY PEDIDOS SELECCIONADOS EN LA TABLA PEDIDO_CACHE
				{
					$resul_transporte = $GuiaModel->consultar('transportes as T', "(T.id_Transporte <> ALL (SELECT id_Transporte FROM pedidos_cache WHERE id_Usuario=$id_Usuario)) AND (T.status_tra=1 AND T.estado_tra='DISPONIBLE')", 2, null);
					$resul_chofer = $GuiaModel->consultar('empleados as E, cargos as C, personas as P', "(E.id_Cargo=C.id_Cargo AND E.id_Persona=P.id_Persona AND C.nombre_car='CHOFER') AND (E.id_Empleado <> ALL (SELECT id_Empleado FROM pedidos_cache WHERE id_Usuario=$id_Usuario)) ", 2, null);
		
				}else // SI NO HAY PEDIDOS SELECCIONADOS EN LA TABLA PEDIDOS_CACHE
				{	
					$resul_transporte = $GuiaModel->consultar('transportes as T', 'T.status_tra=1 AND T.estado_tra="DISPONIBLE"', 2, null);
					$resul_chofer = $GuiaModel->consultar('empleados as E, cargos as C, personas as P', '(E.id_Cargo=C.id_Cargo AND E.id_Persona=P.id_Persona) AND C.nombre_car="CHOFER"', 2, null);
				}

				//$resul_transporte = $GuiaModel->consultar('transportes as T', "(T.id_Transporte<>(SELECT id_Transporte FROM pedidos_cache WHERE id_Usuario=$id_Usuario)) AND (T.status_tra=1 AND T.estado_tra='DISPONIBLE')", 2, null);
				//$resul_chofer = $GuiaModel->consultar('empleados as E, cargos as C, personas as P', '(E.id_Cargo=C.id_Cargo AND E.id_Persona=P.id_Persona) AND C.nombre_car="CHOFER"', 2, null);
			}

			$transporte = array(); //creamos un array
		    $i=0;
		    while($ro =$resul_transporte->fetch())
		    {
		        $transporte[$i] = $ro;
		        $i++;
		    }

		    $chofer = array(); //creamos un array
		    $j=0;
		    while($row =$resul_chofer->fetch())
		    {
		        $chofer[$j] = $row;
		        $j++;
		    }

		   /* $json = '[{"transporte":'.$transporte.', "chofer":'.$chofer.'}]';
		    echo $json;*/
		    $json = array('chofer'=>json_encode($chofer), 'transporte'=>json_encode($transporte));
		    //$json = array('chofer'=>1, 'transporte'=>2);
			echo json_encode($json);
			
		}

		Public function eliminar_pedido_cache_ajax($id_PedidoCache)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');	
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');

			$id_Usuario = $_SESSION['id_usuarios'];
			$eliminar = $GuiaModel->eliminar('pedidos_cache', "id_PedidoCache=$id_PedidoCache AND id_Usuario=$id_Usuario");
			echo 'EL REGISTRO FUE ELMINADO CORRECTAMENTE.';
			//DELETE FROM `db_sistem`.`pedidos_cache` WHERE `pedidos_cache`.`id_PedidoCache` = 6"?
		}

		Public function mostrar_pedido_cache_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');	
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');

	        $id_Usuario = $_SESSION['id_usuarios'];
	       // $insert = $GuiaModel->insertar('pedidos_cache', array('id_Ruta'=>$_POST['Mid_Ruta'], 'id_Transporte'=>$_POST['Mid_Transporte'], 'id_Empleado'=>$_POST['Mid_Empleado'], 'id_Usuario'=>$_SESSION['id_usuarios'], 'descripcion_pdc'=>$_POST['Mdescripcion_ped']));
	        $result_pedido_cache = $GuiaModel->consultar('pedidos_cache as PC, rutas as R, transportes as T, estados as Es, municipios as MU, parroquias as PA', "(PC.id_Ruta=R.id_Ruta AND PC.id_Transporte=T.id_Transporte AND R.id_Estado=Es.id_Estado AND R.id_Municipio=MU.id_Municipio AND R.id_Parroquia=PA.id_Parroquia) AND PC.id_Usuario=$id_Usuario", 2, null);
	        $ValidarForm->modal('form_agregarRutaAjax', 'hide');
	            	 
	        $i=0;     
	        while ($row = $result_pedido_cache->fetch()) 
	        {
	            $i++;
	            $id_div = 'mostrar_ruta_'.$i.'';
	            $id_PedidoCache = $row['id_PedidoCache'];
	            echo'
		            <div id="'.$id_div.'"> 
		            	<a href="#" class="close" data-dismiss="" aria-hidden="false" onclick="eliminar_div(\''.$id_div.'\', \''.$id_PedidoCache.'\')" title="Quitar de la lista" >×</a>
							<blockquote class=" fija bs-callout-danger">
							   <div class="bs-text bs-callout-success">
							      <u><i class="fa fa-road"></i> RUTA # '.$i.'</u>
							         <small><b>Direcci&oacute;n: </b><b>Edo.</b> '.$row["estado"].', <b>Municipio:</b>'.$row["municipio"].', <b>Parroquia: </b>'.$row["parroquia"].' '.$row["parroquia"].'</small>
							         <small><b>Precio por Ruta:</b>'.$row["precio_rut"].'</small>
							         <small><b>Precio por Transporte:</b>'.$row["precio_tra"].' ['.$row["tipo_tra"].'  <b>Marca</b>:'.$row["marca_tra"].' <b>Modelo</b>:'.$row["modelo_tra"].' <b>A&ntilde;o</b>:'.$row["anio_tra"].']</small>                                    					
						        	 ';
						        	 if (!empty($row["descripcion_pdc"])) 
						        	 {
						        	 	echo '<small><b>Detalles de la carga:</b>'.$row["descripcion_pdc"].'</small>';
						        	 }
						        	 $totalRuta = $row["precio_rut"] + $row["precio_tra"];
						        	 echo 
						        	 '
						        	 <small><b>Precio Total:</b>'.$totalRuta.'</small>
						        </div>
						    </blockquote>
					</div>
				';
	        }       
		}

		Public function registrar_pedido_cache_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');	
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');	
    

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	foreach ($_POST as $key => $value) 
	            {
	            	if ($key == 'Mid_Transporte') 
	            	{
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
							$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Transporte', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Transporte');
	                    }
	            	}elseif ($key == 'Mid_Empleado') 
	            	{
	                    $reglas = $ValidarForm->validar($value, array('vacio'));
	                    if(!empty($reglas))
	                    {
							$mensaje = $Funcion->recibirArrayUrl($reglas); 
	                    	$ValidarForm->mostrar_error('Mid_Empleado', $mensaje[0]);
	                    	$error = true;
	                    }else
	                    {
	                    	$ValidarForm->limpiar_error('Mid_Empleado');
	                    }
	            	}
	            }

	            if (!isset($error)) 
	            {
	            	$id_Usuario = $_SESSION['id_usuarios'];
	            	$insert = $GuiaModel->insertar('pedidos_cache', array('id_Ruta'=>$_POST['Mid_Ruta'], 'id_Transporte'=>$_POST['Mid_Transporte'], 'id_Empleado'=>$_POST['Mid_Empleado'], 'id_Usuario'=>$_SESSION['id_usuarios'], 'descripcion_pdc'=>$_POST['Mdescripcion_ped']));
	            	$result_pedido_cache = $GuiaModel->consultar('pedidos_cache as PC, rutas as R, transportes as T, estados as Es, municipios as MU, parroquias as PA', "(PC.id_Ruta=R.id_Ruta AND PC.id_Transporte=T.id_Transporte AND R.id_Estado=Es.id_Estado AND R.id_Municipio=MU.id_Municipio AND R.id_Parroquia=PA.id_Parroquia) AND PC.id_Usuario=$id_Usuario", 2, null);
	            	$ValidarForm->modal('form_agregarRutaAjax', 'hide');
	            	 
	            	 $i=0;     
	            	while ($row = $result_pedido_cache->fetch()) 
	            	{
	            		$i++;
	            		$id_div = 'mostrar_ruta_'.$i.'';
	            		$id_PedidoCache = $row['id_PedidoCache'];
	            		echo'
		            	<div id="'.$id_div.'"> 
		            	<a href="#" class="close" data-dismiss="" aria-hidden="false" onclick="eliminar_div(\''.$id_div.'\', \''.$id_PedidoCache.'\')" title="Quitar de la lista" >×</a>
							<blockquote class=" fija bs-callout-danger">
							   <div class="bs-text bs-callout-success">
							      <u><i class="fa fa-road"></i> RUTA # '.$i.'</u>
							         <small><b>Direcci&oacute;n: </b><b>Edo.</b> '.$row["estado"].', <b>Municipio:</b>'.$row["municipio"].', <b>Parroquia: </b>'.$row["parroquia"].' '.$row["parroquia"].'</small>
							         <small><b>Precio por Ruta:</b>'.$row["precio_rut"].'</small>
							         <small><b>Precio por Transporte:</b>'.$row["precio_tra"].' ['.$row["tipo_tra"].'  <b>Marca</b>:'.$row["marca_tra"].' <b>Modelo</b>:'.$row["modelo_tra"].' <b>A&ntilde;o</b>:'.$row["anio_tra"].']</small>                                    					
						        	 ';
						        	 if (!empty($row["descripcion_pdc"])) 
						        	 {
						        	 	echo '<small><b>Detalles de la carga:</b>'.$row["descripcion_pdc"].'</small>';
						        	 }
						        	 $totalRuta = $row["precio_rut"] + $row["precio_tra"];
						        	 echo 
						        	 '
						        	 <small><b>Precio Total:</b>'.$totalRuta.'</small>
						        </div>
						    </blockquote>
						</div>
						
						';
	            	}
	            }

	        }
	    }

	    Public function ajax_buscar_cliente($valor)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$resul_clientes = $GuiaModel->consultar('personas as P, clientes as C', '(P.id_Persona=C.id_Persona) AND P.cedula_per="'.$valor.'" AND P.status_per=1', 1, null);
			echo json_encode($resul_clientes);
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

		Public function mostrar_estatus_pedido_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';

			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$consulta = $GuiaModel->consultar('pedidos', "id_Pedido=$id AND status_ped=1", 'assoc', null);

			echo json_encode($consulta);
			
		}

		Public function procesar_cambiar_estatus_ajax()
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$id_Usuario = $_SESSION['id_usuarios'];

			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	$id_Pedido = $_POST['id_Pedido'];
	        	$estado_ped = $_POST['estado_ped'];
	            foreach ($_POST as $key => $value) 
	            {
	                $i++;
	                if($key == 'estado_ped')
	                {
		                $reglas = $ValidarForm->validar($value, array('vacio'));
		                if(!empty($reglas))
		                {
		                   	$mensaje = $Funcion->recibirArrayUrl($reglas); 
		                   	$ValidarForm->mostrar_error('estado_ped', $mensaje[0]);
		                    $error = true;
		                }else
		                {
		                   	$ValidarForm->limpiar_error('estado_ped');
		                }
		            }
	            }

	            if(!isset($error)) 
	            {
	            	
	            	$modificar = $GuiaModel->cambiar_estatus_pedido($_POST);
	            	$consultar_td = $GuiaModel->consultar('pedidos', "id_Pedido=$id_Pedido AND status_ped=1", 'assoc', null);
	            		
	            	if(@$modificar)
	            	{
	            		$estatus = $consultar_td['estado_ped'];
	            		$ValidarForm->actualizar_text_2($id_Pedido, 'td_estado_ped', "<center><i class='fa fa-check-square-o'></i> $estatus </center>");
	            		//$ValidarForm->mensaje_jquery_2('respueta_cambiar_estatus', " Los datos fueron actualizados correctamente.", 'success', 'fa-save');
	            		$ValidarForm->cerrar_modal('modal_cambiar_estatus');
	            	}else
	            	{
	            		$ValidarForm->mensaje_jquery_2('respueta_cambiar_estatus', "Error 00DB01 los datos no fueron guardados, por favor contactar su administrador  ", 'danger', 'fa-save');
	            	}
	            }	
	        }
		}

		Public function ver_factura_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');

			$consulta = $GuiaModel->consultar('pedidos as P, facturas as F, clientes as C, personas as PER', "(P.id_Factura=F.id_Factura AND F.id_Factura=$id) AND (F.id_Cliente=C.id_Cliente AND PER.id_Persona=C.id_Persona)", 'assoc', null);
			$consulta_ped = $GuiaModel->consultar('pedidos as P, facturas as F, clientes as C, personas as PER, rutas as R, transportes as T, estados as Es, municipios as MU, parroquias as PA', "(P.id_Factura=F.id_Factura AND F.id_Factura=$id) AND (F.id_Cliente=C.id_Cliente AND PER.id_Persona=C.id_Persona) AND (P.id_Ruta=R.id_Ruta AND P.id_Transporte=T.id_Transporte AND R.id_Estado=Es.id_Estado AND R.id_Municipio=MU.id_Municipio AND R.id_Parroquia=PA.id_Parroquia)", 2, null);
			
			echo 
			'
				<table border="0px;">

					<tr>
						  <td colspan="2">
						  <H3>
						  	<B>'.Configuracion::RAZON_SOCIAL.'</B>
						  </H3>  
						  <FONT size="1.4px;">
						  	<I>
						  		RIF:'.Configuracion::RIF.'<br>
						  		'.Configuracion::DIRECCION.'
						  	</I>
						  </FONT>
						  </td>
						 
						 
						  <td colspan="2" style="width:90pt;">
						  <b class="Encabezadocolumna"></b>
						  </td>
					</tr>
					<tr>
						  <td colspan="2">
						  </td>
						 
						 
						  <td colspan="2" style="width:90pt;">
						  <b class="Encabezadocolumna">Fecha: '.$consulta["fecha_reg_fac"].'</b>
						  </td>
					</tr>

					<!--
					<tr>
						  <td colspan="2">
						  </td>
						 
						 
						  <td colspan="2" style="width:90pt;">
						  <b class="Encabezadocolumna">Nº Factura: '.$consulta["codigo_fac"].'</b>
						  </td>
					</tr>
					<tr>
						  <td colspan="2">
						  </td>

						  <td colspan="2" style="width:90pt;border-left:solid windowtext .75pt;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
						  mso-border-left-alt:solid windowtext .75pt;mso-border-alt:solid windowtext .75pt;">
						  <b class="Encabezadocolumna">Nº Control: '.$consulta["codigo_fac"].'</b>
						  </td>
					</tr>
					-->

					<tr style="width:42.55pt;border:0px;">
						<td colspan="4" style="border:0px;">
						  <p class="Encabezadocolumna"><span style="font-size:8.0pt;mso-bidi-font-size:
						  10.0pt"><o:p></o:p></span></p>
						 </td>
					</tr>

					<tr>
						  <td colspan="2" style="width:42.55pt;padding:0cm 0cm 0cm 0cm" valign="top" width="57">
						  <p class="Encabezadocolumna">Nombre o Raz&oacute;n Social: <o:p>'.$consulta["apellido_per"].' '.$consulta["nombre_per"].'</o:p></p>
						  </td>
						 
						 
						  <td colspan="2" style="width:90pt;padding:0cm 0cm 0cm 0cm" valign="top" width="104">
						  <p class="Encabezadocolumna">RIF/CI:'.$consulta["cedula_per"].'</p>
						  </td>
					</tr>

					<tr>
						  <td colspan="2" style="width:42.55pt;padding:0cm 0cm 0cm 0cm" valign="top" width="57">
						  <p class="Encabezadocolumna">Direcci&oacute;n Fiscal: '.$consulta["direccion_per"].'<o:p></o:p></p>
						  </td>
						 
						 
						  <td colspan="2" style="width:90pt;padding:0cm 0cm 0cm 0cm" valign="top" width="104">
						  <p class="Encabezadocolumna">Telefono: '.$consulta["telefono_movil_per"].'</p>
						  </td>
					</tr>

					<tr style="width:42.55pt;border:0px;">
						<td colspan="4" style="border:0px;">
						  <p class="Encabezadocolumna"><span style="font-size:8.0pt;mso-bidi-font-size:
						  10.0pt"><o:p></o:p></span></p>
						 </td>
					</tr>
					
					 <tbody>

						 <tr>
						  <td style="width:48.55pt;padding:0cm 0cm 0cm 0cm" valign="top" width="57">
						  <p class="Encabezadocolumna"><o:p>Num</o:p></p>
						  </td>
						  <td style="width:376.0pt;padding:0cm 0cm 0cm 0cm" valign="top" width="435">
						  <p class="Encabezadocolumna">Descripci&oacute;n</p>
						  </td>
						  <td style="width:78.0pt;
						  padding:0cm 0cm 0cm 0cm" valign="top" width="104">
						  <p class="Encabezadocolumna">Precio Unit.</p>
						  </td>
						  <td style="width:77.95pt;padding:0cm 0cm 0cm 0cm" valign="top" width="104">
						  <p class="Encabezadocolumna">Total</p>
						  </td>
						 </tr>';
						 /*
						 foreach ($consulta as $key => $value) {
						 	echo $key.':'.$consulta['id_Pedido'].'<br>';
						 }*/
						 $i=0;
						 $subtotal=$consulta["sub_total_fac"];
						 $iva = $consulta["iva_fac"];//$Funcion->redondear_dos_decimal(($consulta["total_fac"]/100)*Configuracion::IVA);
						 $total= $consulta["total_fac"]; //$consulta["total_fac"]+$iva;

						while ($ro = $consulta_ped->fetch()) 
						{
						 	$i++;	

						 echo '
						 <tr style="height:24.0pt">
						  <td style="width:42.55pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="57">
						  <p class="DatosTablaNoDecimales"><o:p>&nbsp; '.$i.'</o:p></p>
						  </td>
						  <td style="width:326.0pt;padding:0cm 0cm 0cm 0cm;
						  height:24.0pt" valign="top" width="435">
						  <p class="Textodetabla">
						  <o:p>&nbsp;<small><b><i class="fa fa-caret-right"></i> Direcci&oacute;n: </b><b>Edo.</b> '.$ro["estado"].', <b>Municipio:</b>'.$ro["municipio"].', <b>Parroquia: </b>'.$ro["parroquia"].' '.$ro["parroquia"].'</small></o:p>
							         
						  <br> <o:p>&nbsp;<small><b><i class="fa fa-caret-right"></i>Transporte: </b> ['.$ro["tipo_tra"].'  <b>Marca</b>:'.$ro["marca_tra"].' <b>Modelo</b>:'.$ro["modelo_tra"].' <b>A&ntilde;o</b>:'.$ro["anio_tra"].']</small></o:p>
						  ';
						   if(!empty($ro["descripcion_ped"])) 
						   {
						       echo '<br><o:p>&nbsp;<small><b><i class="fa fa-caret-right"></i> Detalles de la carga: </b>'.$ro["descripcion_ped"].'</small></o:p>';
						   }
						  echo '
						  </p>

						  </td>
						  <td style="width:78.0pt;padding:0cm 0cm 0cm 0cm;
						  height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp;Bs '.$ro["sub_total_ped"].'</o:p></p>
						  </td>
						  <td style="width:77.95pt;padding:0cm 0cm 0cm 0cm;
						  height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp;Bs '.$ro["sub_total_ped"].'</o:p></p>
						  </td>
						 </tr>';
						}
						 echo'
						 <tr style="height:24.0pt">
						  <td style="width:42.55pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="57">
						  <p class="DatosTablaNoDecimales"><o:p>&nbsp;</o:p></p>
						  </td>
						  <td style="width:326.0pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="435">
						  <p class="Textodetabla"><o:p>&nbsp;</o:p></p>
						  </td>
						  <td style="width:78.0pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp;</o:p></p>
						  </td>
						  <td style="width:77.95pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp;</o:p></p>
						  </td>
						 </tr>
						 <tr style="mso-yfti-irow:8;height:24.0pt">
						  <td colspan="3" style="width:446.55pt;border:none;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="595">
						  <p class="Textodetabla" style="text-align:right" align="right">SUBTOTAL</p>
						  </td>
						  <td style="width:77.95pt;padding:0cm 0cm 0cm 0cm;
						  height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp;</o:p> Bs '.$subtotal.'</p>
						  </td>
						 </tr>
						 
						 <tr style="mso-yfti-irow:10;height:24.0pt">
						  <td colspan="3" style="width:446.55pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="595">
						  <p class="Textodetabla" style="text-align:right" align="right"><span class="GramE">IVA</span>
						  ('.Configuracion::IVA.'%)</p>
						  </td>
						  <td style="width:77.95pt;padding:0cm 0cm 0cm 0cm;
						  height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><o:p>&nbsp; Bs '.$iva.'</o:p></p>
						  </td>
						 </tr>
						 <tr style="mso-yfti-irow:11;mso-yfti-lastrow:yes;height:24.0pt">
						  <td colspan="3" style="width:446.55pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="595">
						  <p class="Textodetabla" style="text-align:right" align="right"><b style="mso-bidi-font-weight:normal">TOTAL</b></p>
						  </td>
						  <td style="width:77.95pt;
						  padding:0cm 0cm 0cm 0cm;height:24.0pt" valign="top" width="104">
						  <p class="Datosdetabla"><b style="mso-bidi-font-weight:normal"><o:p>&nbsp;  Bs '.$total.'</o:p></b></p>
						  </td>
						 </tr>
					</tbody>
				</table>';
		}

		Public function reporteGuia()
		{
			$this->validarSession();
			require_once 'libs/ConvertToPDF.class.php';
			$ConvertToPDF = new ConvertToPDF('libs/ConvertToPDF.class.php');
			require_once 'libs/ValidarForm.class.php';
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$id_Usuario = $_SESSION['id_usuarios'];
			//VERIFICO LOS CAMIONES QUEB ESTAN EN RUTA 
			$ValidarForm->validarModulo($_GET["controlador"], $_GET['accion']);
			if(isset($_POST) && $_POST != null)
	        {
	        	$i=0;
	        	
			    if(empty($_POST['filtrar_fecha_guia']))
			    {
			    	$reglas = $ValidarForm->validar(@$_POST['filtrar_fecha_guia'], array('vacio'));
		            if(!empty($reglas))
		            {
		                $arreglo['filtrar_fecha_guia'] = $reglas;
		            }
			    }elseif(!empty($_POST['filtrar_fecha_guia']) && isset($_POST['filtrar_fecha_guia']))
			    {
			    	if ($_POST['filtrar_fecha_guia']=='SI') 
			    	{
			    		if(empty($_POST['desde'])) 
			    		{
			    			$reglas = $ValidarForm->validar($_POST['desde'], array('vacio'));
		                    if(!empty($reglas))
		                    {
		                    	$arreglo['desde'] = $reglas;
		                    }
			    		}
			    		if(empty($_POST['hasta'])) 
			    		{
			    			$reglas = $ValidarForm->validar($_POST['hasta'], array('vacio'));
		                    if(!empty($reglas))
		                    {
		                    	$arreglo['hasta'] = $reglas;
		                    }
			    		}

			    		if((!empty($_POST['desde']) && isset($_POST['desde'])) && (!empty($_POST['hasta']) && isset($_POST['hasta'])))
			            {
					        if($ValidarForm->comparar_fecha_mayor($Funcion->fechaMysql($_POST['desde'], '/'), $Funcion->fechaMysql($_POST['hasta'], '/')))
					        {
					        	$arreglo['desde'] = $ValidarForm->texto_url(' La fecha no puede ser mayor .');
					                    	
					        }
					    }
			    	}
			    }


			    if(isset($arreglo) && !empty($arreglo)) #si ocurre algun evento durante la validacion del formulario es enviado aqui ..
	            {
	            	$this->view->show("VreporteGuia.php", array("campo"=>$arreglo));
	            }else #una vez validados todos los datos de formulario ingresamos al modelo para guardar y enviamos la salida a la vista .
	            {
	            	$html_todo='
						<?php
							require_once \'libs/Funciones.class.php\';
							$Funcion = new Funcion(\'libs/Funciones.class.php\');
							require_once \'modelo/GuiaModel.php\';
							$GuiaModel = new GuiaModel(\'modelo/GuiaModel.php\');
							$consulta = $GuiaModel->consultar(\'pedidos as Ped, transportes as Tra, facturas as Fac, personas as Per, clientes as Cli, rutas as Rut, estados as Est , ciudades as Ciu, municipios as Mun, parroquias as Par, empleados as Emp \', \'((Ped.id_Transporte=Tra.id_Transporte AND Ped.id_Factura=Fac.id_Factura AND Ped.id_Ruta=Rut.id_Ruta AND Rut.id_Estado=Est.id_Estado AND Rut.id_Ciudad=Ciu.id_Ciudad AND Rut.id_Municipio=Mun.id_Municipio AND Rut.id_Parroquia=Par.id_Parroquia) AND (Fac.id_Cliente=Cli.id_Cliente AND  Cli.id_Persona=Per.id_Persona) AND (Ped.id_Empleado=Emp.id_Empleado)) \', 2, null);
							
						?>
						<?php
						echo "";
						?>
						<table>
							<tr><th colspan=\'5\'>LISTADO DE GUIAS</th></tr>
						    <tr>
						        <th>CLIENTE</th>
						        <th>TRANSPORTE</th>
						        <th>RUTA</th>
						        <th>PAGOS&nbsp;&nbsp;>&nbsp;&nbsp;</th>
						        <th >ESTATUS</th>
						        
						         
						    </tr>
						    <?php
						    $j=0;
						    while ($row = $consulta->fetch()) 
						    {
						    	$id_Empleado = $row["id_Empleado"];
                        		$resultSQL = $GuiaModel->consultar(\'empleados as E, personas P\', \'(E.id_Persona=P.id_Persona AND E.id_Empleado=\'.$id_Empleado.\') AND P.status_per=1\', \'assoc\', null);
                        
						    	echo"
						    	<tr>
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Cliente:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- CI:</b>".$row["cedula_per"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Nombre:</b>".$row["apellido_per"]." ".$row["nombre_per"]."</dd>
                                  		</dl>
							        </td>

							        <td>

							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Transporte:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Tipo:</b>".$row["tipo_tra"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Placa:</b>".$row["matricula_tra"]." </dd>

                                  			<dt><b>&nbsp;&nbsp; * Info. Chofer:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- CI:</b>".$resultSQL["cedula_per"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Nombre:</b>".$resultSQL["apellido_per"]." ".$resultSQL["nombre_per"]."</dd>
                                  		
                                  		</dl>
							        	
                                  	</td>
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Destino:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Edo. :</b>".$row["estado"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Ciud. :</b>".$row["ciudad"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Muni. :</b>".$row["municipio"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Parroq:</b>".$row["parroquia"]." </dd>
                                  		</dl>
							        </td>
							        
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Factura:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Fecha :</b>".$Funcion->fecha_datepicker($row["fecha_reg_fac"])."</dd>
                                  			
                                  			<!--<dd><b>&nbsp;&nbsp;- Numero :</b>".$row["codigo_fac"]."</dd>-->
                                  			<dd><b>&nbsp;&nbsp;- Monto. :</b>".$row["total_fac"]."</dd>
                                  			
                                  		</dl>
							        </td>";
							        if($row["status_fac"]==0)
                        			{
                        				echo "<td><br><br><dd>ANULADA</dd></td>";
                        			}else
                        			{
                        				echo "<td><br><br><dd>".$row["estado_ped"]." </dd></td>";
                        			}
							     echo"   
						        </tr>";
						    }

						    ?>      
						</table>'; 
					//Ped.fecha_reg_ped BETWEEN \'.$desde.\'  AND  \'.$hasta.\'
					//SELECT * FROM `pedidos` WHERE fecha_reg_ped BETWEEN '2015-05-01' AND '2015-05-26' 
					$html_rango_fecha='
						<?php
							require_once \'libs/Funciones.class.php\';
							$Funcion = new Funcion(\'libs/Funciones.class.php\');
							require_once \'modelo/GuiaModel.php\';
							$GuiaModel = new GuiaModel(\'modelo/GuiaModel.php\');

							$desde = $Funcion->fechaMysql($_POST["desde"], \'/\');
							$hasta = $Funcion->fechaMysql($_POST["hasta"], \'/\');
							$consulta = $GuiaModel->consultar(\'pedidos as Ped, transportes as Tra, facturas as Fac, personas as Per, clientes as Cli, rutas as Rut, estados as Est , ciudades as Ciu, municipios as Mun, parroquias as Par, empleados as Emp \', \'(( Ped.id_Transporte=Tra.id_Transporte AND Ped.id_Factura=Fac.id_Factura AND Ped.id_Ruta=Rut.id_Ruta AND Rut.id_Estado=Est.id_Estado AND Rut.id_Ciudad=Ciu.id_Ciudad AND Rut.id_Municipio=Mun.id_Municipio AND Rut.id_Parroquia=Par.id_Parroquia) AND (Fac.id_Cliente=Cli.id_Cliente AND  Cli.id_Persona=Per.id_Persona) AND (Ped.id_Empleado=Emp.id_Empleado ) ) AND (Ped.id_Pedido IN (SELECT id_Pedido FROM pedidos WHERE fecha_reg_ped BETWEEN "\'.$desde.\'" AND "\'.$hasta.\'")) \', 2, null);
							
						?>
						<?php
						echo "";
						?>
						<table>
							<tr><th colspan=\'5\'>LISTADO DE GUIAS</th></tr>
						    <tr>
						        <th>CLIENTE <?php echo $desde; ?></th>
						        <th>TRANSPORTE <?php echo $hasta; ?></th>
						        <th>RUTA</th>
						        <th>PAGOS&nbsp;&nbsp;&nbsp;&nbsp;</th>
						        <th >ESTATUS</th>
						        
						         
						    </tr>
						    <?php
						    $j=0;
						    while ($row = $consulta->fetch()) 
						    {
						    	$id_Empleado = $row["id_Empleado"];
                        		$resultSQL = $GuiaModel->consultar(\'empleados as E, personas P\', \'(E.id_Persona=P.id_Persona AND E.id_Empleado=\'.$id_Empleado.\') AND P.status_per=1\', \'assoc\', null);
                        
						    	echo"
						    	<tr>
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Cliente:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- CI:</b>".$row["cedula_per"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Nombre:</b>".$row["apellido_per"]." ".$row["nombre_per"]."</dd>
                                  		</dl>
							        </td>

							        <td>

							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Transporte:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Tipo:</b>".$row["tipo_tra"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Placa:</b>".$row["matricula_tra"]." </dd>

                                  			<dt><b>&nbsp;&nbsp; * Info. Chofer:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- CI:</b>".$resultSQL["cedula_per"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Nombre:</b>".$resultSQL["apellido_per"]." ".$resultSQL["nombre_per"]."</dd>
                                  		
                                  		</dl>
							        	
                                  	</td>
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Destino:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Edo. :</b>".$row["estado"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Ciud. :</b>".$row["ciudad"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Muni. :</b>".$row["municipio"]."</dd>
                                  			<dd><b>&nbsp;&nbsp;- Parroq:</b>".$row["parroquia"]." </dd>
                                  		</dl>
							        </td>
							        
							        <td>
							        	<dl>
                                  			<dt><b>&nbsp;&nbsp; * Info. Factura:</b></dt>
                                  			<dd><b>&nbsp;&nbsp;- Fecha :</b>".$Funcion->fecha_datepicker($row["fecha_reg_fac"])."</dd>
                                  			<!--<dd><b>&nbsp;&nbsp;- Numero :</b>".$row["codigo_fac"]."</dd>-->
                                  			<dd><b>&nbsp;&nbsp;- Monto. :</b>".$row["total_fac"]."</dd>
                                  			
                                  		</dl>
							        </td>";

							         if($row["status_fac"]==0)
                        			{
                        				echo "<td><br><br><dd>ANULADA</dd></td>";
                        			}else
                        			{
                        				echo "<td><br><br><dd>".$row["estado_ped"]." </dd></td>";
                        			}
						        echo"</tr>";
						    }

						    ?>      
						</table>'; 
					if($_POST['filtrar_fecha_guia']=='SI')
					{ 					
						$ConvertToPDF->doPDF('REPORTES DE GUIAS', $html_rango_fecha, true, 'librerias/dompdf/tabla2.css');	
					}elseif($_POST['filtrar_fecha_guia']=='NO')
					{
						$ConvertToPDF->doPDF('REPORTES DE GUIAS', $html_todo, true, 'librerias/dompdf/tabla2.css');
					}						
					$this->view->show("VreporteGuia.php");		
	            }
			}else
			{
				$this->view->show("VreporteGuia.php");	
			}	      		
		}

		Public function anular_factura_ajax($id)
		{
			$this->validarSession();
			require_once 'libs/ValidarForm.class.php';
			$ValidarForm = new ValidarForm('libs/ValidarForm.class.php');
			require_once 'modelo/GuiaModel.php';
			$GuiaModel = new GuiaModel('modelo/GuiaModel.php');
			$modificar = $GuiaModel->modificar('facturas', array('status_fac'=> 0), "id_Factura=$id");
			if($modificar==null) 
			{
				
				$modificar_ped = $GuiaModel->modificar('pedidos', array("status_ped"=>0), "id_Factura=$id");
				$modificar_ped_estado = $GuiaModel->modificar('pedidos', array('estado_ped'=>'DISPONIBLE'), "status_ped=0 AND id_Factura=$id");
				$consulta = $GuiaModel->consultar('pedidos', "id_Factura=$id", 'assoc', null);
				echo json_encode(1);
		    }
		}

	}

?>
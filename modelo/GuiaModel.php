<?php
	class GuiaModel extends ModelBase 
	{
	
		protected $Modelo;
		
		public function __construct()
		{
			$this->Modelo = new ModelBase();
			
			return parent ::__construct(); //reutilizar el constructor del padre
		}

		Public Function insertar($tabla, $postInsert=array())
		{
			$id = $this->Modelo->insertarSQL_2($tabla, $postInsert);
			return $id;
		}

		Public Function eliminar($tabla, $where=1)
		{
			$id = $this->Modelo->eliminarSQL($tabla, $where);
			return $id;
		}

		Public Function consultar($tabla, $where=null, $condicion=null, $cabeceras=null)
		{
			$array = $this->Modelo->consultarSQL($tabla, $where, $condicion, $cabeceras);
			return $array;
		}

		Public Function modificar($tabla, $set=array(), $where=1)
		{
			$id_modificar_fac = $this->Modelo->editarSQL($tabla, $set, $where);
						
		}

		Public function procesar_pedido($post)
		{
			$Funcion = new Funcion();
			$i=0;//SELECT MAX(codigo_fac) as codigo_fac FROM `facturas` WHERE 1
			$resul_codigo_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 2, null); //para comprobar si se van aregistrar facturas por primera vez
			$id_Usuario = $_SESSION['id_usuarios'];
			if($resul_codigo_fac) //si hay factura ya realizadas
			{
				$cons = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'count_assoc', null);
				if( $cons['count'] > 1) // si es mayor que uno, busco el valor mayor y le sumo uno
				{
					$codigo_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'cabecera_assoc', 'max(codigo_fac) as codigo_fac');
					$num_control_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'cabecera_assoc', 'max(num_control_fac) as num_control_fac');
					//$num_control_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'cabecera_assoc', 'max(num_control_fac) as num_control_fac');
					
					$facturaInsert['codigo_fac'] = $codigo_fac['codigo_fac'] + 1;
					$facturaInsert['num_control_fac'] = $num_control_fac['num_control_fac'] + 1; //verificar
					
				}else // si es menor, es dicir solo hay un registro entonces solo consulto y le sumo uno
				{
					$codigo_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'cabecera_assoc', 'codigo_fac');
					$num_control_fac = $this->Modelo->consultarSQL('facturas', 'status_fac=1', 'cabecera_assoc', 'num_control_fac');
					$facturaInsert['codigo_fac'] = $codigo_fac['codigo_fac'] + 1;
					$facturaInsert['num_control_fac'] = $num_control_fac['num_control_fac'] + 1; 	
				}
				
			}else //en caso de registra por primera vez una factura
			{
				$facturaInsert['codigo_fac'] = 1;
				$facturaInsert['num_control_fac'] = 1;
			}
			$cedula_per = $post['cedula_cli'];
			$id_Cliente = $this->Modelo->consultarSQL('personas as P, clientes as C', "(P.id_Persona=C.id_Persona AND P.status_per=1) AND P.cedula_per='$cedula_per' ", 'cabecera_assoc', 'C.id_Cliente');
			$facturaInsert['iva_fac'] = 0;
			$facturaInsert['sub_total_fac'] = 0;
			$facturaInsert['total_fac'] = 0;
			$facturaInsert['id_PagoFactura'] = $post['id_PagoFactura'];
			$facturaInsert['id_Cliente'] = $id_Cliente['id_Cliente']; 
			$facturaInsert['id_PagoFactura'] = $post['id_PagoFactura'];
			$facturaInsert['id_Usuario'] =  $id_Usuario;
			$facturaInsert['fecha_reg_fac'] = $Funcion->fecha();
			$facturaInsert['hora_reg_fac'] =  $Funcion->hora();
			$facturaInsert['fecha_mod_fac'] = $Funcion->fecha();
			$facturaInsert['hora_mod_fac'] =  $Funcion->hora();
			$facturaInsert['status_fac'] = 1;

			//LO PRIMERO REGISTRAR EN LA TABLA FACTURA PARA OBTENER EL ID_FACTURA
			//foreach($facturaInsert as $key => $value){echo $key.'='.$value.'<br>';}
			$id_Factura = $this->Modelo->insertarSQL_2('facturas', $facturaInsert);
			if(!empty($id_Factura)) //si se guardo correctamente procedo a eliminar los pedidos cache y registrar en la tabla pedido
			{
				$resul_codigo_ped = $this->Modelo->consultarSQL('pedidos', 'status_ped=1', 2, null);
				if($resul_codigo_ped) //si hay pedidos ya registrados
				{
					$consul_ped = $this->Modelo->consultarSQL('pedidos', 'status_ped=1', 'count_assoc', null);
					if( $consul_ped['count'] > 1) // si es mayor que uno, busco el valor mayor y le sumo uno
					{
						$codigo_ped = $this->Modelo->consultarSQL('pedidos', 'status_ped=1', 'cabecera_assoc', 'max(codigo_ped) as codigo_ped');
						$pedidoInsert['codigo_ped'] = $codigo_ped['codigo_ped'] + 1;	
					}else // si es menor, es dicir solo hay un registro entonces solo consulto y le sumo uno
					{
						$codigo_ped = $this->Modelo->consultarSQL('pedidos', 'status_ped=1', 'cabecera_assoc', 'codigo_ped');
						$pedidoInsert['codigo_ped'] = $codigo_ped['codigo_ped'] + 1;	
					}
				}else //cuando es por primera vez
				{
					$pedidoInsert['codigo_ped']=1;
				}

				$resul_pedido_cache = $this->Modelo->consultarSQL('pedidos_cache as PC, transportes as T, rutas as R', "(PC.id_Transporte=T.id_Transporte AND PC.id_Ruta=R.id_Ruta) AND PC.id_Usuario=$id_Usuario", 2, null);
				while ($row = $resul_pedido_cache->fetch()) 
				{
				 	
				 	$sub_total_ped = $row['precio_tra']+$row['precio_rut'];
				 	$iva_ped = $Funcion->redondear_dos_decimal(($sub_total_ped/100)*Configuracion::IVA);
				 	$total_ped = $sub_total_ped+$iva_ped;

				 	$sub_total_fac = $sub_total_ped;
				 	$iva_fac = $iva_ped;//$Funcion->redondear_dos_decimal(($total_ped/100)*Configuracion::IVA);
					$total_fac=$total_ped;
				 	$total = $row['precio_tra']+$row['precio_rut'];

				 	$pedidoInsert['id_Transporte'] = $row['id_Transporte'];
				 	$pedidoInsert['id_Empleado'] = $row['id_Empleado'];
				 	$pedidoInsert['id_Ruta'] = $row['id_Ruta'];
				 	$pedidoInsert['descripcion_ped'] = $row['descripcion_pdc'];
				 	$pedidoInsert['id_Factura'] = $id_Factura;
				 	$pedidoInsert['estado_ped'] = 'ENVIADO';

				 	$pedidoInsert['sub_total_ped'] = $sub_total_ped;
				 	$pedidoInsert['iva_ped'] = $iva_ped;
				 	$pedidoInsert['total_ped'] = $total_ped;
				 	//$pedidoInsert['id_Transporte'] = $row['id_Transporte'];
				 	$pedidoInsert['fecha_reg_ped'] = $Funcion->fecha();
					$pedidoInsert['hora_reg_ped'] =  $Funcion->hora();
					$pedidoInsert['fecha_mod_ped'] = $Funcion->fecha();
					$pedidoInsert['hora_mod_ped'] =  $Funcion->hora();
					$pedidoInsert['status_ped'] = 1;

				 	$id_Pedido = $this->Modelo->insertarSQL_2('pedidos', $pedidoInsert);
				 	if(!empty($id_Pedido))  //si se inserta lo elimino de la tabla pedido_cache
				 	{
				 		$id_PedidoCache = $row['id_PedidoCache'];
				 		//eliminar los pedido de la tabla pedido_cache
				 		$eliminar_pedido_cache = $this->Modelo->eliminarSQL('pedidos_cache', "id_PedidoCache=$id_PedidoCache");

				 		//aqui capturo  el precio de la factura actual para ir actualizandolo
				 		$factura_actual = $this->Modelo->consultarSQL('facturas', "status_fac=1 AND id_Factura=$id_Factura", 'assoc', null);
				 		//$sub_total_actual = $factura_actual['sub_total_fac']+$total;
				 		//$total_actual = $factura_actual['total_fac']+$total;
				 		$sub_total_actual = $factura_actual['sub_total_fac']+$sub_total_fac;
				 		$total_actual = $factura_actual['total_fac']+$total_fac;
				 		$iva_actual = $factura_actual['iva_fac']+$iva_fac;

				 		//$id_modificar_fac = $this->Modelo->editarSQL('facturas', array('total_fac'=>$total_actual, 'sub_total_fac'=>$sub_total_actual), "status_fac=1 AND id_Factura=$id_Factura");
					
				 		$id_modificar_fac = $this->Modelo->editarSQL('facturas', array('iva_fac'=>$iva_actual, 'total_fac'=>$total_actual, 'sub_total_fac'=>$sub_total_actual), "status_fac=1 AND id_Factura=$id_Factura");
					}
				}
				// foreach($pedidoInsert as $key => $value){echo $key.'='.$value.'<br>';}
				if(!empty($id_modificar_fac)) //si se guardo correctamente procedo a eliminar los pedidos cache y registrar en la tabla pedido
				{
					return $id_Factura;
				}else
				{
					return false;
				}
			}else
			{
				return false;
			}
		}

		Public function registrar($post)
		{
			$Funcion = new Funcion();
			$i=0;
			foreach ($post as $key => $value) 
			{
				$i++;
				$postInsert[$key] = $value;
				if($i==sizeof($post)) 
				{
					$postInsert['fecha_reg_rut'] = $Funcion->fecha();
					$postInsert['hora_reg_rut'] =  $Funcion->hora();
					$postInsert['fecha_mod_rut'] = $Funcion->fecha();
					$postInsert['hora_mod_rut'] =  $Funcion->hora();
					$postInsert['status_rut'] = 1;
				}
			}
			$id = $this->Modelo->insertarSQL_2('rutas', $postInsert);
			//foreach($postInsert as $key => $value){echo $key.'='.$value.'<br>';}
			if(!empty($id)){
				return true;
			}else
			{
				return false;
			}
			
		}

		Public function cambiar_estatus_pedido($post)
		{
			$id_Pedido = $_POST['id_Pedido'];
	        $estado_ped = $_POST['estado_ped'];
	        $id = $this->Modelo->editarSQL('pedidos', array('estado_ped'=>$estado_ped), "status_ped=1 AND id_Pedido=$id_Pedido");

	        if (!empty($id)) 
	        {
	        	if (!empty($_POST['observacion_pob'])) 
	        	{
	        		$observacion_pob = '<b>['.$estado_ped.'] </b>'.$_POST['observacion_pob'];
	        		$id_PedidoObservacion = $this->Modelo->insertarSQL_2('pedidos_observacion', array('observacion_pob'=>$observacion_pob, 'id_Pedido'=>$id_Pedido, 'status_pob'=>1));
	        		if(!empty($id_PedidoObservacion)){
						return true;
					}else
					{
						return false;
					}
	        	}else
	        	{
	        		return true;
	        	}	
	        	
	        }else
	        {
	        	return false;
	        }				
		}
	}

?>
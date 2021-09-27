<?php
	class ClienteModel extends ModelBase 
	{
	
		protected $Modelo;
		
		public function __construct()
		{
			$this->Modelo = new ModelBase();
			
			return parent ::__construct(); //reutilizar el constructor del padre
		}

		Public Function consultar($tabla, $where=null, $condicion=null, $cabeceras=null)
		{
			$array = $this->Modelo->consultarSQL($tabla, $where, $condicion, $cabeceras);
			return $array;
		}

		Public Function modificar($set=array(), $id=null)
		{
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$i=0;

			foreach ($set as $key => $value) 
			{
				$i++;
				if($key == 'Mfecha_nac_per') 
				{
					$postEditar['fecha_nac_per'] = $Funcion->fechaMysql($set['Mfecha_nac_per'], '/');
				}elseif($key == 'Mid_Cliente')
				{
					$id_Cliente = $value;
				}else
				{
					$postEditar[substr($key, (1-strlen($key)))] = $value; //aqui se le qui la letra M de la cadena del nombre del campo para porder coincidir con los campos de la base de datos
					//agregar al array editar los campos que van a ser actualizado pero que no forman parte del formulario
				}
				
				if ($i==sizeof($set)) 
				{
					$postEditar['fecha_mod_per'] = $Funcion->fecha();
					$postEditar['hora_mod_per'] =  $Funcion->hora();			
				}
			}

			
			$id_Persona = $this->Modelo->consultarSQL('clientes', "id_Cliente=$id AND status_cli=1", 'cabecera_assoc', 'id_Persona');
			$id_per = $id_Persona['id_Persona'];
			//foreach($postEditar as $key => $value){echo '<script type="text/javascript">alert("'.$key.'='.$value.'");</script>';}
			$modificar = $this->Modelo->editarSQL('personas', $postEditar, "id_Persona=$id_per AND status_per=1");
			//echo '<script type="text/javascript">alert("'.$id_per.'");</script>';//foreach($postEditar as $key => $value){echo '<script type="text/javascript">alert("'.$key.'='.$value.'");</script>';}
			if($modificar) 
			{
				//$modificar2 = $this->Modelo->editarSQL('empleados', array('id_Cargo'=>$set['Mid_Cargo']), "id_Empleado=$id AND status_emp=1");
				//echo '<script type="text/javascript">alert("'.$modificar2.'");</script>';
				return true;
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
				
				if ($key == 'fecha_nac_per') 
				{
					$postInsert['fecha_nac_per'] = $Funcion->fechaMysql($post['fecha_nac_per'], '/');
				}else
				{
					$postInsert[$key] = $value;
				}
				
				if($i==sizeof($post)) 
				{
					$postInsert['fecha_reg_per'] = $Funcion->fecha();
					$postInsert['hora_reg_per'] =  $Funcion->hora();
					$postInsert['fecha_mod_per'] = $Funcion->fecha();
					$postInsert['hora_mod_per'] =  $Funcion->hora();
					$postInsert['status_per'] = 1;
				}
			}

			$resul_persona = $this->Modelo->consultarSQL('personas', 'status_per=1 AND cedula_per="'.$post['cedula_per'].'" ', 'assoc', null);
			if (empty($resul_persona)) 
			{
				$id_Persona = $this->Modelo->insertarSQL_2('personas', $postInsert);
				if(!empty($id_Persona)) // si el cliente no existe en la tabla persona
				{
					$postInsertEmpleado['id_Persona'] = $id_Persona;
					$postInsertEmpleado['fecha_reg_cli'] = $Funcion->fecha();
					$postInsertEmpleado['hora_reg_cli'] =  $Funcion->hora();
					$postInsertEmpleado['fecha_mod_cli'] = $Funcion->fecha();
					$postInsertEmpleado['hora_mod_cli'] =  $Funcion->hora();
					$postInsertEmpleado['status_cli'] = 1;
					$id_Cliente = $this->Modelo->insertarSQL_2('clientes', $postInsertEmpleado);
					if(!empty($id_Cliente))
					{
						return true;
					}else
					{
						return false;
					}
				}else 
				{
					return false;
				}
			}else // si el cliente existe en la tabla persona, se registra solo en la tabla cliente
			{
				$postInsertEmpleado['id_Persona'] = $resul_persona['id_Persona'];
				$postInsertEmpleado['fecha_reg_cli'] = $Funcion->fecha();
				$postInsertEmpleado['hora_reg_cli'] =  $Funcion->hora();
				$postInsertEmpleado['fecha_mod_cli'] = $Funcion->fecha();
				$postInsertEmpleado['hora_mod_cli'] =  $Funcion->hora();
				$postInsertEmpleado['status_cli'] = 1;
				$id_Cliente = $this->Modelo->insertarSQL_2('clientes', $postInsertEmpleado);
				if(!empty($id_Cliente))
				{
					return true;
				}else
				{
					return false;
				}
			}
		}
	}

?>
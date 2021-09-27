<?php
	class RutaModel extends ModelBase 
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

		Public Function modificar($tabla, $set=array(), $where=1, $id=null)
		{
			require_once 'libs/Funciones.class.php';
			$Funcion = new Funcion('libs/Funciones.class.php');
			$i=0;
			foreach ($set as $key => $value) 
			{
				$i++;
				$postEditar[substr($key, (1-strlen($key)))] = $value; //aqui se le qui la letra M de la cadena del nombre del campo para porder coincidir con los campos de la base de datos
				//agregar al array editar los campos que van a ser actualizado pero que no forman parte del formulario
				if ($i==sizeof($set)) 
				{
					$postEditar['fecha_mod_rut'] = $Funcion->fecha();
					$postEditar['hora_mod_rut'] =  $Funcion->hora();			
				}
			}
			
			$modificar = $this->Modelo->editarSQL($tabla, $postEditar, $where);
			if($modificar) 
			{
				return @$modificar;
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

		Public function registrar_ajax($post)
		{
			$Funcion = new Funcion();
			$i=0;
			foreach ($post as $key => $value) 
			{
				$i++;
				if(($key=='id_Estado_rut') OR ($key=='id_Ciudad_rut') OR ($key=='id_Municipio_rut') OR ($key=='id_Parroquia_rut')) 
				{
					$postInsert['id_Estado'] = $post['id_Estado_rut'];
					$postInsert['id_Ciudad'] = $post['id_Ciudad_rut'];
					$postInsert['id_Municipio'] = $post['id_Municipio_rut'];
					$postInsert['id_Parroquia'] = $post['id_Parroquia_rut'];
				}else
				{
					$postInsert[$key] = $value;
				}
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
			//foreach($postInsert as $key => $value){echo '<script type="text/javascript">alert("'.$key.'='.$value.'");</script>';}
			if(!empty($id)){
				return $id;
			}else
			{
				return false;
			}
			
		}
	}

?>
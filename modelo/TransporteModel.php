<?php
	class TransporteModel extends ModelBase 
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
					$postEditar['fecha_mod_tra'] = $Funcion->fecha();
					$postEditar['hora_mod_tra'] =  $Funcion->hora();			
				}
			}
			/*
			foreach ($postEditar as $key => $value) {
				echo$key.'='.$value.'<br>';
			}*/
			$modificar = $this->Modelo->editarSQL($tabla, $postEditar, $where);
			//echo $modificar;
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
					$postInsert['fecha_reg_tra'] = $Funcion->fecha();
					$postInsert['hora_reg_tra'] =  $Funcion->hora();
					$postInsert['fecha_mod_tra'] = $Funcion->fecha();
					$postInsert['hora_mod_tra'] =  $Funcion->hora();
					$postInsert['status_tra'] = 1;
				}
			}

			$id = $this->Modelo->insertarSQL_2('transportes', $postInsert);
			//foreach($postInsert as $key => $value){echo $key.'='.$value.'<br>';}
			if(!empty($id))
			{
				return true;	
			}else
			{
				return false;
			}
			
		}
	}

?>
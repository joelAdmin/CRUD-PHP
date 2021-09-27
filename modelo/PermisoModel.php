<?php
	class PermisoModel extends ModelBase 
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

		Public Function modificarSQL($tabla, $set=array(), $where=1)
		{
			$modificar = $this->Modelo->editarSQL($tabla, $set, $where);
			return $modificar;
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
					$postInsert['codigo_prm'] = $post["controlador_prm"].''.$post["accion_prm"];
					$postInsert['status_prm'] = 1;
				}
			}
			foreach($postInsert as $key => $value){echo $key.'='.$value.'<br>';}
			$id_Permiso = $this->Modelo->insertarSQL_2('permisos', $postInsert);
			if(!empty($id_Permiso))
			{
				return true;
			}else
			{
				return false;
			}
		}
	}
?>
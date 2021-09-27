<?php
	class CargoModel extends ModelBase 
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
			$consulta_actual = $this->Modelo->consultarSQL('menus', "status_men=1 and id_Menu=$id");
			foreach ($set as $key => $value) 
			{
				$i++;
				
				if($consulta_actual['id_Menu'] != $set['Mmenu_men'] ) // si es diferente del menu actual quiere decir que cambiaremos la posicion del menu
				{
					if($key == 'Mposicion_men')
					{
						$id_Menu_selec = $_POST["Mmenu_men"]; //capturo el id de menu seleccionado //$posicion_men = $_POST["Mmenu_men"];

						//procedo a calcular la posicion del menu para aplicar la logica 
						$consulta = $this->Modelo->consultarSQL('menus', "status_men=1 and id_Menu=$id_Menu_selec", 'assoc');
						$posicion_men = $consulta['posicion_men'];
						if($_POST['Mposicion_men'] == 'ANTES')
						{
							
							//consulto todos menos el que estoy editando, para crear el array 
							$consultaMenor = $this->Modelo->consultarSQL('menus', "posicion_men >= $posicion_men AND id_Menu<>$id", 4, 'id_Menu, posicion_men');
							
							//comprovar si la consulta se ejecuto correctamente
							if($consultaMenor->rowCount() != 0)
							{
								//recorrer la consulta para crear el array que va a contener los datos a ser actualizados
								while($row = $consultaMenor->fetch()){
									$postEditar_antes[$row['id_Menu']] = $row['posicion_men']+1;
								}

								//recorrer el arrat creado y actualizar
								foreach ($postEditar_antes as $key2 => $value2) 
								{
									$modificar = $this->Modelo->editarSQL('menus', array('posicion_men'=>$value2), "id_Menu=$key2");
								}

								$modificar = $this->Modelo->editarSQL('menus', array('posicion_men'=>$posicion_men), "id_Menu=$id");
							}

						}elseif($_POST['Mposicion_men'] == 'DESPUES')
						{
							
							$consultaMayor = $this->Modelo->consultarSQL('menus', "posicion_men > $posicion_men AND id_Menu<>$id ", 4, 'id_Menu, posicion_men');
							if($consultaMayor->rowCount() != 0)
							{
								//recorrer la consulta para crear el array que va a contener los datos a ser actualizados
								while($row = $consultaMayor->fetch()){	
									$postEditar_despues[$row['id_Menu']] = $row['posicion_men']+1;	
								}

								//recorrer el arrat creado y actualizar
								foreach ($postEditar_despues as $key2 => $value2) 
								{
									$modificar = $this->Modelo->editarSQL('menus', array('posicion_men'=>$value2), "id_Menu=$key2");
								}

								$posicion_men = $posicion_men + 1;
								$modificar = $this->Modelo->editarSQL('menus', array('posicion_men'=>$posicion_men), "id_Menu=$id");		

							}else // en caso de seleccionar el ultimo registro
							{
								$consultaMax = $this->Modelo->consultarSQL('menus', "status_men=1", 4, 'max(posicion_men) as posicion_men');
								if ($consultaMax->rowCount() != 0) 
								{
									$posicion_men = $posicion_men + 1;
									$modificar = $this->Modelo->editarSQL('menus', array('posicion_men'=>$posicion_men), "id_Menu=$id");	
								}
							}
						}
					}

				}

				if(($key != 'Mposicion_men') && ($key != 'Mmenu_men'))
				{
					//echo '<script type="text/javascript"> alert(CKEDITOR.instances.Mcontenido_men.getData()); </script>';
					if($key == 'Mcontenido_men')
					{
						$postEditar[substr($key, (1-strlen($key)))] = $value; //'<script type="text/javascript">document.write(CKEDITOR.instances.Mcontenido_men.getData())</script>';
					}else
					{
						$postEditar[substr($key, (1-strlen($key)))] = $value;
					}
					
				}

				//agregar al array editar los campos que van a ser actualizado pero que no forman parte del formulario
				if ($i==sizeof($set)) 
				{
					//$postInsert['token_usu'] = md5('1234');
					$postEditar['fecha_mod_men'] = $Funcion->fecha();
					$postEditar['hora_mod_men'] =  $Funcion->hora();
							
				}
			}
			/*
			foreach ($postEditar as $key => $value) {
				echo$key.'='.$value.'<br>';
			}*/
			$modificar = $this->Modelo->editarSQL($tabla, $postEditar, $where);
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
					$postInsert['fecha_reg_car'] = $Funcion->fecha();
					$postInsert['hora_reg_car'] =  $Funcion->hora();
					$postInsert['fecha_mod_car'] = $Funcion->fecha();
					$postInsert['hora_mod_car'] =  $Funcion->hora();
					$postInsert['status_car'] = 1;
				}
			}
			$id = $this->Modelo->insertarSQL_2('cargos', $postInsert);
			if(!empty($id)){
				return true;
			}else
			{
				return false;
			}
			
		}
	}

?>
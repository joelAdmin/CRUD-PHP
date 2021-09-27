<?php
	class SubMenuModel extends ModelBase 
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
			$consulta_actual = $this->Modelo->consultarSQL('submenus', "status_sub=1 AND id_SubMenu=$id");
			foreach ($set as $key => $value) 
			{
				$i++;
				$post_submenu = (int) $set['MsubMenu_sub'];
				if($consulta_actual['id_SubMenu'] != $post_submenu ) // si es diferente del menu actual quiere decir que cambiaremos la posicion del menu
				{
					if($key == 'Mposicion_sub')
					{
						$id_SubMenu = $set["MsubMenu_sub"];
						$id_Menu = $set["Mid_Menu"];
						$consulta = $this->Modelo->consultarSQL('submenus', "status_sub=1 AND id_SubMenu=$id_SubMenu", 'assoc');
						
						if($set['Mposicion_sub'] == 'ANTES')
						{
							$posicion_sub = $consulta['posicion_sub'];
							//echo 'ENTRO AQUI'.$posicion_sub;
							//$postInsert['posicion_sub'] = $posicion_sub;
							$consultaMenor = $this->Modelo->consultarSQL('submenus', "posicion_sub >= $posicion_sub AND id_Menu=$id_Menu AND id_SubMenu<>$id", 4, 'id_SubMenu, posicion_sub');
							//echo $consultaMenor->fetch().num_rows;
							if($consultaMenor->rowCount() != 0)
							{
								while($row = $consultaMenor->fetch()){
									$postEditar_antes[$row['id_SubMenu']] = $row['posicion_sub']+1;
								}

								foreach ($postEditar_antes as $key2 => $value2) 
								{
									//echo $key2.'='.$value2.'<br>';
									$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$value2), "id_SubMenu=$key2");
								}
								//echo 'posicion_sub:'.$posicion_sub;
								$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$posicion_sub), "id_SubMenu=$id");
							}

						}elseif($set['Mposicion_sub'] == 'DESPUES')
						{
							$posicion_sub = $consulta['posicion_sub'];
							//echo 'id='.$posicion_men;
							///$postInsert['posicion_sub'] = $posicion_sub + 1;
							$consultaMayor = $this->Modelo->consultarSQL('submenus', "posicion_sub > $posicion_sub AND id_Menu=$id_Menu AND id_SubMenu<>$id", 4, 'id_SubMenu, posicion_sub');
							if($consultaMayor->rowCount() != 0)
							{
								while($row = $consultaMayor->fetch())
								{
									$postEditar_despues[$row['id_SubMenu']] = $row['posicion_sub']+1;
								}

								foreach ($postEditar_despues as $key2 => $value2) 
								{
									//echo $key2.'/:/'.$value2.'<br>';
									$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$value2), "id_SubMenu=$key2");
								}

								$posicion_sub = $posicion_sub + 1; //me ubico en la posicion actual y le sumo uno mas, para cumplir la concion de que sea agregado despues del submenu seleccionado
								$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$posicion_sub), "id_SubMenu=$id");		
							}else // en caso de seleccionar el ultimo registro
							{
								$consultaMax = $this->Modelo->consultarSQL('submenus', "id_Menu=$id_Menu", 4, 'max(posicion_sub) as posicion_sub');
								if ($consultaMax->rowCount() != 0) 
								{
									$posicion_sub = $posicion_sub + 1;
									$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$posicion_sub), "id_SubMenu=$id");
								}		
							}
						}
					}

				}

				if(($key != 'Mposicion_sub')  && ($key != 'Mmenu_sub') && ($key != 'MsubMenu_sub'))
				{
					//echo '<script type="text/javascript"> alert(CKEDITOR.instances.Mcontenido_men.getData()); </script>';
					if($key == 'Mcontenido_sub')
					{
						$postEditar[substr($key, (1-strlen($key)))] = $value; //'<script type="text/javascript">document.write(CKEDITOR.instances.Mcontenido_men.getData())</script>';
					}else
					{
						if (is_numeric($value)) 
						{
							$postEditar[substr($key, (1-strlen($key)))] = (int) $value;
						}else
						{
							$postEditar[substr($key, (1-strlen($key)))] = $value;
						}
						
					}
					
				}

				//agregar al array editar los campos que van a ser actualizado pero que no forman parte del formulario
				if ($i==sizeof($set)) 
				{
					$postEditar['fecha_mod_sub'] = $Funcion->fecha();
					$postEditar['hora_mod_sub'] =  $Funcion->hora();			
				}
			}
			/*
			foreach ($postEditar as $key => $value) {
				echo$key.'='.$value.'<br>';
			}*/
			$modificar = $this->Modelo->editarSQL($tabla, $postEditar, $where);
			//echo $modificar;
			return @$modificar;
			
		}

		Public function registrar($set=array())
		{
			$Funcion = new Funcion();
			$i=0;
			
			foreach ($set as $key => $value) 
			{
				$i++;
				if($key == 'posicion_sub')
				{
					
					$id_SubMenu = $set["subMenu_sub"];
					$id_Menu = $set["id_Menu"];
					$consulta = $this->Modelo->consultarSQL('submenus', "status_sub=1 AND id_SubMenu=$id_SubMenu", 'assoc');
					
					if($set['posicion_sub'] == 'ANTES')
					{
						$posicion_sub = $consulta['posicion_sub'];
						$postInsert['posicion_sub'] = $posicion_sub;
						$consultaMenor = $this->Modelo->consultarSQL('submenus', "posicion_sub >= $posicion_sub AND id_Menu=$id_Menu", 4, 'id_SubMenu, posicion_sub');
						//echo $consultaMenor->fetch().num_rows;
						
						if($consultaMenor->rowCount() != 0)
						{
							while($row = $consultaMenor->fetch()){
								$postEditar[$row['id_SubMenu']] = $row['posicion_sub']+1;
							}

							foreach ($postEditar as $key2 => $value2) {
								
								$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$value2), "id_SubMenu=$key2");
							}
						}

					}elseif($_POST['posicion_sub'] == 'DESPUES')
					{
						$posicion_sub = $consulta['posicion_sub'];
						//echo 'id='.$posicion_men;
						$postInsert['posicion_sub'] = $posicion_sub + 1;
						$consultaMayor = $this->Modelo->consultarSQL('submenus', "posicion_sub > $posicion_sub AND id_Menu=$id_Menu", 4, 'id_SubMenu, posicion_sub');
						
						if($consultaMayor->rowCount() != 0)
						{

							while($row = $consultaMayor->fetch())
							{
								$postEditar[$row['id_SubMenu']] = $row['posicion_sub']+1;
							}

							foreach ($postEditar as $key2 => $value2) 
							{
								//echo $key2.'/:/'.$value2.'<br>';
								$modificar = $this->Modelo->editarSQL('submenus', array('posicion_sub'=>$value2), "id_SubMenu=$key2");
							}

						}
					}
				}elseif(($key != 'posicion_sub') and ($key != 'subMenu_sub'))
				{
					//$postInsert['posicion_sub'] = 1;
					$postInsert[$key] = $value;
				}
				
				if(empty($set['subMenu_sub']))
				{
					$postInsert['posicion_sub'] = 1;
					
				}

				if($i==sizeof($_POST)) 
				{
					
					$postInsert['fecha_reg_sub'] = $Funcion->fecha();
					$postInsert['hora_reg_sub'] =  $Funcion->hora();
					$postInsert['fecha_mod_sub'] = $Funcion->fecha();
					$postInsert['hora_mod_sub'] =  $Funcion->hora();
					$postInsert['status_sub'] = 1;

				}

			}
			
			foreach ($postInsert as $key => $value) {
				echo$key.'='.$value.'<br>';
			}
			
			$id = $this->Modelo->insertarSQL_2('submenus', $postInsert);
			//echo $id;
			if(!empty($id)){
				return true;
			}else
			{
				return false;
			}
			
		}
	}

?>
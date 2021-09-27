<?php
class ModelBase
{
	protected $db;

	public function __construct()
	{
		$this->db = SPDO::singleton();
	}

	Public function describeTabla($tabla)
	{
		$describe = $this->db->query("DESCRIBE $tabla");
		return $describe ; //->fetch(PDO::FETCH_BOTH);
	}

	Public function eliminarSQL($tabla, $where=1)
	{
		$eliminar = $this->db->query("DELETE  FROM $tabla WHERE $where");
		return $eliminar;
	}
	
	Public function consultarSQL($tabla, $where=1, $tipo=null, $cabeceras=null)
	{
		$consulta = $this->db->query("SELECT * FROM $tabla WHERE $where");
		//echo "SELECT * FROM $tabla WHERE $where";
		if(($tipo==1)||($tipo==null))
		{
			//return $consulta->fetch(PDO::FETCH_ASSOC);
			return $consulta->fetch(PDO::FETCH_BOTH);
		}elseif($tipo=='assoc')
		{
			return $consulta->fetch(PDO::FETCH_ASSOC);
			
		}elseif($tipo==2)
		{
			return $consulta;
		}elseif(($tipo==3) OR ($tipo=='count_both'))
		{
			 $consultaCount = $this->db->query("SELECT COUNT(*) FROM $tabla WHERE $where");
			return $consultaCount->fetch(PDO::FETCH_BOTH);// FETCH_BOTH retorna tanto una array numerico coomo asociativo
		}elseif(($tipo=='cantidad_asociativo') OR ($tipo=='count_assoc'))
		{
			 $consultaCount = $this->db->query("SELECT COUNT(*) as count FROM $tabla WHERE $where");
			return $consultaCount->fetch(PDO::FETCH_ASSOC);// FETCH_BOTH retorna tanto una array numerico coomo asociativo
		}elseif($tipo==4)
		{
			return $consultaLIMIT = $this->db->query("SELECT $cabeceras FROM $tabla WHERE $where");
			//return "SELECT $cabeceras FROM $tabla WHERE $where";
			//return $consultaLIMIT->fetch(PDO::FETCH_BOTH);// FETCH_BOTH retorna tanto una array numerico coomo asociativo
			
		}elseif($tipo=='cabecera_assoc')
		{
			$consultaLIMIT = $this->db->query("SELECT $cabeceras FROM $tabla WHERE $where");
			return $consultaLIMIT->fetch(PDO::FETCH_ASSOC);
		}
		
	}
	
	Public function genera_random($longitud)
	{ 
		$exp_reg="[^A-Z0-9]"; 
		return substr(eregi_replace($exp_reg, "", md5(rand())) . 
		   eregi_replace($exp_reg, "", md5(rand())) . 
		   eregi_replace($exp_reg, "", md5(rand())), 
		   0, $longitud); 
	}
	 
	public function insertarSQL($tabla, $post = array())
	{
		$p=0;$j=0; $m=0; $n=0;
		$describe0 = $this->db->query("DESCRIBE $tabla");
		$describe1 = $this->db->query("DESCRIBE $tabla");
		//$describe2 = $this->db->query("DESCRIBE $tabla");
		while($des = $describe0->fetch()){$p++;$arra2[$p] = $p;}
		$long = count($arra2);		
		$long2 = count($post);		
		
		while($des = $describe1->fetch())
		{
			$j++;
			if($j == $long)
			{
				@$campos .= "{$des['Field']} \n";
			}elseif($j > 1)
			{
				@$campos .= "{$des['Field']} ,\n";
			}
		}

		foreach($post as $key => $value)
		{
			$m++;
			if($m==$long2)
			{ 
				@$valores .= "'".$value."'"; 
			}elseif($value==null)
			{
				@$valores .= "'".$value."'".','; 
			}else
			{ 
				@$valores .= "'".$value."'".',';
			}
		}
		
		$sql = "INSERT INTO $tabla ($campos) VALUES ($valores)";
		/*$consulta = $this->db->exec($sql);
		$id_registro = $this->db->lastInsertId();
		//$_POST = array();
		return  $id_registro;*/
		return $sql;
	}

	public function insertarSQL_2($tabla, $post = array())
	{
		$p=0;$j=0; $m=0; $n=0;
		$describe0 = $this->db->query("DESCRIBE $tabla");
		$describe1 = $this->db->query("DESCRIBE $tabla");
		//$describe2 = $this->db->query("DESCRIBE $tabla");
		while($des = $describe0->fetch()){$p++;$arra2[$p] = $p;}
		$long = count($arra2);		
		$long2 = count($post);		
		
		foreach($post as $key => $value)
		{
			$m++;
			if($m==$long2)
			{ 
				@$valores .= "'".$value."'"; 
				@$campos .= $key;
			}elseif($value==null)
			{
				@$valores .= "'".$value."'".','; 
				@$campos .= $key.','; 
			}else
			{ 
				@$valores .= "'".$value."'".',';
				@$campos .= $key.', ';
			}
		}
		
		$sql = "INSERT INTO $tabla ($campos) VALUES ($valores)";
		//return $sql;
		$consulta = $this->db->exec($sql);
		$id_registro = $this->db->lastInsertId();
		return  $id_registro;
		//return $sql;
	}

	Public function editarSQL($tabla, $post = array(), $where=1)
	{
		$m = 0;
		$long = count($post);
		$valores = null; //variable inicializada en null a partir de la version 5.5.4 php
		
		foreach($post as $key => $value)
		{
			$m++;
			if($m==$long)// si es el ultimo valor le quito la coma
			{ 
				if(is_numeric($value))
				{
					$valores .="".$key."='".$value."'";
				}elseif(($value==null) || ($value==''))
				{
					$valores .= "".$key."='".$value."'";
				}else
				{
					$valores .="".$key."='".$value."'";
					
				}
			}else
			{ 
				if(is_numeric($value))
				{
					$valores .= "".$key."='".$value."'".',';
				}elseif(($value==null) || ($value==''))
				{
					$valores .= "".$key."='".$value."'".',';
				}else
				{
					$valores .= "".$key."='".$value."'".',';
				}
			}
		}
		
		$sql = "UPDATE $tabla SET $valores WHERE $where";
		$consulta = $this->db->exec($sql);
		
		return $consulta;	
	}
	/*
	Public function editarSQL($tabla, $post = array(), $where=1)
	{
		$m = 0;
		$long = count($post);
		$valores = null; //variable inicializada en null a partir de la version 5.5.4 php
		
		foreach($post as $key => $value)
		{
			$m++;
			if($m==$long)// si es el ultimo valor le quito la coma
			{ 
				if(is_numeric($value))
				{
					$valores .="".$key."=".$value."";
				}elseif(($value==null) || ($value==''))
				{
					$valores .= "".$key."='".$value."'";
				}else
				{
					$valores .="".$key."='".$value."'";

				}
			}else
			{ 
				if(is_numeric($value))
				{
					$valores .= "".$key."=".$value."".',';
				}elseif(($value==null) || ($value==''))
				{
					$valores .= "".$key."='".$value."'".',';
				}else
				{
					$valores .= "".$key."='".$value."'".',';
				}
			}
		}
		
		$sql = "UPDATE $tabla SET $valores WHERE $where";
		$consulta = $this->db->exec($sql);
		
		return $consulta;	
	}
	
	
	Public function editarSQL($tabla, $_POST = array(), $where=1)
	{
		$m = 0;
		$long = count($_POST);
		
		foreach($_POST as $key => $value)
		{
			$m++;
			if($m==$long)
			{ 
				if(is_numeric($value))
				{
					$valores .="".$key."=".$value."";
				}else
				{
					$valores .="".$key."='".$value."'";
				}
			}elseif($value==null)
			{
				$valores .= "'".$value."'";
			}else
			{ 
				if(is_numeric($value))
				{
					$valores .= "".$key."=".$value."".',';
				}else
				{
					$valores .= "".$key."='".$value."'".',';
				}
			}
		}
		
		$sql = "UPDATE $tabla SET $valores WHERE $where";
		$consulta = $this->db->exec($sql);
		
		//return $consulta;
		return $valores;
		
	}
	*/
	
	function __destruct()
	{
		$this->db = SPDO::singleton();
    }
	
}
?>

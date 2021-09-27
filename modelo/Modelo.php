 <?php
	class Modelo extends ModelBase 
	{
	
		protected $Modelo;
		
		public function __construct()
		{
			$this->Modelo = new ModelBase();
			
			return parent ::__construct(); //reutilizar el constructor del padre
		}
		
		
		Public Function insertar($tabla, $postInsert=array())
		{
			$id = $this->Modelo->insertarSQL($tabla, $postInsert);
			return $id;
		}
		
		
		Public Function consultar($tabla, $where=null, $tipo=null, $cabeceras=null)
		{
			$array = $this->Modelo->consultarSQL($tabla, $where, $tipo, $cabeceras);
			return $array;
		}
		
		Public Function modificar($tabla, $set=array(), $where=1)
		{
			//$postEditar = array('token_usu' => $_SESSION['token']);
			$modificar = $this->Modelo->editarSQL($tabla, $set, $where);
			return $modificar;
		}
			
	}
?>

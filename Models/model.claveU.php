<?php 
	/**
	* modelo al base de datos
	*/
	include_once '../app/Conexion.php';
	class Unidad 
	{
		public $arr=array();
		public function __construct()
		{
			//default conecta con la base de datos
			$this->con = new Conexion();
		}

		public function set($atributo, $contenido)
		{
			$this->$atributo = $contenido;
		}

		public function get($atributo)
		{
			return $this->$atributo;
		}

		public function add()
		{
			$sql =" INSERT INTO lla_clave_unidad(clave_sat, descripcion_sat, descripcion_empresa) 
					VALUES('{$this->clavesat}','{$this->dessat}','{$this->descripcion}')";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function buscar_auto(){
			$arr=array();
			$sql = "SELECT CONCAT(TRIM(clave_unidad),'-',TRIM(nombre))AS respuesta FROM lls_clave_unidad 
				WHERE CONCAT(TRIM(clave_unidad),'-',TRIM(nombre)) LIKE '%$this->concepto%' ORDER BY rowid";
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);

			while ($row = mysqli_fetch_array($datos)) {
				$row_array=$this->roll=utf8_encode($row['respuesta']);
				array_push($arr,$row_array);
    		}
    		return ($arr);
		}

		public function listageneral(){

			$sql="SELECT * FROM lla_clave_unidad ORDER BY id DESC";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function editar()
		{
			$sql =" UPDATE lla_clave_unidad SET clave_sat='{$this->clavesat}',descripcion_sat='{$this->dessat}',descripcion_empresa='{$this->descripcion}' WHERE id='{$this->id}'";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function delete(){

			$sql="DELETE FROM lla_clave_unidad WHERE id='{$this->id}'";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function buscardatos()
		{
		    $sql="SELECT CONCAT(TRIM(clave_sat),'-',TRIM(descripcion_sat))AS informacionsat, descripcion_empresa FROM lla_clave_unidad WHERE id='{$this->id}'";
		    //echo $sql;
		    $datos = $this->con->consultaRetorno($sql);
		    while($row=mysqli_fetch_array($datos))
		    {
		   		 $this->informacionsat=utf8_encode($row['informacionsat']);
		   		 $this->descripcion=utf8_encode($row['descripcion_empresa']);
		   	}
		}

	}
 ?>
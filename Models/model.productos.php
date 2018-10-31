<?php 
	/**
	* modelo al base de datos
	*/
	include_once '../app/Conexion.php';
	class Productos 
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
			$sql =" INSERT INTO lla_productos(clave_interna, clave_sat, descripcion_sat, descripcion_empresa) 
					VALUES('{$this->clave}','{$this->clavesat}','{$this->dessat}','{$this->descripcion}')";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function buscar_auto(){
			$arr=array();
			$sql = "SELECT CONCAT(TRIM(clave_prodserv),'-',TRIM(descripcion))AS respuesta FROM lls_clave_prodserv 
				WHERE CONCAT(TRIM(clave_prodserv),'-',TRIM(descripcion)) LIKE '%$this->concepto%' LIMIT 20";
				// ORDER BY rowid
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);
			while ($row = mysqli_fetch_array($datos)) {
				$row_array=$this->roll=utf8_encode($row['respuesta']);
				array_push($arr,$row_array);
    		}
    		return ($arr);
		}

		public function listageneral(){

			$sql="SELECT * FROM lla_productos ORDER BY id DESC";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function editar()
		{
			$sql =" UPDATE lla_productos SET clave_interna='{$this->clave}',clave_sat='{$this->clavesat}',descripcion_sat='{$this->dessat}',descripcion_empresa='{$this->descripcion}' WHERE id='{$this->id}'";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function delete(){

			$sql="DELETE FROM lla_productos WHERE id='{$this->id}'";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function buscardatos()
		{
		    $sql="SELECT CONCAT(TRIM(clave_sat),'-',TRIM(descripcion_sat))AS informacionsat, clave_interna,descripcion_empresa FROM lla_productos WHERE id='{$this->id}'";
		    //echo $sql;
		    $datos = $this->con->consultaRetorno($sql);
		    while($row=mysqli_fetch_array($datos))
		    {
		   		 $this->informacionsat=utf8_encode($row['informacionsat']);
		   		 $this->clave=utf8_encode($row['clave_interna']);
		   		 $this->descripcion=utf8_encode($row['descripcion_empresa']);
		   	}
		}
		////////////////Carga Excel/////////////////////
		public function utf8()
		{
			$sql="SET NAMES 'utf8'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}


		public function insertprodtable()
		{
			$sql="ALTER TABLE lla_productos AUTO_INCREMENT = 1";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function cargamasiva()
		{
			// $sql="INSERT INTO lla_productos (clave_interna, clave_sat,descripcion_sat) VALUES
			// ('{$this->clave_interna}','{$this->clave_sat}','{$this->descripcion_sat}')";
			$sql="CALL cargamasivaproductos('{$this->clave_sat}','{$this->descripcion_sat}','{$this->clave_interna}');";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function updateprodtable()
		{
			$sql="ALTER TABLE lla_productos AUTO_INCREMENT = 1";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function deleteprodtable()
		{
			$sql="DELETE FROM lla_productos";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

	}
 ?>
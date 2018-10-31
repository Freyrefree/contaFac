<?php

class Conexion{

	private $datos = array(
		"host" => "localhost",//
		"user" => "root",//root
		"pass" => "",//
		"db"   => "factura_contabilidad"//creditosbcd
	);
	// private $datos = array(
	// 	"host" => "192.168.0.10",
	// 	"user" => "aiko10",
	// 	"pass" => "aiko10",
	// 	"db"   => "nueva_facturacion"
	// );
	private $con; //acceso a otras clases
	/*crudpro*/
	
	public function __construct(){
		$this->con = new \mysqli($this->datos['host'], $this->datos['user'], $this->datos['pass'], $this->datos['db']);
	}

	public function consultaSimple($sql){
		/*$answer = */$this->con->query($sql);
		/*return $answer;*/
	}

	public function consulta($sql){
		/*$answer = */$dato = $this->con->query($sql);
		return $dato;
		/*return $answer;*/
	}


	public function consultaRetorno($sql){
		$datos = $this->con->query($sql);
		return $datos;
	}
	//nuevo agregado ismael //trae el ultimo id registrado de la consulta
	public function last_insert_id($sql){
		return mysqli_insert_id($this->con);			    
	}


	/*public function close(){
		$this->con->close();
	}*/
}
?>
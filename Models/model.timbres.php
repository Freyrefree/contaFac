<?php 
	/**
	* modelo al base de datos
	*/
    include_once '../app/Conexion.php';
    
	class Timbres
	{

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

				public function busquedaGeneral(){
            $sql = "SELECT existencia , consumido_total, consumido_cancelacion, consumido_real FROM lla_timbres
             where rfc='{$this->rfc}'";
             //echo $sql;
            $datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

    public function timbresEnFactura(){
            $sql = "CALL Timbres('{$this->fechainicio}' , '{$this->fechafin}', '{$this->rfc}')";
            //echo $sql;
            $datos=$this->con->consultaRetorno($sql);
			      //return $datos;
            while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC))
          	{
          		$this->pendiente = $row['pendiente'];
          		$this->facturada = $row['facturada'];
              $this->cancelada = $row['cancelada'];
              $this->canceladaNC = $row['canceladaNC'];
          	}

		}
	}
 ?>
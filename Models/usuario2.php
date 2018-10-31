<?php
	/**
	* modelo al base de datos usuario --> lla_usuario
	*/
	//include_once 'app/Conexion.php';
	include_once '../app/Conexion.php';
	class Usuario {



		public function __construct(){
			//default conecta con la base de datos
			//$this->cmd = new Conexion();
			$this->con = new Conexion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
		}

		
		public function comboEmpresa()
		{
			$sql = "SELECT id_empresa, CONCAT(rfc,'-',razon_social) AS nombre_empresa FROM lla_empresa ORDER BY razon_social ASC";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function registrar()
		{

			$sql =" INSERT INTO lla_usuario (nombre,login,clave_seguridad,perfil,estatus,id_empresa)
			VALUES ('{$this->nombre}','{$this->login}','{$this->clave_seguridad}','{$this->perfil}','{$this->estatus}','{$this->id_empresa}')";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}
		public function eliminarUsuario()
		{
			//$sql="UPDATE enca_creditos set ESTATUS='5' where FOLIO_SEGUIMIENTO='{$this->folio}'";
			$sql=" UPDATE lla_usuario  SET estatus = 0 WHERE id ='{$this->id}' ";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}



		public function datosGRID()
		{
		    $sql="SELECT u.id AS id,
				u.nombre AS nombre,
				u.login AS login,
				u.clave_seguridad AS clave_seguridad,
				u.perfil AS perfil,
				u.estatus AS estatus,
				u.id_empresa AS id_empresa,
				CONCAT(e.rfc,'-',e.razon_social) AS nombre_empresa
				FROM lla_usuario u
				LEFT JOIN lla_empresa e ON e.id_empresa = u.id_empresa
				-- WHERE estatus = 1";
		    //echo $sql;
		    $datos = $this->con->consultaRetorno($sql);
			return $datos;

		}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			public function buscardatos()
		{
		  $sql="SELECT id,nombre,login,clave_seguridad,perfil,estatus,id_empresa FROM lla_usuario
			WHERE id = '{$this->id}'";
		  $datos = $this->con->consultaRetorno($sql);
		  return $datos;
		}
//////////////////////////////////////////////////////////////////////////////////////////////////

		public function modificar()
		{

			$sql = " UPDATE lla_usuario
			SET nombre = '{$this->nombre}',
			login = '{$this->usuario}',
			clave_seguridad = '{$this->psw}',
			perfil = '{$this->comboPerfil}',
			estatus= '{$this->estatus}',
		  id_empresa= '{$this->comboEmpresa}'
			WHERE id = '{$this->id}'";
			//echo$sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}
		public function modificarSinPSWyCorreo()
		{

			$sql = " UPDATE lla_usuario
			SET nombre = '{$this->nombre}',
			perfil = '{$this->comboPerfil}',
			estatus= '{$this->estatus}',
		  id_empresa= '{$this->comboEmpresa}'
			WHERE id = '{$this->id}'";
			//echo$sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}
		public function modificarSinPSW()
		{

			$sql = " UPDATE lla_usuario
			SET nombre = '{$this->nombre}',
			login = '{$this->usuario}',
			perfil = '{$this->comboPerfil}',
			estatus= '{$this->estatus}',
		  id_empresa= '{$this->comboEmpresa}'
			WHERE id = '{$this->id}'";
			//echo$sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}
		public function modificarSinCorreo()
		{

			$sql = " UPDATE lla_usuario
			SET nombre = '{$this->nombre}',
			clave_seguridad = '{$this->psw}',
			perfil = '{$this->comboPerfil}',
			estatus= '{$this->estatus}',
		  id_empresa= '{$this->comboEmpresa}'
			WHERE id = '{$this->id}'";
			//echo$sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function eliminaCliente()
		{
			//$sql="UPDATE enca_creditos set ESTATUS='5' where FOLIO_SEGUIMIENTO='{$this->folio}'";
			$sql=" DELETE FROM lla_clientes WHERE id ='{$this->id}' ";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscapsw()
		{
			$sql = "SELECT clave_seguridad FROM lla_usuario WHERE id ='$this->id'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;

		}

		public function actualizarPSW()
		{

			$sql="UPDATE lla_usuario SET clave_seguridad = '{$this->nuevapsw}' WHERE id ='{$this->id}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function recuperarPSW()
		{
			$sql="UPDATE lla_usuario SET clave_seguridad = '{$this->nuevapsw}' WHERE login ='{$this->login}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function correoExistente()
		{
			$sql="SELECT login FROM lla_usuario WHERE login = '{$this->correo}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
	}
 ?>

<?php
	/**
	* modelo al base de datos darosCredito --> enca_creditos
	*/
	include_once '../app/Conexion.php';
	class Cliente
	{
		// private $rfc;
		// private $razonsocial;
		// private $cuenta;
		// private $email;

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

			// $sql =" INSERT INTO lla_clientes(rfc,razon_social,cuenta,correos,estatus,pais,estado,municipio,cp,colonia,calle,ninterior,nexterior,c_usocfdi)
			// 		VALUES('{$this->rfc}','{$this->razonsocial}','{$this->cuenta}','{$this->email}','1','{$this->pais}','{$this->estado}','{$this->municipio}','{$this->codigopostal}','{$this->colonia}',
			// 		'{$this->calle}','{$this->numinterior}','{$this->numexterior}','{$this->cfdi}')";
			$sql =" INSERT INTO lla_clientes(rfc,razon_social,sucursal,cuenta,correos,telefono,contacto,estatus,pais,estado,municipio,cp,colonia,calle,ninterior,nexterior,c_usocfdi,rfc_empresa)
							VALUES('{$this->rfc}','{$this->razonsocial}','{$this->sucursal}',0,'{$this->email}','{$this->telefono}','{$this->contacto}','1','{$this->pais}','{$this->estado}','{$this->municipio}','{$this->codigopostal}','{$this->colonia}',
							'{$this->calle}','{$this->numinterior}','{$this->numexterior}','{$this->cfdi}','{$this->rfc_empresa}')";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}

		public function listageneral()
		{
			$sql = "SELECT id,rfc,razon_social,cuenta,correos,estatus,pais,estado,municipio,colonia,calle,ninterior,nexterior,cp,c_usocfdi FROM lla_clientes where rfc_empresa='{$this->rfc}'";
			//echo $sql;
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function datosGRID()
		{
		    $sql="
			SELECT c.id AS id,
			c.rfc AS rfc,
			c.razon_social AS razon_social,
			c.sucursal AS sucursal,
			c.cuenta AS cuenta,
			c.correos AS correos,
			c.telefono as telefono,
			c.contacto as contacto,
			c.estatus AS estatus,
			p.c_nombre AS pais,
			e.c_nombre_estado AS estado,
			m.c_nombre_municipio AS municipio,
			co.c_nombre_colonia AS colonia,
			c.calle AS calle,
			c.ninterior AS ninterior,
			c.nexterior AS nexterior,
			cp.c_cp AS cp,
			CONCAT(TRIM(cfdi.c_UsoCFDI),'-',TRIM(descripcion)) AS c_usocfdi
			FROM lla_clientes c
			LEFT JOIN lls_pais p ON c.pais = p.rowid
			LEFT JOIN lls_estados e ON c.estado = e.rowid
			LEFT JOIN lls_municipios m ON c.municipio = m.rowid
			LEFT JOIN lls_colonias co ON c.colonia = co.rowid
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			where c.rfc_empresa='{$this->rfc}'
						";
		    //echo $sql;
		    $datos = $this->con->consultaRetorno($sql);
			return $datos;
		    // while($row=mysqli_fetch_array($datos))
		    // {
		   		 // $this->id=utf8_encode($row['id']);
				 // $this->rfc=utf8_encode($row['rfc']);
		   		 // $this->razonsocial=utf8_encode($row['razon_social']);
		   		 // $this->cuenta=utf8_encode($row['cuenta']);
		   		 // $this->correos=utf8_encode($row['correos']);
		   		 // $this->estatus=utf8_encode($row['estatus']);
				 // $this->pais=utf8_encode($row['pais']);
				 // $this->estado=utf8_encode($row['estado']);
				 // $this->municipio=utf8_encode($row['municipio']);
				 // $this->colonia=utf8_encode($row['colonia']);
		   		 // $this->calle=utf8_encode($row['calle']);
		   		 // $this->ninterior=utf8_encode($row['ninterior']);
		   		 // $this->nexterior=utf8_encode($row['nexterior']);
				 // $this->cp=utf8_encode($row['cp']);
				 // $this->c_usocfdi=utf8_encode($row['c_usocfdi']);

		   	// }
		}

		public function comboPaises()
		{
			$sql = "SELECT c_pais,c_nombre FROM lls_pais WHERE rowid = 151";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}
		public function comboCFDI()
		{
			$sql = "SELECT rowid,c_UsoCFDI, descripcion FROM lls_c_usocfdi ORDER BY descripcion ASC";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}
		public function comboEstados()
		{
			$sql = "SELECT rowid,c_estado,c_nombre_estado FROM lls_estados WHERE c_pais = 'MEX'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}




		// public function buscarComboEstado()
		// {
		// 	$sql = "SELECT rowid,c_estado,c_nombre_estado FROM lls_estados WHERE c_pais = '{$this->pais}'";
		// 	$datos = $this->con->consultaRetorno($sql);
		// 	return $datos;
		// }

		public function buscarComboMunicipio()
		{
			$sql = "SELECT rowid,c_municipio,c_estado,c_nombre_municipio FROM lls_municipios WHERE c_estado = '{$this->estado}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarComboCodigoPostal()
		{
			$sql = "SELECT rowid,c_cp,c_estado,c_municipio,c_localidad FROM lls_cp WHERE c_municipio = '{$this->municipio}' or c_estado = '{$this->estado}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarComboColonia()
		{
			// cambio 1/17/2018 Jesus
			// $sql = "SELECT rowid,c_nombre_colonia FROM lls_colonias WHERE c_cp = '{$this->codigopostal}'";

			$sql = "SELECT rowid,c_nombre_colonia FROM lls_colonias ";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscaridPais()
		{
			$sql = " SELECT rowid FROM lls_pais WHERE c_pais = '{$this->pais}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscaridEstado()
		{
			$sql= "SELECT rowid FROM lls_estados WHERE c_estado = '{$this->estado}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscaridMunicipio()
		{
			$sql= "SELECT rowid FROM lls_municipios WHERE c_municipio  = '{$this->municipio}' AND c_estado = '{$this->estado}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscaridCP()
		{
			$sql= "SELECT rowid FROM lls_cp WHERE c_cp = '{$this->codigopostal}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function buscarValorPais()
		{
			$sql= "SELECT c_nombre FROM lls_pais WHERE rowid = '{$this->idpais}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarValorEstado()
		{
			$sql= "SELECT c_nombre_estado FROM lls_estados WHERE rowid = '{$this->idestado}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarValorMunicipio()
		{
			$sql= "SELECT c_nombre_municipio FROM lls_municipios WHERE rowid = '{$this->idmunicipio}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarValorColonia()
		{
			$sql= "SELECT c_nombre_colonia FROM lls_colonias WHERE rowid= '{$this->idcolonia}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function buscarValorCP()
		{
			$sql= "SELECT c_cp FROM lls_cp WHERE rowid = '{$this->idcodigopostal}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}
		public function buscarValorCFDI()
		{
			$sql= "SELECT descripcion FROM lls_c_usocfdi WHERE rowid = '{$this->idcfdi}'";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			public function buscardatos()
		{
		  $sql="SELECT
			c.rfc AS rfc,
			c.razon_social AS razon_social,
			c.sucursal AS sucursal,
			c.cuenta AS cuenta,
			c.correos AS correos,
			c.telefono as telefono,
			c.contacto as contacto,
			c.estatus AS estatus,
			e.c_estado AS rowidestado,
			m.c_municipio AS c_municipio,
			m.c_nombre_municipio AS c_nombre_municipio,
			cp.c_cp AS c_cp,
			co.rowid AS idcolonia,
			co.c_nombre_colonia AS c_nombre_colonia,
			c.calle AS calle,
			c.ninterior AS ninterior,
			c.nexterior AS nexterior,
			cfdi.rowid AS rowid
			FROM lla_clientes c
			LEFT JOIN lls_pais p ON c.pais = p.rowid
			LEFT JOIN lls_estados e ON c.estado = e.rowid
			LEFT JOIN lls_municipios m ON c.municipio = m.rowid
			LEFT JOIN lls_colonias co ON c.colonia = co.rowid
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			WHERE c.id = '{$this->id}'";
		    //echo $sql;
		    $datos = $this->con->consultaRetorno($sql);
		    return $datos;
		    // while($row=mysqli_fetch_array($datos))
		    // {
		   	// 	 $this->rfc=utf8_encode($row['rfc']);
		   	// 	 $this->razonsocial=utf8_encode($row['razon_social']);
		   	// 	 $this->cuenta=utf8_encode($row['cuenta']);
		   	// 	 $this->correos=utf8_encode($row['correos']);
		   	// 	 //$this->estatus=utf8_encode($row['estatus']);
		   	// 	 $this->idestado=utf8_encode($row['rowidestado']);
		   	// 	 $this->idmuni=utf8_encode($row['rowidmuni']);
		   	// 	 $this->c_nombre_municipio=utf8_encode($row['c_nombre_municipio']);
		   	// 	 //$this->idcp=utf8_encode($row['rowcp']);
		   	// 	 $this->calle=utf8_encode($row['calle']);
		   	// 	 $this->ninterior=utf8_encode($row['ninterior']);
		   	// 	 $this->nexterior=utf8_encode($row['nexterior']);
		   	// 	 $this->idcfdi=utf8_encode($row['rowid']);
		   	// }
		}
//////////////////////////////////////////////////////////////////////////////////////////////////

		public function modificar()
		{

			$sql = " UPDATE lla_clientes SET rfc='{$this->rfc}',razon_social='{$this->razonsocial}',sucursal='{$this->sucursal}',cuenta=0,correos='{$this->email}',telefono='{$this->telefono}',contacto='{$this->contacto}',estatus='1',pais='{$this->pais}',estado='{$this->estado}',municipio='{$this->municipio}',cp='{$this->codigopostal}',colonia='{$this->colonia}',calle='{$this->calle}',ninterior='{$this->numinterior}',nexterior='{$this->numexterior}',c_usocfdi='{$this->cfdi}' WHERE id = '{$this->id}'";
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

		public function buscar_auto(){
			$arr=array();
			$sql = "SELECT CONCAT(TRIM(clave_prodserv),'-',TRIM(descripcion))AS respuesta FROM lls_clave_prodserv
				WHERE CONCAT(TRIM(clave_prodserv),'-',TRIM(descripcion)) LIKE '%$this->concepto%' ORDER BY rowid";
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);

			while ($row = mysqli_fetch_array($datos)) {
				$row_array=$this->roll=utf8_encode($row['respuesta']);
				array_push($arr,$row_array);
    		}
    		return ($arr);
		}
		public function  buscar_autocolonias(){
			$arr=array();
			$sql = "SELECT CONCAT(TRIM(rowid),'-',TRIM(c_nombre_colonia)) AS respuesta FROM lls_colonias 
				WHERE CONCAT(TRIM(rowid),'-',TRIM(c_nombre_colonia)) LIKE '%$this->concepto%' LIMIT 20";
				// ORDER BY rowid
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);
			while ($row = mysqli_fetch_array($datos)) {
				$row_array=$this->roll=utf8_encode($row['respuesta']);
				array_push($arr,$row_array);
    		}
    		return ($arr);
		}
		public function buscarCol(){
			$sql="SELECT rowid from lls_colonias where c_nombre_colonia='{$this->colonia}' limit 1";
			$result=$this->con->consultaRetorno($sql);
			$datos=mysqli_fetch_array($result);
			$this->idColonia= $datos['rowid'];
		}
		// public function listarGerentes(){
		// 	$sql = "SELECT nombreGerente,email_gerente FROM usuario GROUP BY email_gerente ORDER BY nombreGerente ASC";
		// 	$datos = $this->con->consultaRetorno($sql);
		// 	return $datos;
		// }

		// public function detalleGerente(){
		// 	$sql = "SELECT nombreGerente,email_gerente FROM usuario WHERE email_gerente = '{$this->email_gerente}'";
		// 	$datos = $this->con->consultaRetorno($sql);
		// 	return $datos;
		// }



		// public function edit(){

		// }

		// public function view(){
		// 	$sql = "SELECT count(*)as registros FROM usuario where login='{$this->email}'";
		// 	$datos = $this->con->consultaRetorno($sql);
		// 	return $datos;
		// }
		// public function validar(){
		// 	$sql = "SELECT tipo_usu, id_usu FROM usuario
		// 			WHERE login='$this->email' AND contrasena='$this->password'";
		// 	$datos = $this->con->consultaRetorno($sql);
		// 	while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
		// 		$this->roll = $row['tipo_usu'];
		// 		$this->id   = $row['id_usu'];
		// 	}
		// }
	}
 ?>

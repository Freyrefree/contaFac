<?php
	/**
	* modelo al base de datos
	*/
	include_once '../app/Conexion.php';
	class Reporte
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
		public function contador()
		{
			$sql="SELECT COUNT(id_documento) AS contador
FROM lla_complemento_pago WHERE id_documento = '{$this->id_documento}'";
			$respuesta=$this->con->consultaRetorno($sql);
			$datos=mysqli_fetch_array($respuesta);
			$this->contador=$datos['contador'];
			return $datos;
		}

    public function factura()
    {
      $sql="SELECT
			f.id as id,
			CONCAT(f.serie,f.folio) AS factura,
			f.rfc_emisor AS rfc_emisor,
			f.id_documento AS id_documento,
			c.rfc AS rfc_receptor,
			c.razon_social AS razon_social,
			cp.c_cp AS c_cp,
			muni.c_nombre_municipio AS c_nombre_municipio,
			CONCAT(cfdi.c_UsoCFDI,'-',cfdi.descripcion) AS uso_cfdi,
			f.total AS total,
			f.tipo_documento AS tipo_documento,
			CASE
			WHEN f.estatus_factura = 1 THEN 'Pendiente'
			WHEN f.estatus_factura = 2 THEN 'Facturada'
			WHEN f.estatus_factura = 3 THEN 'Cancelada'
			WHEN f.estatus_factura = 4 THEN 'Cancelada NC'
			END AS estatus_factura,
			f.fecha_facturacion AS fecha_facturacion,
			f.folio_fiscal AS folio_fiscal
			FROM lla_registro_factura f
			LEFT JOIN lla_clientes c ON f.idCliente = c.id
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			LEFT JOIN lls_municipios muni ON muni.rowid = c.municipio
			WHERE fecha_facturacion BETWEEN '{$this->fechainicio}' AND   '{$this->fechafin}' and  f.rfc_emisor='{$this->rfc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
    }

		public function facturaEstatus()
		{
			$sql="SELECT
			f.id as id,
			CONCAT(f.serie,f.folio) AS factura,
			f.rfc_emisor AS rfc_emisor,
			f.id_documento AS id_documento,
			c.rfc AS rfc_receptor,
			c.razon_social AS razon_social,
			cp.c_cp AS c_cp,
			muni.c_nombre_municipio AS c_nombre_municipio,
			CONCAT(cfdi.c_UsoCFDI,'-',cfdi.descripcion) AS uso_cfdi,
			f.total AS total,
			f.tipo_documento AS tipo_documento,
			CASE
			WHEN f.estatus_factura = 1 THEN 'Pendiente'
			WHEN f.estatus_factura = 2 THEN 'Facturada'
			WHEN f.estatus_factura = 3 THEN 'Cancelada'
			WHEN f.estatus_factura = 4 THEN 'Cancelada NC'
			END AS estatus_factura,
			f.fecha_facturacion AS fecha_facturacion,
			f.folio_fiscal AS folio_fiscal
			FROM lla_registro_factura f
			LEFT JOIN lla_clientes c ON f.idCliente = c.id
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			LEFT JOIN lls_municipios muni ON muni.rowid = c.municipio
			WHERE fecha_facturacion BETWEEN '{$this->fechainicio}' AND   '{$this->fechafin}' AND f.estatus_factura = '{$this->estatus}' and  f.rfc_emisor='{$this->rfc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function facturaCompleto()
		{
			$sql="SELECT
			f.id as id,
			CONCAT(f.serie,f.folio) AS factura,
			f.rfc_emisor AS rfc_emisor,
			f.id_documento AS id_documento,
			c.rfc AS rfc_receptor,
			c.razon_social AS razon_social,
			cp.c_cp AS c_cp,
			muni.c_nombre_municipio AS c_nombre_municipio,
			CONCAT(cfdi.c_UsoCFDI,'-',cfdi.descripcion) AS uso_cfdi,
			f.total AS total,
			f.tipo_documento AS tipo_documento,
			CASE
			WHEN f.estatus_factura = 1 THEN 'Pendiente'
			WHEN f.estatus_factura = 2 THEN 'Facturada'
			WHEN f.estatus_factura = 3 THEN 'Cancelada'
			WHEN f.estatus_factura = 4 THEN 'Cancelada NC'
			END AS estatus_factura,
			f.fecha_facturacion AS fecha_facturacion,
			f.folio_fiscal AS folio_fiscal
			FROM lla_registro_factura f
			LEFT JOIN lla_clientes c ON f.idCliente = c.id
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			LEFT JOIN lls_municipios muni ON muni.rowid = c.municipio
			where f.rfc_emisor='{$this->rfc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function facturaSinFechas()
		{
			$sql="SELECT
			f.id as id,
			CONCAT(f.serie,f.folio) AS factura,
			f.rfc_emisor AS rfc_emisor,
			f.id_documento AS id_documento,
			c.rfc AS rfc_receptor,
			c.razon_social AS razon_social,
			cp.c_cp AS c_cp,
			muni.c_nombre_municipio AS c_nombre_municipio,
			CONCAT(cfdi.c_UsoCFDI,'-',cfdi.descripcion) AS uso_cfdi,
			f.total AS total,
			f.tipo_documento AS tipo_documento,
			CASE
			WHEN f.estatus_factura = 1 THEN 'Pendiente'
			WHEN f.estatus_factura = 2 THEN 'Facturada'
			WHEN f.estatus_factura = 3 THEN 'Cancelada'
			WHEN f.estatus_factura = 4 THEN 'Cancelada NC'
			END AS estatus_factura,
			f.fecha_facturacion AS fecha_facturacion,
			f.folio_fiscal AS folio_fiscal
			FROM lla_registro_factura f
			LEFT JOIN lla_clientes c ON f.idCliente = c.id
			LEFT JOIN lls_cp cp ON c.cp = cp.rowid
			LEFT JOIN lls_c_usocfdi cfdi ON c.c_usocfdi = cfdi.rowid
			LEFT JOIN lls_municipios muni ON muni.rowid = c.municipio
			WHERE f.estatus_factura = '{$this->estatus}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function movimientos()
		{
			$sql="SELECT cp.no_parcialidad AS no_parcialidad,
cp.importe_total AS importe_total,
cp.importe_pagado AS importe_pagado,
cp.importe_restante AS importe_restante,
CASE
WHEN cp.estatus = 0 THEN 'Pendiente'
WHEN cp.estatus = 2 THEN 'Facturada'
WHEN cp.estatus = 3 THEN 'Cancelada'
WHEN cp.estatus = 4 THEN 'Cancelada NC'
END AS estatus,
CONCAT (fp.c_formapago,'-',fp.descripcion) AS forma_pago,
cp.fecha_facturado AS fecha_facturado
FROM lla_complemento_pago cp
LEFT JOIN lls_formapago fp ON fp.c_formapago =  cp.forma_pago
WHERE id_documento = '{$this->id}'";
			//$cuantos =0 ;
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
			// while($row=mysqli_fetch_array($datos))
			// {
			// 	 $this->no_parcialidad=utf8_encode($row['no_parcialidad']);
			// 	 $this->importe_total=utf8_encode($row['importe_total']);
				 //$cuantos++;
				 //$this->cuantos=$cuantos;
			//}
		}

	}
 ?>

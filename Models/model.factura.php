<?php 
	/**
	* modelo al base de datos darosCredito --> enca_creditos
	*/
	include_once '../app/Conexion.php';
	class Factura 
	{
		 private $serie;
		 private $folio;
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

		public function serieFolio(){
			$sql="SELECT serie, Max(folio)+1 as folio FROM lla_serie_folio where documento='{$this->documento}' and empresa='{$this->rfc}'";
			$datos = $this->con->consultaRetorno($sql);
			while($row = mysqli_fetch_array($datos)){
				$this->serie = $row['serie'];
				$this->folio = $row['folio'];
				//return $row['serie'];
			}
		}
		public function forma_pago(){
			$sql="SELECT * FROM lls_formapago";
			$dato=$this->con->consultaRetorno($sql);
			return $dato;
		}
		public function metodo_pago(){
			$sql="SELECT * FROM lls_metodopago";
			$dato=$this->con->consultaRetorno($sql);
			return $dato;
		}
		public function moneda(){
			$sql="SELECT * FROM lls_moneda";
			$dato=$this->con->consultaRetorno($sql);
			return $dato;
		}
		public function cliente(){
			$sql="SELECT c.*,cu.c_UsoCFDI,m.c_nombre_municipio as municipio FROM lla_clientes as c , lls_c_usocfdi as cu,lls_municipios as m where c.c_usocfdi=cu.rowid and c.municipio=m.rowid";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function folioCarrito(){
			$sql="SELECT folio+1 AS folio FROM lla_folio_carrito ORDER BY folio DESC LIMIT 1 ";
			$dato=$this->con->consultaRetorno($sql);
			$valor=mysqli_fetch_array($dato);
			$this->folioC=$valor['folio'];
		}
		public function cambioFolioC(){
			$sql="INSERT INTO lla_folio_carrito(folio,usuario) values('{$this->folioC}','{$this->usuario}')";
			$res=$this->con->consultaSimple($sql);
		}
		public function insertaFactura(){
			$sql="INSERT INTO lla_registro_factura(metodo,forma,condicionPago,rfc_emisor,rfc_receptor,idCliente,concepto_clave,fecha_registro,fecha_facturacion,moneda,tipo_documento,usuario,estatus_factura,usocfdi) VALUES('{$this->metodoPago}','{$this->formaPago}','{$this->condicion}','{$this->emisor}','{$this->receptor}','{$this->idCliente}','{$this->folioC}',NOW(),NOW(),'{$this->moneda}','{$this->tc}','{$this->usuario}','1','{$this->usocfdi}')";
			$res=$this->con->consultaSimple($sql);
		}
		public function modificaFactura(){
			$sql="UPDATE lla_registro_factura set folio='{$this->folio}',serie='{$this->serie}',metodo='{$this->metodoPago}',forma='{$this->formaPago}',condicionPago='{$this->condicion}',rfc_receptor='{$this->receptor}',idCliente='{$this->idCliente}',moneda='{$this->moneda}',tipo_documento='{$this->tc}',usocfdi='{$this->usocfdi}' where concepto_clave='{$this->folioC}'";
			$res=$this->con->consultaSimple($sql);
		}
		public function buscaConcepto(){
			$sql="SELECT * from lla_productos where clave_interna='{$this->valor}' or clave_sat='{$this->valor}' or descripcion_empresa='{$this->valor}'";

			$datos=$this->con->consultaRetorno($sql);
			$valores=mysqli_fetch_array($datos);
			$this->idProd=$valores['id'];
			$this->clave=$valores['clave_sat'];
			$this->descripcionSat=$valores['descripcion_sat'];
			$this->descripcion=$valores['descripcion_empresa'];
			$this->identificador=$valores['clave_interna'];
		}
		public function buscaUnidad(){
			$sql="SELECT * FROM lla_clave_unidad where clave_sat='{$this->valor}' or descripcion_empresa='{$this->valor}'";
			$res=$this->con->consultaRetorno($sql);
			$datos=mysqli_fetch_array($res);
			$this->clave=$datos['clave_sat'];
			$this->descripcionSat=$datos['descripcion_sat'];
			$this->descripcion=$datos['descripcion_empresa'];
		}
		public function insertaCarrito(){
			$sql="INSERT INTO lla_conceptos(folio_carrito,usuario,id_prod_serv,clave_sat,clave_unidad,valor_unitario,tipo_traslado,tipo_factor_translado,valor_tasa_cuota_translado,importe_translado,tipo_retencion,tipo_factor_retencion,valor_tasa_cuota_retencion,importe_retencion,cantidad,importe_total,descripcionProd)
			VALUES('{$this->folioC}','{$this->usuario}','{$this->idProd}','{$this->clave}','{$this->claveUnidad}','{$this->precio}','{$this->Timpuesto}','{$this->Tfactor}','{$this->TtasaoCuota}','{$this->Timporte}','{$this->Rimpuesto}','{$this->Rfactor}','{$this->RtasaoCuota}','{$this->Rimporte}','{$this->cantidad}','{$this->importeTotal}','{$this->descripcion}')";
			//return $sql;
			$res=$this->con->consultaSimple($sql);
		}
		public function consultaConcepto(){
			$sql="SELECT * FROM lla_conceptos where folio_carrito='{$this->folioC}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function eliminaconcepto(){
			$sql="DELETE from lla_conceptos where id='{$this->id}'";
			$res=$this->con->consultaSimple($sql);
		}
		public function claveSat(){
			$sql="SELECT * FROM lla_productos where clave_sat like '%{$this->valor}%' or descripcion_sat like '%{$this->valor}%' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function consultaDescripcionSat(){
			$sql="SELECT * FROM lla_productos where descripcion_empresa like '%{$this->valor}%' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function consultaIdent(){
			$sql="SELECT * FROM lla_productos where clave_interna like '%{$this->valor}%' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function consultaCU(){
			$sql="SELECT * FROM lla_clave_unidad where clave_sat like '%{$this->valor}%' or descripcion_sat like '%{$this->valor}%'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function consultaUnidad(){
			$sql="SELECT * FROM lla_clave_unidad where descripcion_empresa like '%{$this->valor}%' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function editarFactura(){
			$sql="SELECT * FROM lla_registro_factura where id='{$this->key}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function usocfdi(){
			$sql="SELECT * FROM lls_c_usocfdi";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		




	}
 ?>
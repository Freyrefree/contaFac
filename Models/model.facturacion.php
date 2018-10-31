<?php 
	
	include_once '../app/Conexion.php';
	class factura 
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

			$sql =" INSERT INTO lla_clientes(rfc,razon_social,cuenta,correos) 
					VALUES('{$this->rfc}','{$this->razonsocial}','{$this->cuenta}','{$this->email}')";

			$datos=$this->con->consultaRetorno($sql);
			return $datos;	

		}

		public function listageneral()//muestra un listado genera de la consulta
		{
			$sql = "SELECT rf.*,c.razon_social,m.c_nombre_municipio AS municipio FROM lla_registro_factura rf, lla_clientes c,lls_municipios m WHERE rf.idCliente=c.id AND c.municipio=m.rowid and rf.rfc_emisor='{$this->rfc}' ORDER BY fecha_facturacion desc";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function listageneralCaract()//muestra un listado genera de la consulta
		{
			$sql = "SELECT rf.*,c.razon_social,m.c_nombre_municipio AS municipio 
				FROM lla_registro_factura rf, lla_clientes c,lls_municipios m 
				WHERE rf.idCliente=c.id AND c.municipio=m.rowid AND (rf.serie LIKE '%{$this->valor}%' OR rf.folio LIKE '%{$this->valor}%' OR rf.rfc_receptor LIKE '%{$this->valor}%' or concat(rf.serie,rf.folio) like '%{$this->valor}%'  
				OR c.razon_social LIKE '%{$this->valor}%' OR m.c_nombre_municipio LIKE '%{$this->valor}%' OR rf.subtotal LIKE '%{$this->valor}%' OR rf.total_iva LIKE '%{$this->valor}%' OR rf.total_retencion LIKE '%{$this->valor}%'
				OR rf.fecha_facturacion LIKE '%{$this->valor}%' OR rf.folio_fiscal LIKE '%{$this->valor}%' OR rf.estatus_factura LIKE '%{$this->valor}%' )
				ORDER BY fecha_facturacion desc";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		    public function comboPaises()
		{
			$sql = "SELECT rowid,c_nombre FROM lls_pais ORDER BY c_nombre ASC";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function comboEstados()
		{
			$sql = "SELECT rowid,c_nombre_estado FROM lls_estados ORDER BY c_nombre_estado";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		public function comboMunicipios()
		{
			$sql = "SELECT rowid,c_nombre_municipio FROM lls_municipios ORDER BY c_nombre_municipio";
			$datos = $this->con->consultaRetorno($sql);
			return $datos;
		}

		///funciones para nuevas consultas ismael 11117
		public function select_fiscal(){

			// $sql =" INSERT INTO lla_clientes(rfc,razon_social,cuenta,correos) 
				 // VALUES('{$this->rfc}','{$this->razonsocial}','{$this->cuenta}','{$this->email}')";
		    
		    $sql="SELECT * FROM lla_empresa WHERE rfc='{$this->rfc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

        public function select_rfactura(){
		    $sql="SELECT * FROM lla_registro_factura WHERE id='{$this->id_doc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_cliente(){
		    // $sql="SELECT * FROM lla_clientes WHERE id='{$this->id}' AND rfc='{$this->rfc}'";
		    $sql="SELECT c.id,c.rfc,c.razon_social,c.cuenta,c.correos,c.estatus,p.c_nombre AS pais,e.c_nombre_estado AS estado,m.c_nombre_municipio AS municipio
				 ,col.c_nombre_colonia AS colonia,c.calle,c.ninterior,c.nexterior,cp.c_cp AS cp,cu.c_usocfdi
				 FROM lla_clientes AS c,lls_pais AS p,lls_estados AS e,lls_municipios AS m,lls_colonias AS col,lls_cp AS cp,lls_c_usocfdi AS cu
				 WHERE c.id='{$this->id}' AND c.rfc='{$this->rfc}'  AND c.estado=e.rowid AND c.pais=p.rowid AND c.municipio=m.rowid AND c.colonia=col.rowid AND c.cp=cp.rowid AND c.c_usocfdi=cu.rowid";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_serializacion(){
		    $sql="SELECT count(*) as Total FROM lla_registro_factura WHERE tipo_documento='{$this->tipo_documento}' AND (folio_fiscal IS NOT NULL AND folio_fiscal != '') ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_serie_folio(){
		    $sql="SELECT * FROM lla_serie_folio WHERE documento='{$this->tipo_documento}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_folio(){
		    // $sql="SELECT * FROM lla_serie_folio WHERE documento='{$this->tipo_documento}'";
		    $sql="SELECT * FROM lla_registro_factura WHERE serie= '{$this->tipo_serie}' AND (estatus_factura= '2' OR estatus_factura='3' OR estatus_factura='4') ORDER BY folio DESC LIMIT 1";

			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_conceptos(){
		    //$sql="SELECT * FROM lla_conceptos WHERE folio_carrito='{$this->concepto_clave}'";
		    $sql="SELECT lc.*,u.descripcion_empresa FROM lla_conceptos AS lc,lla_clave_unidad AS u WHERE folio_carrito='{$this->concepto_clave}' AND lc.clave_unidad=u.clave_sat";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_producto(){
		    $sql="SELECT * FROM lla_productos WHERE id='{$this->id}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		public function select_uso(){
		    $sql="SELECT * FROM lls_c_usocfdi WHERE c_UsoCFDI='{$this->uso_cfdi}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}
        
        //actualizar el estatus de la factura
		public function update_factura(){

		    $sql="UPDATE lla_registro_factura SET folio_fiscal='{$this->folio_fiscal}', estatus_factura='{$this->estatus_factura	}'  WHERE id='{$this->id_doc}' AND  tipo_documento='{$this->tipo_documento}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

        //actualizar los timbres consumidos
		public function update_timbres(){
			$sql="UPDATE lla_timbres SET consumido_real=consumido_real+1, consumido_total=consumido_total+1 where rfc='{$this->rfc_emisor}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}
		//concumidos cancelacion
		public function update_timbres_cancelacion(){
			$sql="UPDATE lla_timbres SET consumido_cancelacion=consumido_cancelacion+1, consumido_total=consumido_total+1 where rfc='{$this->rfc_emisor}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		//actualizar el estatus de la factura
		public function update_f(){
			
		    $sql="UPDATE lla_registro_factura SET serie='{$this->serie}', folio='{$this->folio}'  WHERE id='{$this->id_doc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}
		public function buscaFactura(){
			$sql="SELECT * FROM lla_registro_factura where concepto_clave='{$this->folioC}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function cancelarFactura(){
			$sql="UPDATE lla_registro_factura set estatus_factura='3' where folio_fiscal='{$this->uuid}'";
			$datos=$this->con->consultaretorno($sql);
			return $datos;
		}
		public function buscatotal(){
			$sql="SELECT c.* FROM lla_registro_factura AS lrf,lla_conceptos AS c WHERE  lrf.concepto_clave=c.folio_carrito AND lrf.id='{$this->id_doc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}	
		public function totales(){
			$sql="UPDATE lla_registro_factura set total_iva='{$this->traslado}',total_retencion='{$this->retencion}',subtotal='{$this->subtotal}',total='{$this->total}' where id='{$this->id_doc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function ultimoFolio(){
			$sql="SELECT folio+1 AS folio,serie FROM lla_registro_factura WHERE tipo_documento='{$this->documento}' and rfc_emisor='{$this->rfc}' ORDER BY folio DESC LIMIT 1";
			$datos=$this->con->consultaRetorno($sql);
			$valores=mysqli_fetch_array($datos);
			$this->folio=$valores['folio'];
			$this->serie=$valores['serie'];
		}
		public function serieFolio(){
			$sql="SELECT serie, folio+1 as folio FROM lla_serie_folio where documento='{$this->documento}' and empresa='{$this->rfc}' order by folio desc limit 1";
			$datos = $this->con->consultaRetorno($sql);
			while($row = mysqli_fetch_array($datos)){
				$this->serie = $row['serie'];
				$this->folio = $row['folio'];
				//return $row['serie'];
			}
		}
		public function complementoPago(){
			$sql="SELECT * FROM lla_complemento_pago where id_documento='{$this->folio_fiscal}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function eliminaConcepto(){
			$sql="DELETE FROM lla_conceptos where folio_carrito='{$this->folio}' and usuario='{$this->usuario}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function eliminaFactura(){
			$sql="DELETE FROM lla_registro_factura where id='{$this->id}' and usuario='{$this->usuario}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
		public function buscaRegimen(){
			$sql="SELECT descripcion from lls_regimenfiscal where clave='{$this->regimen}'";
			$query=$this->con->consultaRetorno($sql);
			$datos=mysqli_fetch_array($query);
			$this->descripcion=$datos['descripcion'];
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

		public function consultaRFC()
		{
			$sql = "SELECT 
c.correos AS correo,
rf.folio_fiscal AS folio_fiscal,
rf.serie AS serie,
rf.folio AS folio,
rf.rfc_emisor AS rfc_emisor,
e.razon_social AS rzempresa,
rf.rfc_receptor AS rfc_receptor,
c.razon_social AS rzcliente,
rf.total as total
FROM lla_registro_factura rf
INNER JOIN lla_clientes c ON rf.idCliente = c.id
INNER JOIN lla_empresa e ON rf.rfc_emisor = e.rfc   
			WHERE rf.id ='{$this->id}'";

			$query = $this->con->consultaRetorno($sql);
			$datos = mysqli_fetch_array($query);

			  $this->correo = $datos['correo'];
			  $this->foliofiscal = $datos['folio_fiscal'];  
			  $this->serie = $datos['serie'];
			  $this->folio = $datos['folio'];
			  
			  $this->rfcemisor = $datos['rfc_emisor'];
			  $this->rzempresa = $datos['rzempresa'];
			  $this->rfcreceptor = $datos['rfc_receptor'];
			  $this->rzcliente = $datos['rzcliente'];
			  $this->total = $datos['total'];

          	
			
		}
	}
 ?>
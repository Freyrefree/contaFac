<?php

	include_once '../app/Conexion.php';
	class pagos
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

		public function listageneral()//consulta solo los timbrados
		{
			$id_cliente="";
			$id_cliente= $this->id_cliente;

			if($id_cliente== 0 ){
				$sql = "SELECT * FROM lla_registro_factura WHERE estatus_factura ='2' AND tipo_documento ='Ingreso' and rfc_emisor='{$this->rfc}' ORDER BY fecha_facturacion DESC";
			    $datos=$this->con->consultaRetorno($sql);

			}
			if($id_cliente > 0 ){
				$sql = "SELECT * FROM lla_registro_factura WHERE idCliente = '$id_cliente' AND estatus_factura ='2' AND tipo_documento ='Ingreso' and rfc_emisor='{$this->rfc}' ORDER BY fecha_facturacion ASC";
			    $datos=$this->con->consultaRetorno($sql);
			}

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
		    $sql="SELECT * FROM lla_clientes WHERE id='{$this->id}' AND rfc='{$this->rfc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function select_serializacion(){
		    $sql="SELECT count(*) as Total FROM lla_registro_factura WHERE tipo_documento='{$this->tipo_documento}' AND (folio_fiscal IS NOT NULL AND folio_fiscal != '') ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function select_serie_folio(){
		    $sql="SELECT * FROM lla_serie_folio WHERE documento='{$this->tipo_documento}' and empresa='{$this->rfc}'";
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
		    $sql="SELECT * FROM lla_conceptos WHERE folio_carrito='{$this->concepto_clave}'";
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
			$sql="UPDATE lla_timbres SET consumido_real=consumido_real+1,consumido_total=consumido_total+1 where rfc='{$this->rfc_emisor}'";

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

		///para los pagos
		public function selectclientes()
       {
       	    $data = array();

       	    $caracter =$this->caracter;

       	    $sql="SELECT cliente.rfc AS rfc_receptor, cliente.id AS id_cliente, cliente.razon_social AS razon_social
            FROM lla_registro_factura AS factura, lla_clientes AS cliente WHERE (factura.rfc_receptor LIKE '%$caracter%' OR cliente.razon_social like '%$caracter%') AND factura.estatus_factura ='2' AND factura.tipo_documento='Ingreso'  AND  factura.idCliente =  cliente.id GROUP BY  factura.idCliente, factura.rfc_receptor";

       	    $datos = $this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				$data[] = array(
			    	'id'=> $row['id_cliente'],
			    	'nombre'=>$row['rfc_receptor']." - ".$row['razon_social'],
			        'rfc_receptor'=> $row['rfc_receptor'],
			        'razon_social'=> $row['razon_social']
			    );
			}

			echo json_encode($data);


		}

		///===========para la forma de pago
		public function selectformaP()
       {
	        $combo="";
       	    $sql="SELECT * FROM lls_formapago";
			$datos=$this->con->consultaRetorno($sql);
			// return $datos;

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				$combo .= "<option value='".$row['c_formapago']."'>".$row['c_formapago']." - ".utf8_encode($row['descripcion'])."</option>";
			}

	        echo $combo;
		}

		///===============para la moneda
		public function selectmonedaP()
       {
       	    $combo="";

       	    $sql="SELECT * FROM lls_moneda";
			$datos=$this->con->consultaRetorno($sql);
			// return $datos;

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{

				if($row['c_moneda']=='MXN'){
				   $combo .= "<option value='".$row['c_moneda']."' selected>".$row['c_moneda']." - ".utf8_encode($row['descripcion'])."</option>";
				}else{
				   $combo .= "<option value='".$row['c_moneda']."'>".$row['c_moneda']." - ".utf8_encode($row['descripcion'])."</option>";
				}
			}

	        echo $combo;
		}


		///para ostrar info de la factura
		///===========para la forma de pago
		public function mostrar_info()
        {
	        $data = array();

	        $rfc_r="";
	        $idRelacionado=0;//id de la factura
	        $uuid="";

	        $saldo =0;
	        $parcialidad=0;//---

	        $total_r=0;//===
	        $no_r=0;//===

	        $total_factura=0;


            $importe_restante=0.00;

       	    $sql="SELECT * FROM lla_registro_factura WHERE id= '{$this->id_factura}' ";
			$datos=$this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				$rfc_r=$row['rfc_receptor'];
				$idRelacionado=$row['id'];
				$uuid=$row['folio_fiscal'];

				$total_factura=$row['total'];//l total de la factura


                //============funcion para traer el numero de pago siguiente al que sigue
				$query="SELECT count(*) as total FROM lla_complemento_pago WHERE id_documento='{$this->id_factura}'";
				$datos2=$this->con->consultaRetorno($query);

				if ($datos2) {//agregado29112016
					while($rowF = mysqli_fetch_array($datos2, MYSQLI_ASSOC)) {
					   $total_r=$rowF["total"];
					}
				}
				$no_r=0;
				if ($total_r==0) {
		            $no_r=1;

                    $importe_restante=$total_factura;//toma el toal de la factura cuando no hay historial de pagos

				}

				if ($total_r>0) {

					$rr2="SELECT  *  FROM lla_complemento_pago WHERE id_documento='{$this->id_factura}' AND no_parcialidad  IS NOT NULL ORDER BY no_parcialidad DESC LIMIT 1";
				    $datos2=$this->con->consultaRetorno($rr2);

			    	if ($datos2){
			    	    while($rowT = mysqli_fetch_array($datos2, MYSQLI_ASSOC)){
			              $no_r2=$rowT["no_parcialidad"];

			              if ($no_r2=="") {
			                $no_r=1;
			              }else{
			                $no_r=$no_r2+1;

			                $importe_restante=$rowT["importe_restante"];//es el impuesto que queda por cubrir

			              }
			            }
			    	}//fin $rr2

				}// fin if ($total_r>0)

				// FIN/============

				$parcialidad = $no_r;//trae el numero siguiente de parcialidad

				$saldo=$importe_restante;

				if ($saldo>0) {
			      $saldo=number_format($saldo,2,'.','');
			    }

                // aqui se llena el json para mostrar la informacion del pago
				$data[] = array(
			    	'rfc_r'=> $rfc_r,
			    	'idRelacionado'=>$idRelacionado,
			        'uuid'=> $uuid,
			        'saldo'=>$saldo,
			        'parcialidad'=> $parcialidad
			    );
			}

			echo json_encode($data);
		}

		//guardar datos cuenta origen
		public function guardar_origen()
		{
			$sql =" INSERT INTO lla_cuentas_bancarias(nombre_banco, rfc_banco, num_cuenta, estatus, usuario_cuenta, fecha_ingreso)
					VALUES('{$this->nom_banco_o}','{$this->rfc_cuenta_o}','{$this->num_cuenta_o}','{$this->estatus}','{$this->pertenece}', '{$this->fecha_r}')";

			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}


        //guardar datos cuenta origen
		public function guardar_destino()
		{
			$sql =" INSERT INTO lla_cuentas_bancarias(nombre_banco, rfc_banco, num_cuenta, estatus, usuario_cuenta, fecha_ingreso)
					VALUES('{$this->nom_banco_d}','{$this->rfc_cuenta_d}','{$this->num_cuenta_d}','{$this->estatus}','{$this->pertenece}', '{$this->fecha_r}')";

			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}


       //para traer las cuentas origen y destino
	   public function selectcuenta_o()
       {
            $pertenece =$this->pertenece;

       	    $combo="";
       	    $combo = "<option value='0'>Seleccione una Cuenta</option>";

       	    $sql="SELECT * FROM lla_cuentas_bancarias WHERE usuario_cuenta='$pertenece' ";

			$datos=$this->con->consultaRetorno($sql);
			// return $datos;

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				$combo .= "<option value='".$row['id']."'>".$row['nombre_banco']." - ".utf8_encode($row['num_cuenta'])."</option>";
			}

	        echo $combo;
		}

		public function selectcuenta_d()
        {
      	    $pertenece =$this->pertenece;

       	    $combo="";
       	    $combo = "<option value='0'>Seleccione una Cuenta</option>";

       	    $sql="SELECT * FROM lla_cuentas_bancarias WHERE usuario_cuenta='$pertenece' ";
			$datos=$this->con->consultaRetorno($sql);
			// return $datos;

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				$combo .= "<option value='".$row['id']."'>".$row['nombre_banco']." - ".utf8_encode($row['num_cuenta'])."</option>";
			}

	        echo $combo;
		}





		///para guardar el pago
		public function guardar_pago()
		{
			$estatus=0;
			$tipo_cambio=1;


			$sql_r="SELECT * FROM lla_registro_factura WHERE id='{$this->idRelacionado}' ";
			$datos2=$this->con->consultaRetorno($sql_r);
			// return $datos;

            $total_factura=0;
			while($row2 = mysqli_fetch_array($datos2, MYSQLI_ASSOC)) {

				$total_factura=$row2["total"];
			}
			/////

			$importe_pagado_total=0;
			$impP2=0;

			$sql_f="SELECT * FROM lla_complemento_pago WHERE id_documento='{$this->idRelacionado}' ORDER BY no_parcialidad DESC LIMIT 1 ";

			$datosf=$this->con->consultaRetorno($sql_f);

			if ($datosf) {
	    	while($rowCan = mysqli_fetch_array($datosf, MYSQLI_ASSOC)){
	               $importe_pagado_total=$rowCan["importe_ya_pagado"];    //modificado ismael 271117
		     }
	        }

            $importe_p=$this->saldo;//importe pagado

	        $imp_t=$total_factura;
	        $imp_suma=$importe_pagado_total + $importe_p;

	        if ($imp_suma>$imp_t) {
		    	echo "El importe agregado supera al total a pagar de la factura";
		    	exit;

		    }//cehcar

			$sql =" INSERT INTO lla_complemento_pago(id_documento, importe_total, importe_pagado, fecha_pago, fecha_sistema, estatus, no_parcialidad, moneda, forma_pago, num_operacion, id_cuenta_emisor, id_cuenta_receptor, tipo_cambio)
					VALUES('{$this->idRelacionado}','$total_factura', '{$this->montoPago}','{$this->fechaP}','{$this->fecha_registro}','$estatus', '{$this->parcialidad}','{$this->monedaP}','{$this->formaP}','{$this->num_operacion}','{$this->cuenta_origen}','{$this->cuenta_destino}','$tipo_cambio')";



			$datos=$this->con->consultaRetorno($sql);

            $importe_total=$total_factura;
			$importe_ya_pagado=0;
			$importe_pagado=0;
			$importe_restante=0;

			if($datos){
			    $id_registro_hist = $this->con->last_insert_id("lla_complemento_pago");

			    // $id_registro_hist = $this->con->mysqli_insert_id("lla_complemento_pago");
			    // $id_registro_hist=mysqli_insert_id($this->con);


			    $sql_c="SELECT * FROM lla_complemento_pago WHERE id_documento='{$this->idRelacionado}' ";
				$datosc=$this->con->consultaRetorno($sql_c);

				if ($datosc) {
			      while($rowCan = mysqli_fetch_array($datosc, MYSQLI_ASSOC)){
			      	$impP=$rowCan["importe_pagado"];
	                if($impP <> 0 || $impP <> ""){
	                   $importe_pagado=$importe_pagado + $impP;
	                }
			      }
			    }

			    $importe_ya_pagado= $importe_pagado;
	            $importe_restante=$importe_total-$importe_ya_pagado;

	            // $sql_U="UPDATE lla_complemento_pago SET importe_ya_pagado= $importe_ya_pagado, importe_restante=$importe_restante WHERE id_documento='{$this->idRelacionado}' ";
	            $sql_U="UPDATE lla_complemento_pago SET importe_ya_pagado= $importe_ya_pagado, importe_restante=$importe_restante WHERE id='$id_registro_hist' ";


				$datosU=$this->con->consultaRetorno($sql_U);

				if($datosU){
					$impoTotal=0;
	                $importe_p=0;
	                $impPT=0;

	                // $queryPagoT="SELECT * FROM lla_complemento_pago WHERE id_documento='{$this->idRelacionado}' ";
	                $queryPagoT="SELECT * FROM lla_complemento_pago WHERE id='$id_registro_hist'  ";

				    $datos_p=$this->con->consultaRetorno($queryPagoT);
				    while($rowPG = mysqli_fetch_array($datos_p, MYSQLI_ASSOC)){

		                $impoTotal=$rowPG["importe_total"];
		                $impPT=$rowPG["importe_ya_pagado"];

		                // if($impPT <> 0 || $impPT <> ""){

		                   // $importe_p=$importe_p + $impPT;
		                // }
					}

					if($impoTotal==$impPT){
						$sql_Up="UPDATE lla_registro_factura SET estatus_pago= '1' WHERE id='{$this->idRelacionado}' ";
				        $datosUp=$this->con->consultaRetorno($sql_Up);
					}

				}
			  echo 1;
			}else{
			  echo 0;
			}
			// return $datos;
		}

		//para listar los pagos
	    public function lista_pagos()//consulta solo los timbrados
		{
			$id_factura="";
			$id_factura= $this->id_factura;

			$id_cliente="";


			$rfc_receptor="";
			$nombre_cliente="";
			$num_parcialidad=0;
			$rowid=0;//id
			$factura="";
			$folio_fiscal="";
			$total_pago=0;
			$fecha_pago="";
			$fecha_facturado="";

			$moneda_pago="";
			$forma_pago="";


			$data = array();

		    $sql = "SELECT * FROM lla_complemento_pago WHERE id_documento = '$id_factura'  ORDER BY no_parcialidad ASC";

			$datos=$this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{

				$nombre_cliente="";
				$num_parcialidad=0;
				$rowid=0;//id
				$factura="";
				$folio_fiscal="";
				$total_pago=0;
				$fecha_pago="";
				$fecha_facturado="";

				$moneda_pago="";
				$forma_pago="";

				$estatus="";


				$sql2 = "SELECT * FROM lla_registro_factura WHERE id = '$id_factura'";
			    $datos2=$this->con->consultaRetorno($sql2);

                $rfc_receptor="";

			    if($datos2){
			    	while($row2= mysqli_fetch_array($datos2, MYSQLI_ASSOC)){
			    		$rfc_receptor="";
			            $id_cliente="";

                        $rfc_receptor=$row2["rfc_receptor"];
			            $id_cliente=$row2["idCliente"];

			            $sql3="SELECT * FROM lla_clientes WHERE id='$id_cliente'";

						$datos3=$this->con->consultaRetorno($sql3);

						if($datos3){
					    	while($row3= mysqli_fetch_array($datos3, MYSQLI_ASSOC)){
					    		$nombre_cliente="";
					    		$nombre_cliente=$row3["razon_social"];
					    	}
					    }
			        }
			    }


				$num_parcialidad=$row["no_parcialidad"];
				$rowid=$row["id"];
				$factura=$row["serie"]."".$row["folio"];
				$folio_fiscal=$row["folio_fiscal"];
				$total_pago=$row["importe_pagado"];

				if($total_pago>0){
                   $total_pago=number_format($total_pago,2,'.','');
				}

				$fecha_pago=$row["fecha_pago"];

                //nuevo ingresado ismael 271117
                //para saber si se encuentra dento del mes del pago

                $status_fecha=0;

                $hoy = date("Y-m-d");

                $arrya_fecha_p = explode("-", $fecha_pago);
		        $arrya_fecha_hoy = explode("-", $hoy);

		        $mes_p=$arrya_fecha_p[1]; // porción1
				$mes_hoy=$arrya_fecha_hoy[1]; // porción1

				$year_p=$arrya_fecha_p[0]; // porción0
				$year_hoy=$arrya_fecha_hoy[0]; // porción0

                $fecha_limite_c="";
                $mes_s="";

                //============operacion para aumentar uno o nada a fechas
				if($mes_p==12){
                   $mes_s=01;
                   $year_p=$year_p+1;
				}else{
				   $mes_s=$mes_p+1;
				}

				$fecha_limite_c=$year_p."-".$mes_s."-10";//es le fecha limite del pago del siguiente mes

				$fecha_inicio = $hoy;
				$fecha_fin    = $fecha_limite_c;

				if($fecha_inicio > $fecha_fin){
					$status_fecha="1";//fecha superada
				}else{
				   $status_fecha="0";//fecha aun no superada
				}
                //==========fin para verificar las fechas 271117

				$fecha_facturado=$row["fecha_facturado"];

				$moneda_pago=$row["moneda"];
				$forma_pago=$row["forma_pago"];

				$estatus=$row["estatus"];
				$estatus_t="0";
				$btn="";



				 if($row['estatus'] == 1){
			      $btn="<span class='glyphicon glyphicon-ok-sign' id='xml' value='btn_c' name='btn_c' style='color: green; font-size: 18px;' title='Timbrado'></span>";
			      $estatus_t="1";
			    }

			    if($row['estatus'] == 0){

			    //   $btn="<span class='glyphicon glyphicon-minus-sign' id='xml' value='btn_pe' name='btn_pe' style='color: #ff5200; font-size: 18px;' title='Pendiente'></span> ";
			        $estatus_t="0";
			    }


                $forma_o="";

				$sqlf="SELECT * FROM lls_formapago where c_formapago='$forma_pago'";

				// echo $sqlf;

				$datosf=$this->con->consultaRetorno($sqlf);
				while($rowf = mysqli_fetch_array($datosf, MYSQLI_ASSOC)) {
					// $forma_o=$rowf['c_formapago']." - ".$rowf['descripcion'];
					$forma_o=$rowf['c_formapago']." - ".utf8_encode($rowf['descripcion']);

			    }



			    $btn_accion="";

			    // if($row['estatus'] == 1){
       //             $btn_accion="<span class='glyphicon glyphicon-file' onclick='descargar_comprobante();' title='Descargar Complemento PDF' style='color: black; font-size: 16px;'></span> || <span class='glyphicon glyphicon-file' onclick='descargar_xml_t();' title='Descargar XML Complemento' style='color: green; font-size: 16px;'></span> || <span class='glyphicon glyphicon-ban-circle' onclick='eliminar_pago($rowid);' title='Cancelar Pago' style='color: red; font-size: 16px;'></span>";
			    // }else{
			    // 	$btn_accion="<span class='glyphicon glyphicon-ban-circle' onclick='eliminar_pago($rowid);' title='Cancelar Pago' style='color: red; font-size: 16px;'></span>";
			    // }

                if($row['estatus'] == 1){
                   $btn_accion="<span class='glyphicon glyphicon-file' onclick='descargar_comprobante($rowid)' title='Descargar Complemento PDF' style='color: black; font-size: 17px;'></span> || <span class='glyphicon glyphicon-file' onclick='descargar_xml_t($rowid)' title='Descargar XML Complemento' style='color: green; font-size: 17px;'></span>";
			    }else{
			    	//nuevo modificado ismael 011217 agregado hoy
			    	$btn_accion="";
			    	// $btn_accion="<span class='glyphicon glyphicon-file' onclick='descargar_comprobante($rowid)' title='Descargar Complemento PDF' style='color: black; font-size: 17px;'></span> || <span class='glyphicon glyphicon-file' onclick='descargar_xml_t($rowid)' title='Descargar XML Complemento' style='color: green; font-size: 17px;'></span> || <span class='glyphicon glyphicon-ban-circle' onclick='eliminar_pago($rowid);' title='Eliminar Pago' style='color: red; font-size: 17px;'>";
			    }




				$data[] = array(
			    	'id_complemento'=>$rowid,
			    	'num_parcialidad'=>$num_parcialidad,
			    	'factura'=>$factura,
			    	'nombre_cliente'=>$nombre_cliente,
			    	'fecha_pago'=>$fecha_pago,
			    	'moneda_pago'=>$moneda_pago,
			    	'forma_pago'=>$forma_o,
			    	'total_pago'=>$total_pago,
			    	'folio_fiscal'=>$folio_fiscal,
			    	'btn_estatus'=>$btn,
			    	'status'=>$estatus_t,
			    	'btn_accion'=>$btn_accion,
			    	'status_fecha'=>$status_fecha//nuevo agregado ismael
			    );

			    // print_r($data);
			}

			// return $datos;
			echo json_encode($data);
			// echo "entro";
			// return json_encode($data);

			//
		}


       //para verificar la fecha
	   public function verificar_fecha()
       {
            $id_pago =$this->id_pago;

       	    $ids_r = substr($id_pago, 0, -1);
		    $row_list = explode(",", $ids_r);


		    $status_fecha=0;
		    $status_timbrado=0;

            $hoy = date("Y-m-d");
            $fecha_pago="";
            $status_timbrado="";

            $id_aceptados="";

            $total_registros=0;
            $total_fechas=0;
            $total_status=0;

		    foreach ($row_list as $row_num) {
		    	$total_registros=$total_registros+1;

		    	$fecha_pago="";
                $status_timbrado="";

	       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$row_num' ";
				$datos=$this->con->consultaRetorno($sql);

				while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					$fecha_pago=$row["fecha_pago"];//2017-07-112017-11-16T12:00:00
					$status_timbrado=$row["estatus"];
				}

                $arrya_fecha_p = explode("-", $fecha_pago);
		        $arrya_fecha_hoy = explode("-", $hoy);

		        $mes_p=$arrya_fecha_p[1]; // porción1
				$mes_hoy=$arrya_fecha_hoy[1]; // porción1

				$year_p=$arrya_fecha_p[0]; // porción0
				$year_hoy=$arrya_fecha_hoy[0]; // porción0

                $fecha_limite_c="";
                $mes_s="";

                //============operacion para aumentar uno o nada a fechas
				if($mes_p==12){
                   $mes_s=01;
                   $year_p=$year_p+1;
				}else{
				   $mes_s=$mes_p+1;
				}

				$fecha_limite_c=$year_p."-".$mes_s."-10";//es le fecha limite del pago del siguiente mes

				$fecha_inicio = $hoy;
				$fecha_fin    = $fecha_limite_c;

				if($fecha_inicio > $fecha_fin){
					// $status_fecha="1";//fecha superada
					$total_fechas=$total_fechas+1;
				}else{
				   // $status_fecha="0";//fecha aun no superada
				}
                //==========fin para verificar las fechas 271117
				if($status_timbrado == 1){
			      //ya timbrado
			       $total_status=$total_status +1;
			    }else{
			    	//aun no timbrado
			    }
		    }

		    if($total_fechas>0){
               echo "hay registros seleccionados que ya no cumplen con el rango de fechas para generarles complemento de pago";
		    }else{
		    	if($total_status>0){
                   echo "hay registros seleccionados que ya se les ha generado complemento de pagos";
		    	}else{

		    		if($total_fechas==0 && $total_status==0){
		    		   echo "1";
		    		}else{
		    			echo "error";
		      		}
		    	}
		    }
		}

	   public function select_hispago()
       {
            $id_pago =$this->id_doc;

	        $id_documento="";

       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";

			$datos=$this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC))
			{
				 $id_documento=$row["id_documento"];//2017-07-112017-11-16T12:00:00
			}


			$sql2 = "SELECT * FROM lla_registro_factura WHERE id ='$id_documento'";
		    $datos2=$this->con->consultaRetorno($sql2);
            return $datos2;


		}

		public function select_serializacion_pago(){
		    $sql="SELECT count(*) as Total FROM lla_complemento_pago as lcp,lla_registro_factura as lrf WHERE (lcp.folio_fiscal IS NOT NULL AND lcp.folio_fiscal != '') and lrf.rfc_emisor='{$this->rfc}' and lcp.id_documento=lrf.id";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}


		public function select_folio_pago(){
		    // $sql="SELECT * FROM lla_serie_folio WHERE documento='{$this->tipo_documento}'";
		    // $sql="SELECT * FROM lla_complemento_pago WHERE serie= '{$this->tipo_serie}' AND estatus = 1 ORDER BY folio DESC LIMIT 1";
		    $sql="SELECT lcp.* FROM lla_complemento_pago AS lcp,lla_registro_factura AS lrf WHERE lcp.serie='{$this->tipo_serie}' AND lcp.estatus = 1 AND lcp.id_documento=lrf.id and lrf.rfc_emisor='{$this->rfc}' ORDER BY lcp.folio DESC LIMIT 1";

			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}


		 public function select_complemento()
       {
            $id_pago =$this->id_pago;

	        $id_documento="";

       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

		 public function select_complemento_pdf()
       {
            $id_pago =$this->id_pago;

	        $id_documento="";

       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}


		public function select_cuenta_re()
       {
            $id_cuenta_receptor =$this->id_cuenta_receptor;

	        // $id_documento="";

       	    $sql="SELECT * FROM lla_cuentas_bancarias WHERE id='$id_cuenta_receptor' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}



        public function select_cuenta_emi()
       {
            $id_cuenta_emisor =$this->id_cuenta_emisor;

	        // $id_documento="";

       	    $sql="SELECT * FROM lla_cuentas_bancarias WHERE id='$id_cuenta_emisor' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

		public function select_pais()
       {
            $id_pais =$this->id_pais;

       	    $sql="SELECT * FROM lls_pais WHERE rowid='$id_pais' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

       public function select_estados()
       {
            $id_estado =$this->id_estado;

       	    $sql="SELECT * FROM lls_estados WHERE rowid='$id_estado' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

		public function select_municipio()
       {
            $id_mun =$this->id_mun;

       	    $sql="SELECT * FROM lls_municipios WHERE rowid='$id_mun' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

		public function select_colonia()
       {
            $id_colonia =$this->id_colonia;

       	    $sql="SELECT * FROM lls_colonias WHERE rowid='$id_colonia' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}

		public function select_cp()
       {
            $id_cp =$this->id_cp;

       	    $sql="SELECT * FROM lls_cp WHERE rowid='$id_cp' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}


		public function select_usocfdi()
       {
            $id_uso =$this->id_uso;

       	    $sql="SELECT * FROM lls_c_usocfdi WHERE rowid='$id_uso' ";
			$datos=$this->con->consultaRetorno($sql);

			return $datos;
		}


		 //actualizar el estatus de la factura
		public function update_factura_pago(){

			$ids="";

			$ids=$this->id_doc;


			//modificado ismael 271117
		  	$ids_r = substr($ids, 0, -1);
			$row_list = explode(",", $ids_r);

			foreach ($row_list as $row_num) {

               $sql="UPDATE lla_complemento_pago SET fecha_facturado='{$this->fecha_factura}', folio_fiscal='{$this->folio_fiscal}', estatus='{$this->estatus_factura	}'  WHERE id='$row_num' ";
			   $datos=$this->con->consultaRetorno($sql);
     		}
			// return $datos;
			return "correcto";
		}

		//actualizar el pago
		public function update_f_pago(){

			$ids=$this->id_doc;

			//modificado ismael 271117
		  	$ids_r = substr($ids, 0, -1);
			$row_list = explode(",", $ids_r);

			foreach ($row_list as $row_num) {

               $sql="UPDATE lla_complemento_pago SET serie='{$this->serie}', folio='{$this->folio}' WHERE id='$row_num' ";
			   $datos=$this->con->consultaRetorno($sql);
     		}

		 //    $sql="UPDATE lla_complemento_pago SET serie='{$this->serie}', folio='{$this->folio}'  WHERE id='{$this->id_doc}' ";
		// $datos=$this->con->consultaRetorno($sql);
			return "correcto";
		}


		public function update_folio(){//modificado ismael 281117

			$ids=$this->id_doc;

		  	$ids_r = substr($ids, 0, -1);
			$row_list = explode(",", $ids_r);

			foreach ($row_list as $row_num) {

              $sql="UPDATE lla_complemento_pago SET serie='{$this->serie}', folio='{$this->folio}'  WHERE id='$row_num' ";
			  $datos=$this->con->consultaRetorno($sql);
     		}

			return "correcto";
		}

        public function consultar_uuid(){
			$id_complemento="";
			$id_complemento= $this->id_complemento;

			$sql="SELECT * FROM lla_complemento_pago WHERE id='$id_complemento' ";

			$datos=$this->con->consultaRetorno($sql);

			return $datos;


        }

        //nuevo agrgado ismael 271117
        public function select_fac(){
		    $sql="SELECT * FROM lla_registro_factura WHERE folio_fiscal='{$this->uuid}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

        ///para obtener el importe pendiente
		public function select_complemento_pendiente(){
			$id_complemento="";
			$id_fac="";
			$id_complemento= $this->id_doc;

			$impo_pe=0;

			// $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_complemento' ";
			$sql="SELECT * FROM lla_complemento_pago WHERE id_documento='$id_complemento' ";



			$datos=$this->con->consultaRetorno($sql);

			if($datos){
				while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					 $id_fac=$row["id_documento"];//2017-07-112017-11-16T12:00:00
				}
			}

			///////
            $sql="SELECT * FROM lla_complemento_pago WHERE id_documento='$id_fac' ORDER BY no_parcialidad DESC LIMIT 1 ";
			 // print_r($sql);
			 // exit;

			$datos=$this->con->consultaRetorno($sql);

			if($datos){
				while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					 $impo_pe=$row["importe_restante"];//2017-07-112017-11-16T12:00:00
				}

			}



			return $impo_pe;
		}




		public function select_complemento2()
       {
            $id_pago =$this->id_doc;

            //modificado ismael 271117
		  	$ids_r = substr($id_pago, 0, -1);
			$row_list = explode(",", $ids_r);

			foreach ($row_list as $row_num) {
				$sql="SELECT * FROM lla_complemento_pago WHERE id='$row_num' ";
				$datos=$this->con->consultaRetorno($sql);

				return $datos;

			}


		}

       //nuevo agregado ismael 281117
		public function select_id_pagos(){
			$id_complemento="";
			$id_complemento= $this->id_doc;

			$sql="SELECT folio_fiscal FROM lla_complemento_pago WHERE id='$id_complemento' ";
			$datos=$this->con->consultaRetorno($sql);

            $uuid="";
			if($datos){
				while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					$uuid=$row["folio_fiscal"];
				}
			}

			$sql2="SELECT * FROM lla_complemento_pago WHERE folio_fiscal='".$uuid."' ";
			$datos2=$this->con->consultaRetorno($sql2);

            $uuid="";
            $ids="";
			if($datos2){
				while($row2 = mysqli_fetch_array($datos2, MYSQLI_ASSOC)){
					$id_s="";
					$id_s=$row2["id"];

					$ids .= $id_s.",";
				}
			}

			return $ids;

        }

        ///
        public function buscar_cliente()
       {
            $id_cliente =$this->id_cliente;
            $razon_social="";

			$sql="SELECT * FROM lla_clientes WHERE id='$id_cliente' ";
			$datos=$this->con->consultaRetorno($sql);

			if($datos){
				while($row2 = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					$razon_social=$row2["razon_social"];
				}
			}

			return $razon_social;
		}

		public function importe_pagado()
        {
            $id_reg =$this->id_reg;
            $importe_pagado="0.00";
            $importe_restante="0.00";
            $total=0;

            $sql="SELECT count(*) as total FROM lla_complemento_pago WHERE id_documento='$id_reg' ";
			$datos=$this->con->consultaRetorno($sql);

			if($datos){
				while($row2 = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					$total=$row2["total"];
				}
			}

			if($total==0){
				$importe_pagado="0.00";

				$sql="SELECT  total FROM lla_registro_factura WHERE id='$id_reg' ";
				$datos=$this->con->consultaRetorno($sql);
				if($datos){
					while($row2 = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
						$importe_restante=$row2["total"];
					}
				}

			}else{

				$sql="SELECT * FROM lla_complemento_pago WHERE id_documento='$id_reg' ORDER BY no_parcialidad DESC LIMIT 1";
				$datos=$this->con->consultaRetorno($sql);
				if($datos){
					while($row2 = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					    $importe_pagado=$row2["importe_ya_pagado"];
					    $importe_restante=$row2["importe_restante"];
					}
				}
			}

			return $importe_pagado.",".$importe_restante;
		}

		//alerta sobre los complementos
		//para verificar la fecha
	   public function verificar_complementos()
       {
            $status_fecha=0;
		    $status_timbrado=0;

            $hoy = date("Y-m-d");
            $fecha_pago="";

            $id_aceptados="";

            $total_registros=0;
            $total_fechas=0;
            $total_status=0;

            $sql_s="SELECT  count(*) as total FROM lla_complemento_pago WHERE estatus='0'";
			$datos=$this->con->consultaRetorno($sql_s);

            $total_registros=0;

            $listado_ids=0;

			if($datos){
				while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
					$total_registros=$row["total"];
				}
			}

			if($total_registros > 0){
				$sql_se="SELECT * FROM lla_complemento_pago WHERE estatus='0' ";
			    $datos=$this->con->consultaRetorno($sql_se);
			    if($datos){
					while($row2 = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
						$listado_ids .= $row2["id"].",";
					}
			    }
			}else{
				$listado_ids="";
			}
			///////

            $total_reg_tiempo=0;

			if($listado_ids != ""){

					$ids_r = substr($listado_ids, 0, -1);
					$row_list = explode(",", $ids_r);

					foreach ($row_list as $row_num) {

				    	$total_registros=$total_registros+1;

				    	$fecha_pago="";
		                $status_timbrado="";

			       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$row_num' ";
						$datos=$this->con->consultaRetorno($sql);

						while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)){
							$fecha_pago=$row["fecha_pago"];//2017-07-112017-11-16T12:00:00
						}

		                $arrya_fecha_p = explode("-", $fecha_pago);
				        $arrya_fecha_hoy = explode("-", $hoy);

				        $mes_p=$arrya_fecha_p[1]; // porción1
						$mes_hoy=$arrya_fecha_hoy[1]; // porción1

						$year_p=$arrya_fecha_p[0]; // porción0
						$year_hoy=$arrya_fecha_hoy[0]; // porción0

						$dia_hoy=$arrya_fecha_hoy[2]; //nuevo agregado ismael

						$dia_p=$arrya_fecha_p[2]; //nuevo agregado ismael

		                $fecha_limite_c="";
		                $mes_s="";


		                $arrya_pago = explode("T", $fecha_pago);
		                $fech_pago=$arrya_pago[0];//contiene la fecha de pago

		                //============operacion para aumentar uno o nada a fechas
						if($mes_p==12){
		                   $mes_s=01;
		                   $year_p=$year_p+1;
						}else{
						   $mes_s=$mes_p+1;
						}


                        //nuevo agregado ismael para sabe sobre la fecha 281117
						if($dia_hoy >= 5){

							$fecha_limite_c=$year_p."-".$mes_s."-05";//es le fecha limite del pago del siguiente mes
							$fecha_limite_c2=$year_p."-".$mes_s."-10";//es le fecha limite del pago del siguiente mes

							$fecha_inicio = $hoy;//fecha actual
							$fecha_fin    = $fecha_limite_c;

							if(($fecha_inicio >= $fecha_fin) && ($fecha_inicio <= $fecha_limite_c2)){
								$total_reg_tiempo=$total_reg_tiempo+1;
							}else{
							}

						}else{
							echo "0";//no llega la fecha
							exit;
						}

					}//fin foreach

				    if($total_reg_tiempo==0){
				    	echo "0";
				    }else{
				    	echo "1";
				    }

			    }else{
					echo "0";//no hay registros
		        }
		}//fin alerta sobre los complementos

		///para eliminar un pago///
		public function eliminar_pago(){
		   $id_pago =$this->id_pago;

        }

//Verificar timbre/********************************************
// public function verificarTimbre()
// {
// 	$sql = "SELECT estatus FROM lla_complemento_pago WHERE id = '{$this->id}'";
// 	$datos = $this->con->consultaRetorno($sql);
// 	return $datos;
// }
// public function cancelarUnPago()
// {
// 	$sql = "CALL cancelarComplementoPago('{$this->id}')";
// 	$datos = $this->con->consultaRetorno($sql);
// 	return $datos;
// }
public function buscaid_documento()
{
	$sql = "SELECT id_documento,no_parcialidad FROM lla_complemento_pago WHERE id ='{$this->id}'";
	$datos = $this->con->consultaRetorno($sql);
	//return $datos;
	while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC))
	{
		$this->id_documento = $row['id_documento'];
		$this->no_parcialidad = $row['no_parcialidad'];
	}
 }
 // public function buscarPagosporid()
 // {
 //
	// $sql = "SELECT estatus FROM lla_complemento_pago WHERE id_documento ='{$this->id_documento}' AND estatus = 1";
 // 	$datos = $this->con->consultaRetorno($sql);
	// return $datos;
 // }

//  public function primerPago()
// {
// $sql = "SELECT no_parcialidad FROM lla_complemento_pago WHERE id_documento = '{$this->id_documento}' ORDER BY no_parcialidad ASC LIMIT 1";
// //echo $sql;
// $datos = $this->con->consultaRetorno($sql);
// //return $datos;
// 	while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC))
// 	{
// 			$this->no_parcialidad = $row['no_parcialidad'];
// 	}
// }
public function buscarTimbradosDespues()
{
 $sql = "SELECT estatus FROM lla_complemento_pago WHERE id_documento = '{$this->id_documento}' AND id >= '{$this->id}' AND estatus = 1";
 $datos = $this->con->consultaRetorno($sql);
 return $datos;
}

public function cancelarPagos()
{
	$sql = "CALL cancelarComplementoPagos('{$this->id}')";
	$datos = $this->con->consultaRetorno($sql);
	return $datos;
}

}
 ?>

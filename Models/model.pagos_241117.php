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
				$sql = "SELECT * FROM lla_registro_factura WHERE estatus_factura ='2' AND tipo_documento ='Ingreso' ORDER BY fecha_facturacion ASC";
			    $datos=$this->con->consultaRetorno($sql);

			}
			if($id_cliente > 0 ){
				$sql = "SELECT * FROM lla_registro_factura WHERE idCliente = '$id_cliente' AND estatus_factura ='2' AND tipo_documento ='Ingreso' ORDER BY fecha_facturacion ASC";
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
			$sql="UPDATE lla_timbres SET consumidas_real=consumidas_real+1 where rfc='{$this->rfc_emisor}'";
			
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

			$sql_f="SELECT * FROM lla_complemento_pago WHERE id_documento='{$this->idRelacionado}' ";
			$datosf=$this->con->consultaRetorno($sql_f);

			if ($datosf) {
	    	while($rowCan = mysqli_fetch_array($datosf, MYSQLI_ASSOC)){
            
	            $impP2=$rowCan["importe_pagado"];
	            
	            if($impP2 <> 0 || $impP2 <> ""){

	               $importe_pagado_total=$importe_pagado_total + $impP2;                  
	            }
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
			   // $id_registro_hist = $this->con->last_insert_id("lla_complemento_pago");

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

	            $sql_U="UPDATE lla_complemento_pago SET importe_ya_pagado= $importe_ya_pagado, importe_restante=$importe_restante WHERE id_documento='{$this->idRelacionado}' ";

				$datosU=$this->con->consultaRetorno($sql_U);

				if($datosU){
					$impoTotal=0;
	                $importe_p=0;

	                $queryPagoT="SELECT * FROM lla_complemento_pago WHERE id_documento='{$this->idRelacionado}' ";
				    $datos_p=$this->con->consultaRetorno($queryPagoT);
				    while($rowPG = mysqli_fetch_array($datos_p, MYSQLI_ASSOC)){
		                
		                $impoTotal=$rowPG["importe_total"];
		                $impPT=$rowPG["importe_pagado"];
		                
		                if($impPT <> 0 || $impPT <> ""){

		                   $importe_p=$importe_p + $impPT;                  
		                }
					}

					if($impoTotal==$importe_p){
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
                   $btn_accion="<span class='glyphicon glyphicon-file' onclick='descargar_comprobante();' title='Descargar Complemento PDF' style='color: black; font-size: 16px;'></span> || <span class='glyphicon glyphicon-file' onclick='descargar_xml_t();' title='Descargar XML Complemento' style='color: green; font-size: 16px;'></span>";                  
			    }else{
			    	$btn_accion="";
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
			    	'btn_accion'=>$btn_accion
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
   
	        $fecha_pago="";

       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";
			$datos=$this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)) 
			{
				 $fecha_pag=$row["fecha_pago"];//2017-07-112017-11-16T12:00:00
			}

			$hoy = date("Y-m-d");

			$arrya_fecha_p = explode("-", $fecha_pag);
	        $arrya_fecha_hoy = explode("-", $hoy);

	        $mes_p=$arrya_fecha_p[1]; // porción1
			$mes_hoy=$arrya_fecha_hoy[1]; // porción1

			$year_p=$arrya_fecha_p[0]; // porción1
			$year_hoy=$arrya_fecha_hoy[0]; // porción1

			if($year_p==$year_hoy){
				if($mes_p==$mes_hoy){
		           echo "1";
		        }else{
		            echo "El mes de pago no coincide con la fecha actual";
		        }

			}else{
				echo "El año de pago no corresponde al de la fecha actual";
			}

		}


		///para traer el rfc del emisor
	 //   public function 
	 //   
	 //   ()
  //      { 
  //           $id_pago =$this->id_doc;
   
	 //        $id_documento="";

  //      	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";
		// 	$datos=$this->con->consultaRetorno($sql);

		// 	while($row = mysqli_fetch_array($datos, MYSQLI_ASSOC)) 
		// 	{
		// 		 $id_documento=$row2["id_documento"];//2017-07-112017-11-16T12:00:00
		// 	}


		// 	$sql2 = "SELECT * FROM lla_registro_factura WHERE id ='$id_documento'";
		// 	$datos2=$this->con->consultaRetorno($sql2);
  //           return $datos2;


		// }




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
		    $sql="SELECT count(*) as Total FROM lla_complemento_pago WHERE (folio_fiscal IS NOT NULL AND folio_fiscal != '') ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}


		public function select_folio_pago(){
		    // $sql="SELECT * FROM lla_serie_folio WHERE documento='{$this->tipo_documento}'";
		    $sql="SELECT * FROM lla_complemento_pago WHERE serie= '{$this->tipo_serie}' AND (estatus=='1') ORDER BY folio DESC LIMIT 1";

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


		public function select_complemento2()
       { 
            $id_pago =$this->id_doc;   

       	    $sql="SELECT * FROM lla_complemento_pago WHERE id='$id_pago' ";
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

		    $sql="UPDATE lla_complemento_pago SET folio_fiscal='{$this->folio_fiscal}', estatus='{$this->estatus_factura	}'  WHERE id='{$this->id_doc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}

		//actualizar el pago
		public function update_f_pago(){
			
		    $sql="UPDATE lla_complemento_pago SET serie='{$this->serie}', folio='{$this->folio}'  WHERE id='{$this->id_doc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}


		public function update_folio(){
			
		    $sql="UPDATE lla_complemento_pago SET serie='{$this->serie}', folio='{$this->folio}'  WHERE id='{$this->id_doc}' ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;	
		}













	}
 ?>
<?php
set_time_limit(0);
date_default_timezone_set('America/Mexico_City');

include('../models/model.facturacion.php');
$datos= new factura();


$id_doc = $_POST['id'];
$folio_fiscal = $_POST['folio'];//nuevo agregado ismael
$gener=genera_pdf($id_doc, $folio_fiscal,$datos);//nuevo agregado ismael 
echo $folio;



function genera_pdf($id, $folio_fiscal, $datos){
 
 include('../libs/archivos_fac/phpqrcode/generadorQR.php');

  //$id ="";
  $archivador2="";



  $id_oper=0;
  $tt_o="";

  $b=0;
  $archivador2="";

  $dato_bl="";

  $datos->set("id_doc", addslashes(utf8_decode($id))); //para obtener el rfc del emisor
  $res_emi= $datos->select_rfactura();


  $rfc_emisor="";
  $rfc_receptor="";
  $id_cliente="";

  // $uuid="";

  while($row_emi = mysqli_fetch_array($res_emi, MYSQLI_ASSOC)){
    $rfc_emisor=$row_emi["rfc_emisor"];

    $rfc_receptor=$row_emi["rfc_receptor"];
    $id_cliente=$row_emi["idCliente"];
  }

  // $id=trim($id);
  $archivador2="../comprobantesCfdi/".$folio_fiscal.".xml";

  //================= datos del cliente
   $r_razon_social = ""; 
   $r_pais = ""; 
   $r_estado = ""; 
   $r_municipio = ""; 
   $r_colonia = ""; 
   $r_calle = ""; 
   $r_int = ""; 
   $r_ext = ""; 
   $r_cp = ""; 

   $r_usocfdi = ""; 
  //$rfc_receptor="ESI920427886";
   
    $datos->set("id", addslashes(utf8_decode($id_cliente)));
    $datos->set("rfc", addslashes(utf8_decode($rfc_receptor)));   
    $resCl= $datos->select_cliente();

    while($rowC = mysqli_fetch_array($resCl, MYSQLI_ASSOC)){ 
      
      $r_razon_social= $rowC["razon_social"];

      $r_pais = $rowC["pais"]; 
      $r_estado = $rowC["estado"]; 
      $r_municipio = $rowC["municipio"]; 
      $r_colonia = $rowC["colonia"]; 
      $r_calle = $rowC["calle"]; 
      $r_int = $rowC["ninterior"]; 
      $r_ext = $rowC["nexterior"]; 
      $r_cp = $rowC["cp"]; 

      $r_usocfdi = $rowC["c_usocfdi"];       
    }

    //============= datos del emisor
    
   $e_razon_social = ""; 
   $e_pais = ""; 
   $e_estado = ""; 
   $e_municipio = ""; 
   $e_colonia = ""; 
   $e_calle = ""; 
   $e_int = ""; 
   $e_ext = ""; 
   $e_cp = "";

   $e_regimen_fiscal = ""; 

   $logo_e = ""; 

  //para obtener datos del emisor
  $datos->set("rfc", addslashes(utf8_decode($rfc_emisor))); 
  $res= $datos->select_fiscal();

  while($fila_emi = mysqli_fetch_array($res, MYSQLI_ASSOC)){
    $e_razon_social=$fila_emi["razon_social"];
    $e_regimen_fiscal=$fila_emi["regimen_fiscal"];

    $e_pais =$fila_emi["pais"]; 
    $e_estado =$fila_emi["estado"]; 
    $e_municipio =$fila_emi["municipio"]; 
    $e_colonia =$fila_emi["colonia"]; 
    $e_calle =$fila_emi["calle"]; 
    $e_int =$fila_emi["nint"]; 
    $e_ext =$fila_emi["next"]; 
    $e_cp =$fila_emi["cp"];

    $logo_e =$fila_emi["logo"];

  }


$xml = simplexml_load_file($archivador2); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
 $xml->registerXPathNamespace('t', $ns['tfd']);

 $TipMoneda="";
 $serie="";
 $folio="";
 $TipoCambio="";


 $condicionesDePago="";

 $NumCtaPago="";//agregado ismael 160517
 
//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
//      echo $cfdiComprobante['version']; 
      $fecha = $cfdiComprobante['Fecha'];  
      $sello = $cfdiComprobante['Sello']; 
      $serie = $cfdiComprobante['Serie']; 
      $folio = $cfdiComprobante['Folio']; 
      $TipMoneda = $cfdiComprobante['Moneda'];

      $TipoCambio = $cfdiComprobante['TipoCambio'];

      $tot1=(string) $cfdiComprobante['Total'];
      // $total = $cfdiComprobante['total']; //modifcado17112016
      $total = number_format($tot1,2,".",","); 

      //$subtotal = $cfdiComprobante['subTotal']; //modificado11172016
      $sub1= (string) $cfdiComprobante['SubTotal'];
      $subtotal = number_format($sub1,2,".",","); 

      $certificado = $cfdiComprobante['Certificado']; 
      $formaDePago = $cfdiComprobante['FormaPago']; 
      $noCertificado = $cfdiComprobante['NoCertificado']; 
      $tipoDeComprobante = $cfdiComprobante['TipoDeComprobante']; 
      $metodoDePago = $cfdiComprobante['MetodoPago']; 
      $LugarExpedicion = $cfdiComprobante['LugarExpedicion']; 
      // $NumCtaPago = $cfdiComprobante['NumCtaPago']; 

      $condicionesDePago =$cfdiComprobante['CondicionesDePago'];
}
 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
    $e_rfc = $Emisor['Rfc']; 
    $e_nombre = $Emisor['Nombre'];  
} 

$taxid="";
$uso_cfdi="";//nuevo agregado ismael 271017 FACTURACION 3.3 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){
  $r_rfc = $Receptor['Rfc']; 
  $r_nombre = $Receptor['Nombre'];


  $uso_cfdi=$Receptor['UsoCFDI'];


  $datos->set("uso_cfdi", addslashes(utf8_decode($uso_cfdi))); 
  $resuso= $datos->select_uso();

  while($fila_uso = mysqli_fetch_array($resuso, MYSQLI_ASSOC)){
     $uso_cfdi=$fila_uso["c_UsoCFDI"]." - ".$fila_uso["descripcion"];
  }

   // $queryDatos2="SELECT * FROM llx_usocfdi WHERE uso_cfdi = '$uso_cfdi'"; 
   //  $resC2=mysqli_query($link, $queryDatos2);

   //  if ($resC2) {
   //    while($r2 = mysqli_fetch_array($resC2, MYSQLI_ASSOC)){
   //      $uso_cfdi=$r2["uso_cfdi"]." ".$r2["u_descripcion"];
   //    }
   // }
}


$factura=$serie." ".$folio;

//==============para los conceptos

   
  $conceptos=" ";   //almacena la estructura de los conceptos cuando se arman

  //almacena los total de los importes de 16, 4, 0
  $importe16 =0.00;
  $importe4 =0.00;
  $importe0 =0.00;

  $importe  =0.00;//nuevo agregado para el importe total del iva

  ///total de la factura
  // $subtotal=0.00;
  /// subtotan de la factura
  $total_factura=0.00;


  $bandera_tasa16=0;
  $bandera_tasa4=0;


  $html_desc="";//==


  $datos->set("id_doc", addslashes(utf8_decode($id)));   
  $res_F= $datos->select_rfactura();
  while($row_F = mysqli_fetch_array($res_F, MYSQLI_ASSOC)){
    $concepto_clave =$row_F['concepto_clave'];
  }


  $id_prod_serv="";
  $cantidad=0;
  $num_identificacion="";
  $clave_unidad="";
  $clave_sat="";
  $tipo_traslado="";
  $t_factor_t="";
  $varlor_tc_traslado="";
  $importe_translado="";
  $tipo_retencion="";
  $t_factor_r="";
  $varlor_tc_retencion="";
  $importe_retencion="";

  $valor_unitario="";
  $importe_total="";

  $datos->set("concepto_clave", addslashes(utf8_decode($concepto_clave)));   
  $res_c= $datos->select_conceptos();

  // print_r($res_c);
  // exit;
  
  while($row = mysqli_fetch_array($res_c, MYSQLI_ASSOC)){ 
        
        $id_prod_serv="";
        $cantidad=0;
        $num_identificacion="";
        $clave_unidad="";
        $clave_sat="";
        $tipo_traslado="";
        $t_factor_t="";
        $varlor_tc_traslado="";
        $importe_translado="";
        $tipo_retencion="";
        $t_factor_r="";
        $varlor_tc_retencion="";
        $importe_retencion="";

        $valor_unitario="";
        $importe_total="";


          
        $id_prod_serv=$row["id_prod_serv"]; //id del producto


        $cantidad=$row["cantidad"];          
        $num_identificacion="";

        $clave_unidad=$row["clave_unidad"];
        $unidad=$row['descripcion_empresa'];

        $clave_sat=$row["clave_sat"];

        $valor_unitario=$row["valor_unitario"];

        $importe_total=$row["importe_total"];

        $descuento="0.00";

        
        $tipo_traslado=$row["tipo_traslado"];  //ISR-IVA-IEPS        
        $t_factor_t=$row["tipo_factor_translado"]; //Tasa Cuota
        $varlor_tc_traslado=$row["valor_tasa_cuota_translado"]; //
        $importe_translado=$row["importe_translado"];  //

        // =======================
        
        $tipo_retencion=$row["tipo_retencion"]; //ISR-IVA-IEPS        
        $t_factor_r=$row["tipo_factor_retencion"]; //Tasa Cuota
        $varlor_tc_retencion=$row["valor_tasa_cuota_retencion"]; //
        $importe_retencion=$row["importe_retencion"];  //

        //=====================================

        
        $datos->set("id", addslashes(utf8_decode($id_prod_serv)));   
        $res_p= $datos->select_producto();

        $p_clave_interna="";
        $p_clave_sat="";
        $p_descripcion_sat="";
        $p_descripcion_empresa="";

        while($rowp = mysqli_fetch_array($res_p, MYSQLI_ASSOC)){
          $p_clave_interna="";
          $p_clave_sat="";
          $p_descripcion_sat="";
          $p_descripcion_empresa="";

          $p_clave_interna=$rowp["clave_interna"];
          $p_clave_sat=$rowp["clave_sat"];
          $p_descripcion_sat=$rowp["descripcion_sat"];
          $p_descripcion_empresa=$rowp["descripcion_empresa"];
        }

        //===========================================
        
        // $subtotal= $subtotal + $importe_total;


        //para colocar los decimales que se necesitan
        
        if($valor_unitario>0){
          $valor_unitario =number_format($valor_unitario, 2, '.', '');
        }else{ $valor_unitario =0.00; }

        if($importe_total>0){
          $importe_total =number_format($importe_total, 2, '.', '');
        }else{ $importe_total =0.00; }

        if($importe_translado>0){
          $importe_translado =number_format($importe_translado, 2, '.', '');
        }else{ $importe_translado =0.00; }

        if($importe_retencion>0){
          $importe_retencion =number_format($importe_retencion, 2, '.', '');
        }else{ $importe_retencion =0.00; }
      
   
          //movido de luggar facturacio 3.3 ismael 231017
          $tasaocuota="";
          $tasaocuota_r="";

          $importe_im="";
          $importe_re="";

          $importe_nodo="";
          $importe_nodo_r="";

              
        //===============para los traslados
          

             $tasaocuota=$varlor_tc_traslado;
             $importe_nodo="";
   
             $importe = $importe + ($importe_total*$tasaocuota); //modificado ismael 160517
             $importe16 = $importe16 + ($importe_total*$tasaocuota);
             $retencioniva  =   $importe_translado; 

             $importe_nodo=$importe_translado;//nuevo agreagdo ismael 231017

             $bandera_tasa16=1;   
           

           if($varlor_tc_traslado == 4){

             $importe_nodo="";
             $tasaocuota="0.040000";
             $importe = $importe + (($importe_total*4)/100); 
             $importe4 =  $importe4 + (($importe_total*4)/100); 
             $retencioniva  =   (($importe_total*4)/100);

             $importe_nodo=(($importe_total*4)/100);//nuevo agreagdo ismael 231017

             $bandera_tasa4=1;       
           }

         



         //====================================par la retencion
          
         
            $tasaocuota_r=$varlor_tc_retencion;//nuevo agragdo ismael 231017 facturacion 3.3. 
            $ImpuestosRetenidos = $importe_retencion; 

            $importe_nodo_r=$importe_retencion; //nuevo agragdo ismael 231017 facturacion 3.3.          
            $retencioniva=$importe_retencion;
            
          //modificado ismael 231017
          if($varlor_tc_retencion == 0)
          {
            $tasaocuota_r="0.000000";//nuevo agragdo ismael 231017 facturacion 3.3. 

            $importe_nodo_r="0.00"; //nuevo agragdo ismael 231017 facturacion 3.3.        
            $retencioniva=0.00;
          } 

           
          //agreagdo ismael facturacion 3.3. 
          if($importe_nodo>0){
            $importe_nodo =number_format($importe_nodo, 2, '.', '');            
          }else{
            $importe_nodo ="0.00";           
          }

          if($importe_nodo_r>0){
            $importe_nodo_r =number_format($importe_nodo_r, 2, '.', '');            
          }else{
            $importe_nodo_r ="0.00";            
          }

         if($num_identificacion==""){
            $num_identificacion="NA";
         }


        //===================================================
        // $taxr = number_format($taxr,2,".",","); 
        // $c_importe =number_format($importe_xml, 2, '.', '');

        $importe_t=$importe_nodo; 
        
        $importe_r=$importe_nodo_r;      

        //nuevo agragdo para la FACTURACION 3.3
        $imp_tra="";
        $imp_ret="";

        if($tipo_traslado=='001'){
           $tipo_traslado="ISR";            
        }
        if($tipo_traslado=='002'){
          $tipo_traslado="IVA";            
        }
        if($tipo_traslado=='003'){
          $tipo_traslado="IEPS";            
        }
        ///==
        if($tipo_retencion=='001'){
           $tipo_retencion="ISR";            
        }
        if($tipo_retencion=='002'){
          $tipo_retencion="IVA";            
        }
        if($tipo_retencion=='003'){
          $tipo_retencion="IEPS";            
        }


        if($importe_t>0){
          $imp_tra .="TRASLADOS"."<br>";
          $imp_tra .="".$tipo_traslado.", ";
          $imp_tra .="".$t_factor_t.", ";
          $imp_tra .="".$tasaocuota."";           
        }else{
          $importe_t="";
        }

        if($importe_r>0){
          $imp_ret .= "RETENCIONES"."<br>";
          $imp_ret .= $tipo_retencion.", ";
          $imp_ret .= $t_factor_r.", ";
          $imp_ret .= $tasaocuota_r.", ";            
        }else{
          $importe_r=0;
        }

        // imp_tra
        // importe_t
        // imp_ret
        // importe_r

        //=============================================================
        // $p_descripcion_sat=utf8_encode($p_descripcion_sat);
        // $clave_unidad=utf8_encode($clave_unidad);


     

        $html_desc .= '<tr style="border-bottom: 1px solid #9e9e9e;">';

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e;  border-right: 1px solid #9e9e9e;  color: #505050">'.$clave_sat.'</td>'; 

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e;  border-right: 1px solid #9e9e9e;  color: #505050">'.$cantidad.'</td>';

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e;  border-right: 1px solid #9e9e9e;  color: #505050">'.utf8_decode($unidad).'</td>';

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="left" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e; color: #505050">'.utf8_decode($p_descripcion_empresa).'</td>';  

          $html_desc .= '<td  HEIGHT="20" rowspan="2" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e; color: #505050">$ '.$valor_unitario.'</td>'; 

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="center"   style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e; color: #505050">'.$descuento.'</td>';
          
          //nuevos agregados facturacion 3.3
          $html_desc .= '<td HEIGHT="20" align="left" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e;  color: #505050">'.$imp_tra.'</td>';
          $html_desc .= '<td HEIGHT="20" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e;  color: #505050">$ '.number_format($importe_t,2,'.',',').'</td>';
          //fin nuevos agregado facturacion 3.3

          $html_desc .= '<td HEIGHT="20" rowspan="2" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e; color: #505050">$ '.$importe_total.'</td>';
          $html_desc .= '</tr>';

          $html_desc .= '<tr style="border-bottom: 1px solid #9e9e9e;">';           
          //nuevos agregados facturacion 3.3
          $html_desc .= '<td HEIGHT="20" align="left" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e;  color: #505050">'.$imp_ret.'</td>';
          $html_desc .= '<td HEIGHT="20" align="center" style="font-size:10px; border-top: 1px solid #9e9e9e; border-right: 1px solid #9e9e9e;  color: #505050">$ '.number_format($importe_r,2,'.',',').'</td>';
        //fin nuevos agregado facturacion 3.3

        $html_desc .= '</tr>';



        // $tax_v ="";
        // $taxr=0.00;
        // $des="";        
   }





   // $IVA01=(string)$tax0;
   // $IVA161=(string)$tax16;
   // $IVA251=(string)$tax25;

   /* Los conceptos pueden ser varios */
   $suma_traslado = 0;
   $base_16 = 0;
   $base_cero = 0;

   $iva4=0.00;
 $cadena="";//nuevo agragdopara la faturacion 3.3. ismael 261017


foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 

   $base="";
   $base=(string)$Traslado['Base']; 

  if($base==""){    
  }else{
     $t_tasa = (string)$Traslado['TasaOCuota']; 

    //modificado ismael
        $t_importe = (float)$Traslado['Importe'];

        // $cadena .=$t_importe.",";
        $iva = (float)$Traslado['Importe'];
        $suma_traslado +=  $t_importe;
        $base_16 = $suma_traslado;
        // $t_impuesto = $Traslado['impuesto'];
    

    if($t_tasa=="0.040000"){//agregado ismael 250517
        $t_importe2 = (float)$Traslado['Importe'];
        $iva2 = (float)$Traslado['Importe'];
        $suma_traslado2 +=  $t_importe2;
        $iva4 = $suma_traslado2 ;
        // $t_impuesto2 = $Traslado['impuesto'];
    }
  } 
} 

// $base_16 = number_format($base_16,2);//modificado17112016
 $base_16 = number_format($base_16,2,".",","); 
$iva4 = number_format($iva4,2,".",","); //agregados ismael 250517

  $r_Retencion=0;

  
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $Retencion){ 
   $r_Retencion = (string) $Retencion['Importe']; 
} 
 // $r_Retencion = number_format($r_Retencion,2);//modificado17112016
  $r_Retencion = number_format($r_Retencion,2,".",","); 

 // $IVA0 = number_format($IVA01,2,".",","); //nuevos agregados
 // $IVA16 = number_format($IVA161,2,".",","); //uevos agregados

 // $IVA25 = number_format($IVA251,2,".",","); //uevos agregados

 ///para el qr 131117
 //ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//t:TimbreFiscalDigital') as $tfd) {
   $selloCFD = $tfd['SelloCFD']; 
   $FechaTimbrado = $tfd['FechaTimbrado']; 
   $UUID = $tfd['UUID']; 
   $noCertificadoSAT = $tfd['NoCertificadoSAT']; 
   $tfd_version = $tfd['Version']; 
   $selloSAT = $tfd['SelloSAT']; 
}

$digitos="";
$digitos=substr($selloSAT, -8);//obtener los ultimos digitos facturacion 3.3

$t=$total;
$t=str_replace(",", "", $total);
$level = 'H';
$data = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?re=".$e_rfc."&rr=".$r_rfc."&tt=".$t."&id=".$UUID."&fe=".$digitos;

$size = '5';
$ImgQR = genera_codigo($level,$data,$size);
 
 ///

if($r_Retencion>0){
  $formato_retencion = '<td align="left" width="15%" style="border-bottom: 1px solid #5F5F5F; color: #505050">Impuestos Retenidos</td>
              <td align="right" width="15%" style="border-bottom: 1px solid #505050; color: #505050">$ '.$r_Retencion.'</td>';
}else{
  $formato_retencion = '<td width="15%" style="border-bottom: 1px solid #505050;font-size:10px; color: #505050"></td><td width="15%" style="border-bottom: 1px solid #5F5F5F;font-size:11px; color: #505050"></td>';
}

if($r_Retencion>0){
  $formato_retencion2 = '<td align="left" width="25%" style="color: #505050">Total Impuestos Retenidos</td>
              <td align="right" width="20%" style="color: #505050">$ '.$r_Retencion.'</td>';
}else{
  $formato_retencion2 = '<td width="25%" style="color: #505050"></td><td width="20%" style=""></td>';
}


$metodoDePago2="";//03


// if($opcion_tp==1){//original se borra la tabla con los datos 
//    $queryDatos="DELETE FROM llx_datos_facturar WHERE id_operacionF = '$id'  AND tipo_operacion = 'IA'"; 
//    $res=mysqli_query($link, $queryDatos);
// }

   
$iva_aplicado="";
$iva_aplicado2="";


if ($base_16>0) {
  $iva_a=$t_tasa.'%';

   $iva_aplicado = '<td align="left" width="15%" style="color: #505050">IVA &nbsp; &nbsp;'.$iva_a.'</td>
              <td align="right" width="15%"  style="color: #505050">$ '.$base_16.'</td>';
}
if ($iva4>0) {
  $iva_a="0.040000%";

  $iva_aplicado2 = '<td align="left" width="15%"  style="color: #505050">IVA &nbsp; &nbsp;'.$iva_a.'</td>
              <td align="right" width="15%"  style="color: #505050">$ '.$iva4.'</td>';
}


//para FACTURACION 3.3
if($metodoDePago=="PUE"){
   $metodoDePago="PUE"." - "."Pago en una sola exhibición";
}
if($metodoDePago=="PPD"){
   $metodoDePago="PPD"." - "."Pago en parcialidades o diferido";
}


$lugar_ex=$LugarExpedicion;
$fecha_expedicion=$fecha;


///para obtener la fecha de hoy
// $fecha_hoy="";
///

if($formaDePago=='01'){
  $descripcion_metodoPago = 'Efectivo';
  }elseif($formaDePago=='02'){
  $descripcion_metodoPago = 'Cheque nominativo';
  }elseif($formaDePago=='03'){
  $descripcion_metodoPago = 'Transferencia electrónica de fondos';
  }elseif($formaDePago=='04'){
  $descripcion_metodoPago = 'Tarjeta de Crédito';
  }elseif($formaDePago=='05'){
  $descripcion_metodoPago = 'Monedero Electrónico';
  }elseif($formaDePago=='06'){
  $descripcion_metodoPago = 'Dinero Electrónico';
  }elseif($formaDePago=='08'){
  $descripcion_metodoPago = 'Vales de despensa';
  }elseif($formaDePago=='12'){
  $descripcion_metodoPago = 'Dación en pago';
  }elseif($formaDePago=='13'){
  $descripcion_metodoPago = 'Pago por subrogación';
  }elseif($formaDePago=='14'){
  $descripcion_metodoPago = 'Pago por consignación';
  }elseif($formaDePago=='15'){
  $descripcion_metodoPago = 'Condonación';
  }elseif($formaDePago=='17'){
  $descripcion_metodoPago = 'Compensación';
  }elseif($formaDePago=='23'){
  $descripcion_metodoPago = 'Novación';
  }elseif($formaDePago=='24'){
  $descripcion_metodoPago = 'Confusión';
  }elseif($formaDePago=='25'){
  $descripcion_metodoPago = 'Remisión de deuda';
  }elseif($formaDePago=='26'){
  $descripcion_metodoPago = 'Prescripción o caducidad';
  }elseif($formaDePago=='27'){
  $descripcion_metodoPago = 'A satisfacción del acreedor';
  }elseif($formaDePago=='28'){
  $descripcion_metodoPago = 'Tarjeta de Débito';
  }elseif($formaDePago=='29'){
  $descripcion_metodoPago = 'Tarjeta de Servicio';
  }elseif($formaDePago=='30'){
  $descripcion_metodoPago = 'Aplicación de anticipos';
  }elseif($formaDePago=='99'){
  $descripcion_metodoPago = 'Por Definir';
  }elseif($formaDePago=='NA'){
   // $descripcion_metodoPago = 'N/A';
  }




 $op=0;
 if ($TipMoneda=='MXN') {
   $op=1;
 }
 if ($TipMoneda=='USD') {
   $op=2;
 }

 $totalconletra=strtoupper(num2letras(1, $total)); 

///utf8
$r_colonia= strtr(strtoupper(utf8_encode($r_colonia)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");

$e_razon_social=strtr(strtoupper(utf8_encode($e_razon_social)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_calle= strtr(strtoupper(utf8_encode($e_calle)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_colonia= strtr(strtoupper(utf8_encode($e_colonia)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_municipio= strtr(strtoupper(utf8_encode($e_municipio)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_estado= strtr(strtoupper(utf8_encode($e_estado)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_pais= strtr(strtoupper(utf8_encode($e_pais)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$rfc_emisor= strtr(strtoupper(utf8_encode($rfc_emisor)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
///


 $style='<style>
   body{
    font-family: Arial,serif;
    letter-spacing: 0.2pt;
  }
  table{
    font-family: Arial,serif;
    letter-spacing: 0.2pt;
    padding: none;
  }
   td{
    font-family: Arial,serif;
    letter-spacing: 0.2pt;
    padding: none;
  }
   p{
    font-family: Arial,serif;
    letter-spacing: 0.2pt;
    padding: none;
  }
  hr{
   padding: none; 
  }
  p,div{ font-family: Arial,serif;
  letter-spacing: 0.2pt; }
  b{ color :#111111;}
</style>';

$cabecera = '
     <div style="width: 100%;  border-bottom: 0px solid #ccc;">

       <div style="width: 70%; border: 0px solid #ccc; border-radius:2pt; padding: 0pt; float: left;">
         <table style="border: 0px solid #000; border-collapse: collapse" width="100%" >
          <tr>
            <td align="center"><img src="'.$logo_e.'" width="120px;" border=0></td>        
            <td>
              <div style="font-size:10px; color: #505050">
                <p style="font-size:12px"><b style="color: #505050">&nbsp;'.$e_razon_social.'</b><p>
                <p>&nbsp;'.$e_calle.', No. Ext. '.$e_ext.', No. Int. '.$e_int.'</p>
                <p>&nbsp;Col. '.$e_colonia.',</p>
                <p>&nbsp;'.$e_municipio.', '.$e_estado.',</p>
                <p>&nbsp;C.P. '.$e_cp.', '.$e_pais.'</p>
                <p>&nbsp;RFC: <b style="color: #505050">'.$rfc_emisor.'</b></p>
                <p>&nbsp;Regímen Fiscal: '.$e_regimen_fiscal.' - General de Ley Personas Morales.</p>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <div style="width: 25%; border: 0px solid #ccc; border-radius:2pt; padding: 0pt; float: right;"> 
          <div style="border: 1px solid #ccc; border-radius:2pt; width: 100%;" >
            <table width="100%" style="border-collapse: collapse">
              <tr style="background-color: #eae8e8;">
                <td align="center">  
                     <p style="font-size:14px; "><b style="color:#000000">FACTURA</b></p>      
                </td>
              </tr>
             
              <tr>
                <td align="center" style=" padding: 3px">  
                     <p style="font-size:14px; "><b style="color:#000000">'.$factura.'</b></p>      
                </td>
              </tr>

              <tr align="center">
                <td align="center" style="border-top: 1px solid #ccc; padding: 3px; background-color:#eae8e8"> <p style="font-size:10px;"><b style="color:#2745a4">Fecha/Hora Certificación</b></p> </td>
              </tr>
               <tr align="center">
                <td align="center" style="border-top: 1px solid #ccc; padding: 3px"><p style="font-size:10px;color:#505050; "><b>'.$FechaTimbrado.'</b></p></td>
              </tr>
               <tr align="center">
                <td align="center" style="border-top: 1px solid #ccc; padding: 3px;  background-color:#eae8e8"><p style="font-size:10px; "><b style="color:#2745a4">Fecha de Emisión</b></p></td>                 
              </tr>
              <tr align="center">
                <td align="center" style="border-top: 1px solid #ccc; padding: 3px"><p style="font-size:10px;color:#505050; "><b>'.$fecha.'</p></b></td>
              </tr>

              <tr><td></td></tr>
            </table>            
          </div>           
      </div>

  </div>

    <HR style="height: 3px; background-color: #ccc;">
 
      <div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt; ">

        <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%" >
            <tr>
              <td width="70%" HEIGHT="20" style="background:#eae8e8; border: 0px solid #eae8e8;"><p style="font-size:11px;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">INFORMACIÓN DEL RECEPTOR</b></font></p></td>

              <td bordercolor="#505050" width="31%" HEIGHT="20" style="background:#eceaea;  border-left:2px solid #eae8e8;"  ><center><p style="font-size:11px;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">FOLIO FISCAL</b></font></p></center></td>
            </tr>
        </table>

        <table width="100%; ">
        <tr>
              <td width="69%" >
                 <table width="100%" style="border:0px">
                    <tr>
                       <td>
                           <table width="100%" style="font-size:12px; font-family:Arial; border-collapse: collapse">
                             <tr>
                               <td style="color: #505050"> <b style="color: #505050">Razón Social: </b>'.utf8_encode($r_nombre).'</td>                               
                             </tr> 
                             <tr>
                                <td style="color: #505050"> <b style="color: #505050">RFC: </b>'.$r_rfc.'</td>
                             </tr>
                             <tr>
                                <td style="color: #505050"> <b style="color: #505050">Dirección: </b>'.utf8_encode($r_calle).', '.utf8_encode($r_int).''.utf8_encode($r_ext).'<br>
                                  '.utf8_encode($r_colonia).','.utf8_encode($r_municipio).', <br> 
                                  '.utf8_encode($r_estado).', '.utf8_encode($r_pais).'.
                                </td>
                             </tr>
                             <tr>
                                 <td style="color: #505050"> <b style="color: #505050">C.P.: </b>'.$r_cp.'</td>
                             </tr> 
                             <tr>
                                 <td style="color: #505050"> <b style="color: #505050">Uso CFDI:</b> '.utf8_encode($uso_cfdi).'</td>
                             </tr> 

                           </table>                        
                      </td>
                    </tr>
                 </table>
              </td>

              <td width="31%" >
                 <table width="100%" bordercolor="#505050" style="border-left: 1px; border-left: 2px solid #eae8e8; border-collapse: collapse  ">

                    <tr>

                      <td HEIGHT="20"  style="color: #505050" ><center><p style="font-size:10px; text-align:center"><font style="font-size:10px;">'.$UUID.'</font></p></center></td>
                    </tr>
                    <tr>

                      <td HEIGHT="20"  style="background:#eae8e8;  border: 1px  solid #eae8e8;"><center><p style="font-size:11px;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">No CSD EMISOR</b></font></p></center></td>
                    </tr>
                    <tr>

                      <td HEIGHT="20"  style="color: #505050"><center><p style="font-size:10px; text-align:center"><font style="font-size:10px; ">'.$noCertificado.'</font></p></center></td>
                    </tr>
                    <tr>

                      <td  HEIGHT="20" style="background:#eae8e8;  border: 1px solid #eae8e8;" VALIGN="BOTTOM"><center><p style="font-size:11px;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">No CSD SAT</b></font></p></center></td>
                    </tr>
                    <tr>
                      <td HEIGHT="20" VALIGN="BOTTOM" style="color: #505050"><center><p style="font-size:10px; text-align:center"><font style="font-size:10px;">'.$noCertificadoSAT.'</font></p></center><br></td>
                    </tr>
                    <tr>

                      <td  HEIGHT="20" style="background:#eae8e8;  border: 1px solid #eae8e8;" VALIGN="BOTTOM"><center><p style="font-size:11px;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">Efecto de Comprobante</b></font></p></center></td>
                    </tr>
                    <tr>
                      <td HEIGHT="20" VALIGN="BOTTOM" style="color: #505050"><center><p style="font-size:10px; text-align:center"><font style="font-size:10px;">I Ingreso</font></p></center><br></td>
                    </tr>

                 </table>
              </td>
          </tr>
         </table></div>';
         
        $html =' <div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt; ">  
            <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%">
              <tr>
                 <th  align="center"  style="font-size:10px;color:#2745a4;background:#eae8e8;width: 7%;"><center><b style="color:#2745a4">Clave</b></center></th>

                  <th lign="center"  style="font-size:10px;color:#2745a4;background:#eae8e8;width: 5%;"><center><b style="color:#2745a4">Cant.</b></center></th> 

                  <th align="center" style="font-size:10px;color:#2745a4;background:#eae8e8;width: 15%;"><center><b style="color:#2745a4">Unidad</b></center></th>

                  <th  align="center" style="font-size:10px;color:#2745a4;background:#eae8e8;width: 30%;"><center><b style="color:#2745a4">Descripción</b></center></th>

                  <th align="left"  style="font-size:10px;color:#2745a4;background:#eae8e8;width: 7%;" ><center><b style="color:#2745a4">Valor U.</b></center></th>

                  <th align="center" style="font-size:10px;color:#2745a4;background:#eae8e8;width: 7%;"><center><b style="color:#2745a4">Desc.</b></center></th>

                  <th align="center" colspan="2" style="font-size:10px;color:#2745a4;background:#eae8e8;width: 30%;"><center><b style="color:#2745a4">Impuestos</b></center></th>

                  <th align="center"  style="font-size:10px;color:#2745a4;background:#eae8e8;width: 10%;"><center><b style="color:#2745a4">Importe</b></center></th>
              </tr>
              <tr><td></td></tr>
              '.$html_desc.'
              <tr><td></td></tr>
           </table>
        </div>

        <br>

      <div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt; ">

          <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%" >
            <tr>
              <td width="66%" HEIGHT="20" bordercolor="#505050" style="background:#eae8e8;  border: 1px  solid #eae8e8; "><p style="font-size:11px;color:#2745a4; "><font style="color:#2745a4"><b style="color:#2745a4">INFORMACIÓN COMERCIAL</b></font></p></td>

              <td width="35%" HEIGHT="20" bordercolor="#505050" style="background:#eae8e8; border-left: 2px solid #eae8e8; border-width: 2px "><center><p style="font-size:11px;color:#2745a4; "><font style="color:#2745a4"><b style="color:#2745a4">Importe</b></font></p></center></td>
            </tr>
          </table>        

          <table border=0 style="border: 0px solid #000;" width="100%">
            <tr>
              <td width="65%" >
                <table width="100%" style="font-size:12px; font-family:Arial; border-collapse: collapse">                  
                  <tr>
                     <td style="color: #505050"><b style="color: #505050">Forma de pago: </b>'.$formaDePago.'- '.$descripcion_metodoPago.'</td>
                  </tr>
                  <tr>
                     <td style="color: #505050"><b style="color: #505050">Moneda: </b>'.$TipMoneda.'</td>
                  </tr>
                  <tr>
                    <td style="color: #505050"><b style="color: #505050">Método de Pago: </b>'.$metodoDePago.'</td>
                  </tr>
                  <tr>
                    <td style="color: #505050"><b style="color: #505050">Condición de Pago: </b>'.$condicionesDePago.'</td>
                  </tr>
                  <tr>
                    <td style="color: #505050"><b style="color: #505050">Importe con letra: </b>'.$totalconletra.'</td>
                  </tr>
                </table>
              </td>

              <td width="35%" >
                 <table  width="100%" bordercolor="#505050" style="font-size:12px; border-left: 1px; border-left: 2px solid #eae8e8;">                   
                    <tr>
                      <td style="font-size:11px; color: #505050" align="left">Subtotal</td>
                      <td style="font-size:11px; color: #505050" align="right">$ '.$subtotal.'</td>                      
                      
                    </tr>
                    <tr>
                      '.$iva_aplicado.'
                    </tr>
                    <tr>
                      '.$iva_aplicado2.'
                    </tr>
                    <tr>
                      '.$formato_retencion.'
                    </tr>
                    <tr>
                      '.$formato_retencion2.'
                    </tr>
                    <tr >
                      <td colspan="2">
                        <br><br>
                        <HR width=100% align="center">
                      </td>
                    </tr>
                    <tr >
                      <td style="font-size:11px; color: #505050" align="left">Total</td>                                            
                      <td style="font-size:11px; color: #505050" align="right">$ '.$total.'</td>
                    </tr>                    
                 </table>
              </td>
            </tr>
            </table>
        </div>
        <br>';

        
        $qr='<div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt;  ">

            <table border=0 style="border-collapse: collapse; border-spacing: 3pt;" width="100%">
              <tr>
                <td HEIGHT="20" style="background:#eae8e8;  border: 1px  solid #eae8e8;"><p style="font-size:16pt;color:#2745a4;"><font style="color:#2745a4"><b style="color:#2745a4">CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACIÓN DEL SAT</b></font></p></td>
              </tr>
              <tr>
                <td  width="100%" style="text-align: justify;">
                  <p style="font-size:15pt; color: #505050 ">||'.$tfd_version.'|'.$UUID.'|'.$FechaTimbrado.'|<br>'.substr($selloCFD,0,120).'<br>'.substr($selloCFD,120,120).'<br>'.substr($selloCFD,240,strlen($selloCFD)).'|'.$noCertificadoSAT.'||</p>                  
                </td>
              </tr>                    
           </table>

          </div>          

          <div style="width: 100%; ">
              <div style="width: 18%; border: 0pt solid #9e9e9e; border-radius:3pt; padding: 0pt; float: left; display: inline-block; position: fixed;">
                 '.$ImgQR.'
              </div>

              <div style="width: 81%; border: 0pt solid #9e9e9e; border-radius:3pt; padding: 0pt; float: left; display: inline-block; margin-left:7px; ">
                  
                 <div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt; margin-top:10px; ">

                   <table  width="100%" style=" border-collapse: separate; border-spacing: 3pt; " cellpadding="10" cellspacing="0" >
                    <tr>
                      <td nowrap HEIGHT="50" style="background:#eae8e8; font-size:20pt; margin-left:12pt; margin-top:1pt; margin-right:1pt; margin-bottom: 1pt">
                      <p style="font-size:20pt;color:#2745a4; "><font style="color:#2745a4; font-size:28pt"><b style="color:#2745a4">SELLO DIGITAL DEL CFDI</b></font>
                      </p>
                      </td>
                    </tr>
                    <tr >
                      <td style="font-size:20pt; margin-top:23px;" >
                          <b ><p style="font-size:20pt; color: #505050">'.substr($selloCFD,0,120).'<br>'.substr($selloCFD,120,120).'<br>'.substr($selloCFD,240,strlen($selloCFD)).'</p>
                          </b>
                      </td>                      
                    </tr>
                  </table>

                </div>

                <div style="width: 100%; border: 1pt solid #9e9e9e; border-radius:3pt; padding: 0pt; margin-top:10px">

                   <table width="100%" style=" border-collapse: separate; border-spacing: 3pt;">
                    <tr >
                      <td HEIGHT="50" style="background:#eae8e8;  font-size:20pt"><p style="font-size:20pt;color:#2745a4;"><font style="color:#2745a4; font-size:28pt"><b style="color:#2745a4">SELLO DIGITAL DEL SAT</b></font>
                      </p>
                      </td>
                    </tr>
                     <tr>
                      <td style="font-size:20pt; margin-top:23pt;">
                          <b><p style="font-size:20pt; color: #505050">'.substr($selloSAT,0,120).'<br>'.substr($selloSAT,120,120).'<br>'.substr($selloSAT,240,strlen($selloSAT)).'
                          </p></b>
                      </td>
                    </tr>
                  </table>

                </div>

              </div>

          </div>';


$html = mb_convert_encoding($html,'utf-8','utf8');
$style = mb_convert_encoding($style,'utf-8','utf8');
$cabecera = mb_convert_encoding($cabecera,'utf-8','utf8');
$qr = mb_convert_encoding($qr,'utf-8','utf8');
include("../libs/MPDF/mpdf.php");
// $mpdf=new mPDF('utf-8' , 'A4','', 4, 4, 4, 130, 12, 4);
$mpdf=new mPDF('utf-8' , 'A4','', 4, 4, 4, 93, 12, 4);


$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetFooter('ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   Página {PAGENO} de {nbpg} ');
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($qr);



$mpdf->Output("../comprobantesCfdi/".$folio_fiscal.".pdf");

$mpdf->Output();

}



function num2letras($op,$num, $fem = false, $dec = true) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0];
    $n1=$num[1];
      if ($n == 1 && $n1 == 0) { 
         $t = ' cien' . $t; 
      }elseif ($n == 1 && $n1 > 0) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   $end_num ="";
   //Zi hack --> return ucfirst($tex);

   if($op==1){
      $end_num=ucfirst($tex).' PESOS '.$float[1].'/100 M.N.';
   }else if($op==2){
       // $end_num=ucfirst($tex);
       $end_num=ucfirst($tex).' DOLARES '.$float[1].'/100 USD';
   }

   return $end_num; 
} 
?>
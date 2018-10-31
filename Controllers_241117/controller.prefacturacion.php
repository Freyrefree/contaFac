<?php
set_time_limit(0);
include("../libs/archivos_fac/FacturacionModerna/FacturacionModerna.php");
date_default_timezone_set('America/Mexico_City');

include('../models/model.facturacion.php');
$datos= new factura();

// $id_doc=$_GET['id'];
$folioC=$_POST['folioC'];
$datos->set("folioC",$folioC);
$ans=$datos->buscaFactura();
while($row=mysqli_fetch_array($ans)){
  $id_doc=$row['id'];
}

$uuid = pruebaTimbrado($id_doc, $datos);//funcion para genera el xml


function remplazar($campo){//para reemplazar caracteres especiales &

    $resultado="";
    $cadena_original = $campo;  
    $cadena_buscada1 = '&amp;';
    $cadena_buscada2 = '&';

    $posicion_Con = strpos($cadena_original, $cadena_buscada1);

    if ($posicion_Con !== false) {    
          $resultado = $cadena_original;    
    }else{
         $posicion_Con2 = strpos($cadena_original, $cadena_buscada2);

         if($posicion_Con2 !== false){    
             $resultado = str_replace("&", "&amp;", $cadena_original);//cadena original    
         }else{
            $resultado=$cadena_original;
         }
    }
    return $resultado; 
}



function pruebaTimbrado($id_doc, $datos){
  
  $rfc_emisor="";

  $datos->set("id_doc", addslashes(utf8_decode($id_doc))); //para obtener el rfc del emisor
  $res_emi= $datos->select_rfactura();

  while($row_emi = mysqli_fetch_array($res_emi, MYSQLI_ASSOC)){
     $rfc_emisor=$row_emi["rfc_emisor"];
  }

  $debug = 1;

  $numero_certificado = "";
  $archivo_cer = "";
  $archivo_pem = "";

  $cfdi= generarXML($rfc_emisor,$id_doc, $datos);

  $xdoc = new DomDocument();
  $xdoc->loadXML($cfdi) or die("XML invalido");

  $xdoc->formatOutput = true;
  $xdoc->saveXML();

  $xdoc->save('../tms/'.$id_doc.'.xml');  

  echo $id_doc;
}



function generarXML($rfc_emisor,$id_doc, $datos){
     
  $razon_social="";
  $regimen_fiscal="";
  $cp="";//tomado como lugar de expedicion de la factura

  //para obtener datos del emisor
  $datos->set("rfc", addslashes(utf8_decode($rfc_emisor))); 
  $res= $datos->select_fiscal();

  while($fila_emi = mysqli_fetch_array($res, MYSQLI_ASSOC)){
    $razon_social=$fila_emi["razon_social"];
    $regimen_fiscal=$fila_emi["regimen_fiscal"];

    $cp=$fila_emi["cp"];
  }

  //para obtener el id y rfc del cliente ismael 111117
  //paa obtener datos del receptor
  $id_client="";
  $rfc_cliente="";
 
  $datos->set("id_doc", addslashes(utf8_decode($id_doc)));   
  $res= $datos->select_rfactura();

  while($fila_f = mysqli_fetch_array($res, MYSQLI_ASSOC)){
    $id_client=$fila_f["idCliente"];
    $rfc_cliente=$fila_f["rfc_receptor"];
  }


   //para obtener datos del cliente
   
  $nombre_cliente="";
  
  $tax_id="";
  $u_usocfdi="";

  $datos->set("id", addslashes(utf8_decode($id_client)));
  $datos->set("rfc", addslashes(utf8_decode($rfc_cliente)));   
  $resCl= $datos->select_cliente();

  while($rowC = mysqli_fetch_array($resCl, MYSQLI_ASSOC)){ 
       $nombre_cliente=$rowC["razon_social"];
       $rfc_cliente=$rowC["rfc"];

       $u_usocfdi=$rowC["c_usocfdi"];
       // $tax_id=$rowC["tax_id"];//campo opcional
  }

   
   
$rfc_receptor=remplazar($rfc_cliente);
$rfc_receptor=$rfc_receptor;

$nombre_receptor2=remplazar($nombre_cliente);    
$nombre_receptor=$nombre_receptor2; 



//========================================================================================
    
  

  $r_concepto = "";
  $ImpuestosRetenidos = 0.00;
  $retencion = null;
  $Traslado = null;

  $tipoDeComprobante="";
  $tipo_documento="";

  $Serie="";
  $Folio="";


  $datos->set("id_doc", addslashes(utf8_decode($id_doc)));   
  $res= $datos->select_rfactura();

  while($fila_fact = mysqli_fetch_array($res, MYSQLI_ASSOC)){
    $tipo_documento=$fila_fact["tipo_documento"];
    
  }

  $tipoDeComprobante = 'TipoDeComprobante="'.$tipo_documento.'"'; //tipo de comprobante

  $ff="";
  $ss2= "";
  $ff2="";  
  $totF=0;


  $ss= ""; //serie
  $f="";  //folio
  

  //para saber cunatos timpos de documentos hay y poner el folio y serie  correspondinte
  $datos->set("tipo_documento", addslashes(utf8_decode($tipo_documento)));   
  $res_s= $datos->select_serializacion();

  if($res_s) {
      while($rowF = mysqli_fetch_array($res_s, MYSQLI_ASSOC)){ 
         $totF=$rowF["Total"];
      }
  }

  if($totF==0) {
    // $f=1;
    $f_serie="";
    $f_folio="";

    $datos->set("tipo_documento", addslashes(utf8_decode($tipo_documento)));   
    $res_se= $datos->select_serie_folio();

    if($res_se) {
      while($rowF2 = mysqli_fetch_array($res_se, MYSQLI_ASSOC)){ 
        $f_serie=$rowF2["serie"];
        $f_folio=$rowF2["folio"];
      }
    }
    
    //para saber que serie y folio tomar cuando no hay datos aun con serie
    if($f_serie==""){
      $ss=$tipo_documento;
    }else{
      $ss=$f_serie;
    }

    if($f_folio==""){
      $f=1;
    }else{
      $f=$f_folio;
    }   

  }else{//traer serie y folio en el cual van
    
    $t_se="";
    $datos->set("tipo_documento", addslashes(utf8_decode($tipo_documento)));   
    $res_se2= $datos->select_serie_folio();

    if($res_se2) {
      while($rowF2 = mysqli_fetch_array($res_se2, MYSQLI_ASSOC)){ 
        $t_se=$rowF2["serie"];
        $ss=$t_se;
      }
    }


    $datos->set("tipo_serie", addslashes(utf8_decode($t_se)));   
    $res_se3= $datos->select_folio();

    if($res_se3) {
      while($rowF3 = mysqli_fetch_array($res_se3, MYSQLI_ASSOC)){ 
        // $f_serie=$rowF3["serie"];
        $f=$rowF3["folio"];
        $f=$f+1; 
      }
    }
  }


  $ss2= $ss;
  $ff2=$f;

  if(isset($ss2)){
      $Serie='Serie="'.$ss2.'"';
  }else{
    $Serie="";
  }
  if(isset($ff2)){
    $Folio='Folio="'.$ff2.'"';
  }else{
    $Folio="";
  }

  $fecha_actual = substr( date('c'), 0, 19);//fecha que aparecera en la factura

  $subtotal=0.00;
  $iva= 0.00;
  $total=0.00;

  $Moneda="";//divisa
  $TipoCambio="";//mexicana es 1.000000
 
  $formaDePago="";//PAGO EN UNA SOLA EXHIBICION
  $condicionesDePago="";
  $metodoDePago="";//03
  $metodoDePago2="";//03
  $servicios_f="";

  $m="";

  
  $uso_cfdi=$u_usocfdi;//checar si coincide

  //====================================================================================
  $datos->set("id_doc", addslashes(utf8_decode($id_doc)));   
  $resD= $datos->select_rfactura();

  while($rowD = mysqli_fetch_array($resD, MYSQLI_ASSOC)){
    $formaDePago =$rowD['forma'];
    $condicionesDePago=$rowD['condicionPago'];
    $metodoDePago=$rowD['metodo'];
    // $uso_cfdi2=$rowD['usocfdi'];
    $Moneda='Moneda="'.$rowD['moneda'].'"';

    if($rowD['moneda']=="MXN"){
      $TipoCambio="";
    }

  }

  if(isset($condicionesDePago)){
    $condicionesDePago='CondicionesDePago="'.$condicionesDePago.'"';
    $condicionesDePago = $condicionesDePago;
  }else{
    $condicionesDePago="";
  }
   
    // $queryDatos2="SELECT * FROM llx_metodopago_sat WHERE rowid = '$metodoDePago2' "; 
    // $res2=mysqli_query($conn, $queryDatos
    // 2);

    // if ($res2) {
    //   while($rowD2 = mysqli_fetch_array($res2, MYSQLI_ASSOC)){ 
    //        $metodoDePago =$rowD2['c_metodopago'];

    //     }
    // } 

    // //nuevo modificado para facturacion 3.3. ismael 231017

    // $queryDatos2f="SELECT * FROM llx_formapago_sat WHERE rowid = '$formaDePago2' "; 
    // $res2f=mysqli_query($conn, $queryDatos2f);

    // if ($res2f) {
    //   while($rowD2f = mysqli_fetch_array($res2f, MYSQLI_ASSOC)){ 
    //        $formaDePago =$rowD2f['c_formapago'];

    //     }
    // } 


   //NUEVO AGREAGDO ISMAEL 231017 FACTURACION 3.3 
    // $queryDatos3f="SELECT * FROM llx_usocfdi WHERE rowid = '$uso_cfdi2' "; 
    // $res3f=mysqli_query($conn, $queryDatos3f);

    // if ($res3f) {
    //   while($rowD3f = mysqli_fetch_array($res3f, MYSQLI_ASSOC)){ 
    //        $uso_cfdi =$rowD3f['uso_cfdi'];
    //     }
    // } 

   
   
  $conceptos=" ";   //almacena la estructura de los conceptos cuando se arman

  //almacena los total de los importes de 16, 4, 0
  $importe16 =0.00;
  $importe4 =0.00;
  $importe0 =0.00;

  $importe  =0.00;//nuevo agregado para el importe total del iva

  ///total de la factura
  $subtotal=0.00;
  /// subtotan de la factura
  $total_factura=0.00;


  $bandera_tasa16=0;
  $bandera_tasa4=0;



  $datos->set("id_doc", addslashes(utf8_decode($id_doc)));   
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
        
        $subtotal= $subtotal + $importe_total;


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

          //////////
          // tipo_traslado
          // t_factor_t
          // varlor_tc_traslado

          // importe_translado
          
          // tipo_retencion
          // t_factor_r
          // varlor_tc_retencion
          
          // importe_retencion

      
        //===============para los traslados
           if($varlor_tc_traslado == 16){

             $tasaocuota="0.160000";
             $importe_nodo="";
   
             $importe = $importe + (($importe_total*16)/100); //modificado ismael 160517
             $importe16 = $importe16 + (($importe_total*16)/100);
             $retencioniva  =   (($importe_total*16)/100); 

             $importe_nodo=(($importe_total*16)/100);//nuevo agreagdo ismael 231017

             $bandera_tasa16=1;   
           }

           if($varlor_tc_traslado == 4){

             $importe_nodo="";
             $tasaocuota="0.040000";
             $importe = $importe + (($importe_total*4)/100); 
             $importe4 =  $importe4 + (($importe_total*4)/100); 
             $retencioniva  =   (($importe_total*4)/100);

             $importe_nodo=(($importe_total*4)/100);//nuevo agreagdo ismael 231017

             $bandera_tasa4=1;       
           }

           if($varlor_tc_traslado <> 4 && $varlor_tc_traslado <> 16)//nuevo ingresado facturacion 3.3.
           {
             $tasaocuota="0.000000";
           }



         //====================================par la retencion
          
          if($varlor_tc_retencion == 4)
          {
            $tasaocuota_r="0.040000";//nuevo agragdo ismael 231017 facturacion 3.3. 
            $ImpuestosRetenidos = $ImpuestosRetenidos + ($retencioniva*.25); 

            $importe_nodo_r=$retencioniva*.25; //nuevo agragdo ismael 231017 facturacion 3.3.          
            $retencioniva=0.00;
          }   
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
    
         $importe_total=$valor_unitario * $cantidad;
        if(($importe_nodo==0 && $importe_nodo_r==0) || ($importe_nodo=="" && $importe_nodo_r=="")) {
           $conceptos .= '<cfdi:Concepto ClaveProdServ="'.$clave_sat.'" NoIdentificacion="'.$num_identificacion.'" Cantidad="'.$cantidad.'" ClaveUnidad="'.$clave_unidad.'" Unidad="'.$clave_unidad.'" Descripcion="'.$p_descripcion_sat.'" ValorUnitario="'.$valor_unitario.'"  Importe="'.$importe_total.'" Descuento="'.$descuento.'">
           </cfdi:Concepto>';
        }

        if($importe_nodo>0 && ($importe_nodo_r=="" || $importe_nodo_r==0)){
          $conceptos .= '<cfdi:Concepto ClaveProdServ="'.$clave_sat.'" NoIdentificacion="'.$num_identificacion.'" Cantidad="'.$cantidad.'" ClaveUnidad="'.$clave_unidad.'" Unidad="'.$clave_unidad.'" Descripcion="'.$p_descripcion_sat.'" ValorUnitario="'.$valor_unitario.'"  Importe="'.$importe_total.'" Descuento="'.$descuento.'">
            <cfdi:Impuestos>
              <cfdi:Traslados>
                <cfdi:Traslado Base="'.$importe_total.'" Impuesto="'.$tipo_traslado.'" TipoFactor="'.$t_factor_t.'"  TasaOCuota="'.$tasaocuota.'" Importe="'.$importe_nodo.'" />
              </cfdi:Traslados>            
            </cfdi:Impuestos>
          </cfdi:Concepto>';
        
        }

        if($importe_nodo_r>0 && ($importe_nodo=="" || $importe_nodo==0)){
          $conceptos .= '<cfdi:Concepto ClaveProdServ="'.$clave_sat.'" NoIdentificacion="'.$num_identificacion.'" Cantidad="'.$cantidad.'" ClaveUnidad="'.$clave_unidad.'" Unidad="'.$clave_unidad.'" Descripcion="'.$p_descripcion_sat.'" ValorUnitario="'.$valor_unitario.'"  Importe="'.$importe_total.'" Descuento="'.$descuento.'">
            <cfdi:Impuestos>              
              <cfdi:Retenciones>
                <cfdi:Retencion Base="'.$importe_total.'" Impuesto="'.$tipo_retencion.'" TipoFactor="'.$t_factor_r.'" TasaOCuota="'.$tasaocuota_r.'" Importe="'.$importe_nodo_r.'" />
              </cfdi:Retenciones>
            </cfdi:Impuestos>
          </cfdi:Concepto>';
        
        }

        if($importe_nodo_r>0 && $importe_nodo>0){
          $conceptos .= '<cfdi:Concepto ClaveProdServ="'.$clave_sat.'" NoIdentificacion="'.$num_identificacion.'" Cantidad="'.$cantidad.'" ClaveUnidad="'.$clave_unidad.'" Unidad="'.$clave_unidad.'" Descripcion="'.$p_descripcion_sat.'" ValorUnitario="'.$valor_unitario.'"  Importe="'.$importe_total.'" Descuento="'.$descuento.'">
            <cfdi:Impuestos>
              <cfdi:Traslados>
                <cfdi:Traslado Base="'.$importe_total.'" Impuesto="'.$tipo_traslado.'" TipoFactor="'.$t_factor_t.'"  TasaOCuota="'.$tasaocuota.'" Importe="'.$importe_nodo.'" />
              </cfdi:Traslados>
              <cfdi:Retenciones>
                <cfdi:Retencion Base="'.$importe_total.'" Impuesto="'.$tipo_retencion.'" TipoFactor="'.$t_factor_r.'" TasaOCuota="'.$tasaocuota_r.'" Importe="'.$importe_nodo_r.'" />
              </cfdi:Retenciones>
            </cfdi:Impuestos>
          </cfdi:Concepto>';        
        }




  } ///para la parte de conceptos

  $iva=$importe;//toma el valor total del iva


  $impuesto = "002";
  $tasa="0.00";
  $translados="";//nuevo agrgado ismael
  $translados2="";//nuevo agrgado ismael


  if($importe > 0){

    $translados="<cfdi:Traslados>";

   if($bandera_tasa4 == 1){
         $tasa = "0.040000";
         $importe4 = $importe4; //este dato cambia 
         $importe4 =number_format($importe4, 2, '.', '');       
         $Traslado .='<cfdi:Traslado Impuesto="'.$impuesto.'" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.$importe4.'"></cfdi:Traslado>';

    }
    if($bandera_tasa16 == 1){

       $tasa = "0.160000";

       $importe16 = $importe16;  //este dato cambia 
       $importe16 =number_format($importe16, 2, '.', '');       
       $Traslado .='<cfdi:Traslado Impuesto="'.$impuesto.'" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.$importe16.'"></cfdi:Traslado>';
    }

   $translados2="</cfdi:Traslados>";

  }else{
    $translados="";
    $translados2="";
    $Traslado="";
   // $importe = "0.00";
   // $tasa = "0.00";
   // $Traslado .='<cfdi:Traslado Impuesto="'.$impuesto.'" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.$importe.'"></cfdi:Traslado>';
  }

// <!-- $cfdi = <<<XML
// < ?xml version="1.0" encoding="UTF-8"? >
// <!-- // <cfdi:Comprobante  xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" Version="3.3" $Serie $Folio Fecha="$fecha_actual" Sello="" FormaPago="$formaDePago" NoCertificado="" Certificado="" SubTotal="$subtotal" Total="$total" $tipoDeComprobante MetodoPago="$metodoDePago" $condicionesDePago LugarExpedicion="$cp" $TipoCambio $Moneda Descuento="0.00"> -->
// <!-- // <cfdi:Emisor Rfc="$rfc_emisor" Nombre="$razon_social" RegimenFiscal="$regimen_fiscal"/> -->
// <!-- // <cfdi:Receptor Rfc="$rfc_receptor" Nombre="$nombre_receptor" UsoCFDI="$uso_cfdi"/> -->
// <!-- // <cfdi:Conceptos> -->
// <!-- //   $conceptos -->
// <!-- // </cfdi:Conceptos> -->
// <!-- // <cfdi:Impuestos TotalImpuestosRetenidos="$ImpuestosRetenidos" TotalImpuestosTrasladados="$iva"> -->
// <!-- //   $retencion        -->
// <!-- // <cfdi:Traslados>   -->
// <!-- //   $Traslado -->
// <!-- // </cfdi:Traslados> -->
// <!-- // </cfdi:Impuestos> -->
// <!-- // </cfdi:Comprobante> -->
// <!-- // XML; -->
// <!-- //  --> 

  $r_concepto = "002";

  if($ImpuestosRetenidos > 0){

    $ImpuestosRetenidos = $ImpuestosRetenidos;
    $ImpuestosRetenidos =number_format($ImpuestosRetenidos, 2, '.', '');

    $retencion = '<cfdi:Retenciones><cfdi:Retencion Impuesto="'.$r_concepto.'" Importe="'.$ImpuestosRetenidos.'"/></cfdi:Retenciones>';

  }else{
    // $ImpuestosRetenidos = "0.00";

    // $retencion = '<cfdi:Retenciones><cfdi:Retencion Impuesto="'.$r_concepto.'" Importe="'.$ImpuestosRetenidos.'"/></cfdi:Retenciones>';
     $retencion = '';
  }     



  $total2= $subtotal + $iva;
  $total=($total2-$ImpuestosRetenidos);

  $iva =number_format($iva, 2, '.', '');

    // if ($Traslado == "") {
    //   $Traslado .='<cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.00" Importe="0.00"/>';;        
    // }
    
       
    $subtotal =number_format($subtotal, 2, '.', ''); 
    $total =number_format($total, 2, '.', ''); 


$cfdi = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante  xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" Version="3.3" $Serie $Folio Fecha="$fecha_actual" Sello="" FormaPago="$formaDePago" NoCertificado="" Certificado="" SubTotal="$subtotal" Total="$total" $tipoDeComprobante MetodoPago="$metodoDePago" $condicionesDePago LugarExpedicion="$cp" $TipoCambio $Moneda Descuento="0.00">
<cfdi:Emisor Rfc="$rfc_emisor" Nombre="$razon_social" RegimenFiscal="$regimen_fiscal"/>
<cfdi:Receptor Rfc="$rfc_receptor" Nombre="$nombre_receptor" UsoCFDI="$uso_cfdi"/>
<cfdi:Conceptos>
  $conceptos
</cfdi:Conceptos>
<cfdi:Impuestos TotalImpuestosRetenidos="$ImpuestosRetenidos" TotalImpuestosTrasladados="$iva">
  $translados
  $Traslado
  $translados2
  $retencion 
</cfdi:Impuestos>
</cfdi:Comprobante>
XML;

$cfdi = utf8_encode($cfdi);

return $cfdi;

}//geneara xml



?>


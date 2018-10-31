<?php
set_time_limit(0);
date_default_timezone_set('America/Mexico_City');

include('../models/model.pagos.php');
$datos= new pagos();

$rowid = $_POST['id'];//contiene los id o ids
$gener=genera_pdf2($rowid, $datos);
echo $rowid;


function genera_pdf2($id, $datos){
 
  $id_oper=0;
  $tt_o="";

  $b=0;
  $archivador2="";

  $dato_bl="";

 
  //modificado ismael 271117
  $ids_r = substr($id, 0, -1);
  $row_list = explode(",", $ids_r);

  foreach ($row_list as $row_num) {

     $datos->set("id_doc", addslashes(utf8_decode($row_num))); //para obtener el rfc del emisor
     $res_emi= $datos->select_hispago();
  }
  ///


  $rfc_emisor="";
  $rfc_receptor="";
  $id_cliente="";

  while($row_emi = mysqli_fetch_array($res_emi, MYSQLI_ASSOC)){
    $rfc_emisor=$row_emi["rfc_emisor"];

    $rfc_receptor=$row_emi["rfc_receptor"];
    $id_cliente=$row_emi["idCliente"];
  }

  $id=trim($id);
  $ids = str_replace(",","-",$id);
  $archivador2="../tms/pre_pago".$ids.".xml"; 

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

   
    $datos->set("id", addslashes(utf8_decode($id_cliente)));
    $datos->set("rfc", addslashes(utf8_decode($rfc_receptor)));   
    $resCl= $datos->select_cliente();

    while($rowC = mysqli_fetch_array($resCl, MYSQLI_ASSOC)){ 
      
      $r_razon_social= $rowC["razon_social"];
      
      $r_pais = $rowC["pais"]; 

      $datos->set("id_pais", addslashes(utf8_decode($r_pais)));   
      $res_pl= $datos->select_pais();

      while($rowp = mysqli_fetch_array($res_pl, MYSQLI_ASSOC)){ 
         $r_pais =utf8_encode($rowp["c_nombre"]);
      }
      
      $r_estado = $rowC["estado"]; 

      $datos->set("id_estado", addslashes(utf8_decode($r_estado)));   
      $res_es= $datos->select_estados();

      while($rowe = mysqli_fetch_array($res_es, MYSQLI_ASSOC)){ 
         $r_estado =utf8_encode($rowe["c_nombre_estado"]);
      }

      $r_municipio = $rowC["municipio"];

      $datos->set("id_mun", addslashes(utf8_decode($r_municipio)));   
      $res_m= $datos->select_municipio();

      while($rowm= mysqli_fetch_array($res_m, MYSQLI_ASSOC)){ 
         $r_municipio =utf8_encode($rowm["c_nombre_municipio"]);
      }

      $r_colonia = $rowC["colonia"]; 

      $datos->set("id_colonia", addslashes(utf8_decode($r_colonia)));   
      $res_c= $datos->select_colonia();

      while($row_c= mysqli_fetch_array($res_c, MYSQLI_ASSOC)){ 
         $r_colonia =utf8_encode($row_c["c_nombre_colonia"]);
      }


      $r_calle = $rowC["calle"]; 
      $r_int = $rowC["ninterior"]; 
      $r_ext = $rowC["nexterior"]; 


      $r_cp = $rowC["cp"]; 


      $datos->set("id_cp", addslashes(utf8_decode($r_cp)));   
      $res_cp= $datos->select_cp();

      while($row_c= mysqli_fetch_array($res_cp, MYSQLI_ASSOC)){ 
         $r_cp =utf8_encode($row_c["c_cp"]);
      }

      $r_usocfdi = $rowC["c_usocfdi"]; 
      $datos->set("id_uso", addslashes(utf8_decode($r_usocfdi)));   
      $res_cf= $datos->select_usocfdi();

      while($row_cf= mysqli_fetch_array($res_cf, MYSQLI_ASSOC)){ 
         $r_usocfdi =utf8_encode($row_cf["c_UsoCFDI"]);
      }    

    }

     $r_usocfdi='P01';

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

//===== otros datos ismael 121117


//=========para leer el xml version 3.3

$xml = simplexml_load_file($archivador2); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
// $xml->registerXPathNamespace('t', $ns['tfd']);

 $TipMoneda="";
 $serie="";
 $folio="";
 $TipoCambio="";


 $condicionesDePago="";

 $NumCtaPago="";//agregado ismael 160517
 

$factura_fin="";
$f_fact="";
$s_fact="";

//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
    $fecha_f = $cfdiComprobante['Fecha'];
    $f_fact=$cfdiComprobante['Folio'];
    $s_fact=$cfdiComprobante['Serie'];
}

$factura_fin=$s_fact.$f_fact;
$fecha_expedicion=$fecha_f;//agregado ismae 311017

 

$factura_fin=$s_fact.$f_fact;

//==============para los conceptos

   

$divisa="";
$importe_pago_original="";
$importe_pago="";

$metodo_pago_f="";


//===========================================================modificado ismael 271117
$ids_r = substr($id, 0, -1);
$row_list = explode(",", $ids_r);
  
$cuenta_banco="";
$nombre_banco_r="";
$cuenta_banco_d="";

$html_desc_pago="";//nuevo agregrado ismael 271117
foreach ($row_list as $row_num) {

     $datos->set("id_pago", addslashes(utf8_decode($row_num))); 
     $rr= $datos->select_complemento();
   
    // $datos->set("id_doc", addslashes(utf8_decode($id))); 
    // $rr= $datos->select_complemento2();

    if ($rr) {
        while($row3 = mysqli_fetch_array($rr, MYSQLI_ASSOC)) { 

            $total_factura=$row3['importe_total'];
            $saldo_pendiente=$row3['importe_restante'];
            $monto_pagado=$row3['importe_pagado'];

            if ($total_factura>0) {
               $total_factura=number_format($total_factura,2,".",",");
            }else{
              $total_factura=$total_factura;
            }

            if ($saldo_pendiente>0) {
               $saldo_pendiente=number_format($saldo_pendiente,2,".",",");
            }else{
              $saldo_pendiente=$saldo_pendiente;
            }

            if ($monto_pagado>0) {
               $monto_pagado=number_format($monto_pagado,2,".",",");
            }else{
              $monto_pagado=$monto_pagado;
            }

            

          $datos->set("id_doc", addslashes(utf8_decode($row_num))); //para obtener el rfc del emisor
          $resqlal= $datos->select_hispago();

          if ($resqlal) {
            while($rowAl = mysqli_fetch_array($resqlal, MYSQLI_ASSOC)) 
            {
               $factura=$rowAl['serie'].$rowAl['folio'];

               $metodo_pago_f= $rowAl['metodo'];
            }
          }

          $folio=$factura;
         

           $num_pago= $row3['no_parcialidad'];
           
           $fecha_pago= $row3['fecha_pago'];
           // $fecha_pago = date_create($fecha_pago);
           // $fecha_pago = date_format($fecha_pago, 'Y-m-d');

            $numero_operacion=$row3['num_operacion'];
            

            // $id_cuenta_receptor=$row3['id_cuenta_receptor'];
            // $id_cuenta_emisor=$row3['id_cuenta_emisor'];
             $id_cuenta_emisor=$row3['id_cuenta_receptor'];
            $id_cuenta_receptor=$row3['id_cuenta_emisor'];

            $datos->set("id_cuenta_receptor", addslashes(utf8_decode($id_cuenta_receptor))); //para obtener el rfc del emisor
            $resqlal= $datos->select_cuenta_re();

            if ($resqlal) {
              while($rowAl = mysqli_fetch_array($resqlal, MYSQLI_ASSOC)) 
              {
                $cuenta_banco=$rowAl['num_cuenta']; 
                $nombre_banco_r=$rowAl['nombre_banco']; 
              }
            }


            $datos->set("id_cuenta_emisor", addslashes(utf8_decode($id_cuenta_emisor))); //para obtener el rfc del emisor
            $resqlal2= $datos->select_cuenta_emi();

            if ($resqlal2) {
              while($rowAl = mysqli_fetch_array($resqlal2, MYSQLI_ASSOC)) 
              {
                 $cuenta_banco_d=$rowAl["nombre_banco"]." - ".$rowAl["num_cuenta"];
              }
            }
           

            $importe_pago=$row3['importe_pagado'];
            $importe_pago_original=$row3['importe_pagado'];

           
            if ($importe_pago>0) {
               $importe_pago=number_format($importe_pago,2,".",",");
            }else{
              $importe_pago=$importe_pago;
            }

            $divisa=$row3['moneda'];
            $forma_pago= $row3['forma_pago'];
        }       
    }//fin $rr==========


    $op=0;
    if ($divisa=='MXN') {
      $op=1;
    }
    if ($divisa=='USD') {
      $op=2;
    }

    if ($importe_pago_original>0) {
      $importe_pago_original=number_format($importe_pago_original,2,".","");
    }else{
      $importe_pago_original=$importe_pago_original;
    }

    $formato_pesos="";

    $formato_pesos=strtoupper(num2letras($op, $importe_pago_original)); 


    if($forma_pago=='01'){
      $descripcion_metodoPago = 'Efectivo';
      }elseif($forma_pago=='02'){
      $descripcion_metodoPago = 'Cheque nominativo';
      }elseif($forma_pago=='03'){
      $descripcion_metodoPago = 'Transferencia electrónica de fondos';
      }elseif($forma_pago=='04'){
      $descripcion_metodoPago = 'Tarjeta de Crédito';
      }elseif($forma_pago=='05'){
      $descripcion_metodoPago = 'Monedero Electrónico';
      }elseif($forma_pago=='06'){
      $descripcion_metodoPago = 'Dinero Electrónico';
      }elseif($forma_pago=='08'){
      $descripcion_metodoPago = 'Vales de despensa';
      }elseif($forma_pago=='12'){
      $descripcion_metodoPago = 'Dación en pago';
      }elseif($forma_pago=='13'){
      $descripcion_metodoPago = 'Pago por subrogación';
      }elseif($forma_pago=='14'){
      $descripcion_metodoPago = 'Pago por consignación';
      }elseif($forma_pago=='15'){
      $descripcion_metodoPago = 'Condonación';
      }elseif($forma_pago=='17'){
      $descripcion_metodoPago = 'Compensación';
      }elseif($forma_pago=='23'){
      $descripcion_metodoPago = 'Novación';
      }elseif($forma_pago=='24'){
      $descripcion_metodoPago = 'Confusión';
      }elseif($forma_pago=='25'){
      $descripcion_metodoPago = 'Remisión de deuda';
      }elseif($forma_pago=='26'){
      $descripcion_metodoPago = 'Prescripción o caducidad';
      }elseif($forma_pago=='27'){
      $descripcion_metodoPago = 'A satisfacción del acreedor';
      }elseif($forma_pago=='28'){
      $descripcion_metodoPago = 'Tarjeta de Débito';
      }elseif($forma_pago=='29'){
      $descripcion_metodoPago = 'Tarjeta de Servicio';
      }elseif($forma_pago=='30'){
      $descripcion_metodoPago = 'Aplicación de anticipos';
      }elseif($forma_pago=='99'){
      $descripcion_metodoPago = 'Por Definir';
      }elseif($forma_pago=='NA'){
       // $descripcion_metodoPago = 'N/A';
      }


      $forma_pago= $forma_pago." - ".$descripcion_metodoPago;

      ///nuevo modificado ismael 271117
    //para los totales finales
    $html_desc_pago .= '<tr>';
    $html_desc_pago .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$num_pago.'</td>';
    $html_desc_pago .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$fecha_pago.'</td>';
    $html_desc_pago .= '<td HEIGHT="" align="left" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$forma_pago.'</td>';
    $html_desc_pago .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc; border-right: 1px solid #ccc; ">'.$divisa.'</td>'; 
    $html_desc_pago .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc; border-right: 1px solid #ccc; ">$ '.$importe_pago.'</td>'; 

     // $html_desc_pago .='
     //      <tr>
     //       <td HEIGHT="20" width="10%" align="left"  colspan="1" style="font-size:12px;color:#000000; border: 1px solid #ccc; ">Cantidad con Letra

     //        </td>
     //        <td HEIGHT="20" width="10%" align="center"  colspan="3" style="font-size:12px;color:#000000; border: 1px solid #ccc; ">
     //        '.$formato_pesos.'

     //        </td>
     //      </tr><tr><td HEIGHT="20" colspan="5" style="font-size:12px;color:#000000; border: 1px solid #ccc; "></td></tr>';


}//fin foreach ismael 271117

$html_desc_pago .= '</tr>';



//////////////////////////////////////////////////////////////////////////////////
// $proD= "DELETE FROM llx_hist_pagos WHERE rowid= '".$id."' ";
// $rrD=$db->query($proD);

//////////////////////////////////////////////////////////////////////////////////
//para el total a cobrar
$html_desc="";
//para los totales finales// se queda igual ismael 27117
$html_desc .= '<tr>';
$html_desc .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">84111506</td>';
$html_desc .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">1</td>';
$html_desc .= '<td HEIGHT="" align="left" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">Pago</td>';
$html_desc .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">ACT</td>';
$html_desc .= '<td HEIGHT="" align="center" style="font-size:12px; border-top: 1px solid #ccc; border-right: 1px solid #ccc; ">$ 0.00</td>';   
$html_desc .= '</tr>';



//////////////////////////////////////////////////////////////////////////////////////


// foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $ImpuestosTrasladados){ //COMENTADO 271117


//========================para consultar si es la misma factura o tiene varias
// $ids_r = substr($id, 0, -1);
// $row_list = explode(",", $ids_r);
  
// $html_desc_pago="";//nuevo agregrado ismael 271117
// foreach ($row_list as $row_num) {

//   $datos->set("id_doc", addslashes(utf8_decode($row_num))); 
//   $rr= $datos->select_complemento2();

//   if($rrf){
//     while($rowf = mysqli_fetch_array($rrf, MYSQLI_ASSOC)) { 
    
//     }
//   }  
// }

$uuid="";
$metodo_pago="";
$moneda_f="";

// $total_factura="";
$monto_pagado="";

$html_desc_debe="";
$uuid_original="";
$ba=0;
$total_factura=0;
$folio=0;
$saldo_pendiente=0;

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//pago10:Pagos//pago10:Pago//pago10:DoctoRelacionado') as $cfdiRelacionado){ 

      $uuid=$cfdiRelacionado['IdDocumento'];

      $metodo_pago_f=$cfdiRelacionado['MetodoDePagoDR'];
      $moneda_f=$cfdiRelacionado['MonedaDR'];
   
      // $saldo_pendiente=$cfdiRelacionado['ImpSaldoInsoluto'];
      // $monto_pagado=$cfdiRelacionado['ImpPagado'];
      
      $datos->set("uuid", addslashes(utf8_decode($uuid))); 
      $rrf= $datos->select_fac();
      if($rrf){
        while($rowf = mysqli_fetch_array($rrf, MYSQLI_ASSOC)) { 

             $id_pago="";
             $folio="";
             $id_pago=$rowf["id"];   
             $folio=$rowf["serie"].$rowf["folio"];  

             $total_factura=$rowf["total"];   

              if ($total_factura>0) {
                $total_factura=number_format($total_factura,2,".","");
              }else{
                $total_factura=$total_factura;
              }

              $datos->set("id_doc", addslashes(utf8_decode($id_pago))); 
              $rr2= $datos->select_complemento_pendiente();
              $saldo_pendiente=$rr2;
                
        } //fin while        
      } // fin if($rrf){  
}


//para los totales finales
$html_desc_debe .= '<tr>';
$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$uuid.'</td>';

$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$folio.'</td>';

$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$metodo_pago_f.'</td>';

$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">'.$moneda_f.'</td>';

$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc;  border-right: 1px solid #ccc;  ">$ '.$total_factura.'</td>';
$html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc; border-right: 1px solid #ccc; ">$ '.$saldo_pendiente.'</td>'; 
// $html_desc_debe .= '<td HEIGHT="" align="center" style="font-size:11px; border-top: 1px solid #ccc; border-right: 1px solid #ccc; ">$ '.$monto_pagado.'</td>';   

$html_desc_debe .= '</tr>';




///utf8
// $r_colonia= strtr(strtoupper(utf8_encode($r_colonia)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");

$e_razon_social=strtr(strtoupper(utf8_encode($e_razon_social)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_calle= strtr(strtoupper(utf8_encode($e_calle)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_colonia= strtr(strtoupper(utf8_encode($e_colonia)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_municipio= strtr(strtoupper(utf8_encode($e_municipio)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_estado= strtr(strtoupper(utf8_encode($e_estado)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$e_pais= strtr(strtoupper(utf8_encode($e_pais)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$rfc_emisor= strtr(strtoupper(utf8_encode($rfc_emisor)), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
///
$r_municipio= strtr(strtoupper($r_municipio), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$r_estado= strtr(strtoupper($r_estado), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$r_pais= strtr(strtoupper($r_pais), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
$r_colonia= strtr(strtoupper($r_colonia), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");

//fin para contidades totales


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
if($rfc_emisor == "RAOE8912182H5")
{
$showlogo = '<img src="'.$logo_e.'" width="120px;" border=0>';
}
else{
  $showlogo = "";
}
$cabecera = '

  <div style="width: 100%;  border-bottom: 0px solid #ccc;">

       <div style="width: 70%; border: 0px solid #ccc; border-radius:2pt; padding: 0pt; float: left;">
         <table style="border: 0px solid #000; border-collapse: collapse" width="100%" >
          <tr>
            <td align="center">
            '.$showlogo.'
            </td>        
            <td>
              <div style="font-size:10px; color: #505050">
                <p style="font-size:12px"><b style="color: #505050">&nbsp;'.$e_razon_social.'</b><p>
                <p>&nbsp;'.$e_calle.', No. Ext. '.$e_ext.', No. Int. '.$e_int.'</p>
                <p>&nbsp;Col. '.$e_colonia.',</p>
                <p>&nbsp;'.$e_municipio.', '.$e_estado.',</p>
                <p>&nbsp;C.P. '.$e_cp.', '.$e_pais.'</p>
                <p>&nbsp;RFC: <b style="color: #505050">'.$rfc_emisor.'</b></p>
                <p>&nbsp;Regímen Fiscal: '.$e_regimen_fiscal.'</p>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <div style="width: 25%; border: 0px solid #ccc; border-radius:2pt; padding: 0pt; float: right;"> 
          <div style="border: 1px solid #ccc; border-radius:2pt; width: 100%; border-collapse: collapse" >
            <table width="100%" style="border-collapse: collapse">
              <tr style="background-color: #ccc;">
                <td align="center">  
                     <p style="font-size:14px; "><b style="color:#000000">Recibo de Pagos</b></p>      
                </td>
              </tr>
             
              <tr>
                <td align="center" style=" padding: 3px">  
                     <p style="font-size:14px; "><b style="color:#000000">'.$factura_fin.'</b></p>      
                </td>
              </tr>

              <tr><td><br></td></tr>
               <tr align="center">
                <td style="border-top: 1px solid #ccc; padding: 3px">  
                     <p style="font-size:12px; "><b style="color:#000000">'.$fecha_expedicion.'</b></p>      
                </td>
              </tr>
              <tr><td></td></tr>
            </table>            
          </div>           
      </div>

  </div>

<HR style="height: 3px; background-color: #ccc;">
  ';

$html = '
  <br><br><br><br>

     <div style="width: 100%; ">

      
       <div style="width: 45%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; float: left;">
         <table style="border: 0px solid #000;border-collapse: collapse " width="100%" >
            <tr style="background-color: #ccc;">
              <td HEIGHT="20" style="border: 0px solid #000000;"><p style="font-size:12px;color:#000000;"><font style="color:#000000"><b style="color:#000000">Receptor</b></font></p>
              </td>          
            </tr>
            <tr>
              <td HEIGHT="20" style="color: #000000;"><p style="font-size:10px;"><font style="font-size:12px; color: #000000"><b style="color: #000000">'.strtoupper($r_razon_social).'</b></font></p></td>
            </tr>   
            <tr>
             <td HEIGHT="20"><p style="font-size:12px;"><font style="font-size:12px">
              <div style="font-size:12px; style="color: #000000"">
                <p style="color: #000000">'.strtoupper($r_calle).', '.$r_ext.', '.$r_int.'</p>
                <p style="color: #000000">'.strtoupper($r_colonia).','.strtoupper($r_municipio).', '.strtoupper($r_estado).'</p>
               <p style="color: #000000">'.strtoupper($r_pais).', C.P. '.$r_cp.'</p>
                <p style="color: #000000">'.$rfc_receptor.'</p>

              </div>
            </td>
          </tr>       

        </table>

              
      </div>

        <div style="width: 50%; border: 0pt solid #9e9e9e; border-radius:4pt; padding: 0pt; float: right;">

          <table border=0 style="border: 0px solid #000;" width="100%" >
            <tr>
                
              <td bordercolor="" width="50%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">USO CFDI:</b></font></p></td>

              <td   width="50%" style="color: #000000" ><p style="font-size:10px; text-align:center"><font style="font-size:10px;">'.$r_usocfdi.'</font></p></td>
           
            </tr>
            <tr>
              
              <td bordercolor="" width="50%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">EFECTO DE COMPROBANTE:</b></font></p></td>

              <td width="50%" style="color: #000000" ><p style="font-size:10px; text-align:center"><font style="font-size:10px;">P Pago</font></p></td>
           
            </tr>
            <tr>
              
              <td bordercolor="" width="40%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">FOLIO SAT:</b></font></p></td>

              <td   width="60%" style="color: #000000" ><p style="font-size:10px; text-align:center"><font style="font-size:10px;"></font></p></td>
           
            </tr>
            <tr>

               <td bordercolor="" width="40%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">CERTIFICADO SAT:</b></font></p></td>

               <td  width="60%"  style="color: #000000"><p style="font-size:10px; text-align:left"><font style="font-size:10px; "></font></p></td>
            </tr>

            <tr>
              <td bordercolor="" width="40%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">CERTIFICADO EMISOR:</b></font></p></td>
                  
              <td width="60%" style="color: #000000"><p style="font-size:10px; text-align:center"><font style="font-size:10px;"></font></p></td>              
            </tr>  
             <tr>
              <td bordercolor="" width="50%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"><b style="color:#000000">LUGAR Y FECHA DE EXPEDICION:</b></font></p></td>
              
              <td bordercolor="" width="50%"  style=""><p style="font-size:10px;color:#000000;"><font style="color:#000000"></font>'.$e_cp.' '.$fecha_expedicion.'</p></td>

            </tr>           
          </table>
        </div>


    </div>
    <br>

    <div style="width: 100%;  border-bottom: 3px solid #ccc;">
       <div style="width: 49%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; float: left;">
         <table style="border: 0px solid #000; border-collapse: collapse" width="100%" >
            <tr style="background-color: #ccc;">
              <td HEIGHT="20" style="border: 0px solid #000000;"><p style="font-size:12px;color:#000000;"><font style="color:#000000"><b style="color:#000000">Datos del Receptor (Cliente)</b></font></p>
              </td>          
            </tr> 
            <tr>
             <td HEIGHT="20"><p style="font-size:12px;"><font style="font-size:12px">
              <div style="font-size:12px; style="color: #000000"">
                <p style="color: #000000">Número de Operación: '.$numero_operacion.'</p>
                <p style="color: #000000">Nombre Banco: '.$nombre_banco_r.'</p>
                <p style="color: #000000">Cuenta Banco: '.$cuenta_banco.'</p>              

              </div>
            </td>
          </tr> 
        </table>
      </div>

      <div style="width: 49%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; float: right;">
         <table style="border: 0px solid #000; border-collapse: collapse" width="100%" >
            <tr style="background-color: #ccc;">
              <td HEIGHT="20" style="border: 0px solid #000000;"><p style="font-size:12px;color:#000000;"><font style="color:#000000"><b style="color:#000000">Datos del Emisor</b></font></p>
              </td>          
            </tr> 
            <tr>
             <td HEIGHT="20"><p style="font-size:12px;"><font style="font-size:12px">
              <div style="font-size:12px; style="color: #000000"">
                <p style="color: #000000">Cuenta Banco: '.$cuenta_banco_d.'</p>              

              </div>
            </td>
          </tr> 
        </table>
           
      </div><br>

    </div>


    <br>    
    <div style="width: 100%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; "> 
        <label style="color: #000000; font-size:8px">Productos/Servicios</label> 
        <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%">
          <tr style="background-color: #ccc;">
            <td HEIGHT="20" width="10%" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Clave Producto/Servicio</b></center></td>
            <td HEIGHT="20" width="10%" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Cantidad</b></center></td>            
            <td HEIGHT="20" width="40%" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><b style="color:#000000">Descripción</b></td>
            <td HEIGHT="20" width="10%" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Unidad de Medida</b></center></td>
            <td HEIGHT="20" width="25%" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" ><center><b style="color:#000000">Importe</b></center>
            </td>
          </tr>
          <tr>
          '.$html_desc.'
       </table>
    </div>
    <br>
    <hr>

    <br>    
    <div style="width: 100%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; "> 
        <label style="color: #000000; font-size:8px">Pago</label> 
        <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%">
          <tr style="background-color: #ccc;">
            <td HEIGHT="20" width="15%" align="left"  style="font-size:12px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">No. Parcialidad</b></center></td>
            <td HEIGHT="20" width="20%" align="left"  style="font-size:12px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Fecha Pago</b></center></td>
            <td HEIGHT="20" width="40%" align="left"  style="font-size:12px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><b style="color:#000000">Forma de Pago</b></td>
            <td HEIGHT="20" width="20%" align="left"  style="font-size:12px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" ><center><b style="color:#000000">Moneda</b></center>
            <td HEIGHT="20" width="20%" align="left"  style="font-size:12px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" ><center><b style="color:#000000">Total del Pago</b></center>
            </td>
          </tr>
          <tr><td>

          </td>
          </tr>
          '.$html_desc_pago.'       

       </table>
    </div>
    <br>

    <HR>
     <br>    
    <div style="width: 100%; border: 1px solid #ccc; border-radius:2pt; padding: 0pt; "> 
        <label style="color: #000000; font-size:8px">CFDI Relacionados</label>

        <table border=0 style="border: 0px solid #000; border-collapse: collapse" width="100%">
          <tr style="background-color: #ccc;">
            <td HEIGHT="20"  align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">UUID</b></center></td>
            <td HEIGHT="20" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Factura</b></center></td>
            <td HEIGHT="20" align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Método Pago</b></center></td>
            <td HEIGHT="20"  align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><center><b style="color:#000000">Moneda</b></center></td>
            <td HEIGHT="20"  align="center"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;"><b style="color:#000000">Total Factura</b></td>
            <td HEIGHT="20"  align="left"  style="font-size:11px;color:#000000; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" ><center><b style="color:#000000">Importe Pendiente</b></center>
            
            </td>
          </tr>
          <tr>
          '.$html_desc_debe.'
       </table>
    </div>
    <br>
      ';
  



  
              
$html = mb_convert_encoding($html,'utf-8','utf8');
$style = mb_convert_encoding($style,'utf-8','utf8');
$cabecera = mb_convert_encoding($cabecera,'utf-8','utf8');
// $qr = mb_convert_encoding($qr,'utf-8','utf8');
include("../libs/MPDF/mpdf.php");
// $mpdf=new mPDF('utf-8' , 'A4','', 4, 4, 4, 130, 12, 4);
$mpdf=new mPDF('utf-8' , 'A4','', 4, 4, 4, 15, 12, 4);
// $mpdf=new mPDF('utf-8' , 'A4');

//$mpdf->SetFont('Arial');
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetFooter('ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   Página {PAGENO} de {nbpg} ');
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($html);
// $mpdf->Output($file.".pdf");
// $mpdf->Output();
$mpdf->Output("../tms/pre_pago".$id.".pdf");

}







// $list = "487,";
// $list = substr($list, 0, -1);
// $row_list = explode(",", $list);
// foreach ($row_list as $row_num ) {
//   genera_pdf($row_num);
// }
// echo 1;

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
      $end_num=ucfirst($tex).' PESOS '.$float[1].'/100 MONEDA NACIONAL';
   }else if($op==2){
       // $end_num=ucfirst($tex);
       $end_num=ucfirst($tex).' DOLARES '.$float[1].'/100 USD';
   }

   return $end_num; 
} 
?>
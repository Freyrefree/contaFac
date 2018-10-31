<?php

set_time_limit(0);
include("../libs/archivos_fac/FacturacionModerna/FacturacionModerna.php");
date_default_timezone_set('America/Mexico_City');

include('../models/model.pagos.php');
$datos= new pagos();


$rowid=$_POST['id'];//id_pago
// $rowid=$_GET['id'];//id_pago


$res= pruebaTimbrado($rowid, $datos);//nuevo modificado ismael 271017 facturacion 3.3



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


function pruebaTimbrado($rowid, $datos){//modificado ismael FACTURACION 3.3. 
  $rfc_emisor="";

  $datos->set("id_doc", addslashes(utf8_decode($rowid))); //para obtener el rfc del emisor
  $res_emi= $datos->select_hispago();

  while($row_emi = mysqli_fetch_array($res_emi, MYSQLI_ASSOC)){
     $rfc_emisor=$row_emi["rfc_emisor"];
  }

  $debug = 1;

  $numero_certificado = "";
  $archivo_cer = "";
  $archivo_pem = "";

  $cfdi= generarXML($rfc_emisor, $rowid, $datos);

  $xdoc = new DomDocument();
  $xdoc->loadXML($cfdi) or die("XML invalido");

  $xdoc->formatOutput = true;
  $xdoc->saveXML();

  $xdoc->save('../tms/pre_pago'.$rowid.'.xml');  

  echo $rowid;
}



function generarXML($rfc_emisor,$rowid, $datos){
   
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
 
  $datos->set("id_doc", addslashes(utf8_decode($rowid)));   
  $res= $datos->select_hispago();


  $rowid_factura="";
  $id_client="";

  $uso_cfdi="";
  
  while($fila_f = mysqli_fetch_array($res, MYSQLI_ASSOC)){
    $id_client=$fila_f["idCliente"];
    $rfc_cliente=$fila_f["rfc_receptor"];

  }

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
  }
  
  $rfc_receptor=remplazar($rfc_cliente);
  $rfc_receptor=$rfc_receptor;

  $nombre_receptor2=remplazar($nombre_cliente);    
  $nombre_receptor=$nombre_receptor2; 



//////////////////////////////////////////////////////////////////////////////////////////////////
    $r_concepto = "";
    $ImpuestosRetenidos = 0.00;
    $retencion = null;
    $Traslado = null;

    $tipoDeComprobante="";
    $tipo_documento="";

    $Serie="";
    $Folio="";

    $r_concepto = "";
    $ImpuestosRetenidos = 0.00;
    $retencion = null;
    $Traslado = null;
    
    $tipoDeComprobante="";    
    //CAMBIO PARA LA FACTURACION 3.3. GENERAR NOTA DE CREDITO ISMAEL 27102017
    // $tipoDeComprobante = 'tipoDeComprobante="egreso"'; //tipo de comprobante
    $tipoDeComprobante = 'TipoDeComprobante="P"'; //tipo de comprobante


    $ff="";
  $ss2= "";
  $ff2="";  
  $totF=0;


  $ss= ""; //serie
  $f="";  //folio
   

  $tipo_documento='P';

  //para saber cunatos timpos de documentos hay y poner el folio y serie  correspondinte
  $datos->set("tipo_documento", addslashes(utf8_decode($tipo_documento)));   
  $res_s= $datos->select_serializacion_pago();

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
    $res_se3= $datos->select_folio_pago();

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


    $fecha_actual = substr( date('c'), 0, 19);



    $subtotal=0;//17200.00
    $iva= 0.00;//2752
    $total=0;//19264.00

    //checar moneda
    $Moneda="";//divisa


    $NumCtaPago="";//NO IDENTIFICADO
    $formaDePago="";//PAGO EN UNA SOLA EXHIBICION
    $condicionesDePago="";
    $metodoDePago="";//03
    $metodoDePago2="";//03

    // $servicios_f="";//03

    $NumCtaPagoid="";//NO IDENTIFICAD

       //nuevo ingresados 160517
    $cuenta_banco="";
    $nombre_banco="";//NO IDENTIFICADO

  
    //PARA MODIFICAR LO DEL TIPO DE CAMBIO PARA OBTENER EL DE LA FACTURA ORIGINAL QUE SE ESTA REALIZANDO FACTURACION 3.3. 291017
    $TipoCambio="";
    


      $cantidad_s="";
      $cantidad_ser="";
      // $general="";

      //NUEJVOS AGRAGDOS PARA LA FACTURACON 3.3. ISMAEL 2711017
      $ClaveProdServ="";
      $general="";
 


    $condicionesDePago='CondicionesDePago=""';



    $id_con="";
    $noIdentificacion_xml="";
    $cantidad_xml="";
    $descripcion_xml="";
    $valorUnitario_xml="";
    $importe_xml="";
    $unidad_xml ="";

    $conceptos=" ";

    $tax_c="";
    $retencion_c="";

    $tax_v="";
    $retencion_v="";

    $divisa="";

    $contador=0;
    $importe =0.00;

    $retencioniva =0.00;
    

    $bandera_tasa16=0;
    $bandera_tasa4=0;



    $m="";
    
    
    $codProducto="84111506";
    $clave_unidad="ACT";
    $unidad_xml="Actividad";
    $cantidad_xml="1";
    $descripcion_xml="Pago";
    $valorUnitario_xml="0";
    $importe_xml="0";
        
       
 //NUEVO AGREAGDO PARA LA FACTURACION 3.3 ISMAEL 271017
  $doc_relacion="";
// $doc_relacion  



$Moneda='Moneda="XXX"';

$fecha_pago_aactual="";
$forma_pago_actual="";
$moneda_pago_actual="";
$monto_pago_actual="";

//
$id_uuid="";
$uuid="";
$folio_f="";
$moneda_f="";
$metodo_pago_f="";
$num_parcialidad="";

$ImpSaldoAnt=0.00;
$ImpPagado=0.00;
$ImpSaldoInsoluto=0.00;

$ref_pagos="";//nuevo agregado ismale 3101017


$datos->set("id_pago", addslashes(utf8_decode($rowid)));   
$resPrP= $datos->select_complemento();

while($rowRPP = mysqli_fetch_array($resPrP, MYSQLI_ASSOC)){ 

  $ref_pagos=$rowRPP["no_parcialidad"];//nuevo agregado ismael 

  $num_parcialidad=$rowRPP["no_parcialidad"];//nuevo agregado ismael 

   $fecha_pago_aactual=$rowRPP["fecha_pago"];
   $forma_pago_actual=$rowRPP["forma_pago"];
   $moneda_pago_actual=$rowRPP["moneda"];
   $monto_pago_actual=$rowRPP["importe_pagado"];

   if($monto_pago_actual>0){
     $monto_pago_actual=number_format($monto_pago_actual,2,'.',''); 
   }


    if($ref_pagos=="1"){
      $ImpSaldoAnt=$rowRPP["importe_total"];
      $ImpPagado=$rowRPP["importe_pagado"];

      $ImpSaldoInsoluto=$ImpSaldoAnt-$ImpPagado;

    }else{

      $it=$rowRPP["importe_total"];
      $iyp=$rowRPP["importe_ya_pagado"];

      $ImpPagado=$rowRPP["importe_pagado"];      

      $ImpSaldoAnt= $it-$iyp+$ImpPagado;
       

      $ImpSaldoInsoluto=$ImpSaldoAnt-$ImpPagado;

    }

    ////============
    ///
   $ref_fac=$rowRPP["id_documento"]; 


    $datos->set("id_doc", addslashes(utf8_decode($ref_fac)));   
    $resD= $datos->select_rfactura();

    if ($resD) {
      while($row12 = mysqli_fetch_array($resD, MYSQLI_ASSOC)){ 
        $moneda_f=$row12["moneda"];
        $uuid=$row12["folio_fiscal"];
        $folio_f=$row12["folio"];
        $metodo_pago_f=$row12["metodo"];     
      }
    }     

}



$fecha=$fecha_pago_aactual;


if($ImpSaldoAnt>0){
  $ImpSaldoAnt=number_format($ImpSaldoAnt,2,'.',''); 
}else{
  $ImpSaldoAnt="0.00";
}
if($ImpPagado>0){
  $ImpPagado=number_format($ImpPagado,2,'.',''); 
}else{
  $ImpPagado="0.00";
}
if($ImpSaldoInsoluto>0){
  $ImpSaldoInsoluto=number_format($ImpSaldoInsoluto,2,'.',''); 
}else{
  $ImpSaldoInsoluto="0.00";
}


$pagos_relacionados="";

$pagos_relacionados .= '<pago10:DoctoRelacionado IdDocumento="'.$uuid.'" Folio="'.$folio_f.'" MonedaDR="'.$moneda_f.'" MetodoDePagoDR="'.$metodo_pago_f.'" NumParcialidad="'.$num_parcialidad.'" ImpSaldoAnt="'.$ImpSaldoAnt.'" ImpPagado="'.$ImpPagado.'" ImpSaldoInsoluto="'.$ImpSaldoInsoluto.'" />';

// <pago10:DoctoRelacionado IdDocumento="BDA2876E-F303-4667-B2BF-32ABD6777534" Folio="747" MonedaDR="MXN" MetodoDePagoDR="PPD" NumParcialidad="1" ImpSaldoAnt="576.00" ImpPagado="120.00" ImpSaldoInsoluto="456.00"/>



$cfdi = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante  xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsdhttp://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:pago10="http://www.sat.gob.mx/Pagos" Version="3.3" $Serie $Folio Fecha="$fecha_actual" Sello="" NoCertificado="" Certificado="" SubTotal="$subtotal" Total="$total" $tipoDeComprobante LugarExpedicion="$cp" $Moneda >
<cfdi:Emisor Rfc="$rfc_emisor" Nombre="$razon_social" RegimenFiscal="$regimen_fiscal"/>
<cfdi:Receptor Rfc="$rfc_receptor" Nombre="$nombre_receptor" UsoCFDI="P01"/>
<cfdi:Conceptos>
<cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Descripcion="Pago" ValorUnitario="0" Importe="0"/>
</cfdi:Conceptos>
  <cfdi:Complemento>
    <pago10:Pagos Version="1.0">
      <pago10:Pago FechaPago="$fecha" FormaDePagoP="$forma_pago_actual" MonedaP="$moneda_pago_actual" Monto="$monto_pago_actual">
        $pagos_relacionados
      </pago10:Pago>
    </pago10:Pagos>
  </cfdi:Complemento>
</cfdi:Comprobante>
XML;

$cfdi = utf8_encode($cfdi);

return $cfdi;

}//geneara xml

?>

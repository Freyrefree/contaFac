<?php
set_time_limit(0);
include("../libs/archivos_fac/FacturacionModerna/FacturacionModerna.php");
date_default_timezone_set('America/Mexico_City');


function pruebaCancelacion($uuid){
  /**
  * Niveles de debug:
  * 0 - No almacenar
  * 1 - Almacenar mensajes SOAP en archivo log.
  */
  $debug = 1;
  include("../Models/model.facturacion.php");
  /*RFC utilizado para el ambiente de pruebas*/
  $rfc_fact = 'ESI920427886';
  $factura=new factura();
  $factura->set("rfc",$rfc_fact);
  $consult=$factura->select_fiscal();
  $fila = mysqli_fetch_array($consult);

  $factura->set("rfc_emisor",$rfc_fact);
  $factura->update_timbres();
  //$update_timbres = "UPDATE timbres SET consumidas=consumidas+1 where rfc='$rfc_fact'";
  //mysqli_query($link,$update_timbres);

  $rfc_emisor = $fila['rfc'];
  
  /*Datos de acceso al ambiente de pruebas*/
   $url_timbrado = "https://t1demo.facturacionmoderna.com/timbrado/wsdl";
   //$url_timbrado = "https://t2.facturacionmoderna.com/timbrado/wsdl";
  $user_id = 'UsuarioPruebasWS';
  $user_password = 'b9ec2afa3361a59af4b4d102d3f704eabdf097d4';

  $parametros = array('emisorRFC' => $rfc_emisor,'UserID' => $user_id,'UserPass' => $user_password);
  $cliente = new FacturacionModerna($url_timbrado, $parametros, $debug);

  /*Cambiar este valor por el UUID que se desea cancelar*/
  //$uuid = $folio;
  $opciones=null;
  
  if($cliente->cancelar($uuid, $opciones)){
    $factura->set("uuid",$uuid);
    $factura->cancelarFactura();
  	//mysqli_query($link,"UPDATE lla_registro_factura set estatus_factura='3' where uuid='$uuid'");
    echo "Cancelación exitosa\n";
  }else{
    echo "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
  }    
}

  $UUID = $_POST["uuid"];
  pruebaCancelacion($UUID);


?>
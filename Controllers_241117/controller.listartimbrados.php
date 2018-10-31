<?php
include('../models/model.pagos.php');

$datos= new pagos();


$id_cliente=$_POST['id_cliente'];

$datos->set("id_cliente",$id_cliente);
$res= $datos->listageneral();

$data = array(); //creamos un array


while($row = mysqli_fetch_array($res))
{
    //$servicio = $row['TIPO_SERV']; 
    $btn="";
    $estado_pago="";

    if($row['estatus_pago'] == "1"){
      $btn="<span class='glyphicon glyphicon-ok-sign' id='xml' value='btn_p' name='btn_p' style='color: green; font-size: 18px;' title='Pagado'></span>";
      $estado_pago="1";
    }
      
    if($row['estatus_pago'] == "0"){
      $btn="<span class='glyphicon glyphicon-minus-sign' id='xml' value='btn_pe' name='btn_pe' style='color: #ff5200; font-size: 18px;' title='Pendiente'></span> ";
      $estado_pago="0";
    }
    
    $status="";
    if($row['estatus_factura'] =='2'){
     $status="Facturado";
    }

    $data[] = array(
            'id'                     => utf8_decode($row['id']),
            'factura'                => utf8_decode($row['serie']).utf8_decode($row['folio']),
            'folio_fiscal'           => utf8_decode($row['folio_fiscal']),
            'rfc_emisor'             => utf8_decode($row['rfc_emisor']),
            'rfc_receptor'           => utf8_decode($row['rfc_receptor']),
            'total'                  => utf8_decode($row['total']),
            'fecha_timbrado'         => utf8_decode($row['fecha_facturacion']),
            'tipo_documento'         => utf8_decode($row['tipo_documento']),
            'status_factura'         => $status,
            'btn'                    => $btn,
            'estado_pago'            => $estado_pago
        );
}
echo json_encode($data);
?>
<?php
include('../models/model.pagos.php');
session_start();
$datos= new pagos();
$rfc=$_SESSION['fa_rfc'];

$id_cliente=$_POST['id_cliente'];
$datos->set("rfc",$rfc);
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

    ///nuevo agrgeado ismael 281117
    $id_cl=$row['idCliente'];

    $datos->set("id_cliente", $id_cl);
    $res2= $datos->buscar_cliente();//obtener la razon social
    $razon_social="";
    $razon_social= $res2;

    //para traer el total_ya_pagado

    $id_reg=$row['id'];
    $datos->set("id_reg", $id_reg);
    $res3= $datos->importe_pagado();//obtener la razon social
    
    $totales = explode(",", $res3);
    $importe_pagado="";
    $importe_restante="";
    $importe_pagado=$totales[0];
    $importe_restante=$totales[1];

    $data[] = array(
            'id'                     => utf8_decode($row['id']),
            'factura'                => utf8_decode($row['serie']).utf8_decode($row['folio']),
            'folio_fiscal'           => utf8_decode($row['folio_fiscal']),
            'rfc_emisor'             => utf8_decode($row['rfc_emisor']),
            'razon_social'           => utf8_decode($razon_social),
            'rfc_receptor'           => utf8_decode($row['rfc_receptor']),
            'moneda'                 => utf8_decode($row['moneda']),
            'total'                  => utf8_decode($row['total']),
            'total_pagado'           => utf8_decode($importe_pagado),
            'total_restante'         => utf8_decode($importe_restante),
            'fecha_timbrado'         => utf8_decode($row['fecha_facturacion']),
            'tipo_documento'         => utf8_decode($row['tipo_documento']),
            'status_factura'         => $status,
            'btn'                    => $btn,
            'estado_pago'            => $estado_pago
        );
}
echo json_encode($data);
?>
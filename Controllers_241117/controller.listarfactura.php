<?php
include('../models/model.facturacion.php');

$datos= new factura();
$res= $datos->listageneral();

$data = array(); //creamos un array


while($row = mysqli_fetch_array($res))
{
    //$servicio = $row['TIPO_SERV']; 
    if($row['folio_fiscal'] <> ""){
      $btn="<i class='fa fa-file-code-o' aria-hidden='true' onclick='descxml(".$row['id'].");' id='xml' name='xml' style='color:blue;font-size:18px;cursor:pointer' title='Descargar XML'></i>    <i class='fa fa-file-pdf-o' aria-hidden='true' id='pdf' name='pdf' onclick='descpdf(".$row['id'].");' title='Descargar PDf' style='color:red;font-size:18px;cursor:pointer'></i>";
      
    }else{
        $btn="";
    }

    if($row['estatus_factura']==1){
        $estatus="Pendiente";
    }else if($row['estatus_factura']==2){
        $estatus="Facturada";
    }else if($row['estatus_factura']==3){
        $estatus="Cancelada";
    }else if($row['estatus_factura']==4){
        $estatus="Cancelada NC";
    }

    $data[] = array(
            'id'                     => utf8_decode($row['id']),
            'factura'                => utf8_decode($row['serie']).utf8_decode($row['folio']),
            'folio_fiscal'           => utf8_decode($row['folio_fiscal']),
            'rfc_emisor'             => utf8_decode($row['rfc_emisor']),
            'rfc_receptor'           => utf8_decode($row['rfc_receptor']),
            'total'                  => '$'.utf8_decode(number_format($row['total'],2,'.',',')),
            'fecha_timbrado'         => utf8_decode($row['fecha_facturacion']),
            'tipo_documento'         => utf8_decode($row['tipo_documento']),
            'status_factura'         => utf8_decode($estatus),
            'btn_accion'             =>$btn
        );
}
echo json_encode($data);
?>
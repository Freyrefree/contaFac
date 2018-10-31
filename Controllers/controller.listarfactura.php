<?php
include('../models/model.facturacion.php');
session_start();

$datos= new factura();
$rfc=$_SESSION['fa_rfc'];
$datos->set("rfc",$rfc);
$res= $datos->listageneral();

$data = array(); //creamos un array


while($row = mysqli_fetch_array($res))
{
    $correo = '<i class="fa fa-envelope" aria-hidden="true" id="sendemail" name="sendemail" onclick="confirmarEnvioCorreo('.$row["id"].');"    style="color:blue;font-size: 20px;" title="Enviar Correo"></i>';

    //$servicio = $row['TIPO_SERV']; 
    $pago='';
     $complemento='';
    if($row['folio_fiscal'] <> ""){
      $btn="<i class='fa fa-file-code-o' aria-hidden='true' onclick='descxml(".$row['id'].");' id='xml' name='xml' style='color:blue;font-size:18px;cursor:pointer' title='Descargar XML'></i>    <i class='fa fa-file-pdf-o' aria-hidden='true' id='pdf' name='pdf' onclick='descpdf(".$row['id'].");' title='Descargar PDf' style='color:red;font-size:18px;cursor:pointer'></i>";

      
            $datos->set('folio_fiscal',$row['folio_fiscal']);
            $complementosPago=$datos->complementoPago();
            $pago='<i class="fa fa-check-circle-o fa-2x" aria-hidden="true" style="color:green;font-size: 20px;"></i>';
            $complemento='<i class="fa fa-check-circle-o fa-2x" aria-hidden="true" style="color:green;font-size: 20px;"></i>';
            if(mysqli_num_rows($complementosPago)>0){
                while ($row2=mysqli_fetch_array($complementosPago)) {
                    if($row2['importe_restante']<=0 or $row2['importe_restante']==null){
                        $pago='<i class="fa fa-clock-o fa-2x" aria-hidden="true" style="color:blue;font-size: 20px;"></i>';
                    }

                    if($row2['folio_fiscal']==null or $row2['folio_fiscal']==""){
                        $complemento='<i class="fa fa-clock-o fa-2x" aria-hidden="true" style="color:blue;font-size: 20px;"></i>';
                    }
                }

            }else{
                $pago='<i class="fa fa-clock-o fa-2x" aria-hidden="true" style="color:blue;font-size: 20px;"></i>';
                $complemento='<i class="fa fa-clock-o fa-2x" aria-hidden="true" style="color:blue;font-size: 20px;"></i>';
            }
      
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

    

    //if($row['metodo']=='PUE'){
      //  $pago="";
        //$complemento="";
    //}

    $data[] = array(
             'id'                     => utf8_encode($row['id']),
            'factura'                => utf8_encode($row['serie']).utf8_encode($row['folio']),
            'folio_fiscal'           => utf8_encode($row['folio_fiscal']),
            'rfc_emisor'             => utf8_encode($row['rfc_emisor']),
            'rfc_receptor'           => utf8_encode($row['rfc_receptor']),
            'razon_social'           => utf8_encode($row['razon_social']),
            'municipio'              => utf8_encode($row['municipio']),
            'subtotal'               => "$ ".number_format($row['subtotal'],2,'.',','),
            'totalTraslado'          => "$ ".number_format($row['total_iva'],2,'.',','),
            'totalRetencion'         => "$ ".number_format($row['total_retencion'],2,'.',','),
            'total'                  => "$ ".utf8_encode(number_format($row['total'],2,'.',',')),
            'fecha_timbrado'         => utf8_encode($row['fecha_facturacion']),
            'tipo_documento'         => utf8_encode($row['tipo_documento']),
            'status_factura'         => utf8_encode($estatus),
            'btn_accion'             =>$btn,
             'btn_pago'               => $pago,
            'btn_complemento'        => $complemento,
            'folioconcepto'           => $row['concepto_clave'],
            'btncorreo'               => $correo
        );
}
echo json_encode($data);
?>
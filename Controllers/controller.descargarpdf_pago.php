<?php

include('../models/model.pagos.php');

$datos= new pagos();


$id_complemento=$_REQUEST['comp'];


$uuid="";
$datos->set("id_complemento", addslashes($id_complemento)); 
$res= $datos->consultar_uuid();



if($res){
	while($row = mysqli_fetch_array($res)){

        $uuid=$row["folio_fiscal"];
		   
    }
}



$pdf = "../comprobantesPago/".$uuid.".pdf";
// $documento = $_REQUEST['archivo'];
// $uuid = $_REQUEST['uuid'];
$ruta_fin=$pdf;
// $ruta_uuid = $uuid;
// $ruta_fin=$documento;
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$uuid.'.pdf');
readfile($ruta_fin); 
exit; 



?>
<?php


$documento = $_REQUEST['archivo'];
$uuid = $_REQUEST['uuid'];

$ruta_fin="";


$ruta_uuid = $uuid;
$ruta_fin=$documento;

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$ruta_uuid.'.pdf');
readfile($ruta_fin); 
exit;
?>
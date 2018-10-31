<?php
include("../Models/model.factura.php");
$factura=new factura();
//$caracter=$_GET['term'];
//$factura->set("valor",$caracter);
$answer=$factura->cliente();
//$data=array();
while ($row=mysqli_fetch_array($answer)) {
	$data[]=array("value"=>utf8_encode($row['rfc']).' - '.utf8_encode($row['razon_social']).' - '. utf8_encode($row['sucursal']).' - '.utf8_encode($row['municipio']),
"idReceptor"=>$row['id'],
"usoCFDI"=>$row['c_UsoCFDI']);
	
}
//print_r($data);
echo json_encode($data);
?>
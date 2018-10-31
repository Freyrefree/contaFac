<?php
include("../Models/model.factura.php");
$factura=new factura();
$caracter=$_GET['term'];
$factura->set("valor",$caracter);
$answer=$factura->cliente();
//$data=array();
while ($row=mysqli_fetch_array($answer)) {
	$data[]=utf8_encode($row['rfc']).' - '.utf8_encode($row['razon_social']);
	
}
//print_r($data);
echo json_encode($data);
?>
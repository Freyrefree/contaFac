<?php
include("../models/model.factura.php");
$factura=new factura();
$term=$_GET['term'];
$factura->set("valor",$term);
$answer=$factura->consultaCU();
$data=array();
while ($row=mysqli_fetch_array($answer)) {
	$data[]=$row['clave_sat'].' - '.utf8_decode($row['descripcion_sat']);
}

echo json_encode($data);
?>
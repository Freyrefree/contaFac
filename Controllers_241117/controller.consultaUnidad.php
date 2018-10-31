<?php
include("../Models/model.factura.php");
$factura=new factura();
$term=$_GET['term'];
$factura->set("valor",$term);
$answer=$factura->consultaUnidad();
$data=array();
while ($row=mysqli_fetch_array($answer)) {
	$data[]=utf8_decode($row['descripcion_empresa']);
}

echo json_encode($data);
?>
<?php
include("../Models/model.factura.php");
$factura=new factura();
$term=$_GET['term'];
$factura->set("valor",$term);
$data=array();
$answer=$factura->consultaIdent();
while ($row=mysqli_fetch_array($answer)) {
	$data[]=$row['clave_interna'];
}

echo json_encode($data);
?>
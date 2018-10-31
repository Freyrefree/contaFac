<?php 
set_time_limit(0);
include('../Models/model.productos.php'); //Modelo clientes
$unidad  = new Productos();

if (isset($_GET['term'])){
$termino=$_GET['term'];
$unidad->set("concepto", $termino);
$res= $unidad->buscar_auto();
 echo json_encode($res);

 }
?>
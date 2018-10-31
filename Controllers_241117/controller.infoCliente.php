<?php 
set_time_limit(0);
include('../Models/model.clientes.php'); //Modelo clientes
$busqueda  = new Productos();

if (isset($_GET['term'])){
$arr = array();
$termino=$_GET['term'];

$busqueda->set("concepto", $termino);
$res= $busqueda->buscar_auto();
 echo json_encode($res);

 }
?>
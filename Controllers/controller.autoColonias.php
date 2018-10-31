<?php 
set_time_limit(0);
include('../Models/model.clientes.php'); //Modelo clientes
$cliente  = new cliente();

if (isset($_GET['term'])){
$termino=$_GET['term'];
$cliente->set("concepto", $termino);
$res= $cliente->buscar_autocolonias();
 echo json_encode($res);

 }
?>
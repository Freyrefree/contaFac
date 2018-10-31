<?php 
set_time_limit(0);
include('../Models/model.claveU.php');

$unidad= new Unidad();

if (isset($_GET['term'])){
$arr = array();
$termino=$_GET['term'];

$unidad->set("concepto", $termino);
$res= $unidad->buscar_auto();
 echo json_encode($res);

 }
?>
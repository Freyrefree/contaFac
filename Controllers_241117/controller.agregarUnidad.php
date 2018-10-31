<?php
set_time_limit(0);
include('../Models/model.claveU.php'); //Modelo clientes
$unidad  = new Unidad();

function cambiar($cara)
{
$cara= str_replace('"', '', $cara); 
$cara= str_replace('“', '', $cara);  
$cara= str_replace('”', '', $cara);
$cara= str_replace("'", "", $cara);
return $cara;  
}

$informacion=$_POST['informacionsat'];
	$inf=explode("-",$informacion);
	$clave_sat=$inf[0];
	$dessat=cambiar(utf8_encode($inf[1]));
$descripcion=cambiar(utf8_encode($_POST['descripcion']));
		$unidad->set("clavesat",addslashes($clave_sat));
		$unidad->set("dessat",addslashes($dessat));
		$unidad->set("descripcion",addslashes($descripcion));
		$datos=$unidad->add();
		if($datos)
		{
		 echo 1;
		}			
?>
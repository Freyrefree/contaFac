<?php
set_time_limit(0);
include('../Models/model.productos.php'); //Modelo clientes
$producto  = new Productos();

function cambiar($cara)
{
$cara= str_replace('"', '', $cara); 
$cara= str_replace('“', '', $cara);  
$cara= str_replace('”', '', $cara);
$cara= str_replace("'", "", $cara);
return $cara;  
}

$id=$_POST['id'];
$informacion=$_POST['informacionsat'];
	$inf=explode("-",$informacion);
	$clave_sat=$inf[0];
	$dessat=cambiar(utf8_encode($inf[1]));
$clave=$_POST['clave'];
$descripcion=cambiar(utf8_encode($_POST['descripcion']));
		
		$producto->set("id",$id);
		$producto->set("clave",	 $clave);		
		$producto->set("clavesat",$clave_sat);
		$producto->set("dessat",$dessat);
		$producto->set("descripcion",$descripcion);
		$datos=$producto->editar();
		if($datos)
		{
		 echo 1;
		}	
?>
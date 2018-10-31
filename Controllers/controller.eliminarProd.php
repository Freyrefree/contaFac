<?php
set_time_limit(0);
include('../Models/model.productos.php'); //Modelo clientes
$producto  = new Productos();
$id=$_GET['id'];
$producto->set("id",$id);		
$datos=$producto->delete();
if($datos)
	{
	 echo 1;
	}			
?>
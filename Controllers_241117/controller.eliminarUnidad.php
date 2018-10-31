<?php
set_time_limit(0);
include('../Models/model.claveU.php'); //Modelo clientes
$unidad  = new Unidad();
$id=$_GET['id'];
$unidad->set("id",$id);		
$datos=$unidad->delete();
if($datos)
	{
	 echo 1;
	}			
?>
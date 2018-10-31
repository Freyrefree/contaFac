<?php
set_time_limit(0);
include('../Models/model.claveU.php'); //Modelo clientes
$unidad  = new Unidad();
$id=$_GET['id'];
$unidad->set("id",$id);		
$unidad->buscardatos();
$informacionsat=utf8_decode($unidad->get("informacionsat"));
$descripciont=utf8_decode($unidad->get("descripcion"));
   $datosGrupo[] = array(
   			'id'=>$id,
            'informacionsat'=>utf8_decode($informacionsat),
            'descripcion' =>utf8_decode($descripciont),
            );
    print_r(json_encode($datosGrupo));
?>
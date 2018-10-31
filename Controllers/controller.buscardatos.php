<?php
set_time_limit(0);
include('../Models/model.productos.php'); //Modelo clientes
$producto  = new Productos();
$id=$_GET['id'];
$producto->set("id",$id);		
$producto->buscardatos();
$informacionsat=utf8_decode($producto->get("informacionsat"));
$clavet=$producto->get("clave");
$descripciont=utf8_decode($producto->get("descripcion"));

   $datosGrupo[] = array(
   			'id'=>$id,
            'informacionsat'=>utf8_decode($informacionsat),
            'clave'=> $clavet,
            'descripcion' =>utf8_decode($descripciont),
            );

    print_r(json_encode($datosGrupo));
?>

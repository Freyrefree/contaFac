<?php
include("../models/model.factura.php");
$factura=new factura();
$valor=$_POST['valor'];
$clave=explode("-", $valor);
$factura->set("valor",utf8_encode(trim(str_replace("-", "", $clave[0]))));
$factura->buscaUnidad();
$clave=$factura->get("clave");
$descripcionSat=$factura->get("descripcionSat");
$descripcion=$factura->get("descripcion");
echo $clave.' - '.utf8_decode($descripcionSat).'|'.utf8_decode($descripcion);
?>
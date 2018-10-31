<?php
include("../Models/model.factura.php");
$factura=new factura();
$valor=$_POST['valor'];
$clave=explode("-", utf8_encode($valor));
$factura->set("valor",trim(str_replace("-","", $clave[0])));
$answer=$factura->buscaConcepto();
$clave=$factura->get("clave");
$descripcionSat=$factura->get("descripcionSat");
$descripcion=$factura->get("descripcion");
$identificador=$factura->get("identificador");
$idProd=$factura->get("idProd");

echo $clave.' - '.utf8_decode($descripcionSat).'|'.utf8_decode($descripcion).'|'.$identificador.'|'.$idProd;
//echo $answer;
?>
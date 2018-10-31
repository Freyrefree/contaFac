<?php
include("../Models/model.factura.php");
$valores=$_POST['valor'];
$factura=new factura();
$factura->set('documento',$valores);
$answer=$factura->serieFolio();
$serie=$factura->get('serie');
$folio=$factura->get('folio');
echo $serie.'|'.$folio;
?>
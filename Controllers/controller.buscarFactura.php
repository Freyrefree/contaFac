<?php
include("../Models/model.factura.php");
$valores=$_POST['valor'];
session_start();
$factura=new factura();
$factura->set('rfc',$_SESSION['fa_rfc']);
$factura->set('documento',$valores);
$answer=$factura->serieFolio();
$serie=$factura->get('serie');
$folio=$factura->get('folio');
echo $serie.'|'.$folio;
?>
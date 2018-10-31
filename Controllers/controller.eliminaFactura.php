<?php
session_start();
$usuario=$_SESSION['fa_id'];
//===== incluyo el modelo y la instancio =============
include("../Models/model.facturacion.php");
$factura=new factura();
//===== recibe variables =============
$id=$_POST['id'];
$folio=$_POST['folio'];
//========= envio parametros y se eliminan los conceptos relacionados =====
$factura->set("usuario",$usuario);
$factura->set("folio",$folio);
$factura->eliminaConcepto();
//========= envio parametros y se elimina el registro de la factura =========
$factura->set("usuario",$usuario);
$factura->set("id",$id);
$factura->eliminaFactura();
?>
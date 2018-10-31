<?php
include('../models/model.pagos.php');

$datos= new pagos();


$id_factura=$_POST['id_factura'];

$datos->set("id_factura",addslashes($id_factura)); 
$res= $datos->lista_pagos();

// echo $id_factura;
 echo $res;
?>
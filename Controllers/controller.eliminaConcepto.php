<?php
include("../Models/model.factura.php");
$factura= new factura();
$id=$_POST['id'];
$factura->set("id",$id);
$factura->eliminaConcepto();

$folioC=$_POST['folioC'];
$factura->set("folioC",$folioC);
$answer=$factura->consultaConcepto();
$subtotal=0;
$Ttraslado=0;
$Tretencion=0;
$total=0;
while($row=mysqli_fetch_array($answer)){
	$subtotal += $row['valor_unitario'] * $row['cantidad'];
	$Ttraslado += $row['importe_translado'];
	$Tretencion += $row['importe_retencion'];
}

$total= $subtotal + $Ttraslado;
$total=$total - $Tretencion;

echo number_format($subtotal,2,'.',',').'|'.number_format($Ttraslado,2,'.',',').'|'.number_format($Tretencion,2,'.',',').'|'.number_format($total,2,'.',',');
?>
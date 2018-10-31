<?php
include("../Models/model.factura.php");
$factura=new factura();

$clave=$_POST['clave'];
//==============
$descripcion=$_POST['descripcion'];
$identificacion=$_POST['identificacion'];
$claveUnidad=$_POST['claveUnidad'];
//===========
$unidad=$_POST['unidad'];
$cantidad=$_POST['cantidad'];
$precio=$_POST['precio'];
$Timpuesto=$_POST['Timpuesto'];
$TtasaoCuota=$_POST['TtasaoCuota'];
$Tfactor=$_POST['Tfactor'];
$Timporte=$_POST['Timporte'];
$Rimpuesto=$_POST['Rimpuesto'];
$RtasaoCuota=$_POST['RtasaoCuota'];
$Rfactor=$_POST['Rfactor'];
$Rimporte=$_POST['Rimporte'];

$folioC=$_POST['folioC'];
$idProd=$_POST['idProd'];

if($Rimporte==""){
	$Rimporte=0;
	$RtasaoCuota=0.0;
}

$importeTotal= $precio * $cantidad;

$importeTotal= $importeTotal + $Timporte;

$importeTotal= $importeTotal - $Rimporte;
$clave=explode("-", $clave);
$claveUnidad=explode("-", $claveUnidad);
$factura->set("clave",addslashes(trim(str_replace("-", "", $clave[0]))));
$factura->set("descripcion",addslashes($descripcion));
$factura->set("identificacion",addslashes($identificacion));
$factura->set("claveUnidad",addslashes(trim(str_replace("-", "", $claveUnidad[0]))));
$factura->set("unidad",addslashes($unidad));
$factura->set("cantidad",addslashes($cantidad));
$factura->set("precio",addslashes($precio));
$factura->set("Timpuesto",addslashes($Timpuesto));
$factura->set("Tfactor",addslashes($Tfactor));
$factura->set("TtasaoCuota",addslashes($TtasaoCuota));
$factura->set("Timporte",addslashes($Timporte));
$factura->set("Rimpuesto",addslashes($Rimpuesto));
$factura->set("Rfactor",addslashes($Rfactor));
$factura->set("RtasaoCuota",addslashes($RtasaoCuota));
$factura->set("Rimporte",addslashes($Rimporte));
$factura->set("folioC",addslashes($folioC));
$factura->set("idProd",addslashes($idProd));
$factura->set("importeTotal",addslashes($importeTotal));
$factura->set("usuario","1");
//$factura->set("",);
//$factura->set("",);


$ans=$factura->insertaCarrito();
//echo $ans;


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
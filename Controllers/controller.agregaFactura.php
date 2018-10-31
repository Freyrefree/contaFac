<?php
session_start();
$usuario=$_SESSION["fa_id"];
include("../Models/model.factura.php");
$factura=new factura();
$TComprobante=$_POST['tc'];
$folio="";
$serie="";
$emisor=$_POST['r_emisor'];
$receptor=$_POST['r_receptor'];
$formaPago=$_POST['forma'];
$metodoPago=$_POST['metodo'];
$fecha=$_POST['fecha'];
$moneda=$_POST['moneda'];
$condicion=$_POST['condicion'];
$idReceptor=$_POST['idReceptor'];
$usoCFDI=$_POST['usocfdi'];

if($condicion==""){
	$condicion="ninguna";
}

$r_receptor=explode(" - ", $receptor);

//$factura->set('valor',trim(str_replace("-", "", $r_receptor[0])));
//$answer=$factura->cliente();
//$datos=mysqli_fetch_array($answer);



if($_POST['folioC']==""){
	$factura->folioCarrito();
	$folioCarrito=$factura->get("folioC");

	if($folioCarrito==""){
		$folioCarrito=1;
	}
	//$usuario=1;
	$factura->set("folioC",addslashes($folioCarrito));
	$factura->set("usuario","1");
	$factura->cambioFolioC();
	$factura->set("tc",addslashes($TComprobante));
	$factura->set("folio",addslashes($folio));
	$factura->set("serie",addslashes($serie));
	$factura->set("emisor",addslashes($emisor));
	$factura->set("idCliente",addslashes($idReceptor));
	$factura->set("receptor",addslashes(trim(str_replace("-", "", $r_receptor[0]))));
	$factura->set("formaPago",addslashes($formaPago));
	$factura->set("metodoPago",addslashes($metodoPago));
	$factura->set("moneda",addslashes($moneda));
	$factura->set("condicion",addslashes($condicion));
	$factura->set("usuario",addslashes($usuario));
		$factura->set("usocfdi",$usoCFDI);
	$factura->insertaFactura();



}else{
	$folioCarrito=$_POST['folioC'];
	$factura->set("folioC",addslashes($folioCarrito));
	//$factura->set("usuario","1");
	//$factura->cambioFolioC();
	$factura->set("tc",addslashes($TComprobante));
	$factura->set("folio",addslashes($folio));
	$factura->set("serie",addslashes($serie));
	//$factura->set("emisor",$emisor);
	$factura->set("idCliente",addslashes($idReceptor));
	$factura->set("receptor",addslashes(trim(str_replace("-", "", $r_receptor[0]))));
	$factura->set("formaPago",addslashes($formaPago));
	$factura->set("metodoPago",addslashes($metodoPago));
	$factura->set("moneda",addslashes($moneda));
	$factura->set("condicion",addslashes($condicion));
		$factura->set("usocfdi",$usoCFDI);
	$factura->modificaFactura();
}

echo $folioCarrito;




?>
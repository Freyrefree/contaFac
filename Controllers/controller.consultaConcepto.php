<?php
include("../Models/model.factura.php");
$factura=new factura();
$folioC=$_GET['id'];
//$folioC=13;
$factura->set("folioC",$folioC);
$answer=$factura->consultaConcepto();
$data=array();
while($row=mysqli_fetch_array($answer)){
	//=========== converciion de la clave unidad por su descripcion
	$factura->set("valor",$row['clave_unidad']);
	$factura->buscaUnidad();
	$descripcionUnidad=$factura->get("descripcion");
	//=========== convercion de los impuestos traslado=============
	if($row['tipo_traslado']=="001"){
		$tipo_traslado="ISR";
	}else if($row['tipo_traslado']=='002'){
		$tipo_traslado="IVA";
	}else if($row['tipo_traslado']=='003'){
		$tipo_traslado="IEPS";
	}
	else{
		$tipo_traslado="";
	}
	//=========== convercion de los impuestos retencion=============
	if($row['tipo_retencion']=="001"){
		$tipo_retencion="ISR";
	}else if($row['tipo_retencion']=='002'){
		$tipo_retencion="IVA";
	}else if($row['tipo_retencion']=='003'){
		$tipo_retencion="IEPS";
	}else{
		$tipo_retencion="";
	}
	if($row['importe_translado']==""){$importe_traslado=0;}else{$importe_traslado=$row['importe_translado'];}
	if($row['importe_retencion']==""){$importe_retencion=0;}else{$importe_retencion=$row['importe_retencion'];}
	$data[]=array(
		"id"=>$row['id'],
		"clave"=>$row['clave_sat'],
		"cantidad"=>$row['cantidad'],
		"unidad"=>$descripcionUnidad,
		"valorUnitario"=>'$'.number_format($row['valor_unitario'],2,'.',','),
		"impuestoT"=>$tipo_traslado,
		"factorT"=>$row['tipo_factor_translado'],
		"tcT"=>$row['valor_tasa_cuota_translado'],
		"importeT"=>'$'.number_format($importe_traslado,2,'.',','),
		"impuestoR"=>$tipo_retencion,
		"factorR"=>$row['tipo_factor_retencion'],
		"tcR"=>$row['valor_tasa_cuota_retencion'],
		"importeR"=>'$'.number_format($importe_retencion,2,'.',','),
		"total"=>'$'.number_format($row['importe_total'],2,'.',','),
		"opcion"=>'<i class="fa fa-trash" onclick="eliminarconcepto('.$row['id'].')"  aria-hidden="true" style="color:red;cursor:pointer"></i>'
	);
}
echo json_encode($data);

?>
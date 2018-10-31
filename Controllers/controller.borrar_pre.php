<?php
  
	include('../models/model.facturacion.php');

	$datos= new factura();
	$res= $datos->listageneral();

	$id_doc=$_POST['id'];

	$ruta_xml="../tms/".$id_doc.".xml";
	$ruta_pdf="../tms/".$id_doc.".pdf";

	if (file_exists($ruta_xml)) {
	    unlink($ruta_xml);
	} else {
	}

	if (file_exists($ruta_pdf)) {
	    unlink($ruta_pdf);
	} else {
	}



?>
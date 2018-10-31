<?php
	include('../models/model.pagos.php');

	$datos= new pagos();
   
    
    $action=$_REQUEST['action'];

    if($action==2){
    	$id_complemento=$_REQUEST['com'];

		$uuid="";

		$datos->set("id_complemento", addslashes($id_complemento)); 
		$res= $datos->consultar_uuid();

		if($res){
			while($row = mysqli_fetch_array($res)){
		       $uuid=$row["folio_fiscal"];
		    }
		}

		$pdf = "../comprobantesPago/".$uuid.".xml";
		// $documento = $_REQUEST['archivo'];
		// $uuid = $_REQUEST['uuid'];
		$ruta_fin=$pdf;
		// $ruta_uuid = $uuid;
		// $ruta_fin=$documento;
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$uuid.'.xml');
		readfile($ruta_fin); 
		exit;  

    }
	

  
  if($action==1){
  	  $documento = $_REQUEST['archivo'];
	  $uuid = $_REQUEST['uuid'];


	   header('Content-Type: application/octet-stream');
	   header('Content-Disposition: attachment; filename='.$uuid.".XML");
	   header('Content-Transfer-Encoding: binary');
	   header('Content-Length: '.filesize($documento));

	   readfile($documento);

	   exit; 
  }
  
?>
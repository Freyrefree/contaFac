<?php
include('../models/model.pagos.php');
/*function ok($valor)
{
if ($valor == 1)
{
echo 1;
}
else{
echo 0;
}
}*/
// if (@$_GET['opc'] == 1)
// {
// $estatus  = new pagos();
// $idcomplementop = $_GET['id'];
// $estatus->set('id',$idcomplementop);
// $respuesta=$estatus->verificarTimbre();
// while($fila = mysqli_fetch_array($respuesta))
// {
// 	$estatus = $fila['estatus'];
// 	$data[] = array('estatus'=> $estatus);
// }
// print json_encode($data);
// }else if(@$_POST['opc'] == 2)
// {
// 	$cancelarpago =  new pagos();
// 	$idcomplementop = $_POST['id'];
// 	$cancelarpago->set('id',$idcomplementop);
// 	$respuesta=$cancelarpago->cancelarUnPago();
// 	if($respuesta)
// 	{
// 		echo 1;
// 	}else {
// 		echo 0;
// 	}
// }else if($_POST['opc'] == 3)
// {
//
// 	$buscaid_documento =  new pagos();
// 	$idcomplementop = $_POST['id'];
// 	$buscaid_documento->set('id',$idcomplementop);
// 	$buscaid_documento->buscaid_documento();
// 	$id_documento = $buscaid_documento->get("id_documento");
//
// 	////////////////////////////////////////////////////////////
// 	$busquedaporDocumento = new pagos();
// 	$busquedaporDocumento->set('id_documento',$id_documento);
// 	$respuesta=$busquedaporDocumento->buscarPagosporid();
// 		if ($respuesta->num_rows > 0)
// 		{
// 			echo 1;
// 		}
// 		else {
// 			echo 0;
// 		}
// 		//echo 1;
// 	////////////////////////////////////////////////////////////
// 		/*$validarSiesElPrimero = new pagos()
// 		$validarSiesElPrimero->set('id',$idcomplementop);
// 		$validarSiesElPrimero->primerPago();
// 		$id = $buscaid_documento->get("id");
// 		if($id == $idcomplementop){
// 			echo 1;
// 		}
// 		else {
// 			echo 0;
// 		}*/
// 	//}
// }else if($_POST['opc'] == 4)
// {
// 	$buscaid_documento =  new pagos();
// 	$idcomplementop = $_POST['id'];
// 	$buscaid_documento->set('id',$idcomplementop);
// 	$buscaid_documento->buscaid_documento();
// 	$id_documento = $buscaid_documento->get("id_documento");
// 	$no_parcialidad = $buscaid_documento->get("no_parcialidad");
// 	echo $id_documento.','.$no_parcialidad;
//
// }else if($_POST['opc'] == 5)
// {
// 		 $validarSiesElPrimero = new pagos();
// 		 $iddocumento = $_POST['id_documento'];
// 		 $validarSiesElPrimero->set('id_documento',$iddocumento);
// 		 $validarSiesElPrimero->primerPago();
// 		 $no_parcialidad = $validarSiesElPrimero->get("no_parcialidad");
// 		 echo $no_parcialidad;
//
// }else
if(@$_POST['opc'] == 6)
{
	$buscaid_documento =  new pagos();
	$idcomplementop = $_POST['id'];
	$buscaid_documento->set('id',$idcomplementop);
	$buscaid_documento->buscaid_documento();
	$id_documento = $buscaid_documento->get("id_documento");

	////////////////////////////////////////////////////////////
	$estatusDespues = new pagos();
	$estatusDespues->set('id',$idcomplementop);
	$estatusDespues->set('id_documento',$id_documento);
	$respuesta=$estatusDespues->buscarTimbradosDespues();
		if ($respuesta->num_rows > 0)
		{
			echo 1;
		}
		else {
			echo 0;
		}

}
else if(@$_POST['opc'] == 7)
{
	$cancelarpago =  new pagos();
	$idcomplementop = $_POST['id'];
	$cancelarpago->set('id',$idcomplementop);
	$respuesta=$cancelarpago->cancelarPagos();
	if($respuesta)
	{
		echo 1;
	}else {
		echo 0;
	}
}
?>

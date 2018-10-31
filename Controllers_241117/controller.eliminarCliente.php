<?php
include('../Models/model.clientes.php');


$folio=$_GET['id'];
$Credito=new Cliente();
$Credito->set('id',$folio);
$answer=$Credito->eliminaCliente();
if($answer){
	echo 1;
}else{
	echo 0;
}
?>
<?php
set_time_limit(0);
include('Models/clientes.php'); //Modelo clientes
$cliente  = new Cliente();
if(!$_POST)
{
}
else 
{
		$cliente->set("rfc",			addslashes(utf8_decode($_POST['rfc'])));		
		$cliente->set("razonsocial",	addslashes(utf8_decode($_POST['razonsocial'])));
		$cliente->set("cuenta",	addslashes(utf8_decode($_POST['cuenta'])));
		$cliente->set("email",	addslashes(utf8_decode($_POST['email'])));
		$datos=$cliente->add();
		if($datos)
		{
			echo 1;
		}		
		
}
?>
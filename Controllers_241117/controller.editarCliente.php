<?php
set_time_limit(0);
include('../Models/model.clientes.php'); //Modelo clientes
$cliente  = new Cliente();
$busquedapais = new Cliente();
$busquedaestado = new Cliente();
$busquedamunicipio = new Cliente();
$busquedacp = new Cliente();
if(!$_POST)
{
}
else 
{
	
		   $busquedapais->set("pais",addslashes(utf8_decode('MEX')));    
	       $answer=$busquedapais->buscaridPais();      
	       while ($row = mysqli_fetch_array($answer))
	       {

			   $busquedaestado->set("estado",addslashes(utf8_decode($_POST['estado'])));
			   $answere=$busquedaestado->buscaridEstado();
			   while($rowe = mysqli_fetch_array($answere))
			   {
					$busquedamunicipio->set("municipio",addslashes(utf8_decode($_POST['municipio'])));
					$busquedamunicipio->set("estado",addslashes(utf8_decode($_POST['estado'])));
				    $answerm=$busquedamunicipio->buscaridMunicipio();
				    while($rowm = mysqli_fetch_array($answerm))
					{
						$busquedacp->set("codigopostal",addslashes(utf8_decode($_POST['codigopostal'])));						
						$answercp=$busquedacp->buscaridCP();
						while($rowcp = mysqli_fetch_array($answercp))
						{
						
							$idcp=$rowcp['rowid']; 
							$idmunicipio=$rowm['rowid'];
							$idestado = $rowe['rowid'];
							$idpais = $row['rowid'];

							$cliente->set("id",			addslashes(utf8_decode($_POST['id'])));
							$cliente->set("rfc",			addslashes(utf8_decode($_POST['rfc'])));		
							$cliente->set("razonsocial",	addslashes(utf8_decode($_POST['razonsocial'])));
							$cliente->set("cuenta",	addslashes(utf8_decode($_POST['cuenta'])));
							$cliente->set("email",	addslashes(utf8_decode($_POST['email'])));
							//$cliente->set("codigopostal",	addslashes(utf8_decode($_POST['codigopostal'])));
							//$cliente->set("municipio",	addslashes(utf8_decode($_POST['municipio'])));
							$cliente->set("pais",	addslashes(utf8_decode($idpais)));
							$cliente->set("estado",	addslashes(utf8_decode($idestado)));
							$cliente->set("municipio",	addslashes(utf8_decode($idmunicipio)));
							$cliente->set("codigopostal",	addslashes(utf8_decode($idcp)));
							$cliente->set("colonia",	addslashes(utf8_decode($_POST['colonia'])));
							$cliente->set("calle",	addslashes(utf8_decode($_POST['calle'])));
							$cliente->set("numinterior",	addslashes(utf8_decode($_POST['numinterior'])));
							$cliente->set("numexterior",	addslashes(utf8_decode($_POST['numexterior'])));
							
							$cliente->set("cfdi",	addslashes(utf8_decode($_POST['cfdi'])));
							$datos=$cliente->modificar();
							if($datos)
							{
								echo 1;
							}
							else
							{
								echo $datos;
							}
						}
					}
				}                     
	                  
	       }

}		

?>
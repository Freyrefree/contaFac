<?php
set_time_limit(0);
include('../Models/model.clientes.php'); //Modelo clientes
$cliente  = new Cliente();
$busquedapais = new Cliente();
$busquedaestado = new Cliente();
$busquedamunicipio = new Cliente();
$busquedacp = new Cliente();
$busquedaCol = new Cliente();
session_start();
if(!$_POST)
{
}
else
{
	$rfc=utf8_decode($_POST['rfc']);
	if(!preg_match("/^[A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]$/",$rfc)){
		echo "2";
		return false;
		exit;
	}


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

							// $busquedaCol->set("colonia",addslashes(utf8_decode($_POST['colonia'])));
							// $busquedaCol->buscarCol();
							// $idColonia=$busquedaCol->get("idColonia");
							$colonias=explode("-", $_POST['colonia']);


							$idcp=$rowcp['rowid'];
							$idmunicipio=$rowm['rowid'];
							$idestado = $rowe['rowid'];
							$idpais = $row['rowid'];
							$cliente->set("rfc",			addslashes(utf8_decode($_POST['rfc'])));
							$cliente->set("razonsocial",	addslashes(utf8_decode($_POST['razonsocial'])));
							$cliente->set("sucursal",	addslashes(utf8_decode($_POST['sucursal'])));
							//$cliente->set("cuenta",	addslashes(utf8_decode($_POST['cuenta'])));
							$cliente->set("email",	addslashes(utf8_decode($_POST['email'])));
							$cliente->set("telefono",	addslashes(utf8_decode($_POST['telefono'])));
							$cliente->set("contacto",	addslashes(utf8_decode($_POST['contacto'])));
							//$cliente->set("codigopostal",	addslashes(utf8_decode($_POST['codigopostal'])));
							//$cliente->set("municipio",	addslashes(utf8_decode($_POST['municipio'])));
							$cliente->set("pais",	addslashes(utf8_decode($idpais)));
							$cliente->set("estado",	addslashes(utf8_decode($idestado)));
							$cliente->set("municipio",	addslashes(utf8_decode($idmunicipio)));
							$cliente->set("codigopostal",	addslashes(utf8_decode($idcp)));
							$cliente->set("colonia",	addslashes(utf8_decode(trim($colonias[0]))));
							$cliente->set("calle",	addslashes(utf8_decode($_POST['calle'])));
							$cliente->set("numinterior",	addslashes(utf8_decode($_POST['numinterior'])));
							$cliente->set("numexterior",	addslashes(utf8_decode($_POST['numexterior'])));
							$cliente->set("rfc_empresa",addslashes($_SESSION['fa_rfc']));
							$cliente->set("cfdi",	addslashes(utf8_decode($_POST['cfdi'])));
							$datos=$cliente->add();
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

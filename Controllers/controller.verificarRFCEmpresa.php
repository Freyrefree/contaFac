<?php
set_time_limit(0);
include('../Models/model.empresa.php'); //Modelo clientes
$empresa  = new Empresa();
$empresa->set("rfc",	        utf8_decode($_POST['rfc']));
$resultados=$empresa->verificarRFCEmpresa();
  if ($resultados->num_rows > 0)
  {
    echo 1;
  }
  else
  {
    echo 0;
  }
?>

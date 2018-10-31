<?php
include('../Models/model.claveU.php');

$datos= new Unidad();
$res= $datos->listageneral();

while($row = mysqli_fetch_array($res))
{
    $data[] = array(
                'id'              => utf8_decode($row['id']),
                'clave_sat'       => utf8_decode($row['clave_sat']),
                'descripcion_sat' => utf8_decode($row['descripcion_sat']),
                'descripcion'     => utf8_decode($row['descripcion_empresa'])
              );
}
echo json_encode($data);
?>
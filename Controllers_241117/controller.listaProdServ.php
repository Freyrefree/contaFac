<?php
include('../Models/model.productos.php');

$datos= new Productos();
$res= $datos->listageneral();

while($row = mysqli_fetch_array($res))
{
    $data[] = array(
                'id'              => utf8_decode($row['id']),
                'clave_sat'       => utf8_decode($row['clave_sat']),
                'descripcion_sat' => utf8_decode($row['descripcion_sat']),
                'clave'           => utf8_decode($row['clave_interna']),
                'descripcion'     => utf8_decode($row['descripcion_empresa'])
              );
}
echo json_encode($data);
?>
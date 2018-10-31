<?php
include('Models/clientes.php');

$datos= new Cliente();

$res= $datos->listageneral();
while($row = mysqli_fetch_array($res))
{
    //$servicio = $row['TIPO_SERV']; 
    $data[] = array(
                'id'          => utf8_decode($row['id']),
                'rfc'         => utf8_decode($row['rfc']),
                'razonsocial' => utf8_decode($row['razon_social']),
                'cuenta'      => utf8_decode($row['cuenta']),
                'correo'      => utf8_decode($row['correos'])
              );
}
echo json_encode($data);
?>
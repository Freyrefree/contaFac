<?php
include('../Models/model.clientes.php');
session_start();
$datos = new Cliente();
$datos->set('rfc',$_SESSION['fa_rfc']);
$res = $datos->datosGRID();
		while($row = mysqli_fetch_array($res))
		{
			$estaus='';
			if(utf8_encode($row['estatus'])==1)
			{
				$estatus = 'Activo';
			}
			else
			{
				$estatus = 'Inactivo';
			}
			// $sucursal ='';
			// if(utf8_encode($row['sucursal'])==1)
			// {
			// 	$sucursal = "Matriz";
			// }
			// else if(utf8_encode($row['sucursal'])==2)
			// {
			// 	$sucursal = "Sucursal";
			// }
			// else
			// {
			// 	$sucursal = "";
			// }

			$data[] = array(
									  'id'          => $row['id'],
									  'rfc'         => utf8_encode($row['rfc']),
									  'razonsocial' => utf8_encode($row['razon_social']),
									  'sucursal' => utf8_encode($row['sucursal']),
										//'sucursal' => utf8_encode($sucursal),
									  //'cuenta'      => utf8_encode($row['cuenta']),
									 'correo'      => utf8_encode($row['correos']),
									 'telefono'      => utf8_encode($row['telefono']),
									 'contacto'      => utf8_encode($row['contacto']),
									 'estatus'     => utf8_encode($estatus),
									  'pais'       => utf8_encode($row['pais']),
									  'estado'     => utf8_encode($row['estado']),
									  'municipio'  => utf8_encode($row['municipio']),
									  'colonia'    => utf8_encode($row['colonia']),
									  'calle'      => utf8_encode($row['calle']),
									  'ninterior'  => utf8_encode($row['ninterior']),
									  'nexterior'  => utf8_encode($row['nexterior']),
									  'cp'         => utf8_encode($row['cp']),
									  'cfdi'       => utf8_encode($row['c_usocfdi'])

						  );
			}
			print json_encode($data);
?>

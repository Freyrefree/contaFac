<?php
include('../Models/model.clientes.php');
$datos = new Cliente();
$res = $datos->datosGRID();
		while($row = mysqli_fetch_array($res))
		{

			$data[] = array(
									  'id'          => $row['id'],
									  'rfc'         => utf8_encode($row['rfc']),
									  'razonsocial' => utf8_encode($row['razon_social']),
									  'cuenta'      => utf8_encode($row['cuenta']),
									 'correo'      => utf8_encode($row['correos']),
									 'estatus'     => utf8_encode($row['estatus']),									
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
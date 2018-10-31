<?php
include('../Models/usuario2.php');
$grid = new Usuario();
$respuesta = $grid->datosGRID();
		while($fila = mysqli_fetch_array($respuesta))
		{
			$estaus='';
			if($fila['estatus']==1){$estatus = 'Activo';}else{$estatus = 'Inactivo';}
			$perfil='';
			if($fila['perfil']==1){$perfil = 'Administrador';}else{$perfil = 'Facturación';}

			$data[] = array(
									  'id'             => $fila['id'],
									  'nombre'         => utf8_encode($fila['nombre']),
									  'login'          => utf8_encode($fila['login']),
										'clave_seguridad'=> utf8_encode($fila['clave_seguridad']),
									  'perfil'         => $perfil,
									  'estatus'        => $estatus,
									  'id_empresa'     => utf8_encode($fila['id_empresa']),
										'nombre_empresa' => utf8_encode($fila['nombre_empresa']),

						  );
			}
			print json_encode($data);
?>

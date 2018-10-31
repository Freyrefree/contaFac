<?php
include('../Models/usuario2.php'); //Modelo usuarios
$buscapswBD  = new Usuario();
$idusuario = addslashes(utf8_decode($_GET['id']));
$buscapswBD->set('id',$idusuario);
$respuesta=$buscapswBD->buscapsw();
while($fila = mysqli_fetch_array($respuesta))
{
	$pswBD=$fila['clave_seguridad'];
			$psw = addslashes(utf8_decode(sha1(md5($_GET['psw']))));
			$data[] = array('psw'=> $psw,'pswBD' => $pswBD,);

}
print json_encode($data);
?>

<?php
set_time_limit(0);
include_once 'Models/usuario.php'; //Modelo usuario
$usuario  = new Usuario();
if(!$_POST){
	// error de datos
	echo 1; //error no hay datos a validar
	exit;
}else {
	$rolUsuario = "";
	$id_Usuario = "";
	
	$usuario->set("email",	  addslashes(utf8_decode($_POST['email'])));
	$usuario->set("password", addslashes(utf8_decode(sha1(md5($_POST['password'])))));
	//$usuario->set("password", addslashes(utf8_decode($_POST['password'])));
	$usuario->validar();
	$id_Usuario = $usuario->get("id");
	$nombre     = $usuario->get("nombre");
	$rolUsuario = $usuario->get("perfil");
	$rfc 		= $usuario->get("rfc");

	

	$psw        = utf8_decode(sha1(md5($_POST['password'])));
	$login        = utf8_decode($_POST['email']);
	
	if(empty($rolUsuario)){
			echo 2;
			exit;
		}else{
			session_start();
			$_SESSION["fa_login"]  = 1;
			$_SESSION["fa_id"] 	   = $id_Usuario;
			$_SESSION["fa_nombre"] = $nombre;
			$_SESSION["fa_perfil"] = $rolUsuario;
			$_SESSION["fa_rfc"]		= $rfc;

						
			@$_SESSION["fa_email"] 	   =  $login;
			$_SESSION["fa_psw"] = $psw;

			echo 3;
		}
}
?>

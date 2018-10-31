<?php
include('../Models/usuario2.php');


$id=$_GET['id'];
$eliminar=new Usuario();
$eliminar->set('id',$id);
$respuesta=$eliminar->eliminarUsuario();
if($respuesta){
	echo 1;
}else{
	echo 0;
}
?>

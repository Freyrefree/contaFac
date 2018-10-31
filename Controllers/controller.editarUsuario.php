<?php
set_time_limit(0);
include('../Models/usuario2.php'); //Modelo usuario
$editarUsuario  = new Usuario();

if(!$_POST)
{
}
else
{


							if(($_POST['psw1']!='') and ($_POST['usuario']!=''))
							{
								$psw = addslashes(utf8_decode(sha1(md5($_POST['psw1']))));
								$editarUsuario->set("id",			addslashes(utf8_decode($_POST['id'])));
								$editarUsuario->set("nombre",			addslashes(utf8_decode($_POST['nombre'])));
								$editarUsuario->set("usuario",			addslashes(utf8_decode($_POST['usuario'])));
								$editarUsuario->set("psw",	$psw);
								$editarUsuario->set("comboPerfil",	addslashes(utf8_decode($_POST['comboPerfil'])));
								$editarUsuario->set("comboEmpresa",	addslashes(utf8_decode($_POST['comboEmpresa'])));
								$editarUsuario->set("estatus",	addslashes(utf8_decode($_POST['estatus'])));
								$respuesta=$editarUsuario->modificar();
								if($respuesta)
								{
									echo 1;
								}
								else
								{
									echo $respuesta;
								}
							}else
							{
								if(($_POST['psw1']=='') and ($_POST['usuario']==''))
								{
										$editarUsuario->set("id",			addslashes(utf8_decode($_POST['id'])));
										$editarUsuario->set("nombre",			addslashes(utf8_decode($_POST['nombre'])));
										$editarUsuario->set("comboPerfil",	addslashes(utf8_decode($_POST['comboPerfil'])));
										$editarUsuario->set("comboEmpresa",	addslashes(utf8_decode($_POST['comboEmpresa'])));
										$editarUsuario->set("estatus",	addslashes(utf8_decode($_POST['estatus'])));
										$respuesta=$editarUsuario->modificarSinPSWyCorreo();
										if($respuesta){echo 1;}else{echo $respuesta;}
							  }else
								{
									if(($_POST['psw1']=='') and ($_POST['usuario']!=''))////sin modificar contraseña
									{
										$editarUsuario->set("id",			addslashes(utf8_decode($_POST['id'])));
										$editarUsuario->set("nombre",			addslashes(utf8_decode($_POST['nombre'])));
										$editarUsuario->set("usuario",			addslashes(utf8_decode($_POST['usuario'])));
										$editarUsuario->set("comboPerfil",	addslashes(utf8_decode($_POST['comboPerfil'])));
										$editarUsuario->set("comboEmpresa",	addslashes(utf8_decode($_POST['comboEmpresa'])));
										$editarUsuario->set("estatus",	addslashes(utf8_decode($_POST['estatus'])));
										$respuesta=$editarUsuario->modificarSinPSW();
										if($respuesta){echo 1;}else{echo $respuesta;}
									}else
									{
										if(($_POST['psw1']!='') and ($_POST['usuario']==''))///sin modifcar correo
										{
											$psw = addslashes(utf8_decode(sha1(md5($_POST['psw1']))));
											$editarUsuario->set("id",			addslashes(utf8_decode($_POST['id'])));
											$editarUsuario->set("nombre",			addslashes(utf8_decode($_POST['nombre'])));
											$editarUsuario->set("psw",	$psw);
											$editarUsuario->set("comboPerfil",	addslashes(utf8_decode($_POST['comboPerfil'])));
											$editarUsuario->set("comboEmpresa",	addslashes(utf8_decode($_POST['comboEmpresa'])));
											$editarUsuario->set("estatus",	addslashes(utf8_decode($_POST['estatus'])));
											$respuesta=$editarUsuario->modificarsinCorreo();
											if($respuesta){echo 1;}else{echo $respuesta;}
										}
									}
								}

							}

}

?>

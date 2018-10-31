<?php
set_time_limit(0);
include('../Models/usuario2.php'); //Modelo clientes
$registrar  = new Usuario();
$busquedaEmpresa = new Usuario();
if(!$_POST)
{
}
else
{
              $psw = addslashes(utf8_decode(sha1(md5($_POST['psw1']))));

							$registrar->set("nombre",	        addslashes(utf8_decode($_POST['nombre'])));
							$registrar->set("login",	        addslashes(utf8_decode($_POST['usuario'])));
							$registrar->set("clave_seguridad",$psw);
							$registrar->set("perfil",	        addslashes(utf8_decode($_POST['comboPerfil'])));
							$registrar->set("estatus",	      addslashes(utf8_decode($_POST['estatus'])));
							$registrar->set("id_empresa",	    addslashes(utf8_decode($_POST['comboEmpresa'])));


							$respuesta=$registrar->registrar();
							if($respuesta)
							{
								echo 1;
							}
							else
							{
								echo $respuesta;
							}
}

?>

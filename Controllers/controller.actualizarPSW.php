<?php
set_time_limit(0);
include('../Models/usuario2.php'); //Modelo usuarios
$actualizarpsw  = new Usuario();

if(!$_POST)
{
}
else
{

              $psw = addslashes(utf8_decode(sha1(md5($_POST['pswn']))));
              $actualizarpsw->set("id",	        addslashes(utf8_decode($_POST['id'])));
              $actualizarpsw->set("nuevapsw",                      $psw);
              $respuesta=$actualizarpsw->actualizarPSW();
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

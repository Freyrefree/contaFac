<?php
//set_time_limit(0);
include('../Models/usuario2.php'); //Modelo usuario
$usuario  = new Usuario();
$id=$_GET['id'];
$usuario->set("id",$id);
$respuesta=$usuario->buscardatos();

        while($fila = mysqli_fetch_array($respuesta))
        {

                       $datos[] = array(



                        'nombre'=>utf8_encode($fila['nombre']),
                        'login'=>utf8_encode($fila['login']),
                        'clave_seguridad'=> utf8_encode($fila['clave_seguridad']),
                        'perfil' => utf8_encode($fila['perfil']),
                        'estatus' => utf8_encode($fila['estatus']),

                        'id_empresa'=>utf8_encode($fila['id_empresa'])

                                );


      }

    echo json_encode($datos);
?>

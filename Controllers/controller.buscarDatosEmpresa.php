<?php
//set_time_limit(0);
include('../Models/model.empresa.php'); //Modelo clientes
$empresa  = new Empresa();
$respuesta=$empresa->verificarRegistro();
        while($fila = mysqli_fetch_array($respuesta))
        {

                       $datos[] = array(

                                'id'=>utf8_encode($fila['id_empresa']),
                                'rfc'=>utf8_encode($fila['rfc']),
                                'razonsocial'=>utf8_encode($fila['razon_social']),
                                'pais'=>utf8_encode($fila['pais']),
                                'estado'=> utf8_encode($fila['estado']),
                                'municipio' => utf8_encode($fila['municipio']),
                                'colonia' => utf8_encode($fila['colonia']),
                                'cp' => utf8_encode($fila['cp']),
                                'calle' => utf8_encode($fila['calle']),
								                'numinterior' => utf8_encode($fila['nint']),
								                'numexterior' => utf8_encode($fila['next']),
                                'referencia' => utf8_encode($fila['referencia']),
								                'email' => utf8_encode($fila['correo']),
								                'telefono' => utf8_encode($fila['telefono']),
                                'celular' => utf8_encode($fila['celular']),
                                'responsable' =>utf8_encode($fila['responsable']),
                                'certificado' => utf8_encode($fila['num_certificado']),
                                'regimenfis' => utf8_encode($fila['regimen_fiscal']),
                                'clavekey' => utf8_encode($fila['clave_key'])
                                );

      }

    echo json_encode($datos);
?>

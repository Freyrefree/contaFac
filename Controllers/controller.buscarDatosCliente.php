<?php
//set_time_limit(0);
include('../Models/model.clientes.php'); //Modelo clientes
$cliente  = new Cliente();
$id=$_GET['id'];
$cliente->set("id",$id);

$res=$cliente->buscardatos();

        while($row = mysqli_fetch_array($res))
        {

// $rfc=$cliente->get("rfc");
// $razonsocial=$cliente->get("razonsocial");
// $cuenta=$cliente->get("cuenta");
// $correos=$cliente->get("correos");
// //$estatus=$cliente->get("descripcion");
// $idestado=$cliente->get("idestado");
// $idmuni=$cliente->get("idmuni");
// $municipio=$cliente->get("c_nombre_municipio");
// //$idcp=$cliente->get("idcp");
// $calle=$cliente->get("calle");
// $ninterior=$cliente->get("ninterior");
// $nexterior=$cliente->get("nexterior");
// $idcfdi=$cliente->get("idcfdi");


                       $datos[] = array(

                       			// 'rfc'=>$rfc,
                          //       'razonsocial'=>$razonsocial,
                          //       'cuenta'=> $cuenta,
                          //       'correo' => $correos,
                          //       'idestado' => $idestado,
                          //       'idmuni' => $idmuni,
                          //       'municipio' => $municipio,
                          //       //'idcp' => $idcp,
                          //       'calle' => $calle,
                          //       'ninterior' => $ninterior,
                          //       'nexterior' => $nexterior,
                          //       'idcfdi' => $idcfdi

                        'rfc'=>utf8_encode($row['rfc']),
                                'razonsocial'=>utf8_encode($row['razon_social']),
                                'sucursal'=>utf8_encode($row['sucursal']),
                                'cuenta'=> utf8_encode($row['cuenta']),
                                'correo' => utf8_encode($row['correos']),
                                'telefono' => utf8_encode($row['telefono']),
                                'contacto' => utf8_encode($row['contacto']),
                                'idestado' => utf8_encode($row['rowidestado']),
								'c_municipio' => utf8_encode($row['c_municipio']),
								'c_nombre_municipio' => utf8_encode($row['c_nombre_municipio']),
                                'c_cp' => $row['c_cp'],
								'idcolonia' => utf8_encode($row['idcolonia']),
								'c_nombre_colonia' => utf8_encode($row['c_nombre_colonia']),
                                'calle' => utf8_encode($row['calle']),
                                'ninterior' =>utf8_encode($row['ninterior']),
                                'nexterior' => utf8_encode($row['nexterior']),
                                'idcfdi' => utf8_encode($row['rowid'])

                                );



            //$this->rfc=utf8_encode($row['rfc']);
            //   $this->razonsocial=utf8_encode($row['razon_social']);
            //   $this->cuenta=utf8_encode($row['cuenta']);
            //   $this->correos=utf8_encode($row['correos']);
            //   //$this->estatus=utf8_encode($row['estatus']);
            //   $this->idestado=utf8_encode($row['rowidestado']);
            //   $this->idmuni=utf8_encode($row['rowidmuni']);
            //   $this->c_nombre_municipio=utf8_encode($row['c_nombre_municipio']);
            //   //$this->idcp=utf8_encode($row['rowcp']);
            //   $this->calle=utf8_encode($row['calle']);
            //   $this->ninterior=utf8_encode($row['ninterior']);
            //   $this->nexterior=utf8_encode($row['nexterior']);
            //   $this->idcfdi=utf8_encode($row['rowid']);

      }

    echo json_encode($datos);
?>

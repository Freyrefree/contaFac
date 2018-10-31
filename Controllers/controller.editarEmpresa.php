<?php
set_time_limit(0);
include('../Models/model.empresa.php'); //Modelo clientes
$modificar  = new Empresa();

  if(($_FILES['logo']!='') and ($_FILES['archivo'] != ''))
  {

              $directorio = "../img/";
              $path = $_FILES['logo']['name'];
              $ext = pathinfo($path, PATHINFO_EXTENSION);
              $nombrefile = $_POST['rfc'];

              $pathzip = $_FILES['archivo']['name'];
              $extzip = pathinfo($pathzip, PATHINFO_EXTENSION);
              $nombrefilezip = $_POST['rfc'];




              $modificar->set("id",	        addslashes(utf8_decode($_POST['idempresa'])));
              $modificar->set("rfc",	        addslashes(utf8_decode($_POST['rfc'])));
							$modificar->set("razonsocial",	        addslashes(utf8_decode($_POST['razonsocial'])));
							$modificar->set("pais",	        addslashes(utf8_decode($_POST['pais'])));
							$modificar->set("estado",	      addslashes(utf8_decode($_POST['estado'])));
							$modificar->set("municipio",	    addslashes(utf8_decode($_POST['municipio'])));
              $modificar->set("colonia",	    addslashes(utf8_decode($_POST['colonia'])));
              $modificar->set("cp",	    addslashes(utf8_decode($_POST['cp'])));
							$modificar->set("calle",	    addslashes(utf8_decode($_POST['calle'])));
              $modificar->set("numexterior",	    addslashes(utf8_decode($_POST['numexterior'])));
              $modificar->set("numinterior",	    addslashes(utf8_decode($_POST['numinterior'])));
              $modificar->set("referencia",	    addslashes(utf8_decode($_POST['referencia'])));
              $modificar->set("email",	    addslashes(utf8_decode($_POST['email'])));
              $modificar->set("telefono",	    addslashes(utf8_decode($_POST['telefono'])));
              $modificar->set("celular",	    addslashes(utf8_decode($_POST['celular'])));
              $modificar->set("responsable",	    addslashes(utf8_decode($_POST['responsable'])));
              $modificar->set("certificado",	    addslashes(utf8_decode($_POST['certificado'])));
              $modificar->set("regimenfis",	    addslashes(utf8_decode($_POST['regimenfis'])));
              $modificar->set("clavekey",	    addslashes(utf8_decode($_POST['clavekey'])));
              //$modificar->set("archivo",	$directorio.$nombrefilezip.'.'.$extzip);
              $modificar->set("logo",$directorio.$nombrefile.'.'.$ext);




							$respuesta=$modificar->actualizar();
							if($respuesta)
							{

                $subidalogo = 1;
                $temp = explode(".", $_FILES["logo"]["name"]);

                $nombrearchivo = $nombrefile . '.' . end($temp);
                // if everything is ok, try to upload file
                if ($subidalogo == 1)
                {
                    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $directorio . $nombrearchivo)) {
                        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    } else {
                        //echo "Sorry, there was an error uploading your file.";
                    }
                }


                $subidazip = 1;
                $temp = explode(".", $_FILES["archivo"]["name"]);

                $nombrearchivo = $nombrefile . '.' . end($temp);
                // if everything is ok, try to upload file
                if ($subidazip == 1)
                {
                    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $nombrearchivo)) {
                        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    } else {
                        //echo "Sorry, there was an error uploading your file.";
                    }
                }
								echo 1;

							}
							else
							{

								echo $respuesta;
							}
    }
    else if(($_FILES['logo']!=''))
    {

                $directorio = "../img/";
                $path = $_FILES['logo']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombrefile = $_POST['rfc'];

                $modificar->set("id",	        addslashes(utf8_decode($_POST['idempresa'])));
                $modificar->set("rfc",	        addslashes(utf8_decode($_POST['rfc'])));
  							$modificar->set("razonsocial",	        addslashes(utf8_decode($_POST['razonsocial'])));
  							$modificar->set("pais",	        addslashes(utf8_decode($_POST['pais'])));
  							$modificar->set("estado",	      addslashes(utf8_decode($_POST['estado'])));
  							$modificar->set("municipio",	    addslashes(utf8_decode($_POST['municipio'])));
                $modificar->set("colonia",	    addslashes(utf8_decode($_POST['colonia'])));
                $modificar->set("cp",	    addslashes(utf8_decode($_POST['cp'])));
  							$modificar->set("calle",	    addslashes(utf8_decode($_POST['calle'])));
                $modificar->set("numexterior",	    addslashes(utf8_decode($_POST['numexterior'])));
                $modificar->set("numinterior",	    addslashes(utf8_decode($_POST['numinterior'])));
                $modificar->set("referencia",	    addslashes(utf8_decode($_POST['referencia'])));
                $modificar->set("email",	    addslashes(utf8_decode($_POST['email'])));
                $modificar->set("telefono",	    addslashes(utf8_decode($_POST['telefono'])));
                $modificar->set("celular",	    addslashes(utf8_decode($_POST['celular'])));
                $modificar->set("responsable",	    addslashes(utf8_decode($_POST['responsable'])));
                $modificar->set("certificado",	    addslashes(utf8_decode($_POST['certificado'])));
                $modificar->set("regimenfis",	    addslashes(utf8_decode($_POST['regimenfis'])));
                $modificar->set("clavekey",	    addslashes(utf8_decode($_POST['clavekey'])));
                //$modificar->set("archivo",	$directorio.$nombrefilezip.'.'.$extzip);
                $modificar->set("logo",$directorio.$nombrefile.'.'.$ext);




  							$respuesta=$modificar->actualizarSinArchivo();
  							 if($respuesta)
  							{

                  $subidalogo = 1;
                  $temp = explode(".", $_FILES["logo"]["name"]);

                  $nombrearchivo = $nombrefile . '.' . end($temp);
                  // if everything is ok, try to upload file
                  if ($subidalogo == 1)
                  {
                      if (move_uploaded_file($_FILES["logo"]["tmp_name"], $directorio . $nombrearchivo)) {
                          //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                      } else {
                          //echo "Sorry, there was an error uploading your file.";
                      }
                  }



  								echo 1;

  							}
  							else
  							{

  								echo $respuesta;
  							}
      }
      else if(($_FILES['archivo'] != ''))
      {

                  $directorio = "../img/";


                  $pathzip = $_FILES['archivo']['name'];
                  $extzip = pathinfo($pathzip, PATHINFO_EXTENSION);
                  $nombrefilezip = $_POST['rfc'];

                  $modificar->set("id",	        addslashes(utf8_decode($_POST['idempresa'])));
                  $modificar->set("rfc",	        addslashes(utf8_decode($_POST['rfc'])));
                  $modificar->set("razonsocial",	        addslashes(utf8_decode($_POST['razonsocial'])));
                  $modificar->set("pais",	        addslashes(utf8_decode($_POST['pais'])));
                  $modificar->set("estado",	      addslashes(utf8_decode($_POST['estado'])));
                  $modificar->set("municipio",	    addslashes(utf8_decode($_POST['municipio'])));
                  $modificar->set("colonia",	    addslashes(utf8_decode($_POST['colonia'])));
                  $modificar->set("cp",	    addslashes(utf8_decode($_POST['cp'])));
                  $modificar->set("calle",	    addslashes(utf8_decode($_POST['calle'])));
                  $modificar->set("numexterior",	    addslashes(utf8_decode($_POST['numexterior'])));
                  $modificar->set("numinterior",	    addslashes(utf8_decode($_POST['numinterior'])));
                  $modificar->set("referencia",	    addslashes(utf8_decode($_POST['referencia'])));
                  $modificar->set("email",	    addslashes(utf8_decode($_POST['email'])));
                  $modificar->set("telefono",	    addslashes(utf8_decode($_POST['telefono'])));
                  $modificar->set("celular",	    addslashes(utf8_decode($_POST['celular'])));
                  $modificar->set("responsable",	    addslashes(utf8_decode($_POST['responsable'])));
                  $modificar->set("certificado",	    addslashes(utf8_decode($_POST['certificado'])));
                  $modificar->set("regimenfis",	    addslashes(utf8_decode($_POST['regimenfis'])));
                  $modificar->set("clavekey",	    addslashes(utf8_decode($_POST['clavekey'])));
                  //$modificar->set("archivo",	$directorio.$nombrefilezip.'.'.$extzip);
                //  $modificar->set("logo",$directorio.$nombrefile.'.'.$ext);




                  $respuesta=$modificar->actualizarSinLogo();
                  if($respuesta)
                  {
                    $subidazip = 1;
                    $temp = explode(".", $_FILES["archivo"]["name"]);

                    $nombrearchivo = $nombrefile . '.' . end($temp);
                    // if everything is ok, try to upload file
                    if ($subidazip == 1)
                    {
                        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $nombrearchivo)) {
                            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        } else {
                            //echo "Sorry, there was an error uploading your file.";
                        }
                    }
                    echo 1;

                  }
                  else
                  {

                    echo $respuesta;
                  }
        }
        else if(($_FILES['archivo'] == '') and ($_FILES['logo'] == ''))
        {



                    $modificar->set("id",	        addslashes(utf8_decode($_POST['idempresa'])));
                    $modificar->set("rfc",	        addslashes(utf8_decode($_POST['rfc'])));
                    $modificar->set("razonsocial",	        addslashes(utf8_decode($_POST['razonsocial'])));
                    $modificar->set("pais",	        addslashes(utf8_decode($_POST['pais'])));
                    $modificar->set("estado",	      addslashes(utf8_decode($_POST['estado'])));
                    $modificar->set("municipio",	    addslashes(utf8_decode($_POST['municipio'])));
                    $modificar->set("colonia",	    addslashes(utf8_decode($_POST['colonia'])));
                    $modificar->set("cp",	    addslashes(utf8_decode($_POST['cp'])));
                    $modificar->set("calle",	    addslashes(utf8_decode($_POST['calle'])));
                    $modificar->set("numexterior",	    addslashes(utf8_decode($_POST['numexterior'])));
                    $modificar->set("numinterior",	    addslashes(utf8_decode($_POST['numinterior'])));
                    $modificar->set("referencia",	    addslashes(utf8_decode($_POST['referencia'])));
                    $modificar->set("email",	    addslashes(utf8_decode($_POST['email'])));
                    $modificar->set("telefono",	    addslashes(utf8_decode($_POST['telefono'])));
                    $modificar->set("celular",	    addslashes(utf8_decode($_POST['celular'])));
                    $modificar->set("responsable",	    addslashes(utf8_decode($_POST['responsable'])));
                    $modificar->set("certificado",	    addslashes(utf8_decode($_POST['certificado'])));
                    $modificar->set("regimenfis",	    addslashes(utf8_decode($_POST['regimenfis'])));
                    $modificar->set("clavekey",	    addslashes(utf8_decode($_POST['clavekey'])));

                    $respuesta=$modificar->actualizarSinLogoySinArchivo();
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

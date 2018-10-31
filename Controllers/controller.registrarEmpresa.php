<?php
set_time_limit(0);
include('../Models/model.empresa.php'); //Modelo clientes
$registrar  = new Empresa();
if(!$_POST)
{
}
else
{

              $directorio = "../img/";
              $path = $_FILES['logo']['name'];
              $ext = pathinfo($path, PATHINFO_EXTENSION);
              $nombrefile = $_POST['rfc'];

              $pathzip = $_FILES['archivo']['name'];
              $extzip = pathinfo($pathzip, PATHINFO_EXTENSION);
              $nombrefilezip = $_POST['rfc'];




							$registrar->set("rfc",	        addslashes(utf8_decode($_POST['rfc'])));
							$registrar->set("razonsocial",	        addslashes(utf8_decode($_POST['razonsocial'])));
							$registrar->set("pais",	        addslashes(utf8_decode($_POST['pais'])));
							$registrar->set("estado",	      addslashes(utf8_decode($_POST['estado'])));
							$registrar->set("municipio",	    addslashes(utf8_decode($_POST['municipio'])));
              $registrar->set("colonia",	    addslashes(utf8_decode($_POST['colonia'])));
              $registrar->set("cp",	    addslashes(utf8_decode($_POST['cp'])));
							$registrar->set("calle",	    addslashes(utf8_decode($_POST['calle'])));
              $registrar->set("numexterior",	    addslashes(utf8_decode($_POST['numexterior'])));
              $registrar->set("numinterior",	    addslashes(utf8_decode($_POST['numinterior'])));
              $registrar->set("referencia",	    addslashes(utf8_decode($_POST['referencia'])));
              $registrar->set("email",	    addslashes(utf8_decode($_POST['email'])));
              $registrar->set("telefono",	    addslashes(utf8_decode($_POST['telefono'])));
              $registrar->set("celular",	    addslashes(utf8_decode($_POST['celular'])));
              $registrar->set("responsable",	    addslashes(utf8_decode($_POST['responsable'])));
              $registrar->set("certificado",	    addslashes(utf8_decode($_POST['certificado'])));
              $registrar->set("regimenfis",	    addslashes(utf8_decode($_POST['regimenfis'])));
              $registrar->set("clavekey",	    addslashes(utf8_decode($_POST['clavekey'])));
              $registrar->set("archivo",	$directorio.$nombrefilezip.'.'.$extzip);
              $registrar->set("logo",$directorio.$nombrefile.'.'.$ext);




							$respuesta=$registrar->registrar();
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

?>

<?php
include('../models/model.facturacion.php');
$getCorreo = new factura();

function enviarCorreoconarchivo($pBodyUsu, $asunto, $correousu, $CC, $archivopdf,$archivoxml)
    {
        $retorno = 0;
        require_once('../libs/swiftmailer/swift_required.php');
       // require_once('../ConfCorreo.php');
            
    
        try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
          ->setUsername('soporte@aiko.com.mx')
          ->setPassword('soporte**17');
          $mailer = Swift_Mailer::newInstance($transport);
          $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Sistema Facturas'))
            ->setTo($correousu)
            //->setTo('al221311043@gmail.com')
            //->setTo($correousu)
            //->setCC(array('cristian.reyes@bcdme.mx','soportebcd@aiko.com.mx'))
            ->setCC($CC)//con copia
            ->setBody($pBodyUsu, 'text/html')
            ->attach(Swift_Attachment::fromPath($archivopdf))//archivo adjunto
            ->attach(Swift_Attachment::fromPath($archivoxml));//archivo adjunto
          if ($mailer->send($message)){
            //echo '/Mensaje enviado con éxito';
            $retorno = 1;
          }
          else{
           // echo 'Problema al enviar el mensaje a '.$correousu.'.';
            $retorno = 0;
          }
        } 
        catch (Exception $e) {
         // echo 'Excepción capturada al enviar correo a '.$correousu.'.',  $e->getMessage(), "\n";
         $retorno = 0;
        }
        return $retorno;
    }

if(@$_POST['opc'] == 1)
{
    $id = $_POST['id'];
    $getCorreo->set("id",$id);
    $getCorreo->consultaRFC();
    $correo = $getCorreo->get("correo");

    $array[0]=$correo;
    echo json_encode($array);
}elseif(@$_POST['opc'] == 2){

    $id = $_POST['id'];
    $getCorreo->set("id",$id);
    $getCorreo->consultaRFC();

    $correo = $getCorreo->get("correo");
    $foliofiscal = $getCorreo->get("foliofiscal");
    $serie = $getCorreo->get("serie");
    $folio = $getCorreo->get("folio");

    $rfc_emisor = $getCorreo->get("rfcemisor");
    $razonsocialempresa = $getCorreo->get("rzempresa");
    $rfc_receptor = $getCorreo->get("rfcreceptor");
    $razonsocialcliente = $getCorreo->get("rzcliente");
    $total = $getCorreo->get("total");
    $totalnumber=number_format($total,2,'.',' ');


    $rutapdf = "../comprobantesCfdi/".$foliofiscal.".pdf";
    $rutaxml = "../comprobantesCfdi/".$foliofiscal.".xml";
    $CC = "yadira89@hotmail.com";


    $pBodyUsu = '
    <html>
        <head>		
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
    
    
    td.center {
      background-color: white;
      color: #003366;
      font-weight: bold;
    }
    </style>		
        </head>
        <body>
            <center>				
                <table>
                    <tr>
                        <td colspan="2" ><center><font font size="4">Detalles Factura</font></center></td>
                    </tr>
                    <tr>					
                    </tr>
                    <tr>					
                        <td><font color="#003366">Total: </font></td>
                        <td class="center">' ."$ ".$totalnumber.'</td>					
                    </tr>

                    <tr>					
                        <td><font color="#003366">Factura: </font></td>
                        <td class="center">' .$serie.' '.$folio.'</td>					
                    </tr>

                    <tr>
                        <td><font color="#003366">RFC Emisor: </font></td>
                        <td class="center">'.$rfc_emisor.'</td>					
                    </tr>
                    <tr>					
                        <td><font color="#003366">Razón Social Emisor: </font></td>
                        <td class="center">'.$razonsocialempresa.'</td>					
                    </tr>
                    <tr>					
                        <td><font color="#003366">RFC Receptor: </font></td>
                        <td class="center">'.$rfc_receptor.'</td>					
                    </tr>
                    <tr>					
                        <td><font color="#003366">Razón Social Receptor: </font></td>
                        <td class="center">'.$razonsocialcliente.'</td>					
                    </tr>
                    
                    
                </table>
            </center>
        </body>
    </html>';
    $asunto = "Envío de Factura ".$serie." ".$folio;
    

    if (enviarCorreoconarchivo($pBodyUsu,$asunto,$correo,$CC,$rutapdf,$rutaxml) == 1)
    {
        echo 1;
    }
    else
    {
         echo 0;
    }
    



    
}




?>
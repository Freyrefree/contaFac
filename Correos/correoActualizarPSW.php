<?php
$nombre=$_POST['correonombreusuario'];
$psw = $_POST['correopsw'];
$correo =$_POST['correologin'];
date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d H:i:s");
$ejecutar= $_POST['ejecutarfuncion'];
if($ejecutar=="si")
{
		$html = '
							<html>
							<head>
							<title>Notificacion</title>
							<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
							<style type="text/css">
							</style>
							</head>
							<body>
								<center>
									<table width="80%" style=" font-family: Arial, Helvetica, sans-serif; ">
									<tr>
										<td align="left" ><img src="http://www.aiko.com.mx/images/logo2.png" border=0  width="150px" /></td>
									</tr>
									<tr >
										<td colspan="3" bgcolor="#337AB7" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
											<font color="#FFFFFF" size="4px">
												SISTEMA FACTURAS
											</font>
										</td>
									</tr>
									</table>
									<table width="80%" style="font-family: Arial, Helvetica, sans-serif; ">
									<tr>
										<td colspan="2" style="height: 10px; color:#575756; font-size: 13px;">
										</td>
									</tr>
									<tr>
								<td style="height: 20px; font-size: 14px;">
								<font color="#003366">
									<p align="justify">
									Estimado(a) '. $nombre.'
									</p>
									<p>
									Por medio del presente correo, se le notifica que su contraseña para el ingreso al sistema facturas se ha modificado.
									</p>
									<table width="80%" border="0"  class="">
										<!--align="center"-->

									<tr>
										<td class=""><font color="#003366">Fecha:</font></td>
										<td class="ui-widget-content ">'.$fecha.'</td>
									</tr>
									<tr>
										<td class=""><font color="#003366">Contraseña Nueva:</font></td>
										<td class="ui-widget-content ">'.$psw.'</td>
									</tr>
									<tr>
										<td class=""><font color="#003366">Correo:</font></td>
										<td class="ui-widget-content ">'.$correo.'</td>
									</tr>
									</table>
								</font>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="height: 10px;padding-top:20px;padding-bottom:20px; font-size: 12px;" VALIGN="bottom">
								<!--<br>-->
								</td>
							</tr>
									<tr>
										<td align="center" style="height: 20px;" colspan="3" bgcolor="#E6E6E6">
											<span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
										</td>
									</tr>
								</table>
							</center>
						</body>
						</html>';
						require_once('../libs/swiftmailer/swift_required.php');
						//$receptor = 'ebecerril@aiko.com.mx';
						//$receptor='diegofgo@outlook.com';
						$receptor = $correo;
						//$receptor = 'facturacion-notacredito@juliatours.com.mx';
						//$nombre = "Nombre Prueba";
						try {
						$transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
								->setUsername('soporte@aiko.com.mx')
								->setPassword('soporte**17');
						$mailer = Swift_Mailer::newInstance($transport);
						$pBody = $html; //body html
						$message = Swift_Message::newInstance('CAMBIO DE CONTRASEÑA')
						->setFrom(array('soporte@aiko.com.mx' => 'Sistema Facturas'))
						->setTo(array($receptor =>$nombre))
						//->setCc('soporte@aiko.com.mx')
						->setBody($pBody, 'text/html'); //body html
							if ($mailer->send($message)){
							echo 1;
							}else{
								echo 'Error envio de correo notificación cierre';
							}
						} catch (Exception $e) {
						//echo 'Excepcion',  $e->getMessage(), "\n";
						}

}



?>

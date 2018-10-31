<?php 
	session_set_cookie_params(0); 
	session_start();
	session_unset();
	session_destroy();
	
 	header('Location:http://conta.factura.aiko.com.mx/login.php' );
 ?>
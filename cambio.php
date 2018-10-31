<?php
	session_start();
	$rfc=$_GET['rfc'];
	$_SESSION["fa_rfc"]		= $rfc;
	header('Location: acceso.php');

?>
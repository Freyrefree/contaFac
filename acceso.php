<?php
session_start();
if(!empty($_SESSION['fa_login']) and $_SESSION['fa_login'] == 1){
    // $_SESSION["id"] 	   = $id_Usuario;
    // $_SESSION['nombre']    = $nombre;
    if($_SESSION['fa_perfil'] == 1) {
        header('Location: index.php');
    }else {
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}
?>
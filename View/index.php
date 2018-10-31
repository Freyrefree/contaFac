<?php
session_start();
if(!empty($_SESSION['fa_login']) and $_SESSION['fa_login'] == 1){
    if($_SESSION['fa_perfil'] == 1) {
        // header('Location: index.php');
    }else {
        // header('Location: login.php');
    }
}else{
    header('Location: ../login.php');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Facturación | Inicio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='../img/ICONO2.ico' rel='shortcut icon' type='image/x-icon'>
        <script src="../libs/js/jquery-1.11.3.js"></script>
        <script src="../libs/js/bootstrap.js"></script>

        <link rel="stylesheet" href="../libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../libs/css/design.aiko.css"/>
    </head>
    <body>
        <!-- menu -->
        <?php
         include("../menu.php");
         ?>
        <!-- menu -->
        <div class="container-fluid">
            <div class="row">
                <br><br><br><br><br><br><br>
                <center> 
                    <h2 style="color:#004b9b;"><strong> BIENVENIDO AL PORTAL </strong></h2>
                    <br>
                    <img src="../img/facturacion.png" alt=""> 
                </center>
            </div>
        </div>
    </body>
</html>
<!-- <!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>

        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/design.aiko.css"/>
    </head>
    <body> -->
<?php 
//$ruta = "http://localhost/CFDI/view"; 
$ruta = "http://demofactura.aiko.com.mx/PRUEBAFACTURA/view";
$rutapro = "http://demofactura.aiko.com.mx/PRUEBAFACTURA";
session_start();
?>
<link href='<?= $rutapro; ?>/img/ICONO2.ico' rel='shortcut icon' type='image/x-icon'>
<div class="navbar-wrapper">
<div class="container-fluid">
    <nav class="navbar navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="#"><img src="<?= $rutapro; ?>/img/Logoa.png"  width="70" height="40"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <!-- <li class="active"><a href="#" class="">Cobranza</a></li> -->
                    <?php // if(($_SESSION["id_perfil"]==1)){?>
                    <li>
                        <a href="<?= $ruta; ?>/view.empresa.php">
                        <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Empresa
                        </a>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.factura.php">
                        <strong><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Facturación</strong>
                        </a>
                    </li>
                    <!-- <li class=" dropdown"> -->
                        <!-- <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Nueva Factura </strong><span class="caret"></span></a> -->
                        <!-- <ul class="dropdown-menu"> -->
                        <!-- class=" dropdown" -->
                        <!-- class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" -->
                            <!-- <li><a href="antiguedad_saldos/importar.php" target="iframe">Carga antigüedad de saldos</a></li>
                            <li><a href="cobranza/importar.php" target="iframe">Cobranza</a></li>
                            <li><a href="cobranza_reportes/inicio.php" target="iframe">Reportes Cobranza</a></li>
                            <li><a href="cruce_pagos/importarpr.php" target="iframe">Cargar pagos recibidos</a></li>
                            <li><a href="cruce_pagos/diferenciareporte.php" target="iframe">Reporte de diferencias</a></li>
                            <li><a href="graficas/ReporteDesviacion.php" target="iframe">Grafica de diferencias</a></li> -->
                        <!-- </ul> -->
                    <!-- </li> -->
                    <!-- <li class=" dropdown">
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> Descarga Edocs </strong><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="importar/importar.php" target="iframe">Documentos edocs</a></li>
                            <li><a href="interjet/importar.php" target="iframe">Interjet</a></li>
                            <li><a href="#">Volaris</a></li>
                            <li><a href="importar_autorizaciones/importar.php" target="iframe">Autorizaciones</a></li>
                        </ul>
                    </li> -->
                    <li class=" dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong> <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> Catalogos</strong><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= $ruta; ?>/view.clientes.php" >Catalogo Clientes</a></li>
                            <li><a href="<?= $ruta; ?>/view.productoServ.php" >Cargar Productos / Servicios</a></li>
                            <li><a href="<?= $ruta; ?>/view.claveUnidad.php" >Cargar Clave de Unidad</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.pagos.php">
                        <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Pagos
                        </a>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.timbres.php">
                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Timbres
                        </a>
                    </li>
                    <!-- <li><a href="usuarios/usuarios.php" ><strong><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usuarios</strong></a></li> -->
                    <!-- <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Staff <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">View Staff</a></li>
                            <li><a href="#">Add New</a></li>
                            <li><a href="#">Bulk Upload</a></li>
                        </ul>
                    </li> -->
                    <!-- <li class=" down"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">HR <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li> -->
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <!-- ." ".$_SESSION["amaterno"]." " -->
                    <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong> <?= $_SESSION["fa_nombre"]; ?> </strong> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <!-- <li><a href="#">Change Password</a></li> -->
                            <li><a href="<?= $rutapro; ?>/logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir</a></li>
                        </ul>
                    </li>
                    <!-- <li class=""><a href="#">Logout</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
</div>
</div>
<script>
    $(document).on("ready", function() {
            $('ul li:has(ul)').hover(function(e) {
                $(".dropdown-menu").not($("ul", this)).slideUp("fast")
                .next()
                $(this).find('ul').slideToggle("fast")
                .end();
            });
        });
</script>
    <!-- </body>
</html> -->
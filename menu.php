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
$ruta = "http://localhost:8080/contafactura/view";
$rutapro = "http://localhost:8080/contafactura/";
// $ruta = "http://conta.factura.aiko.com.mx/view";
// $rutapro = "http://conta.factura.aiko.com.mx";
session_start();
$psw=$_SESSION['fa_psw'];
$idusuario = $_SESSION['fa_id'];
$correonombreuser = $_SESSION['fa_nombre'];
$correologinuser = $_SESSION['fa_email'];
include("Models/model.empresa.php");
$empresa=new empresa();

?>
<style>
/* CSS used here will be applied after bootstrap.css */
.badge{
   /* background:orange; */
   display: none;
   position:relative;
   top: -13px;
   left: -9px;
  }
</style>
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
                        <a href="<?= $ruta; ?>/view.facturas.php">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Facturación
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
                    <li class=" dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> Catalogos<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= $ruta; ?>/view.clientes.php" > Clientes</a></li>
                            <li><a href="<?= $ruta; ?>/view.productoServ.php" > Productos / Servicios</a></li>
                            <li><a href="<?= $ruta; ?>/view.claveUnidad.php" > Clave de Unidad</a></li>
                            <li><a href="<?= $ruta; ?>/view.usuarios.php" >Catálogo Usuarios</a></li>
                        
                           <!--  <li><a href="<?= $ruta; ?>/view.usuarios.php" >Catálogo Usuarios</a></li> -->                       
                        </ul>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.pagos.php">
                        <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Pagos
                        </a>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.timbres.php">
                            
                            <strong><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Timbres </span><span class="badge" id="notificador"></span></strong>
                        <!-- <span  class="glyphicon glyphicon-warning-sign" id="notificador" style=""></span> -->

                        </a>
                    </li>
                    <li>
                        <a href="<?= $ruta; ?>/view.reportes.php">
                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Reportes
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <?=$_SESSION['fa_rfc']?>

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
                    <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?= $_SESSION["fa_nombre"]; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li role="presentation" class="dropdown-header">Empresa</li>
                          <li role="presentation" class="divider"></li>
                          <?php
                          $datos=$empresa->listarRFC();
                          while($row=mysqli_fetch_array($datos)){
                            echo "<li><a href='".$rutapro."/cambio.php?rfc=".$row['rfc']."'>".$row['rfc']."</a></li>";
                          }

                          ?>
                          <li role="presentation" class="divider"></li>
                            <!-- <li><a href="#">Change Password</a></li> -->
                            <li><a href="<?= $rutapro; ?>/logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir</a></li>
                            <li><a href="#" id="myLink"><span class="glyphicon glyphicon-lock"></span>Cambiar Contraseña</a></li>
                        
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
    // $(document).on("ready", function() {
    //         $('ul li:has(ul)').hover(function(e) {
    //             $(".dropdown-menu").not($("ul", this)).slideUp("fast")
    //             .next()
    //             $(this).find('ul').slideToggle("fast")
    //             .end();
    //         });
    //     });
    $(document).on("ready", function() {
            $('ul li:has(ul)').hover(function(e) {
                $(this).children('ul').stop()
                $(".dropdown-menu").not($("ul", this)).slideUp("fast")
                .next()
                $(this).children('ul').stop()
                $(this).children('ul').slideToggle("fast")
                .end();
                           });
        });
        $('#myLink').click(function(){ modalusuario(0); return false; });
</script>



<script type="text/javascript">
function modalusuario(x)
{
    var indentificador=x;
    if (indentificador==0)
      {
          $("#confirmarupdatepsw").show();
          //$("#modalwarningpsw").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
          $("#mensajeconpsw").html("Cambio de Contraseña");
          $("#ModalUsuario").modal("show");
      }
}
$('#ModalValidarCambiopsw').on('hidden', function () {
  // Load up a new modal...
  $('#ModalUsuario').modal('show')
})
function validarPSWBD()
{ //alert("ok");
var c =  document.forms["FormularioCambioPSW"]["psw"].value;
  var pswn = document.forms["FormularioCambioPSW"]["pswn"].value;
  var pswn2 = document.forms["FormularioCambioPSW"]["pswn2"].value;

  var pswencrypt = '';
  var pswBD = '';
  var idusuario = '<?php echo $idusuario ;?>';


    $.getJSON('../Controllers/controller.encriptarPSW.php?psw='+c+'&id='+idusuario,
    function(data){

    $.each(data, function(objeto,item)
    {

              pswencrypt=item.psw;
              pswBD = item.pswBD;

              if (pswBD != pswencrypt)
              {
                $("#modalvalidarpsw").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                $("#mensajevalidarpsw").html("La contraseña no coincide con la anterior");
                $("#ModalValidarCambiopsw").modal("show");
                 document.getElementById("psw").style.borderColor = "red";
                 //return false;
               }
                 else  if (c == "")
                  {
                    $("#modalvalidarpsw").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                    $("#mensajevalidarpsw").html("Ingrese la contraseña anterior");
                    $("#ModalValidarCambiopsw").modal("show");
                     document.getElementById("psw").style.borderColor = "red";

                     //$("#ModalUsuario").modal("show");
                  }else if (pswn== "" || pswn2 =="")
                  {
                    $("#modalvalidarpsw").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                    $("#mensajevalidarpsw").html("Debes ingresar las contraseñas nuevas");
                    $("#ModalValidarCambiopsw").modal("show");
                     document.getElementById("pswn").style.borderColor = "red";
                     document.getElementById("pswn2").style.borderColor = "red";

                  }
                  else if (pswn !=  pswn2)
                  {
                    $("#modalvalidarpsw").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                    $("#mensajevalidarpsw").html("Las contraseñas nuevas no coinciden");
                    $("#ModalValidarCambiopsw").modal("show");
                     document.getElementById("pswn").style.borderColor = "red";
                     document.getElementById("pswn2").style.borderColor = "red";

                  }else
                {
                  actualizarpsw();

               }

            });
        });



}

function actualizarpsw()
{
  var idusuario =  '<?php echo $idusuario; ?>';

  var formData = new FormData(document.getElementById("FormularioCambioPSW"));
  formData.append("id",idusuario);
  $.ajax({
      url: "../Controllers/controller.actualizarPSW.php",
      type: "POST",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false


      }).done(function(res){
        if(res == "1")
        {
          correoUpdatePSW();//**********ejecutar correo*****
           location.href = "<?= $rutapro; ?>/logout.php";
           /**/


         }
         else
         {
          $("#encabezadopsw").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
          $("#mensajepsw").html("Ocurrio un error, no se pudo cambiar la contraseña");
          $("#Modalmensajepsw").modal("show");
         }
      });

}

</script>
<script type="text/javascript">
function correoUpdatePSW()
{
  var nombreusuario =  '<?php echo $correonombreuser; ?>';
  var correologin = '<?php echo $correologinuser; ?>';
  var pswn = document.forms["FormularioCambioPSW"]["pswn"].value;
         $.ajax({
                    type:'POST',
                    url:"../Correos/correoActualizarPSW.php",
                    data:'correopsw='+ pswn +'&correonombreusuario='
                     + nombreusuario + '&ejecutarfuncion=' + 'si'
                      + '&correologin=' + correologin,

               });
}
</script>
<script type="text/javascript">
$('#Modalmensajepsw').on('hidden.bs.modal', function () {
location.reload();
})
</script>
<!--******************************************************Modal mensaje exito inicio-->
<div id="Modalmensajepsw" class="modal fade" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header " id="encabezadopsw">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" align="center">USUARIOS</h4>
    </div>
    <div class="modal-body">
      <div id='mensajepsw' align="center"></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal" id="confirmar">Cerrar</button>
    </div>
  </div>
</div>
</div>
<!--******************************************************Modal mensaje exito fin-->
<!--******************************************************Modal Validaciones inicio-->
<div id="ModalValidarCambiopsw" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header " id="modalvalidarpsw">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" align="center">USUARIOS</h4>
        </div>
        <div class="modal-body">
            <div id='mensajevalidarpsw' align="center"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
        </div>
    </div>
</div>
</div>
<!--******************************************************Modal Validaciones fin-->

<div id="ModalUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header btn-warning" id="modalwarningpsw" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">USUARIOS</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
        <div id='mensajeconpsw' align="center"></div>
        </div>
        <form id="FormularioCambioPSW">

          <div class="form-group">
            <label for="recipient-name">Contraseña Actual</label>
            <input type="password" class="form-control" name= "psw" id="psw" >
          </div>

          <div class="form-group">
            <label for="recipient-name">Contraseña Nueva</label>
            <input type="password" class="form-control" id="pswn" name="pswn">
          </div>

          <div class="form-group">
            <label for="recipient-name">Confirmar Contraseña Nueva</label>
            <input type="password" class="form-control" id="pswn2" name="pswn2">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger"  data-dismiss="modal" id="no-con"><span class="glyphicon glyphicon-remove-circle"></span>Cancelar</button>
        <button class="btn btn-primary"   id="confirmarupdatepsw" onclick="validarPSWBD();" data-dismiss="modal"><span class="glyphicon glyphicon-refresh"></span>Actualizar</button>
      </div>
    </div>
  </div>
</div>
<?php $rfc=$_SESSION['fa_rfc']; ?>
<script type="text/javascript">
$( document ).ready(function() {
  var opc = 3;
  var rfc = "<?php echo $rfc; ?>";
      $.ajax({
    type:'post',
    url:'../Controllers/controller.timbres.php?',
    data:'opc=' + opc + '&rfc=' + rfc,
  }).done(function(result) {
    //$( this ).addClass( "done" );

    var json = $.parseJSON(result);
    var disponibles = json[0];
    //alert(disponibles);
    if(disponibles <= 200)
    {
      $("#notificador").css({"background-color":"#FF9100","font-weight":"bold","color":"white"});
      $("#notificador").html(disponibles);
      $("#notificador").show();
    }

            });
        });
</script>
    <!-- </body>
</html> -->
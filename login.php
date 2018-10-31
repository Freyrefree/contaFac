<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Facturación | Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="libs/js/jquery-1.11.3.js"></script>
        <script src="libs/js/bootstrap.js"></script>
        <link rel="stylesheet" href="libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="libs/css/design.aiko.css"/>
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <h3 class="panel-title">
                    <span class="break"></span>
                    <center><h3> Inicio de Sesión </h3></center>
                    <!-- <span class="glyphicon glyphicon-ok-circle pull-right"></span> -->
                    </h3>
                    </div>
                    <div class="panel-body">
                    <div class="col-md-12">
                    <div class="copy"> 
                        <img src="img/facturacion.png" class="LogoSistema">
                        <!-- <h4>Inicio de Sesión</h4> -->
                    </div>
                    <br><br>
                    <!-- action="access.php" -->
                    <form id="FormularioUno" class="form-horizontal" method="POST">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email" placeholder="Correo electronico" autofocus>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
                    </div>
                    <br>

                    <a id="forgot-pw" class="fr" href="">Recuperar Contraseña</a>
                    
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary" id="botonSolicitud" onclick="ejecuta();">Iniciar</button>
                    </div>
                    <br>
                    </form>
                    </div>
                    </div>
                    <br>
                    <br>
                    <div class="copy">
                        <img src="img/ico-power-by.png" alt="Power by aiko" class="powerby">
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        </div>
        <script type="text/javascript">
$('#forgot-pw').click(function(){ modalusuario(0); return false; });
function modalusuario(x)
{
    var indentificador=x;
    if (indentificador==0)
      {
          $("#confirmarlogin").show();
          $("#modalwarninglogin").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
          $("#mensajelogin").html("Ingresa tu Correo Electrónico para enviar una nueva Contraseña");
          $("#ModalLogin").modal("show");
      }
}
function validaRecuperacion()
{
  var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
  var emailr =  document.forms["FormularioRecuperar"]["emailr"].value;
  if (emailr == "")
{
    $("#modalvalidarrecuperacion").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
    $("#mensajevalidarrecuperacion").html("Ingrese el Correo Electrónico");
    $("#ModalValidarRecuperacion").modal("show");
     document.getElementById("emailr").style.borderColor = "red";
 }else if(expr.test(emailr)==false)
{
 $("#modalvalidarrecuperacion").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
 $("#mensajevalidarrecuperacion").html("Email Incorrecto");
 $("#ModalValidarRecuperacion").modal("show");
 document.getElementById("emailr").style.borderColor = "red";
}
else
{
//enviarCorreo();
verificarCorreo();
}


}

function verificarCorreo()
{
  var opc = 1;
  var formData = new FormData(document.getElementById("FormularioRecuperar"));
  formData.append("opcion",opc);
  //formData.append();
  $.ajax({

  method: "POST",
  url: "Correos/correoRecuperarPSW.php",
  //data: { opcion: opc, location: "Boston" }
  data: formData,
  cache: false,
  contentType: false,
  processData: false
})
  .done(function(respuesta) 
  {
    if(respuesta != 1)
    {
      //alert("no hay correos");
      $("#encabezadorecupera").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensajerecupera").html("Lo sentimos, el correo que ingresó no se encuentra registrado, por favor consulte al administrador");
      $("#Modalmensajerecupera").modal("show");


    }
    else
    {
      enviarCorreo();
    }

  });
}





function enviarCorreo()
{

  var opc = 2; 
  var formData = new FormData(document.getElementById("FormularioRecuperar"));
  formData.append("ejecutarfuncion","si");
  formData.append("opcion",opc);

$.ajax({
              url: "Correos/correoRecuperarPSW.php",
              type: "POST",
              dataType: "html",
              data:  formData,
              cache: false,
              contentType: false,
              processData: false
          }).done(function(respuesta)
          {
                  if(respuesta == "1")
                  {
                    $("#encabezadorecupera").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                    $("#mensajerecupera").html("Se ha enviado un Correo Electrónico con su nueva Contraseña");
                    $("#FormularioRecuperar")[0].reset();
                    $("#Modalmensajerecupera").modal("show");
                  }
                  else
                  {
                    $("#encabezadorecupera").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                    $("#mensajerecupera").html("Ocurrio un error, no se pudo Enviar el Correo Electrónico");
                    $("#Modalmensajerecupera").modal("show");
                  }
          });

}
function cancelar()
{

        $("#FormularioRecuperar")[0].reset();
}
</script>
    <script>
        function ejecuta(){
            $("#FormularioUno").on("submit", function(e){
            $("#botonSolicitud").attr("disabled", true);
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("FormularioUno"));
            formData.append("dato", "valor");
            $.ajax({
                url: "validaDatos.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
                }).done(function(answer){
                    if(answer == 3){ 
                        window.location.href = "acceso.php";
                    }
                });
            e.preventDefault(); //stop default action
            //e.unbind(); //unbind. to stop multiple form submit.
            });
        }
    </script>
    <div id="ModalLogin" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header btn-warning" id="modalwarninglogin" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" align="center">RECUPERAR CONTRASEÑA</h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
            <div id='mensajelogin' align="center"></div>
            </div>
            <form id="FormularioRecuperar" enctype="multipart/form-data" method="POST" role="form">

              <div class="form-group">
                <label for="recipient-name">Correo Electrónico</label>
                <input type="email" class="form-control" name= "emailr" id="emailr" placeholder="ejemplo@mail.com" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger"  data-dismiss="modal" id="no-con" onclick="cancelar();"><span class="glyphicon glyphicon-remove-circle"></span>Cancelar</button>
            <button type="submit" class="btn btn-primary"   id="confirmarlogin" onclick="validaRecuperacion();" data-dismiss="modal"><span class="glyphicon glyphicon-envelope"></span>Enviar</button>
          </div>
        </div>
      </div>
    </div>
    <!--******************************************************Modal Validaciones inicio-->
    <div id="ModalValidarRecuperacion" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header " id="modalvalidarrecuperacion">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">RECUPERAR CONTRASEÑA</h4>
            </div>
            <div class="modal-body">
                <div id='mensajevalidarrecuperacion' align="center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
    <!--******************************************************Modal Validaciones fin-->
    <!--******************************************************Modal mensaje exito inicio-->
    <div id="Modalmensajerecupera" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header " id="encabezadorecupera">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" align="center">USUARIOS</h4>
        </div>
        <div class="modal-body">
          <div id='mensajerecupera' align="center"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="confirmar">Cerrar</button>
        </div>
      </div>
    </div>
    </div>
    <!--******************************************************Modal mensaje exito fin-->
    
    </body>
</html>
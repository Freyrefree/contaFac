<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Usuarios</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">



        <!-- Latest compiled and minified CSS -->
   <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 -->
    <!-- Optional theme -->
   <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

   <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="../libs/js/jquery-1.11.3.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/i18n/grid.locale-en.js"></script>
  	<script src="../libs/js/jquery.jqGrid.min.js"></script>
    <script src="../libs/plugins/grid.addons.js" type="text/javascript"></script>
    <script src="../libs/js/jquery-ui.js" type="text/javascript"></script>
    <script src="../libs/js/jquery-ui.min.js" type="text/javascript"></script>
  	<link rel="stylesheet" href="../libs/css/ui.jqgrid-bootstrap.css"/>
    <link rel="stylesheet" href="../libs/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../libs/css/design.aiko.css"/>
    <script src="../libs/js/timepicki.js" type="text/javascript"></script>
    <script src="../libs/js/jquery.timepicker.js" type="text/javascript"></script>
  	<script>
		    	$.jgrid.defaults.width = 400;
	        $.jgrid.defaults.responsive = true;
	        $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>



</head>
<?php
session_start();
include('../Models/usuario2.php');
$usuario  = new Usuario();
$comboEmpresa = $usuario->comboEmpresa();
include('../menu.php');
?>

<body>
<!----------------------------------------------------------------- Modal -------------------------------------------------------->
<div id="ModalValidar" class="modal fade" role="dialog">
<div class="modal-dialog">
	<div class="modal-content">
	 <div class="modal-header " id="mtituvalidar">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" align="center">USUARIOS</h4>
		</div>
		<div class="modal-body">
			<div id='mensajevalidar' align="center"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
		</div>
	</div>
</div>
</div>

	<div id="Modalmen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header " id="mtitu">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">USUARIOS</h4>
      </div>
      <div class="modal-body">
        <div id='mensaje' align="center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
      </div>
    </div>
  </div>
</div>
    <!--MODAL CONFIRMACIÓN -->
<div id="Modalcon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header btn-warning" id="modalwarning" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">USUARIOS</h4>
      </div>
      <div class="modal-body">
        <div id='mensajecon' align="center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="no-con">No</button>
        <button class="btn btn-primary" id="confirmardelete" onclick="eliminar()" data-dismiss="modal">SI</button>
        <button class="btn btn-primary" id="confirmarupdate" onclick="editar()" data-dismiss="modal">SI</button>
        <button class="btn btn-primary" id="confirmarupdates" onclick="guardaredit()" data-dismiss="modal">SI</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -------------------------------------------------------->

<!-- FORMULARIO -------------------------------------------------------------->
<div class = "formulario" id="formulario" style="display: none">
    <div class="col-md-12">

    	<form id="FormularioUsuario" enctype="multipart/form-data" method="POST" role="form" >
				<div class="panel panel-primary">
			      <div class="panel-heading">
			              <h3 class="panel-title">Administración de usuarios</h3>
			      </div>

					  <div class="panel-body">
							    <div class=" col-md-4">
									<div class="form-group">
										<label for="">Nombre</label>
										<input type="text" name="nombre" id="nombre" class="form-control"  placeholder="Nombre" maxlength="13" size="13" required>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Correo Electrónico</label>
										<input type="text" name="usuario" id="usuario" class="form-control" placeholder="ejemplo@mail.com" required>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Confirmar Correo Electrónico</label>
										<input type="text" name="usuario2" id="usuario2" class="form-control" placeholder="ejemplo@mail.com" required>
									</div>
								</div>



								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Contraseña</label>
										<input type="password" name="psw1" id="psw1" class="form-control" placeholder="*******" required>
									</div>
								</div>
								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Confirmar Contraseña</label>
										<input type="password" name="psw2" id="psw2" class="form-control" placeholder="*******" required>
									</div>
								</div>

                <div class=" col-md-4">
                  <div class="form-group">
                    <label for="exampleSelect1">Perfil</label>
                    <select class="form-control" name="comboPerfil" id="comboPerfil" required>
              				<option value="">Seleccione un Perfil</option>
              				<option value="1">Administrador</option>
											<option value="2">Facturación</option>
                    </select>
                  </div>
               </div>


              <div class=" col-md-4">
                <div class="form-group">
                  <label for="exampleSelect1">Empresa</label>
                  <select class="form-control" name="comboEmpresa" id="comboEmpresa" required>
                    <option value="">Seleccione su Empresa</option>
                    <?php
                      while($fila = mysqli_fetch_array($comboEmpresa))
                      {
                        echo "<option value=".utf8_encode($fila['id_empresa']).">".utf8_encode($fila['nombre_empresa'])."</option>";
                      }
                    ?>
                  </select>
                </div>
             </div>

             <label for="">Estatus</label>
             <br>
             <div class="col-lg-4">
           <div class="input-group">
             <span class="input-group-addon">
               <input type="radio" id="e1"name="estatus" value="1" required>
             </span>
             <input type="text" class="form-control" id="ee1" aria-label="" value="Activo" readonly>
           </div><!-- /input-group -->
          <div class="input-group">
             <span class="input-group-addon">
               <input type="radio" id="e2" name="estatus" value="0" required>
             </span>
             <input type="text" class="form-control" id="ee2" aria-label="" value="Inactivo" readonly>
           </div><!-- /input-group -->
         </div><!-- /.col-lg-6 -->

								 <div class=" col-md-12" align="right">
                 <button type ="reset" class="btn btn-danger" onclick="cancelar();" id="botoncancelar"> <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="validarRegistro();" id="botonguardar"> <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>Guardar</button>
              <button type="button" class="btn btn-primary" onclick="validarUpdate();" style="display: none" id="botoneditar"> <span class="glyphicon glyphicon-refresh"  ></span>Actualizar</button>
            </div>
					  </div>
				</div>
		</form>

	</div>
  </div>
<!------------------------------------------------------------------ FORMULARIO -------------------------------------------------------------->
<!------------------------------------------------------------------ TABLA -------------------------------------------------------------->

<div id="lista">
  <div class="col-md-12">
    <div class="panel panel-primary">

        <div class="panel-heading"><center><strong>Listado de Usuarios</strong> </center></div>
        <div class="btn-group">
        <button type="button" class="btn btn-primary" onclick="nuevo()"> <span class="glyphicon glyphicon-floppy-saved" id="add"></span>Nuevo</button>
          <button type="button" class="btn btn-warning" onclick="modal(1)"> <span class="glyphicon glyphicon-edit" id="modeled"></span>Editar</button>

           <button type="button" class="btn btn-danger" onclick="modal(0)"> <span class="glyphicon glyphicon-minus-sign" id="model"></span>Eliminar</button>
      </div>

        <div class="panel-body" id="body">
            <div id="list">
                <table id="jqGrid" ></table>
                <div id="jqGridPager" style="height: 40px; width: 100%"></div>
            </div>
        </div>
    </div>
</div>
</div>



<!------------------------------------------------------------------ TABLA -------------------------------------------------------------->
<script type="text/javascript">

function validarUpdate() {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	  var a = document.forms["FormularioUsuario"]["nombre"].value;
		var b = document.forms["FormularioUsuario"]["usuario"].value;
		var c = document.forms["FormularioUsuario"]["psw1"].value;
		var d = document.forms["FormularioUsuario"]["comboPerfil"].value;
		var e = document.forms["FormularioUsuario"]["comboEmpresa"].value;
		var f = document.forms["FormularioUsuario"]["psw2"].value;
		var g = document.forms["FormularioUsuario"]["estatus"].value;
		var h = document.forms["FormularioUsuario"]["usuario2"].value;



 		if (a == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe llenar el campo nombre");
			$("#ModalValidar").modal("show");
			document.getElementById("nombre").style.borderColor = "red";
		}else if((b != "" && h == "") || (b == "" && h != "") )
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Si desea cambiar su correo electrónico debe ingresarlo en los dos campos, de lo contrario debe omitirlos");
			$("#ModalValidar").modal("show");
			document.getElementById("usuario").style.borderColor = "red";
			document.getElementById("usuario2").style.borderColor = "red";
						if(expr.test(b)==false)
					{
						$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
						$("#mensajevalidar").html("Email Incorrecto");
						$("#ModalValidar").modal("show");
						document.getElementById("usuario").style.borderColor = "red";
					}
		}else if (b != h)
	 {
			 $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			 $("#mensajevalidar").html("Las Correos electrónicos no coinciden!");
			 $("#ModalValidar").modal("show");
				document.getElementById("usuario").style.borderColor = "red";
				document.getElementById("usuario2").style.borderColor = "red";

		}else if((c != "" && f == "") || (c == "" && f != "") )
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Si desea cambiar su contraseña debe ingresarla en los dos campos, de lo contrario debe omitirlos");
			$("#ModalValidar").modal("show");
			document.getElementById("psw1").style.borderColor = "red";
			document.getElementById("psw2").style.borderColor = "red";
		}else if (c != f)
	 {
			 $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			 $("#mensajevalidar").html("Las Contraseñas no coinciden!");
			 $("#ModalValidar").modal("show");
				document.getElementById("psw1").style.borderColor = "red";
				document.getElementById("psw2").style.borderColor = "red";

		}else if(d == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe elegir un perfil");
			$("#ModalValidar").modal("show");
			document.getElementById("comboPerfil").style.borderColor = "red";
		}else if(e == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe elegir una Empresa");
			$("#ModalValidar").modal("show");
			document.getElementById("comboEmpresa").style.borderColor = "red";
		}
		 else
		{
			modal(2);
		}
}
function nuevo(x)
{

    $("#FormularioUsuario")[0].reset();
    $("#formulario").show();
    $("#lista").hide();
    $("#botoneditar").hide();
    $("#botonguardar").show();


}
function cancelar(x)
{

    $("#formulario").hide();
    $("#lista").show();
		$("#e1")[0].reset();
		$("#e2")[0].reset();
}


    $('#Modalmen').on('hidden.bs.modal', function () {
 location.reload();
})
function modal(x)
{
    var inde=x;
    //alert(inde)
    var grid = $("#jqGrid");
    var ret = grid.jqGrid('getGridParam',"selrow");
    if(ret!=null)
    {
      if(inde==1)
      {
      editar();
      }
      else if (inde==0)
      {
          $("#confirmarupdate").hide();
          $("#confirmardelete").show();
          $("#confirmarupdates").hide();
          $("#modalwarning").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});

          $("#mensajecon").html("¿Está seguro de Eliminar ésta Fila?");
          $("#Modalcon").modal("show");
      }
      else if (inde==2)
      {
      $("#confirmarupdates").show();
      $("#confirmardelete").hide();
      $("#confirmarupdate").hide();
      $("#modalwarning").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("¿Está seguro de Actualizar la Información?");
      $("#Modalcon").modal("show");
      }
    }
    else {
        //$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
        $("#mensaje").html("Debe seleccionar una fila para continuar");
        $("#Modalmen").modal("show");
    }
}
</script>
<script type="text/javascript">
$(document).ready(function() {///funcion para prevenir copiado y pegado de un input
    $('#usuario2').bind("cut copy paste", function(e) {
        e.preventDefault();
         //alert("You cannot paste into this text field.");
        $('#usuario2').bind("contextmenu", function(e) {
            e.preventDefault();
        });
    });
});
function validarRegistro() {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	  var a = document.forms["FormularioUsuario"]["nombre"].value;
		var b = document.forms["FormularioUsuario"]["usuario"].value;
		var c = document.forms["FormularioUsuario"]["psw1"].value;
		var d = document.forms["FormularioUsuario"]["comboPerfil"].value;
		var e = document.forms["FormularioUsuario"]["comboEmpresa"].value;
		var f = document.forms["FormularioUsuario"]["psw2"].value;
		var g = document.forms["FormularioUsuario"]["estatus"].value;
		var h = document.forms["FormularioUsuario"]["usuario2"].value;


 		if (a == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe llenar el campo nombre");
			$("#ModalValidar").modal("show");
			document.getElementById("nombre").style.borderColor = "red";
		}else if (b == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe llenar el campo correo electrónico");
			$("#ModalValidar").modal("show");
			document.getElementById("usuario").style.borderColor = "red";
		}else if(expr.test(b)==false)
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Email Incorrecto");
			$("#ModalValidar").modal("show");
			document.getElementById("usuario").style.borderColor = "red";
		}else  if (b != h)
		{
				$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
				$("#mensajevalidar").html("Los Correos Electrónicos no Coinciden");
				$("#ModalValidar").modal("show");
				 document.getElementById("usuario").style.borderColor = "red";
				 document.getElementById("usuario2").style.borderColor = "red";
		 }else if(c == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe llenar el campo contraseña");
			$("#ModalValidar").modal("show");
			document.getElementById("psw1").style.borderColor = "red";
		}else  if (c != f)
 		{
 				$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
 				$("#mensajevalidar").html("Las Contraseñas no coinciden!");
 				$("#ModalValidar").modal("show");
         document.getElementById("psw1").style.borderColor = "red";
         document.getElementById("psw2").style.borderColor = "red";
     }else if(d == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe elegir un perfil");
			$("#ModalValidar").modal("show");
			document.getElementById("comboPerfil").style.borderColor = "red";
		}else if(e == "")
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe elegir una Empresa");
			$("#ModalValidar").modal("show");
			document.getElementById("comboEmpresa").style.borderColor = "red";
		}else  if ((document.getElementById("e1").checked == false)&&(document.getElementById("e2").checked == false) )
  		{
  				$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
  				$("#mensajevalidar").html("Debe elegir un estatus");
  				$("#ModalValidar").modal("show");
          document.getElementById("ee1").style.borderColor = "red";
					document.getElementById("ee2").style.borderColor = "red";

      }
		 	else {
			 guardar();
			 //alert("ok");// ||
		 }
}
</script>
<script type="text/javascript">
function guardar()
{
                var formData = new FormData(document.getElementById("FormularioUsuario"));

                $.ajax({
                    url: "../Controllers/controller.registrarUsuario.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                      if(res == "1")
                      {
                         $("#formulario").hide();
    								 		 $("#lista").show();
                        $("#mensaje").html("El Usuario ha sido registrado");//texto que lleva la modal
                        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaUsuarios.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                        $("#FormularioUsuario")[0].reset();
                        $("#Modalmen").modal("show");
                       }
                       else
                       {
												$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, el Usuario no se registró");
                        $("#Modalmen").modal("show");
                       }
                    });


}

</script>
<script type="text/javascript">

    $(document).ready(function (a)
	  {

	      $("#jqGrid").jqGrid({
	      url: '../Controllers/controller.listaUsuarios.php',
	      datatype: "json",
	      styleUI : 'Bootstrap',
	      height: 280,
        //rowNum: 5,
        rowList: [5,10,15],
        colModel: [
								    { label: 'ID', name: 'id', width: 50, key: true },
								    { label: 'Nombre', name: 'nombre',autowidth: true },
								    { label: 'Correo Electrónico', name: 'login',width: 70 },
                    //{ label: 'Contraseña', name: 'clave_seguridad',autowidth: true },
                    { label: 'Perfil', name: 'perfil',width: 60 },
                    { label: 'Estatus', name: 'estatus',width: 50 },
										//{ label: 'Empresa', name: 'id_empresa', autowidth: true }
                    { label: 'Empresa', name: 'nombre_empresa', autowidth: true }
      					],
	      viewrecords: true, // show the current page, data rang and total records on the toolbar
	      autowidth: true,
	      height: 390,
	      rowNum: 10,
	      sortname: 'id',
	      gridview: true,
	      loadonce: true, // this is just for the demo
	      pager: "#jqGridPager",
	      });
	      $("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});

    });




</script>
<script type="text/javascript">
function editar()
{
	 var grid = $("#jqGrid");
   var ret = grid.jqGrid('getGridParam',"selrow");
   $("#botoneditar").show();
   $("#botonguardar").hide();
   $("#formulario").show();
   $("#lista").hide();

    if(ret!=null)
    {
	    $.getJSON('../Controllers/controller.buscarDatosUsuario.php?id='+ret,
		  function(data){
	    $.each(data, function(objeto,item)
			{
				var estatus=5;

                  $('#nombre').val(item.nombre);
                  //$('#usuario').val(item.login);
									//$('#psw').val(item.clave_seguridad);
									$('#comboPerfil').val(item.perfil);
                  $('#comboEmpresa').val(item.id_empresa);

									if(item.estatus==1) {
											document.getElementById("e1").checked = true
									}
									else {
											document.getElementById("e2").checked = true
										}
              });
          });
    }
    else
    {
      $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensaje").html("Debe seleccionar una fila para editar");
      $("#Modalmen").modal("show");
    }
  }


	function guardaredit()
  {
                var grid = $("#jqGrid");
                var ret = grid.jqGrid('getGridParam',"selrow");

                var formData = new FormData(document.getElementById("FormularioUsuario"));


									//e.preventDefault();
									formData.append("id",ret);

	                $.ajax({
				                    url: "../Controllers/controller.editarUsuario.php",
				                    type: "POST",
				                    dataType: "html",
				                    data:  formData,
				                    cache: false,
				                    contentType: false,
				                    processData: false
	                    	}).done(function(res)
												{
					                      if(res == "1")
					                      {
					                        $("#formulario").hide();
					                        $("#lista").show();
					                        $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
					                        $("#mensaje").html("El Usuario se ha editado correctamente");
					                        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaUsuarios.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
					                        $("#FormularioUsuario")[0].reset();
					                        $("#Modalmen").modal("show");
																	$("#botoneditar").hide();
																	$("#botonguardar").show();
					                      }
					                      else
					                      {
					                        $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
					                        $("#mensaje").html("Ocurrio un error, el Usuario no se pudo editar");
					                        $("#Modalmen").modal("show");
					                      }
	                    	});
	                e.preventDefault();
	                e.unbind();

  }


function eliminar()
  {
    var grid = $("#jqGrid");
    var ret = grid.jqGrid('getGridParam',"selrow");
    if(ret!=null)
    {
          $.ajax({
				            url: "../Controllers/controller.eliminarUsuario.php?id="+ret,
				            type: "POST",
				            dataType: "html",
				            cache: false,
				            contentType: false,
				            processData: false
            		}).done(function(res)
								{
			              if(res == "1")
			                {
			                  $("#mensaje").html("El Usuario ha sido borrado");
			                  $("#Modalmen").modal("show");
			                  $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaUsuarios.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
			                }
			              else
			                {
			                  $("#mensaje").html("Ocurrio un error, Usuario no se pudo borrar");
			                  $("#Modalmen").modal("show");
			                }
             		});
        }
  }
</script>
<script type="text/javascript">
</script>
</script>
 <script src="../libs/js/actions.aiko.js"></script>
</body>
</html>

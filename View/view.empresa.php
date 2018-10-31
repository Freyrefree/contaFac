<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Empresa</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

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
		<!-- show password start-->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>
		<!-- show password end-->
  	<script>
		    	$.jgrid.defaults.width = 400;
	        $.jgrid.defaults.responsive = true;
	        $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>



</head>
<?php
session_start();

include('../menu.php');
// include("../Models/model.empresa.php");
$Empresa = new Empresa();
$comboRegimen=$Empresa->comboRegimen();
?>
<script type="text/javascript">

</script>
<body>
<!----------------------------------------------------------------- Modal -------------------------------------------------------->
<div id="ModalValidar" class="modal fade" role="dialog">
<div class="modal-dialog">
	<div class="modal-content">
	 <div class="modal-header " id="mtituvalidar">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" align="center">EMPRESA</h4>
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
        <h4 class="modal-title" align="center">EMPRESA</h4>
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
        <h4 class="modal-title" align="center">EMPRESA</h4>
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
<div class = "formulario" id="formulario">
	<!-- <div class = "formulario" id="formulario" style="display: none"> -->
    <div class="col-md-12">

    	<form id="FormularioEmpresa" enctype="multipart/form-data" method="POST" role="form" >
				<div class="panel panel-primary">
			      <div class="panel-heading">
			              <h3 class="panel-title">EMPRESA</h3>
			      </div>




					  <div class="panel-body">
								<input type="hidden" name="idempresa" id="idempresa" class="form-control">

							    <div class=" col-md-4">
									<div class="form-group">
										<label for="">RFC</label>
										<input type="text" name="rfc" id="rfc" class="form-control"  placeholder="RFC" maxlength="13" size="13" required>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Razón Social</label>
										<input type="text" name="razonsocial" id="razonsocial" class="form-control" placeholder="Razón Social">
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">País</label>
										<input type="text" name="pais" id="pais" class="form-control" placeholder="País">
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Estado</label>
										<input type="text" name="estado" id="estado" class="form-control" placeholder="Estado">
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Municipio</label>
										<input type="text" name="municipio" id="municipio" class="form-control" placeholder="Municipio">
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Colonia</label>
										<input type="text" name="colonia" id="colonia" class="form-control" placeholder="Colonia">
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Código Postal</label>
										<input type="text" name="cp" id="cp" class="form-control" placeholder="00000" maxlength="5" size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Calle</label>
										<input type="text" name="calle" id="calle" class="form-control" placeholder="Calle" >
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Número Exterior</label>
										<input type="text" name="numexterior" id="numexterior" class="form-control" placeholder="Número Exterior" maxlength="30" size="30" >
									</div>
								</div>



								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Número Interior</label>
										<input type="text" name="numinterior" id="numinterior" class="form-control" maxlength="30" size="30" placeholder="Número Interior">
									</div>
								</div>


								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Referencia</label>
										<input type="text" name="referencia" id="referencia" class="form-control">
									</div>
								</div>


								<div class=" col-md-4">
									 <div class="form-group">
										 <label for="">Correo</label>
											<input type="email" name="email" id="email" class="form-control"  placeholder="ejemplo@mail.com" >
									 </div>
								 </div>




								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Teléfono</label>
										<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono"  >
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Celular</label>
										<input type="text" name="celular" id="celular" class="form-control" placeholder="Celular"  >
									</div>
								</div>
								<div class=" col-md-4">
								<div class="form-group">
									<label for="">Responsable</label>
									<input type="text" name="responsable" id="responsable" class="form-control" placeholder="Nombre Responsable" >
								</div>
							</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">No. Certificado (CER)</label>
										<input type="text" name="certificado" id="certificado" class="form-control" placeholder="Certificado"  >
									</div>
								</div>



							<!-- <div class=" col-md-4">
							<div class="form-group">
								<label for="">Régimen Fiscal</label>
								<input type="text" name="regimenfis" id="regimenfis" class="form-control" placeholder="Régimen Fiscal" >
							</div>
						</div> -->
						<div class=" col-md-4">
													<div class="form-group">
														<label for="">Régimen Fiscal</label>
														<select name="regimenfis" id="regimenfis" class="form-control" required>
																	<option value="" >selecciona un régimen Fiscal</option>
																	<?php
																		while($fila = mysqli_fetch_array($comboRegimen))
																		{
																			echo "<option value=".utf8_encode($fila['clave']).">".utf8_encode($fila['regimen'])."</option>";
																		}
																	?>
														</select>
													</div>
												</div>

							<div class=" col-md-4">
							<div class="form-group">
								<label for="">Clave Key</label>


                        <input type="password" name="clavekey" id="clavekey" class="form-control" placeholder="****" data-toggle="password" >



							</div>
						</div>

							<div class=" col-md-4">
							<div class="form-group">
								<label for="">Archivo ZIP</label>

								<input type="file" name="archivo" id="archivo" class="btn btn-info btn-sm"  >
								<div class="invalid-feedback">
	        			Archivos requeridos(cer | key)
	      			</div>
							</div>
						</div>



					<div class=" col-md-4">
					<div class="form-group">
						<label for="">Logo</label>
						<input type="file" name="logo" id="logo" class="btn btn-info btn-sm"  >
					</div>
				</div>


						<div class=" col-md-12" align="right">
            	<button type="button" class="btn btn-primary" onclick="validararchivos(1)" id="botonguardar"> <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>Guardar</button>
              <button type="button" class="btn btn-primary" onclick="validararchivos(2)" style="display: none" id="botoneditar"> <span class="glyphicon glyphicon-refresh"  ></span>Actualizar</button>
            </div>
					  </div>
				</div>
		</form>

	</div>
  </div>
<!------------------------------------------------------------------ FORMULARIO -------------------------------------------------------------->
<script type="text/javascript">

</script>
<script type="text/javascript">

$(document ).ready(function() {


	var formData = new FormData();
	formData.append("Ejecutar", "1");
	$.ajax({

			url: "../Controllers/controller.verificarEmpresa.php",
			type: "POST",
			dataType: "html",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
			}).done(function(res){
				if(res == "1")
				{
					//alert("existen registros");

					 $("#botoneditar").show();
					 $("#botonguardar").hide();
					// $("#formulario").show();
					// $("#lista").hide();
						 $.getJSON('../Controllers/controller.buscarDatosEmpresa.php',
						 function(data){
						 $.each(data, function(objeto,item)
						 {
							 					 $('#idempresa').val(item.id);
												 $('#rfc').val(item.rfc);
												 $('#razonsocial').val(item.razonsocial);
												 $('#pais').val(item.pais);
												 $('#estado').val(item.estado);
												 $('#municipio').val(item.municipio);
												 $('#colonia').val(item.colonia);
												 $('#cp').val(item.cp);
												 $('#calle').val(item.calle);
												 $('#numinterior').val(item.numinterior);
												 $('#numexterior').val(item.numexterior);
												 $('#referencia').val(item.referencia);
												 $('#email').val(item.email);
												 $('#telefono').val(item.telefono);
												 $('#celular').val(item.celular);
												 $('#responsable').val(item.responsable);
												 $('#certificado').val(item.certificado);
												 $('#regimenfis').val(item.regimenfis);
												 $('#clavekey').val(item.clavekey);
										 });
								 });


				 }
				 else
				 {
					 //alert("no existen registros");
				 }
			});


});

function validararchivos(opcion){
	if (opcion==1) ////////validaciones para guardar registro
	{
        var logo = $('#logo').val();
				var archivo = $('#archivo').val();
        if(logo=='')
        {
					$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
					$("#mensajevalidar").html("Debe seleccionar un logo");
					$("#ModalValidar").modal("show");
					document.getElementById("logo").style.borderColor = "red";
					return false;
        }else if (archivo=='')
				{
					$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
					$("#mensajevalidar").html("Debe seleccionar un archivo");
					$("#ModalValidar").modal("show");
					document.getElementById("archivo").style.borderColor = "red";
					return false;
				}else
				{
					validarRegistro();
				}
	 }else //if(opcion == 2) ////////////validaciones para ACTUALIZAR (opcion = 2)
	 {


			var archivo = $('#archivo').val();var logo = $('#logo').val();
			if ((archivo!=''))
			{


							var files = document.getElementById('archivo').files;

						 	var str = files[0].name;
						 	var verext = str.split(".");
						 	var tam = verext.length;
						 	var ext = verext[tam-1];

						 	if(ext != 'zip')
						 	{
						 		$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
						 		$("#mensajevalidar").html("Debe seleccionar un archivo con extensión .zip");
						 		$("#ModalValidar").modal("show");
						 		document.getElementById("archivo").style.borderColor = "red";
						 		return false;
						 	}else {
						 		validacionesGenerales();
						 	}

			}

			else if ((logo!=''))
			{


							var files2 = document.getElementById('logo').files;

						 	var str2 = files2[0].name;
						 	var verext2 = str2.split(".");
						 	var tam2 = verext2.length;
						 	var ext2 = verext2[tam2-1];
						 	if(ext2 != 'png' && ext2 != 'jpg')
						 	 {
						 		 $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
						 		 $("#mensajevalidar").html("Debe seleccionar una imágen con extensión .png o .jpg");
						 		 $("#ModalValidar").modal("show");
						 		 document.getElementById("logo").style.borderColor = "red";
						 		 return false;
						 	  }	else {
						  		validacionesGenerales();
						  	}

			}
			else {
				validacionesGenerales();
			}



	 }

}


function validacionesGenerales()
{
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		var a = document.forms["FormularioEmpresa"]["rfc"].value;
		var b = document.forms["FormularioEmpresa"]["razonsocial"].value;
		var c = document.forms["FormularioEmpresa"]["pais"].value;

		var e = document.forms["FormularioEmpresa"]["estado"].value;
		var f = document.forms["FormularioEmpresa"]["municipio"].value;
		var g = document.forms["FormularioEmpresa"]["colonia"].value;
		var h = document.forms["FormularioEmpresa"]["cp"].value;
		var i = document.forms["FormularioEmpresa"]["calle"].value;
		var j = document.forms["FormularioEmpresa"]["numexterior"].value;
		var k = document.forms["FormularioEmpresa"]["numinterior"].value;
		var l = document.forms["FormularioEmpresa"]["referencia"].value;
		var m = document.forms["FormularioEmpresa"]["email"].value;
		var n = document.forms["FormularioEmpresa"]["telefono"].value;
		var o = document.forms["FormularioEmpresa"]["celular"].value;
		var p = document.forms["FormularioEmpresa"]["responsable"].value;
		var q = document.forms["FormularioEmpresa"]["certificado"].value;
		var r = document.forms["FormularioEmpresa"]["regimenfis"].value;
		var s = document.forms["FormularioEmpresa"]["clavekey"].value;


 if(a=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un RFC");
			$("#ModalValidar").modal("show");
			document.getElementById("rfc").style.borderColor = "red";
			return false;
		}else if(b =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar la Razón Social");
			$("#ModalValidar").modal("show");
			document.getElementById("razonsocial").style.borderColor = "red";
			return false;
		}else if(c =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un país");
			$("#ModalValidar").modal("show");
			document.getElementById("pais").style.borderColor = "red";
			return false;
		}else if(e =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un Estado");
			$("#ModalValidar").modal("show");
			document.getElementById("estado").style.borderColor = "red";
			return false;
		}else if(f=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un Municipio");
			$("#ModalValidar").modal("show");
			document.getElementById("municipio").style.borderColor = "red";
			return false;
		}else if(g=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una colonia");
			$("#ModalValidar").modal("show");
			document.getElementById("colonia").style.borderColor = "red";
			return false;
		}else if(h=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el Código Postal");
			$("#ModalValidar").modal("show");
			document.getElementById("cp").style.borderColor = "red";
			return false;
		}else if(i=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una calle");
			$("#ModalValidar").modal("show");
			document.getElementById("calle").style.borderColor = "red";
			return false;
		}else if(j=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el número exterior");
			$("#ModalValidar").modal("show");
			document.getElementById("numexterior").style.borderColor = "red";
			return false;
		}else if(k=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el número interior");
			$("#ModalValidar").modal("show");
			document.getElementById("numinterior").style.borderColor = "red";
			return false;
		}else if(l=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una referencia domiciliaria");
			$("#ModalValidar").modal("show");
			document.getElementById("referencia").style.borderColor = "red";
			return false;
		}else if(m=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un correo");
			$("#ModalValidar").modal("show");
			document.getElementById("email").style.borderColor = "red";
			return false;
		}else if(expr.test(m)==false)
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Email Incorrecto");
			$("#ModalValidar").modal("show");
			document.getElementById("email").style.borderColor = "red";
		}else if(n=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un teléfono");
			$("#ModalValidar").modal("show");
			document.getElementById("telefono").style.borderColor = "red";
			return false;
		}else if(o=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un celular");
			$("#ModalValidar").modal("show");
			document.getElementById("celular").style.borderColor = "red";
			return false;
		}else if(p=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el nombre de un  contacto o responsable");
			$("#ModalValidar").modal("show");
			document.getElementById("responsable").style.borderColor = "red";
			return false;
		}else if(q=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el certificado");
			$("#ModalValidar").modal("show");
			document.getElementById("certificado").style.borderColor = "red";
			return false;
		}else if(r=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el Régimen Fiscal");
			$("#ModalValidar").modal("show");
			document.getElementById("regimenfis").style.borderColor = "red";
			return false;
		}else if(s=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una clave");
			$("#ModalValidar").modal("show");
			document.getElementById("clavekey").style.borderColor = "red";
			return false;
		}else {
			//alert("validaciones inputs gneral ok");
			actualizar();
		}

}


function validarRegistro() {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;


		var a = document.forms["FormularioEmpresa"]["rfc"].value;
		var b = document.forms["FormularioEmpresa"]["razonsocial"].value;
		var c = document.forms["FormularioEmpresa"]["pais"].value;

		var e = document.forms["FormularioEmpresa"]["estado"].value;
		var f = document.forms["FormularioEmpresa"]["municipio"].value;
		var g = document.forms["FormularioEmpresa"]["colonia"].value;
		var h = document.forms["FormularioEmpresa"]["cp"].value;
		var i = document.forms["FormularioEmpresa"]["calle"].value;
		var j = document.forms["FormularioEmpresa"]["numexterior"].value;
		var k = document.forms["FormularioEmpresa"]["numinterior"].value;
		var l = document.forms["FormularioEmpresa"]["referencia"].value;
		var m = document.forms["FormularioEmpresa"]["email"].value;
		var n = document.forms["FormularioEmpresa"]["telefono"].value;
		var o = document.forms["FormularioEmpresa"]["celular"].value;
		var p = document.forms["FormularioEmpresa"]["responsable"].value;
		var q = document.forms["FormularioEmpresa"]["certificado"].value;
		var r = document.forms["FormularioEmpresa"]["regimenfis"].value;
		var s = document.forms["FormularioEmpresa"]["clavekey"].value;



 		var files = document.getElementById('logo').files;
		var str = files[0].name;
	  var verext = str.split(".");
	  var tam = verext.length;
	  var ext = verext[tam-1];

		var fileszip = document.getElementById('archivo').files;
		var strzip = fileszip[0].name;
		var verextzip = strzip.split(".");
		var tamzip = verextzip.length;
		var extzip = verextzip[tam-1];

 if(ext != 'png' && ext != 'jpg')
	{
		$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
		$("#mensajevalidar").html("Debe seleccionar una imágen con extensión .png o .jpg");
		$("#ModalValidar").modal("show");
		document.getElementById("logo").style.borderColor = "red";
		return false;
	}else if(extzip != 'zip')
	{
		$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
		$("#mensajevalidar").html("Debe seleccionar un archivo con extensión .zip");
		$("#ModalValidar").modal("show");
		document.getElementById("archivo").style.borderColor = "red";
		return false;
	}else if(a=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un RFC");
			$("#ModalValidar").modal("show");
			document.getElementById("rfc").style.borderColor = "red";
			return false;
		}else if(b =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar la Razón Social");
			$("#ModalValidar").modal("show");
			document.getElementById("razonsocial").style.borderColor = "red";
			return false;
		}else if(c =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un país");
			$("#ModalValidar").modal("show");
			document.getElementById("pais").style.borderColor = "red";
			return false;
		}else if(e =='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un Estado");
			$("#ModalValidar").modal("show");
			document.getElementById("estado").style.borderColor = "red";
			return false;
		}else if(f=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un Municipio");
			$("#ModalValidar").modal("show");
			document.getElementById("municipio").style.borderColor = "red";
			return false;
		}else if(g=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una colonia");
			$("#ModalValidar").modal("show");
			document.getElementById("colonia").style.borderColor = "red";
			return false;
		}else if(h=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el Código Postal");
			$("#ModalValidar").modal("show");
			document.getElementById("cp").style.borderColor = "red";
			return false;
		}else if(i=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una calle");
			$("#ModalValidar").modal("show");
			document.getElementById("calle").style.borderColor = "red";
			return false;
		}else if(j=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el número exterior");
			$("#ModalValidar").modal("show");
			document.getElementById("numexterior").style.borderColor = "red";
			return false;
		}else if(k=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el número interior");
			$("#ModalValidar").modal("show");
			document.getElementById("numinterior").style.borderColor = "red";
			return false;
		}else if(l=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una referencia domiciliaria");
			$("#ModalValidar").modal("show");
			document.getElementById("referencia").style.borderColor = "red";
			return false;
		}else if(m=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un correo");
			$("#ModalValidar").modal("show");
			document.getElementById("email").style.borderColor = "red";
			return false;
		}else if(expr.test(m)==false)
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Email Incorrecto");
			$("#ModalValidar").modal("show");
			document.getElementById("email").style.borderColor = "red";
		}else if(n=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un teléfono");
			$("#ModalValidar").modal("show");
			document.getElementById("telefono").style.borderColor = "red";
			return false;
		}else if(o=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar un celular");
			$("#ModalValidar").modal("show");
			document.getElementById("celular").style.borderColor = "red";
			return false;
		}else if(p=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el nombre de un  contacto o responsable");
			$("#ModalValidar").modal("show");
			document.getElementById("responsable").style.borderColor = "red";
			return false;
		}else if(q=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el certificado");
			$("#ModalValidar").modal("show");
			document.getElementById("certificado").style.borderColor = "red";
			return false;
		}else if(r=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar el Régimen Fiscal");
			$("#ModalValidar").modal("show");
			document.getElementById("regimenfis").style.borderColor = "red";
			return false;
		}else if(s=='')
		{
			$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensajevalidar").html("Debe ingresar una clave");
			$("#ModalValidar").modal("show");
			document.getElementById("clavekey").style.borderColor = "red";
			return false;
		}
		else
		{
			//guardar();
			comprobarExistente();
		}



}




$('#Modalmen').on('hidden.bs.modal', function () {
 location.reload();
})

</script>
<script type="text/javascript">

</script>


<script type="text/javascript">
function comprobarExistente()
{
	var a = document.forms["FormularioEmpresa"]["rfc"].value;
	var formData = new FormData();
	formData.append("rfc", a);
	$.ajax({

			url: "../Controllers/controller.verificarRFCEmpresa.php",
			type: "POST",
			dataType: "html",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
			}).done(function(res){
				if(res == "1")
				{
					$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
					$("#mensajevalidar").html("El RFC ya está registrado");
					$("#ModalValidar").modal("show");
					document.getElementById("rfc").style.borderColor = "red";
					return false;
				}
				else
				{
					guardar();
				}
		 });
}
function guardar()
{


                var formData = new FormData(document.getElementById("FormularioEmpresa"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.registrarEmpresa.php",
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
                        $("#mensaje").html("La Empresa ha sido registrada");//texto que lleva la modal

                        //$("#FormularioCliente")[0].reset();
                        $("#Modalmen").modal("show");
                       }
                       else
                       {
												$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, la Empresa no se registró");
                        $("#Modalmen").modal("show");
                       }
                    });
										e.preventDefault();
									 e.unbind();
}

</script>

<script type="text/javascript">
function actualizar()
{


							var formData = new FormData(document.getElementById("FormularioEmpresa"));
								formData.append("dato", "valor");
								$.ajax({
													url: "../Controllers/controller.editarEmpresa.php",
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

																$("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
																$("#mensaje").html("La Empresa se ha editado correctamente");
																$("#Modalmen").modal("show");

															}
															else
															{
																$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
																$("#mensaje").html("Ocurrio un error, la Empresa no se pudo editar");
																$("#Modalmen").modal("show");
															}
											});e.preventDefault();
										 e.unbind();


}
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
	    $.getJSON('../Controllers/controller.buscarDatosCliente.php?id='+ret,
		  function(data){
	    $.each(data, function(objeto,item)
			{

                  $('#rfc').val(item.rfc);
                  $('#razonsocial').val(item.razonsocial);
									$('#sucursal').val(item.sucursal);
                  //$('#cuenta').val(item.cuenta);
                  $('#email').val(item.correo);
									$('#telefono').val(item.telefono);
									$('#contacto').val(item.contacto);
                  $('#resEstados').val(item.idestado);
                  $('#calle').val(item.calle);
                  $('#numinterior').val(item.ninterior);
                  $('#numexterior').val(item.nexterior);
                  $('#cfdi').val(item.idcfdi);

                        var estado = item.idestado;
                        var muni = item.c_municipio;
                        var cp = item.c_cp;
                        var colonia = item.idcolonia;
                        if(estado)

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






</script>
<script type="text/javascript">
</script>
</script>
 <script src="../libs/js/actions.aiko.js"></script>
</body>
</html>

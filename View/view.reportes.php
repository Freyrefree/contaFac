<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Reportes</title>
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
include('../Models/model.clientes.php');
$cliente  = new Cliente();
$combopais = $cliente->comboPaises();
$comboestado = $cliente->comboEstados();
$combocfdi = $cliente->comboCFDI();
include('../menu.php');
?>

<body>
<!----------------------------------------------------------------- Modal -------------------------------------------------------->
<div id="ModalValidar" class="modal fade" role="dialog">
<div class="modal-dialog">
	<div class="modal-content">
	 <div class="modal-header " id="mtituvalidar">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" align="center">REPORTES</h4>
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
        <h4 class="modal-title" align="center">CLIENTES</h4>
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
        <h4 class="modal-title" align="center">CLIENTES</h4>
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
<!-- ***************************************************************************************** -->
<div class="col-md-12">
  <div class="panel panel-primary">
      <div class="panel-heading">
              <h3 class="panel-title">Reportes</h3>
      </div>
 <div class="panel-body">

	 <div class=" col-md-4">
     <div class="form-group">
       <label for="exampleSelect1">Tipo Reporte</label>
       <select class="form-control" name="comboTipoReporte" id="comboTipoReporte">

         <option value="1">Factura</option>
         <option value="2">Factura Complemento</option>
       </select>
     </div>
  </div>

  <div class=" col-md-4">
    <div class="form-group">
      <label for="exampleSelect1">Estatus</label>
      <select class="form-control" name="comboEstatus" id="comboEstatus">
				<option value="9">Todos</option>
				<!-- option value = 9 no tiene nada que ver con la base de datos en campo estatus  -->
        <option value="1">Pendiente</option>
        <option value="2">Facturada</option>
				<option value="3">Cancelada</option>
				<option value="4">Cancelada NC</option>
      </select>
    </div>
 </div>

							<div class=" col-md-4">
							 <div class="form-group">
									 <label>Fecha Timbrado Inicio</label>
									 <input type="text" name="fechaInicio" id="fechaInicio"  class="form-control" placeholder="fecha inicio" />
							 </div>
							</div>
							<div class=" col-md-4">
							 <div class="form-group">
									 <label>Fecha Timbrado Fin</label>
									 <input type="text" name="fechaFin" id="fechaFin"  class="form-control" placeholder="fecha fin" />
							 </div>
							</div>

 <div class=" col-md-12" align="right">
 <button type="button" class="btn btn-primary" onclick=""  id="botonreporte"> <span class="glyphicon glyphicon-th-list"  ></span>Reporte Facturas</button>
 </div>
</div>
</div>
</div>


<script type="text/javascript">
document.getElementById('botonreporte').onclick = function ()
{
	validaciones();
	//var comboReporte = $('#comboReporte').val();
  //var idPerson = $('#Personas').val();
  //var idProd = $('#Productos').val();

};
</script>

<script type="text/javascript">
$("#fechaInicio").datepicker({

           changeMonth:true,
           dateFormat:"yy-mm-dd",
           numberOfMonths:1
      });
$("#fechaFin").datepicker({

         changeMonth:true,
         dateFormat:"yy-mm-dd",
         numberOfMonths:1
    });

function validaciones()
{
	var f1 = document.getElementById("fechaInicio").value
	var f2 = document.getElementById("fechaFin").value
	//var f1valid=moment(f1,"yy-mm-dd",true);
	//var f2valid=moment(f2,"yy-mm-dd",true);
	var estatus = document.getElementById("comboEstatus").value
	 if ((f1 != "" && f2 == "") || (f1 == "" && f2 != "") )
	 {
		//alert("Debe ingresar valores en los campos fecha inicio y fecha fin");
		$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
		$("#mensajevalidar").html("Debe ingresar ambas fechas");
		$("#ModalValidar").modal("show");
		document.getElementById("fechaInicio").style.borderColor = "red";
		document.getElementById("fechaFin").style.borderColor = "red";
		return false;
	 }
  else if(f1>f2)
	{
		//alert("La fecha inicio debe ser menor que la fecha final");
		$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
		$("#mensajevalidar").html("La fecha inicio debe ser menor que fecha fin");
		$("#ModalValidar").modal("show");
		document.getElementById("fechaInicio").style.borderColor = "red";
		return false;
	 }//else if(!f1valid.isValid())
	// {
	// 	$("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
	// 	$("#mensajevalidar").html("Ingrese un valor de fecha correcto");
	// 	$("#ModalValidar").modal("show");
	// 	document.getElementById("fechaInicio").style.borderColor = "red";
	// 	return false;
	// }
	else if (document.getElementById("comboTipoReporte").value == 1)
	{
		location.href = "../Reportes/reporte.factura.php?fechainicio=" + f1 + "&fechafin=" + f2 + "&estatus=" + estatus;
	}
	else if (document.getElementById("comboTipoReporte").value == 2)
	{
		location.href = "../Reportes/reporte.facturaComplemento.php?fechainicio=" + f1 + "&fechafin=" + f2 + "&estatus=" + estatus;
	}

}
</script>




















<script src="../libs/js/actions.aiko.js"></script>
</body>
</html>

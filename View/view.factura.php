<!DOCTYPE html>
<html>
<head>
	<title>Facturacion</title>
	
	
   <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="../libs/js/jquery-1.11.3.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="../libs/css/bootstrap.min.css"/> 

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/i18n/grid.locale-en.js"></script>
  	<script src="../libs/js/jquery.jqGrid.min.js"></script>
    <script src="../libs/plugins/grid.addons.js" type="text/javascript"></script>
    <script src="../libs/js/jquery-ui.js" type="text/javascript"></script>
    <script src="../libs/js/jquery-ui.min.js" type="text/javascript"></script>
  	<link rel="stylesheet" href="../libs/css/ui.jqgrid-bootstrap.css"/>
    <script src="../libs/js/timepicki.js" type="text/javascript"></script>
    <script src="../libs/js/jquery.timepicker.js" type="text/javascript"></script>
	<link href="../libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  	<link rel="stylesheet" type="text/css" href="../libs/css/design.aiko.css">
  	
</head>
<body>
	<?php
	include('../menu.php');
	include("../Models/model.factura.php");
	$factura=new factura();
	
	if(isset($_GET['key'])){
		$factura->set("key",$_GET['key']);
		$datos=$factura->editarFactura();
		while($row=mysqli_fetch_array($datos)){
			$tipoComprobante=$row['tipo_documento'];
			$REmisor=$row['rfc_emisor'];
			$RReceptor=$row['rfc_receptor'];
			$FPago=$row['forma'];
			$MPago=$row['metodo'];
			$Fecha=$row['fecha_registro'];
			$Moneda=$row['moneda'];
			$condicionPago=$row['condicionPago'];
			$folioC=$row['concepto_clave'];
			$usoCFDI=$row['usocfdi'];
			$idReceptor=$row['idCliente'];

			$factura->set("folioC",$folioC);
			$answer=$factura->consultaConcepto();
			$subtotal=0;
			$Ttraslado=0;
			$TRetencion=0;
			$total=0;
			while($row=mysqli_fetch_array($answer)){
				$subtotal += $row['valor_unitario'] * $row['cantidad'];
				$Ttraslado += $row['importe_translado'];
				$TRetencion += $row['importe_retencion'];
			}

			$total= $subtotal + $Ttraslado;
			$total=$total - $TRetencion;

			$subtotal=number_format($subtotal,2,'.',',');
			$Ttraslado=number_format($Ttraslado,2,'.',',');
			$TRetencion=number_format($TRetencion,2,'.',',');
			$total=number_format($total,2,'.',',');
			

		}
	}else{
		//session_start();
		$tipoComprobante="";
		$REmisor=$_SESSION['fa_rfc'];
		$RReceptor="";
		$FPago="";
		$MPago="";
		$Fecha=date("Y-m-d");
		$Moneda="MXN";
		$condicionPago="";
		$folioC="";
		$usoCFDI="G01";
		$idReceptor="";
		$subtotal="0.00";
		$Ttraslado="0.00";
		$TRetencion="0.00";
		$total="0.00";
	}

	?>
	<script type="text/javascript">
		$(document).ready(function (a) {
		var tipo="<?=$tipoComprobante?>";
		var emisor="<?=$REmisor?>";
		var receptor="<?=$RReceptor?>";
		var forma="<?=$FPago?>";
		var metodo="<?=$MPago?>";
		var fecha="<?=$Fecha?>";
		var moneda="<?=$Moneda?>";
		var condicion="<?=$condicionPago?>";
		var folioC="<?=$folioC?>";
		var usocfdi="<?=$usoCFDI?>";
		var idReceptor="<?=$idReceptor?>";
		var subtotal="<?=$subtotal?>";
		var Ttraslado="<?=$Ttraslado?>";
		var Tretencion="<?=$TRetencion?>";
		var total="<?=$total?>";
		//console.log(tipo);
		//console.log(emisor);
		//console.log(receptor);
		//console.log(metodo);
		//console.log(fecha);
		//console.log(moneda);
		//console.log(condicion);
		//console.log(folioC);
		

		$("#tc").val(tipo);
		$("#r_emisor").val(emisor);
		$("#r_receptor").val(receptor);
		$("#forma").val(forma);
		$("#metodo").val(metodo);
		$("#fecha").val(fecha);
		$("#moneda").val(moneda);
		$("#condicion").val(condicion);
		$("#folioC").val(folioC);
		$("#usocfdi").val(usocfdi);
		$("#idReceptor").val(idReceptor);
		$("#subtotal").text(subtotal);
		$("#totalTraslado").text(Ttraslado);
		$("#totalRetencion").text(Tretencion);
		$("#totalfinal").text(total);
		});
	</script>
	<br><br>
	<div class="container-fluid">
		<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">FACTURA</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
			      <li id="datos_factura" class="active"><a data-toggle="tab" href="#home">Datos Factura</a></li>
			      <li id="conceptos" class="disabled"><a  href="#menu1">Conceptos</a></li>
			     <!-- <li id="confirmacion" class=""><a data-toggle="tab" href="#menu2">Confirmación</a></li>-->
			    </ul>
			    <div class="tab-content">
		    		<!--================== TAB DE DATO DE FACTURA ======================-->
			    	<div id="home" class="tab-pane fade in active">
			    		<br>
			    		<form id="form_datos_factura">
			    		<div class="row">
			    			<div class="col-md-4">
			    				<label>Tipo de Comprobante</label>
			    				<select class="form-control" onchange="folioSerie(this.value);" name="tc" id="tc"  required>
			    					<option value="">-- Seleccione un tipo de comprobante</option>
			    					<option value="Ingreso" >Ingreso</option>
			    					<option value="Egreso">Egreso</option>
			    				</select>
			    			</div>
			    			<div class="col-md-4">
			    				<!--<label>Folio</label>
			    				<input type="text" name="folio" id="folio" class="form-control" required readonly="readonly">-->
			    			</div>
			    			<div class="col-md-4">
			    				<!--<label>Serie</label>
			    				<input type="text" name="serie" id="serie" class="form-control" required readonly="readonly">-->
			    			</div>
			    		</div>
			    		<br>
			    		<div class="row">
			    			<div class="col-md-4">
			    				<label>RFC Emisor</label>
			    				<input type="text" name="r_emisor" id="r_emisor" value="SECL891011MN7" class="form-control" required readonly="readonly">
			    			</div>
			    			<div class="col-md-4">
			    				<label>RFC Receptor</label>
			    				<input type="text" name="r_receptor" id="r_receptor" class="form-control" onkeyup="buscaReceptor()" placeholder="Buscar..." required>
			    				<input type="hidden" name="idReceptor" id="idReceptor" class="form-control">
			    				<!--<select class="form-control" name="r_receptor" id="r_receptor" required>
			    					<option value=""> Seleccione un cliente </option>-->
			    					<?php
			    						/*$combo_cliente=$factura->cliente();
			    						while ($row=mysqli_fetch_array($combo_cliente)) {
			    							echo "<option value='".$row['rfc']."'>".$row['rfc']." - ".$row['razon_social']."</option>";
			    						}*/
			    					?>
			    				<!--</select>-->
			    			</div>
			    			<div class="col-md-4">
			    				<label>Forma de Pago</label>
			    				<select class="form-control" name="forma" id="forma" required>
			    					<option value="">-- Seleccione una forma de pago --</option>
			    					<?php
			    					$answer=$factura->forma_pago();
			    					while ($row=mysqli_fetch_array($answer)) {
			    						echo "<option value='".$row['c_formapago']."'>".$row['c_formapago']." - ".utf8_encode($row['descripcion'])."</option>";
			    					}
			    					?>
			    				</select>
			    			</div>
			    		</div>
			    		<br>
			    		<div class="row">
			    			<div class="col-md-4">
			    				<label>Metodo de pago</label>
			    				<select class="form-control" name="metodo" id="metodo" required>
			    					<option value="">-- Seleccion un metodo de pago --</option>
			    					<?php
			    					$combo_metodo=$factura->metodo_pago();
			    					while ($row=mysqli_fetch_array($combo_metodo)) {
			    						echo "<option value='".$row['c_metodopago']."'>".$row['c_metodopago']." - ".utf8_encode($row['descripcion'])."</option>";
			    					}
			    					?>
			    				</select>
			    			</div>
			    			<div class="col-md-4">
			    				<label>Fecha</label>
			    				<input type="text" name="fecha" id="fecha" class="form-control" value="<?=date("Y-m-d")?>" readonly="readonly">
			    			</div>
			    			<div class="col-md-4">
			    				<label>Moneda</label>
			    				<select class="form-control" id="moneda" name="moneda" required>
			    					<option value="">-- Seleccione una moneda --</option>
			    					<?php
			    						$combo_moneda=$factura->moneda();
			    						while ($row=mysqli_fetch_array($combo_moneda)) {
			    							if($row['c_moneda']=="MXN"){
			    								echo "<option value='".$row['c_moneda']."' selected>".$row['c_moneda']." - ".utf8_encode($row['descripcion'])."</option>";
			    							}else{
			    							echo "<option value='".$row['c_moneda']."'>".$row['c_moneda']." - ".utf8_encode($row['descripcion'])."</option>";
			    							}
			    						}
			    					?>
			    				</select>
			    			</div>
			    		</div>
			    		<br>
			    		<div class="row">
			    			<div class="col-md-4">
			    				<label>Condiciones de pago</label>
			    				<input type="text" name="condicion" id="condicion" class="form-control" value="" >
			    			</div>
			    			<div class="col-md-4">
			    				<label>Uso CFDI</label>
			    				<select name="usocfdi" id="usocfdi" class="form-control">
			    					<?php
			    						$combocfdi=$factura->usocfdi();
			    						while ($row=mysqli_fetch_array($combocfdi)) {
			    							echo "<option value='".$row['c_UsoCFDI']."'>".$row['c_UsoCFDI']." - ".utf8_encode($row['descripcion'])."</option>";
			    						}
			    					?>
			    				</select>
			    				
			    			</div>
			    		</div>
			    		<br>
			    		<div class="row">
			    			<div class="col-md-12" style="text-align: center">
			    				<button type="submit" class="btn btn-primary" > Continuar <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
			    			</div>
			    		</div>
			    	</form>
			    	</div>

			    	<!--===================== TAB DE CONCEPTOS ======================-->
			    	<div id="menu1" class="tab-pane fade in ">
			    		<!--=============-->
			    		<div id="formConcepto">
			    		<div class="panel panel-default">
			    			<div class="panel-body">
			    				
					    		<div class="row">
					    			<div class="col-md-4">
					    				<label>Clave</label>
					    				<input type="hidden" value="" id="folioC" name="folioC">
					    				<input type="hidden" name="idProd" id="idProd">
					    				<input type="text" name="claveProd" id="claveProd" onchange="buscaConcepto(this.value)" class="form-control" placeholder="Buscar...">

					    			</div>
					    			<div class="col-md-4">
					    				<label>Descripcion</label>
					    				<input type="text" name="descripcionProd"  id="descripcionProd" class="form-control" placeholder="Buscar...">
					    			</div>
					    			
					    			<div class="col-md-4">
					    				<label>No identificacion</label>
					    				<input type="text" name="noIndent" onchange="buscaConcepto(this.value)" id="noIndent" class="form-control" placeholder="Buscar...">
					    				
					    			</div>
					    		</div>
					    		<br>
					    		<div class="row">
					    			<div class="col-md-4">
					    				<label>Unidad</label>
					    				<input type="text" name="unidad" onchange="buscaUnidad(this.value)" id="unidad" class="form-control" placeholder="Buscar...">
					    			</div>
					    			<div class="col-md-4">
					    				<label>Clave Unidad</label>
					    				<input type="text" name="claveUnidad" onchange="buscaUnidad(this.value)"  id="claveUnidad" class="form-control" placeholder="Buscar...">
					    			</div>
					    			<div class="col-md-4">
					    				<label>Cantidad</label>
					    				<input type="text" name="cantidad" id="cantidad" class="form-control">
					    			</div>
					    		</div><br>
					    		<div class="row">
					    			<div class="col-md-4">
					    				<label>Precio</label>
					    				<input type="text" id="precio" name="precio" onchange="impTraslado();impRetencion();" class="form-control">
					    			</div>
					    			<div class="col-md-4">
					    				<label>Descuento</label>
					    				<input type="text" id="descuento" name="descuento" value="0" class="form-control">
					    			</div>
					    			<div class="col-md-4">
					    				<br>
					    				<button class="btn btn-success" data-toggle="modal" data-target="#modalImpuestos"><i class="fa fa-gavel" aria-hidden="true"></i> Impuestos</button>
					    			</div>
					    		</div>
			    			</div>
			    		</div>
			    		<div class="row">
				    		<div class="col-md-10">
				    			<div class="table-responsive">
				    				<table id="jqGrid" ></table>
	                    			<div id="jqGridPager"></div>
	                    		</div>
				    		</div>
				    		<div class="col-md-2" style="">
				    			<div style="border:1px solid #dddddd;height: 339px;width: 100%">
				    			<table width="90%">
				    				<tr>
				    					<td style="text-align: left"><b>Subtotal</b></td>
				    					<td style="text-align: right">$<span id="subtotal">0.0</span></td>
				    				</tr>
				    				<tr>
				    					<td style="text-align: left"><b>Total Traslado</b></td>
				    					<td style="text-align: right">$<span id="totalTraslado">0.0</span></td>
				    				</tr>
				    				<tr>
				    					<td style="text-align: left"><b>Total Retención</b></td>
				    					<td style="text-align: right">$<span id="totalRetencion">0.0</span></td>
				    				</tr>
				    				<tr>
				    					<td style="text-align: left"><b>Total</b></td>
				    					<td style="text-align: right">$<span id="totalfinal">0.0</span></td>
				    				</tr>
				    			</table>
				    			<br>
				    			<center>
				    			<button type="button" id="visualizar" onclick="pre_factra();" name="vizualizar" class="btn btn-primary"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Pre-visualizar </button>
				    			<br>
				    			<br>
				    			<a href="view.facturas.php"><button type="button" id="momento" name="momento" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar sin timbrar</button></a>
				    		</center>
				    		</div>
				    	</div>
			    		</div>
			    			
			    		
			    	</div>
			    		




			    	</div>
		    	
		   		 </div>
		    </div>
		</div>
	</div>
	</div>

	  <div id="Modalmen" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		    <div class="modal-header" id="mtitu">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Factura</h4>
		      </div>
		      <div class="modal-body">
		        <div id='mensaje'></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!--======================MODAL DE  IMPUESTOS START==============================-->
		<div id="modalImpuestos" class="modal fade" role="dialog">
		  <div class="modal-dialog" style="width: 80%">
		    <div class="modal-content">
		    <div class="modal-header" id="mtitu">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">IMPUESTOS</h4>
		      </div>
		      	<div class="modal-body">
		        		     <div class="panel panel-default">
			    			<div class="panel-body">
			    				<div class="row">
			    					<div class="col-md-12">
			    						TRASLADOS
			    					</div>
			    				</div>
			    				<br>
			    				<div class="row">
			    					<div class="col-md-3">
			    						<label>Impuesto</label>
			    						<select name="impTraslado" id="impTraslado" class="form-control" onchange="tasaTraslado();" required>
			    							<option value="">-- Seleccione un tipo de Impuesto --</option>
			    							<option value="001">001 - ISR</option>
			    							<option value="002">002 - IVA</option>
			    							<option value="003">003 - IEPS</option>
			    						</select>
			    					</div>
			    					<div class="col-md-3">
			    						<label>Tipo Factor</label>
			    						<select name="TFTraslado" id="TFTraslado" onchange="impTraslado();tasaTraslado();" class="form-control" required>
			    							<option value="">-- Seleccione un tipo de Impuesto --</option>
			    							<option value="Tasa">Tasa</option>
			    							<option value="Cuota">Cuota</option>
			    							<option value="Exento">Excento</option>
			    						</select>
			    						
			    					</div>
			    					<div class="col-md-3">
			    						<label>Tasa o Cuota</label>
			    						<div id="tasaT">
			    							<input type="text" name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control" readonly="readonly">
			    						</div>
			    						
			    					</div>
			    					<div class="col-md-3" id="traslado2" style="display:none">
			    						<label>Tasa o Cuota</label>
			    							<input type="text" name="TCTraslado2" minlength="8" onchange="impTraslado()" id="TCTraslado2" class="form-control" >
			    					</div>
			    					<div class="col-md-3">
			    						<label>Importe</label>
			    						<input type="text" name="importeTraslado" onchange="impTraslado()" id="importeTraslado" class="form-control" readonly="readonly">
			    					</div>
			    				</div>
			    				
			    			</div>
			    		</div>
			    		<div class="panel panel-default">
			    			<div class="panel-body">
			    				<div class="row">
			    					<div class="col-md-12">RETENCIONES</div>
			    				</div>
			    				<br>
			    				<div class="row">
			    					<div class="col-md-3">
			    						<label>Impuesto</label>
			    						<select name="impRetencion" id="impRetencion" onchange="impRetencion();tasaRtencion();" class="form-control" required>
			    							<option value="">-- Seleccione un tipo de Impuesto --</option>
			    							<option value="001">001 - ISR</option>
			    							<option value="002">002 - IVA</option>
			    							<option value="003">003 - IEPS</option>
			    						</select>
			    					</div>
			    					<div class="col-md-3">
			    						<label>Tipo Factor</label>
			    						<select name="TFRetencion" id="TFRetencion" onchange="impRetencion();tasaRtencion();" class="form-control" required>
			    							<option value="">-- Seleccione un tipo de Impuesto --</option>
			    							<option value="Tasa">Tasa</option>
			    							<option value="Cuota">Cuota</option>
			    							<option value="Exento">Excento</option>
			    						</select>
			    						
			    					</div>
			    					<div class="col-md-3">
			    						<label>Tasa o Cuota</label>
			    						<div id="tasaR">
			    							<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" readonly="readonly">
			    						</div>
			    					</div>
			    					<div class="col-md-3" id="retencion2" style="display:none">
			    						<label>Tasa o Cuota</label>
			    							<input type="text" name="TCRetencion2" minlength="8" onchange="impRetencion()" id="TCRetencion2" class="form-control" >
			    					</div>
			    					<div class="col-md-3">
			    						<label>Importe</label>
			    						<input type="text" name="importeRetencion" onchange="impRetencion()" id="importeRetencion" class="form-control" readonly="readonly">
			    					</div>
			    				</div>
			    			</div>
			    		</div>
		    	</div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success" onclick="guardarCarrito()" data-dismiss="modal">Aceptar</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!--======================MODAL DE IMPUESTOS END ================================-->
		<!--modal para mostrar los archivos-->
<div class="modal fade" id="myModalArchivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <embed src="" width="100%" height="400" id="documentotxt">
          <input name="id_pdf"  value=""  id="id_pdf"  hidden = "hidden">
          <input name="idFactura" id="idFactura" value="" type="hidden">
      </div>
      <div class="modal-footer">
      	<div style="float: left">
        <button type="button" class="btn btn-success  btn-sm" onclick="timbrar()" style="border-radius: 0px; " title="Timbrar Factura"> <span class="glyphicon glyphicon-file" ></span> Timbrar</button>
        <span id="procesando" style="display:none;">PROCESANDO...</span> 
		</div>

        <!-- <button type="button" class="btn btn-primary  btn-sm" onclick="download()" style="border-radius: 0px"> <span class="glyphicon glyphicon-save-file" ></span> Descargar Pre PDF</button> -->

        <button type="button" class="btn btn-primary  btn-sm" data-dismiss="modal" style="border-radius: 0px"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
	function pre_factra(){
		var folioC=$("#folioC").val();
		var parametros="folioC="+folioC;
      $.ajax({
      data:  parametros,
      url: '../controllers/controller.prefacturacion.php',
      type: 'post',
      beforeSend: function () {                                    
         // $('#myMensajeG').modal('show');
          //$('#mensajesGif').html('<img src="../img/loader1.gif"/>');
          //$("#mensajesC").html("Procesando, espere por favor...");
      },
      success: function(data){ 
          //$('#myMensajeG').modal('hide');

          var dato=data;

          if (dato>0) {
             descpdf2(dato);
          }else{
             $('#myModalMensajes').modal('show');
             $('#mensaje10').text("Error en la Visualización");
          }

          // $('#btn_pdf').attr("style", "display=block");
          // $('#div_todo' ).html( data );
       }

    });  

}

function descpdf2(id){  

  var id =id;
  if (id>0) {
    var reg= id;
    var r="";
    $("#idFactura").val(reg);
    var parametros = {"id" : reg};
    r="../controllers/controller.prefuncion_MPDF.php";

     $.ajax({
        data:  parametros,
        url:   r,
        type:  'post',
        async: false,
        beforeSend: function () {
        },
        success:  function (response) {
          // var dato=response;
          visualizarArchivo(id);
        }
    }); 

  }else{
     $('#myModalMensajes').modal('show');
     $('#mensaje10').text("Seleccione un Registro");       
  }
}

function visualizarArchivo(dato)
{  
   $("#id_pdf").val(dato);
    var dir="../tms/";
    var URL="";

    URL = dir+dato+".pdf";
    // document.getElementById("btn_factura_bl").style.display="none";

    $('#myModalArchivo').modal('show');
    $('embed#documentotxt').attr('src', URL);
}

function borrar_pre(id){  

  var id =id;
  if (id>0) {
    var reg= id;
    var r="";
    var parametros = {"id" : reg};
    r="../controllers/controller.borrar_pre.php";

     $.ajax({
        data:  parametros,
        url:   r,
        type:  'post',
        async: false,
        beforeSend: function () {
        },
        success:  function (response) {
          // var dato=response;
          // visualizarArchivo(id);
        }
    }); 

  }else{
     $('#myModalMensajes').modal('show');
     $('#mensaje10').text("Seleccione un Registro");       
  }
}

function timbrar(){
  var id =$("#idFactura").val();
  var parametros ="id="+ id;  


     $.ajax({
      data:  parametros,
      url: '../controllers/controller.facturacion.class.php',
      type: 'post',
      beforeSend: function () {  
      $("#procesando").show("slow");                                    
          //$('#myMensajeG').modal('show');
          //$('#mensajesGif').html('<img src="../img/loader1.gif"/>');
          //$("#mensajesC").html("Procesando, espere por favor...");
      },
      success: function(data){ 
      	$("#procesando").hide("slow");
      	console.log("respuesta");
        console.log(data);
          $('#myMensajeG').modal('hide');

          var dato=data;
          var separador= "->";

          var re = dato.split(separador);

          var mensaje=re[0];
          var devuelto=re[1];

          if(mensaje=="factura"){
             borrar_pre(id);//funcion para borrar la prefactura

             $("#id_xml").val(id);
             $("#uuid_xml").val(devuelto);

            // document.getElementById("btnpdf").style.display="block";
             
             downloadxml(devuelto);
          }
          if(mensaje=="error"){
             $('#myModalMensajes').modal('show');
             $('#mensaje10').text(devuelto);            
          }
       }

    });  
 
}
//=================================
function downloadxml(dato){

  var xml="";
  var uuid= dato;

  xml = "../comprobantesCfdi/"+uuid+".xml";
 
  //xml = "comprobantes/"+uui+".XML";

  if(uuid != null ){ 
      con=0;
      var uuid = uuid;
      var URL = xml;
      // window.location.href = 'descargaxml.php?archivo='+URL+'&uuid='+uuid;
      window.location.href = '../controllers/controller.descargaxml.php?archivo='+URL+'&uuid='+uuid;
       window.location.href = 'view.facturas.php';

  }else{
      return false;
  }   
}
</script>
<script type="text/javascript">
	function buscaReceptor(){
		//console.log("datos");
		$.getJSON('../controllers/controller.consultaReceptor.php',function(data){
			//console.log(data);
	    $("#r_receptor").autocomplete({
	        source: data,
	         select: function(event, ui)
			{
				var valor = ui.item.value;
				var id = ui.item.idReceptor;
				var usoCFDI= ui.item.usoCFDI;
				//console.log(valor);
				console.log(id);
				//console.log(usoCFDI);
				$("#idReceptor").val(id);
				$("#usocfdi").val(usoCFDI);
			}
	        //minLength: 1,
	    });

		});
  	}

  	$(function(){
	    $("#claveProd").autocomplete({
	        source: "../controllers/controller.consultaClaveSat.php",
	        minLength: 1,
	    });
  	});
  	$(function(){
	    $("#descripcionProd").autocomplete({
	        source: "../controllers/controller.consultaDescripcionProd.php",
	        minLength: 1,
	    });
  	});
  	$(function(){
	    $("#noIndent").autocomplete({
	        source: "../controllers/controller.consultaIdent.php",
	        minLength: 1,
	    });
  	});
  	$(function(){
	    $("#claveUnidad").autocomplete({
	        source: "../controllers/controller.consultaCU.php",
	        minLength: 1,
	    });
  	});
  	$(function(){
	    $("#unidad").autocomplete({
	        source: "../controllers/controller.consultaUnidad.php",
	        minLength: 1,
	    });
  	});
	
</script>
<script type="text/javascript">
	function tasaTraslado(){
		var valor=$("#impTraslado").val();
		var factor=$("#TFTraslado").val();
		console.log(valor);
		console.log(factor);
		if(valor==""){
			var option='<input type="text" name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control" readonly="readonly">';
		}else if(valor=="002" && factor=="Tasa"){
			var option='<select name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control"><option value="">-- Seleccione una tasa o cuota --</option><option value="0.000000">0.000000</option><option value="0.160000">0.160000</option>';
		}else if(valor=="003" && factor=="Tasa"){
			var option='<select name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control"><option value="">-- Seleccione una tasa o cuota --</option><option value="0.265000">0.265000</option><option value="0.300000">0.300000</option><option value="0.530000">0.530000</option><option value="0.500000">0.500000</option><option value="1.600000">1.600000</option><option value="0.304000">0.304000</option><option value="0.250000">0.250000</option><option value="0.090000">0.090000</option><option value="0.080000">0.080000</option><option value="0.070000">0.070000</option><option value="0.060000">0.060000</option><option value="0.030000">0.030000</option><option value="0.000000">0.000000</option><option value="otro">Otro</option></select>';
		}else if(valor=="003" && factor=='Cuota'){
			//$("#traslado2").show("slow");
			var option='<input type="text" name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control" >';
		}else{
			//$("#traslado2").hide("slow");
			var option='<input type="text" name="TCTraslado" onchange="impTraslado()" id="TCTraslado" class="form-control" readonly="readonly">';
		}

		$("#tasaT").html(option);

		



	}
	function tasaRtencion(){
		var valor=$("#impRetencion").val();
		var factor=$("#TFRetencion").val();
		console.log(valor);
		console.log(factor);
		if(valor==""){
			var option='<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" readonly="readonly">';
		}else if(valor=="003" && factor=="Tasa"){
			var option='<select name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control"><option value="">-- Seleccione una tasa o cuota --</option><option value="0.265000">0.265000</option><option value="0.300000">0.300000</option><option value="0.530000">0.530000</option><option value="0.500000">0.500000</option><option value="1.600000">1.600000</option><option value="0.304000">0.304000</option><option value="0.250000">0.250000</option><option value="0.090000">0.090000</option><option value="0.080000">0.080000</option><option value="0.070000">0.070000</option><option value="0.060000">0.060000</option><option value="otro">Otro</option></select>';
			
		}else if(valor=="001" && factor=="Tasa"){
			var option='<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" >';
		}else if(valor=="002" && factor=="Tasa"){
			var option='<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" >';
		}else if(valor=="003" && factor=="Cuota"){
			var option='<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" >';
		}else{
			var option='<input type="text" name="TCRetencion" onchange="impRetencion()" id="TCRetencion" class="form-control" readonly="readonly">';
		}


		$("#tasaR").html(option);


	}
</script>
<script type="text/javascript">
	function limpiar(){
		$("#claveProd").val('');
		$("#descripcionProd").val('');
		$("#noIndent").val('');
		$("#claveUnidad").val('');
		$("#unidad").val('');
		$("#cantidad").val('');
		$("#precio").val('');
		$("#impTraslado").val('');
		$("#TCTraslado").val('');
		$("#TFTraslado").val('');
		$("#importeTraslado").val('');
		$("#impRetencion").val('');
		$("#TCRetencion").val('');
		$("#TFRetencion").val('');
		$("#importeRetencion").val('');
		$("#idProd").val('');
		$("#descuento").val("");
	}
</script>
<script type="text/javascript">
	$(document).ready(function (a) {
		var folioC=$("#folioC").val();
      $("#jqGrid").jqGrid({
      url: '../controllers/controller.consultaConcepto.php?id='+folioC,
      datatype: "json",
      styleUI : 'Bootstrap',
      height: 280,
        rowNum: 5,
        rowList: [5,10,15],
       colModel: [
        { label: 'id', name: 'id',  key: true,hidden:true },
        { label: 'Clave', name: 'clave',width:50  },
        { label: 'Cantidad', name: 'cantidad',width:50},
        { label: 'Clave Unidad', name: 'unidad',width:50},
        { label: 'Valor Unitario', name: 'valorUnitario',width:86 },
        { label: 'Impuesto Traslado', name: 'impuestoT',width:86 },
        { label: 'Tipo Factor Traslado', name: 'factorT',width:86 },
        { label: 'Tasa o Cuota Traslado', name: 'tcT',width:86 },
        { label: 'Importe Traslado', name: 'importeT',width:86 },
        { label: 'Impuesto Retencion', name: 'impuestoR',width:86 },
        { label: 'Tipo Factor Retencion', name: 'factorR',width:86 },
        { label: 'Tasa o Cuota Retencion', name: 'tcR',width:86 },
        { label: 'Importe Retencion', name: 'importeR',width:86 },
        { label: 'Importe Total', name: 'total',width:86 },
        { label: '<i class="fa fa-cogs" aria-hidden="true"></i>', name: 'opcion',width:50},
        
        // sorttype is used only if the data is loaded locally or loadonce is set to true
      ],
      viewrecords: true, // show the current page, data rang and total records on the toolbar
      //width: 1050,
      height: 200,
      rowNum: 5,
      loadonce: true, // this is just for the demo
      pager: "#jqGridPager"

      });
      
    });
</script>
<script type="text/javascript">
	function mostrarConceptos(){
		$("#formConcepto").hide("slow");
		$("#tableConcepto").show("slow");
	}
	function mostrarFormulario(){
		$("#tableConcepto").hide("slow");
		$("#formConcepto").show("slow");
	}
</script>
<script type="text/javascript">
$("#form_datos_factura").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("form_datos_factura"));
	var folioC=$("#folioC").val();
	formData.append("folioC", folioC);
	$.ajax({
        url: "../controllers/controller.agregaFactura.php",
        type: "POST",
    	dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
        	console.log(data);
        	$("#folioC").val(data);
        }
    });
	  e.preventDefault(); //



	$("#conceptos").removeAttr("class");
	$('.nav-tabs a[href="#menu1"]').tab('show')
});
</script>
<script type="text/javascript">
	function folioSerie(valor){
		//console.log(valor);
		if(valor==""){
			//$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
			$("#mensaje").html("Seleccion un tipo de comprobante");
			$("#Modalmen").modal("show");
		}else{
			$.ajax({
                url: "../controllers/controller.buscarFactura.php",
                type: "POST",
                dataType: "html",
                data: "valor=" + valor,
                success: function(data){
                	//console.log(data);
                	var res=data.split("|");
                	if(res[0]=="" && res[1]==""){
                		//$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
						$("#mensaje").html("No se ha configurado la serie y folio ");
						$("#Modalmen").modal("show");
						;
                	}else{
                	//$("#serie").val(res[0]);
                	//$("#folio").val(res[1]);
                	}
                },
            });
		}
	}
</script>
<script type="text/javascript">
	function buscaConcepto(valor){
		console.log(valor);
		$.ajax({
                url: "../controllers/controller.buscaConcepto.php",
                type: "POST",
                dataType: "html",
                data: "valor=" + valor,
                success: function(data){
                	console.log(data);
                	var res=data.split("|");
                	$("#claveProd").val(res[0]);
                	$("#descripcionProd").val(res[1]);
                	$("#noIndent").val(res[2]);
                	$("#idProd").val(res[3]);
                }
        });
	}
</script>
<script type="text/javascript">
	function buscaUnidad(valor){
		console.log(valor);
		$.ajax({
                url: "../controllers/controller.buscaUnidad.php",
                type: "POST",
                dataType: "html",
                data: "valor=" + valor,
                success: function(data){
                	console.log(data);
                	var res=data.split("|");
                	$("#claveUnidad").val(res[0]);
                	$("#unidad").val(res[1]);
                }
        });
	}
</script>
<script type="text/javascript">
	function impTraslado(){
		var Impuesto=$("#impTraslado").val();
		var tasaOCuota=$("#TCTraslado").val();
		var tipoFactor=$("#TFTraslado").val();
		var precio=$("#precio").val();
		var cantidad=$("#cantidad").val();
		console.log(Impuesto);
		console.log(tasaOCuota);
		console.log(tipoFactor);
		console.log(precio);
		console.log(cantidad);
		

		if(tasaOCuota=='otro'){
			$("#traslado2").show("slow");
		}else{
			$("#traslado2").hide("slow");
		}



		if(Impuesto!="" && tasaOCuota!="" && tipoFactor!="" && precio!=""){
			if(tasaOCuota=="otro"){
				tasaOCuota=$("#TCTraslado2").val();
			}
			//tasaOCuota=tasaOCuota / 100;
			var importeTraslado= precio * cantidad;
			 importeTraslado= importeTraslado * tasaOCuota;
			$("#importeTraslado").val(importeTraslado);
		}
		else{
			$("#importeTraslado").val("");
		}
	}
	function impRetencion(){
		var Impuesto=$("#impRetencion").val();
		var tasaOCuota=$("#TCRetencion").val();
		var tipoFactor=$("#TFRetencion").val();
		var precio=$("#precio").val();
		var cantidad=$("#cantidad").val();

		if(tasaOCuota=="otro"){
			$("#retencion2").show('slow');
		}else{
			$("#retencion2").hide('slow');
		}


		if(Impuesto!="" && tasaOCuota!="" && tipoFactor!="" && precio!=""){
			if(tasaOCuota=="otro"){
				tasaOCuota=$("#TCRetencion2").val();
			}
			//tasaOCuota=tasaOCuota / 100;
			var importeRetencion=precio * cantidad;
			 importeRetencion= importeRetencion * tasaOCuota;
			$("#importeRetencion").val(importeRetencion);
		}else{
			$("#importeRetencion").val("");
		}
	}
</script>
<script type="text/javascript">
	function alertCarrito(){
		alert("¿El producto o servicio que desea agregar no cuenta con retencion es correcto?");
	}
	function guardarCarrito(){

		var clave=$("#claveProd").val();
		var descripcion =$("#descripcionProd").val();
		var identificacion=$("#noIndent").val();
		var claveUnidad=$("#claveUnidad").val();
		var unidad=$("#unidad").val();
		var cantidad=$("#cantidad").val();
		var precio=$("#precio").val();
		var Timpuesto=$("#impTraslado").val();
		var TtasaoCuota=$("#TCTraslado").val();
		var Tfactor=$("#TFTraslado").val();
		var Timporte=$("#importeTraslado").val();
		var Rimpuesto=$("#impRetencion").val();
		var RtasaoCuota=$("#TCRetencion").val();
		var Rfactor=$("#TFRetencion").val();
		var Rimporte=$("#importeRetencion").val();
		var folioC=$("#folioC").val();
		var idProd=$("#idProd").val();
		var descuento=$("#descuento").val();

		//valor en caso de que no este en la lista
		if(TtasaoCuota=="otro"){
			TtasaoCuota=$("#TCTraslado2").val();
		}

		if(RtasaoCuota=="otro"){
			RtasaoCuota=$("#TCRetencion2").val();
		}

		//validacion de la clave no puede venir vacia
		if(clave==""){
			$("#claveProd").focus();
			$("#mensaje").html("Introduca la clave, descripcion o numero de identificacion del producto o servicio");
			$("#Modalmen").modal("show");
			//alert("Introdusca la clave del producto");
			return false;
		}
		//validacion de la clave unidad no puede venir vacia
		if(claveUnidad==""){
			$("#claveUnidad").focus();
			$("#mensaje").html("Inrodusca la Clave de unidad o descripcion del producto o servicio");
			$("#Modalmen").modal("show");
			//alert("Introdusca la clave de unidad del producto");
			return false;
		}
		//validacion del importe de traslado  venir vacia
		

		//========
		

		if(precio==""){
			$("#mensaje").html("Inserte el precio unitario del producto o servicio");
			$("#Modalmen").modal("show");
			//alert("inserte precio de producto");
			return false;
		}
		if(descuento==""){
			$("#mensaje").html("Por vafor inserte el descuento del producto o servicio, en caso de no tener digite 0");
			$("#Modalmen").modal("show");
			//alert("inserte descuento de producto");
			return false;
		}

		if(cantidad=="" || cantidad==0){
			$("#mensaje").html("Inserte la cantidad de productos o servicios");
			$("#Modalmen").modal("show");
			//alert("inserte cantidad de producto");
			return false;
		}



		var parametros="clave="+clave+"&descripcion="+descripcion+"&identificacion="+identificacion+"&claveUnidad="+claveUnidad+"&unidad="+unidad+"&cantidad="+cantidad+"&precio="+precio+"&Timpuesto="+Timpuesto+"&TtasaoCuota="+TtasaoCuota+"&Tfactor="+Tfactor+"&Timporte="+Timporte+"&Rimpuesto="+Rimpuesto+"&RtasaoCuota="+RtasaoCuota+"&Rfactor="+Rfactor+"&Rimporte="+Rimporte+"&folioC="+folioC+"&idProd="+idProd;

		$.ajax({
                url: "../controllers/controller.agregaConceptos.php",
                type: "POST",
                dataType: "html",
                data: parametros,
                success: function(data){
                	limpiar();
                	console.log(data);

                	var datos=data.split("|");
                	$("#subtotal").text(datos[0]);
                	$("#totalTraslado").text(datos[1]);
                	$("#totalRetencion").text(datos[2]);
                	$("#totalfinal").text(datos[3]);



                	var folioC=$("#folioC").val();
                	console.log("folio="+folioC)
                	 $('#jqGrid').jqGrid('setGridParam',{url:'../controllers/controller.consultaConcepto.php?id='+folioC, datatype:'json',type:'GET'}).trigger('reloadGrid');
                	 $("#mensaje").modal("El producto o servicio se agrego correctamente");
                	 $("#Modalmen").modal("show");
                	//alert("Se agrego correctamente");
                }
        });




	}
</script>
<script type="text/javascript">
	function eliminarconcepto(id){
			var folioC=$("#folioC").val();
        	 var parametros="id="+id+"&folioC="+folioC;
        	$.ajax({
                url: "../controllers/controller.eliminaConcepto.php",
                type: "POST",
                dataType: "html",
                data: parametros,
                success: function(data){
                	var datos=data.split("|");
                	$("#subtotal").text(datos[0]);
                	$("#totalTraslado").text(datos[1]);
                	$("#totalRetencion").text(datos[2]);
                	$("#totalfinal").text(datos[3]);
                	var folioC=$("#folioC").val();
            		$('#jqGrid').jqGrid('setGridParam',{url:'../controllers/controller.consultaConcepto.php?id='+folioC, datatype:'json',type:'GET'}).trigger('reloadGrid');
                }
        });
        	
       
	}
</script>
<script type="text/javascript" src="../libs/js/actions.aiko.js"></script>
</html>
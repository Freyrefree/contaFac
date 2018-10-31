<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Clientes</title>
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
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------- Modal -------------------------------------------------------->

<!------------------------------------------------------------------ FORMULARIO -------------------------------------------------------------->
<div class = "formulario" id="formulario" style="display: none">
    <div class="col-md-12">

    	<form id="FormularioCliente" enctype="multipart/form-data" method="POST" role="form" >    	
				<div class="panel panel-primary">
			      <div class="panel-heading">
			              <h3 class="panel-title">Administración de clientes</h3>
			      </div>
           

				 

					  <div class="panel-body">
							    <div class=" col-md-4">
									<div class="form-group">
										<label for="">RFC</label>
										<input type="text" name="rfc" id="rfc" class="form-control" placeholder="RFC" required>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Razón Social</label>
										<input type="text" name="razonsocial" id="razonsocial" class="form-control" placeholder="Razón Social" required>
									</div>
								</div>

								<div class=" col-md-4">
									<div class="form-group">
										<label for="">Cuenta</label>
										<input type="text" name="cuenta" id="cuenta" class="form-control" placeholder="Cuenta" required>
									</div>
								</div>

						        <div class=" col-md-4">
						           <div class="form-group">
						             <label for="">Correo</label>
						              <input type="email" name="email" id="email" class="form-control"  placeholder="example@mail.com" required>
						           </div>
						         </div>

						        <div class=" col-md-4">
						          <div class="form-group">
						            <label for="">País</label>
						            <select name="pais" id="pais" class="form-control"  required disabled>
                              <option value="0">Elige un País</option>
                              <?php 
                                while($row = mysqli_fetch_array($combopais)) 
                                {
                                  echo "<option value=".utf8_encode($row['c_pais'])." selected='selected' >".utf8_encode($row['c_nombre'])."</option>";                        
                                }
                              ?>
                        </select>
						          </div>
						        </div>


                   

                     <div class=" col-md-4">
                      <div class="form-group">
                        <label for="">Estado</label>                        
                        <!-- <select name="estado" id="resEstado" class="form-control" required onchange="get_municipios();"> -->
                         <select name="estado" id="resEstados" class="form-control"  required>
                              <option value=""  >Elige un Estado</option>
                              <?php 
                                while($row = mysqli_fetch_array($comboestado)) 
                                {
                                  echo "<option value=".utf8_encode($row['c_estado']).">".utf8_encode($row['c_nombre_estado'])."</option>";                        
                                }
                              ?>

                        </select>
                      </div>
                    </div>

                       <div class=" col-md-4">
                      <div class="form-group">
                        <label for="">Municipio</label>                        
                         <select name="municipio" id="resMunicipios" class="form-control" required>
                              <option value=""  >Elige un Municipio</option>

                        </select>
                      </div>
                    </div>

                    <div class=" col-md-4">
                      <div class="form-group">
                        <label for="">Código Postal</label>                        
                         <select name="codigopostal" id="resCodigoPostal" class="form-control" required>
                              <option value=""  >Elige un Código Postal</option>                              
                        </select>
                      </div>
                    </div>
					
					<div class=" col-md-4">
                      <div class="form-group">
                        <label for="">Colonia</label>                        
                         <select name="colonia" id="resColonia" class="form-control" required>
                              <option value=""  >Elige una Colonia</option>                              
                        </select>
                      </div>
                    </div>
					
					<div class=" col-md-4">
					<div class="form-group">
						<label for="">Calle</label>
						<input type="text" name="calle" id="calle" class="form-control" placeholder="Calle" required>
					</div>
				</div>
				
				<div class=" col-md-4">
					<div class="form-group">
						<label for="">Número Exterior</label>
						<input type="text" name="numexterior" id="numexterior" class="form-control" placeholder="Número Exterior" required>
					</div>
				</div>
				
				<div class=" col-md-4">
					<div class="form-group">
						<label for="">Número Interior</label>
						<input type="text" name="numinterior" id="numinterior" class="form-control" placeholder="Número Interior">
					</div>
				</div>
				
				<div class=" col-md-4">
						          <div class="form-group">
						            <label for="">CFDI</label>
						            <select name="cfdi" id="cfdi" class="form-control" required>
                              <option value=""  >Elige La Categoría de CFDI</option>
                              <?php 
                                while($row = mysqli_fetch_array($combocfdi)) 
                                {
                                  echo "<option value=".utf8_encode($row['rowid']).">".utf8_encode($row['c_UsoCFDI']).' '.utf8_encode($row['descripcion'])."</option>";
                                }
                              ?>
                        </select>
						          </div>
						        </div>
				
					
					
					
					



								 <div class=" col-md-12" align="right">
                 <button type ="reset" class="btn btn-danger" onclick="cancelar();" id="botoncancelar"> <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>Cancelar</button>
              <button type="submit" class="btn btn-primary" onclick="guardar();" id="botonguardar"> <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>Guardar</button>
              <button type="submit" class="btn btn-primary" onclick="guardaredit();" style="display: none" id="botoneditar"> <span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>Actualizar</button>
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

        <div class="panel-heading"><center><strong>Listado de Clientes</strong> </center></div>
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
function nuevo(x)
{
    
    $("#FormularioCliente")[0].reset();
    $("#formulario").show();
    $("#lista").hide();
    $("#botoneditar").hide();
    $("#botonguardar").show();

    
}
function cancelar(x)
{
    
    $("#formulario").hide();
    $("#lista").show();

    
}
function recarga()
{
	location.reload();
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
      $("#confirmarupdate").show();
      $("#confirmardelete").hide();
      $("#modalwarning").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("¿Está seguro de Editar ésta Fila?");

      $("#Modalcon").modal("show");


      }
      else{
       $("#confirmarupdate").hide();
      $("#confirmardelete").show();
      $("#modalwarning").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("¿Está seguro de Eliminar ésta Fila?");
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
// $(document).ready(function(){
//     $('#pais').on('change',function(){
//         var countryID = $(this).val();
//         if(countryID){
//             $.ajax({
//                 type:'POST',				
//                 url:'../Controllers/controller.fillCombosEstadosMunicipios.php',
//                 data:'pais='+countryID,
//                 success:function(html){
//                     $('#resEstados').html(html);
//                     $('#resMunicipios').html('<option value="">Selecciona Primero el Estado</option>'); 
//                 }
//             }); 
//         }else{
//             $('#resEstados').html('<option value="">Select Selecciona Primero el País</option>');
//             $('#resMunicipios').html('<option value="">Selecciona Primero el Estado</option>');
// 			$('#resMunicipios').html('<option value="">Selecciona Primero el Municipio</option>');			
//         }
//     });
    
    $(document).ready(function(){
    $('#resEstados').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'../Controllers/controller.fillCombosEstadosMunicipios.php',
                data:'estado='+stateID,
                success:function(html){
                    $('#resMunicipios').html(html);
          $('#resCodigoPostal').html('<option value="">Selecciona Primero el Municipio</option>'); 
                }
            }); 
        }else{
            $('#resMunicipios').html('<option value="">Selecciona Primero el Estado</option>'); 
        }   
    });
  $('#resMunicipios').on('change',function(){
        var munID = $(this).val();
    var select = document.getElementById('resEstados');
        var estado = select.value;
        if(munID && estado){
            $.ajax({
                type:'POST',
                url:'../Controllers/controller.fillCombosEstadosMunicipios.php',
                data:'municipio='+ munID+'&estadomun='+estado,
                success:function(html){
                    $('#resCodigoPostal').html(html);
          $('#resColonia').html('<option value="">Selecciona Primero el Código Postal</option>');
                }
            }); 
        }else{
            $('#resCodigoPostal').html('<option value="">Selecciona Primero el Municipio</option>'); 
        }   
    });
  $('#resCodigoPostal').on('change',function(){
        var cpID = $(this).val();   
        if(cpID){
            $.ajax({
                type:'POST',
                url:'../Controllers/controller.fillCombosEstadosMunicipios.php',
                data:'codigopostal='+ cpID,
                success:function(html){
                    $('#resColonia').html(html);
           
                }
            }); 
        }else{
            $('#resColonia').html('<option value="">Selecciona Primero el Código Postal</option>'); 
        }   
    });
});
</script>


<script type="text/javascript">
function guardar(){
            $("#FormularioCliente").on("submit", function(e){
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("FormularioCliente"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.registrarCliente.php",
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
                        //alert("Prducto Registrado!");
                        //limpia el formulario
                       // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});//cambia el color del encabezado de la modal
                        $("#mensaje").html("El Cliente ha sido registrado");//texto que lleva la modal
                        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaclientes.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                        $("#FormularioCliente")[0].reset();
                        $("#Modalmen").modal("show");
                        //$("#jqGrid").reload;//muestra la modal
         
          //location.reload();

                  
                     
            
                       }
                       else
                       {
                       // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, el Cliente no se registro");
                        $("#Modalmen").modal("show");
                       }
                    });
                  
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
          }

</script>

<script type="text/javascript">

    $(document).ready(function (a) {
            
      $("#jqGrid").jqGrid({
      url: '../Controllers/controller.listaclientes.php',
      datatype: "json",
      styleUI : 'Bootstrap',
      height: 280,
        //rowNum: 5,
        rowList: [5,10,15],
       colModel: [
         { label: 'ID', name: 'id', width: 50, key: true },
         { label: 'RFC', name: 'rfc',autowidth: true },
         { label: 'Razón Social', name: 'razonsocial',autowidth: true },
        { label: 'Cuenta', name: 'cuenta',autowidth: true },
        { label: 'Correo', name: 'correo',autowidth: true },		
	    { label: 'Estatus', name: 'estatus', autowidth: true },
	      { label: 'País', name: 'pais', autowidth: true },
		  { label: 'Estado', name: 'estado', autowidth: true },
	     { label: 'Municipio', name: 'municipio', autowidth: true },
		 { label: 'Colonia', name: 'colonia',autowidth: true},
		 { label: 'CP', name: 'cp', autowidth: true },		
		{ label: 'Calle', name: 'calle', autowidth: true },
		{ label: 'NInterior', name: 'ninterior', autowidth: true },
		{ label: 'NExterior', name: 'nexterior', autowidth: true },		 
		{ label: 'CFDI', name: 'cfdi', autowidth: true }
		
        
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
function editar(){

   var grid = $("#jqGrid");
   var ret = grid.jqGrid('getGridParam',"selrow");
   $("#botoneditar").show();
   $("#botonguardar").hide();
    $("#formulario").show();
    $("#lista").hide();
    // $("#resEstados").removeAttr("required");
    // $("#resMunicipios").removeAttr("required");
    // $("#resCodigoPostal").removeAttr("required");
    // $("#resColonia").removeAttr("required");
   
    if(ret!=null)
    {
      $.getJSON('../Controllers/controller.buscarDatosCliente.php?id='+ret,
	  function(data){
         $.each(data, function(objeto,item){

                  $('#rfc').val(item.rfc);
                  $('#razonsocial').val(item.razonsocial);
                  $('#cuenta').val(item.cuenta);
                  $('#email').val(item.correo);

                 
                  $('#resEstados').val(item.idestado);
                  
				  
				  $('#resMunicipios').append('<option value="' + item.c_municipio + '">' + item.c_nombre_municipio + '</option>');
				  document.getElementById("resMunicipios").selectedIndex = "1";
				  
				  
                  $('#resCodigoPostal').append('<option value="' + item.c_cp + '">' + item.c_cp + '</option>');
				  document.getElementById("resCodigoPostal").selectedIndex = "1";
				  
				  $('#resColonia').append('<option value="' + item.idcolonia + '">' + item.c_nombre_colonia + '</option>');
				  document.getElementById("resColonia").selectedIndex = "1";
				  
                  $('#calle').val(item.calle);
                  $('#numinterior').val(item.ninterior);
				  
                  $('#numexterior').val(item.nexterior);
                  $('#cfdi').val(item.idcfdi);

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
     $("#FormularioCliente").on("submit", function(e){
                e.preventDefault();
                var grid = $("#jqGrid");
                var ret = grid.jqGrid('getGridParam',"selrow");
                var f = $(this);
                var formData = new FormData(document.getElementById("FormularioCliente"));
                   // $("#resEstados").Attr("required");
                  // $("#resMunicipios").Attr("required");
                  // $("#resCodigoPostal").Attr("required");
                  // $("#resColonia").Attr("required");
                 
                formData.append("id",ret);               

                $.ajax({
                    url: "../Controllers/controller.editarCliente.php",
                    type: "POST",
                    dataType: "html",
                    data:  formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                      if(res == "1")
                      {
                        $("#formulario").hide();
                        $("#lista").show();
                        
                        $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                         
                        $("#mensaje").html("El Cliente se ha editado correctamente");
                        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaclientes.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                        $("#FormularioCliente")[0].reset();
                        $("#Modalmen").modal("show");

						$("#botoneditar").hide();
						$("#botonguardar").show();
						
						
            
                     
					 
					 //location.reload();
                  
            
                       }
                       else
                       {
                        //alert(res);
                       $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, el Cliente no se pudo editar");
                        $("#Modalmen").modal("show");
                       }
                    });
                e.preventDefault(); //stop default action
                e.unbind(); //unbind. to stop multiple form submit.
            });
  }
  

function eliminar()
  {
    var grid = $("#jqGrid");
    var ret = grid.jqGrid('getGridParam',"selrow");
    if(ret!=null)
    {
          $.ajax({
            url: "../Controllers/controller.eliminarCliente.php?id="+ret,
            type: "POST",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
              if(res == "1")
                {
                 // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                  $("#mensaje").html("El Cliente ha sido borrado");
                  $("#Modalmen").modal("show");
                  $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaclientes.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                }
              else
                {
                 // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                  $("#mensaje").html("Ocurrio un error, Cliente no se pudo borrar");
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

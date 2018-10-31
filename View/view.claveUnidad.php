
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>CLAVE UNIDAD</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Clave Unidad</title>

    <!-- Latest compiled and minified CSS -->
   <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 -->
    <!-- Optional theme -->
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

   <!--<script src="js/bootstrap.min.js"></script>-->
   <link rel="stylesheet" href="../libs/css/bootstrap.min.css"/>
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
    <script src="../libs/js/timepicki.js" type="text/javascript"></script>
    <script src="../libs/js/jquery.timepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libs/css/design.aiko.css"/>
    
  	<script>
		 	$.jgrid.defaults.width = 400;
	        $.jgrid.defaults.responsive = true;
	        $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>

</head>
<body>
  <?php
  session_start();
  include("../Models/model.claveU.php");
  $unidad=new Unidad();
  include('../menu.php');
  ?>
<!--*******************************MODAL************************-->
  <div id="Modalmen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header " id="mtitu">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">CLAVE UNIDAD</h4>
      </div>
      <div class="modal-body">
        <div id='mensaje' align="center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
       <button id="btnConfirm" class="btn btn-primary" id="confirmar" style="display:none">Si</button>
      </div>
    </div>
  </div>
</div>
     
<!--MODAL CONFIRMACIÓN  -->
<div id="Modalcon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-warning" id="mtitucon">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">CLAVE UNIDAD</h4>
      </div>
      <div class="modal-body">
        <div id='mensajecon' align="center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button class="btn btn-primary" id="confirmar" onclick="eliminar()" data-dismiss="modal">Yes</button>
        <button class="btn btn-primary" id="confirmared" onclick="editar()" data-dismiss="modal">Yes</button>
      </div>
    </div>
  </div>
</div>
<!--************************************FORMULARIO*****************************************-->
<div id=formulario>
  <div class="col-md-12">
    <form id="formularioProd" enctype="multipart/form-data" method="POST" role="form" >    	
			<div class="panel panel-primary" style="border-color: #3173ac">
			  <div class="panel-heading">
			    <h2 class="panel-title" align="center" style="font-weight: bold"> Clave de Unidad</h3>
			  </div>
				<div class="panel-body">
            <div class="col-md-8">
             <label for="clavesat">Clave Unidad Sat</label>
             <input type="text" class="form-control" id="informacionsat" name="informacionsat" placeholder="00000-ejemplo" required>
            </div>  
             <div class=" col-md-4" style="display: none">
              <label for="dessat">ID</label>
              <input type="text" class="form-control" id="id" name="id" placeholder="0000" align="center">
            </div>
  				  <div class=" col-md-8">
              <label for="descripcion"><br>Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="es un ejemplo de la descripcion del producto o servicio" required></textarea><br>
  					</div>
            <div class=" col-md-12" align="right">
              <button type="submit" class="btn btn-primary" onclick="guardar();" id="botonguardar"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Guardar</button>
              <button type="submit" class="btn btn-primary" onclick="guardaredit();" style="display: none" id="botoneditar"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true" ></span> Editar</button>
            </div>
 
				</div>	
			</div>
		</form>
	</div>
</div>
<!-- *******************************TABLA************************** -->
<div id="lista">
  <div class=" col-md-4">
     
       <!--   <br><br> -->
  </div>

  <div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading"><center><strong>Listado de Unidades</strong> </center></div>
          <div class="btn-group">
                 <button type="button" class="btn btn-warning" onclick="modal(1)"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                  <button type="button" class="btn btn-danger" onclick="modal(0)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
              </div>
        <div class="panel-body">
            <div id="list">
                <table id="jqGrid" ></table>
                <div id="jqGridPager" style="height: 40px; width: 100%"></div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
// *********************LISTA DE DATOS
 $(document).ready(function (a) {
            
      $("#jqGrid").jqGrid({
      url: '../Controllers/controller.listaUnidad.php',
      datatype: "json",
      styleUI : 'Bootstrap',
      height: 280,
        rowNum: 5,
        rowList: [5,10,15],
       colModel: [
        { label: 'ID', name: 'id', width: 10, key: true },
        { label: 'CLAVE PRODUCTO ', name: 'clave_sat', width: 20 },
        { label: 'TIPO', name: 'descripcion_sat', width: 50 },
        { label: 'DESCRIPCIÓN', name: 'descripcion', width: 50 }
      ],
      viewrecords: true, // show the current page, data rang and total records on the toolbar
      autowidth: true,
      height: 200,
      rowNum: 5,
      sortname: 'id',
      gridview: true,
      loadonce: true, // this is just for the demo
      pager: "#jqGridPager",
    });
      //$("#list").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});
  });
// ***************AUTOCOMPLETAR****
  $(function(){
    $("#informacionsat").autocomplete({
                source: "../Controllers/controller.autoUnidad.php",
                minLength: 3,
                success:function(data){
                 $('#informacionsat').val(data);
                }
    });
  });
// ********************************

function guardar(){
            $("#formularioProd").on("submit", function(e){
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("formularioProd"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.agregarUnidad.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                      if(res == "1")
                      {
                        //alert("Prducto Registrado!");
                        $("#formularioProd")[0].reset();
                       // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                        $("#mensaje").html("La unidad ha sido registrada");
                        $("#Modalmen").modal("show");
                        $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaUnidad.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                       }
                       else
                       {
                       // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});

                        $("#mensaje").html("Ocurrio un error, la unidad no se registro");
                        $("#Modalmen").modal("show");
                       }
                    });
                
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
          }
/***********************************FUNCION DE CONFIRMACIÓN************/
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
      $("#confirmared").show();
      $("#confirmar").hide();
      $("#mtitucon").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("Esta seguro de editar esta fila");
      $("#Modalcon").modal("show");

     
      }
      else{
       $("#confirmared").hide();
      $("#confirmar").show();
      $("#mtitucon").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("Esta seguro de eliminar esta fila");
      $("#Modalcon").modal("show");
      }
    } 
    else {
        //$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
        $("#mensaje").html("Debe seleccionar una fila para continuar");
        $("#Modalmen").modal("show");
    } 
}
/*********************************/
function eliminar()
  {
    var grid = $("#jqGrid");
    var ret = grid.jqGrid('getGridParam',"selrow");
   
          $.ajax({
            url: "../Controllers/controller.eliminarUnidad.php?id="+ret,
            type: "POST",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
              if(res == "1")
                {
                 // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                  $("#mensaje").html("La unidad ha sido borrada");
                  $("#Modalmen").modal("show");
                  $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaUnidad.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
            
                }
              else
                {
                 // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                  $("#mensaje").html("Ocurrio un error, La unidad no pudo ser eliminada");
                  $("#Modalmen").modal("show");
                }
             
            });
  }

  function editar(){  
      var grid = $("#jqGrid");
      var ret = grid.jqGrid('getGridParam',"selrow");
       $("#botoneditar").show();
       $("#botonguardar").hide();
   
        $.getJSON('../Controllers/controller.buscardatosU.php?id='+ret,function(data){
         $.each(data, function(objeto,item){
                  $('#informacionsat').val(item.informacionsat);
                  $('#descripcion').val(item.descripcion);
                  $('#id').val(item.id); 
              });
          });
  }


 function guardaredit()
  {
     $("#formularioProd").on("submit", function(e){
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("formularioProd"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.editarUnidad.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                      if(res == "1")
                      {
                        $("#formularioProd")[0].reset();
                        //$("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                        $("#mensaje").html("La unidad se ha editado correctamente");
                        $("#Modalmen").modal("show");
                        $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaUnidad.php', datatype:'json',type:'POST'}).trigger('reloadGrid');   
            
                       }
                       else
                       {
                        //$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error,La unidad no se edito");
                        $("#Modalmen").modal("show");
                       }
                     
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
  }

</script>
  <script src="../libs/js/actions.aiko.js"></script>
</body>
</html>

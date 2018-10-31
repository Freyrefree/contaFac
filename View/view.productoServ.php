<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Productos y Servicios</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body>
  <?php
  session_start();
  include("../Models/model.productos.php");
  $producto=new Productos();
  include('../menu.php');
  ?>

<!--******************************* MODAL *****************************-->
<div id="ModalValidar" class="modal fade" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header " id="mtituvalidar">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" align="center">PRODUCTOS Y SERVICIOS</h4>
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
        <h4 class="modal-title" align="center">PRODUCTOS Y SERVICIOS</h4>
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
    <div class="modal-header btn-warning" id="mtitucon">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" align="center">PRODUCTOS Y SERVICIOS</h4>
      </div>
      <div class="modal-body">
        <div id='mensajecon' align="center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="no-con">No</button>
        <button class="btn btn-primary" id="confirmardelete" onclick="eliminar()" data-dismiss="modal">Sii</button>
        <button class="btn btn-primary" id="confirmared" onclick="editar()" data-dismiss="modal">Si</button>
      </div>
    </div>
  </div>
</div>

<!--************************************FORMULARIO CARGA***********************************-->
<div id=formulariocarga style="display: none">
  <div class="col-md-12">
    <!-- <form id="formulariocargaexcel" enctype="multipart/form-data" method="POST" role="form" > -->
      <div class="panel panel-primary" style="border-color: #3173ac">
        <div class="panel-heading">
          <h3 class="panel-title" align="center"><strong>Carga Masiva</strong></h3SS>
        </div>
        <div class="panel-body">
            <div class="col-md-8">
             <label for="">Documento</label>
             <input type="file" class="btn btn-info" class="form-control-file" id="archivoexcel" name="archivoexcel" aria-describedby="fileHelp" required>
            </div>



<br>
<br>
<br>
<br>
<label for="">TIPO DE CARGA</label>
<br>

            <!-- <div class="col-md-8" id="radios">
            <label for="">Conservar  Existentes</label>
            <input type="radio" id="m1"name="modo" value="1" required>
            <label for="">Eliminar Existentes</label>
            <input type="radio" id="m2" name="modo" value="0" required>
            </div> -->

      <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="radio" id="m1"name="modo" value="1" required>
      </span>
      <input type="text" class="form-control" aria-label="" value="Conservar  Existentes" readonly>
    </div><!-- /input-group -->
    <div class="input-group">
      <span class="input-group-addon">
        <input type="radio" id="m2" name="modo" value="0" required>
      </span>
      <input type="text" class="form-control" aria-label="" value="Eliminar Existentes" readonly>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->


            <div class=" col-md-12" align="right">
              <button type ="reset" class="btn btn-primary" onclick="lista();" id="botoncancelar"> <span class="glyphicon glyphicon-list" aria-hidden="true" ></span>Listado</button>
              <button type ="reset" class="btn btn-danger" onclick="cancelar();" id="botoncancelar"> <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>Cancelar</button>
              <button type="submit" class="btn btn-primary" onclick="subirexcel();"  id="botonprocesar"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>Procesar</button>
            </div>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>
<!--************************************FORMULARIO*****************************************-->
<div id=formulario>
  <div class="col-md-12">
    <form id="formularioProd" enctype="multipart/form-data" method="POST" role="form" >    	
			<div class="panel panel-primary" style="border-color: #3173ac">
			  <div class="panel-heading">
			    <h3 class="panel-title" align="center"><strong>Productos y Servicios</strong></h3SS>
			  </div>
				<div class="panel-body">
            <div class="col-md-8">
             <label for="clavesat">Clave Sat</label>
             <input type="text" class="form-control" id="informacionsat" name="informacionsat" placeholder="00000-ejemplo" required>
            </div>  
            <div class=" col-md-4">
              <label for="dessat">Clave Interna</label>
              <input type="text" class="form-control" id="clave" name="clave" placeholder="0000" align="center" required>
            </div>  
  				  <div class=" col-md-8">
              <label for="descripcion"><br>Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="es un ejemplo de la descripcion del producto o servicio" required></textarea><br>
  					</div>
             <div class=" col-md-4" style="display: none">
              <label for="dessat">ID</label>
              <input type="text" class="form-control" id="id" name="id" placeholder="0000" align="center" >
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
      
  </div>

  <div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading"><center><strong>Listado de Productos y Servicios</strong> </center></div>
              <div class="btn-group">

                <button type="button" class="btn btn-primary" onclick="carga()"><span class="glyphicon glyphicon-arrow-up"  id="cargamasiva"></span> Carga Masiva</button>               

                <button type="button" class="btn btn-warning" onclick="modal(1)"><span class="glyphicon glyphicon-edit" id="modeled"></span> Editar</button>
                <button type="button" class="btn btn-danger" onclick="modal(0)"><span class="glyphicon glyphicon-minus-sign" id="model"></span> Eliminar</button>

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

<!-- *************************************************FUNCIONES**************************** -->
<script type="text/javascript">
function carga()
{

    //$("#FormularioCliente")[0].reset();
    $("#formulario").hide();
    $("#formulariocarga").show();
    $("#lista").hide();
}

function lista()
{

  document.getElementById("archivoexcel").value = "";
  document.getElementById("m1").checked = false;
  document.getElementById("m2").checked = false;
  $("#formulario").show();
  $("#formulariocarga").hide();
  $("#lista").show();
  $("#lista").show();
}

function cancelar()
{
    //$("#archivoexcel").reset();
    document.getElementById("archivoexcel").value = "";
    document.getElementById("m1").checked = false;
    document.getElementById("m2").checked = false;
    $("#formulario").show();
    $("#formulariocarga").hide();
    $("#lista").show();
}

function subirexcel()
{
    var data = new FormData();
    var files = document.getElementById('archivoexcel').files;
    var cuantos = files.length;
    var val1 = document.getElementById("m1");
    var val2 = document.getElementById('m2');




    if(cuantos == 0)
    {
      $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensajevalidar").html("Debe seleccionar el archivo de excel a cargar");
      $("#ModalValidar").modal("show");
      document.getElementById("archivoexcel").style.borderColor = "red";
      //alert("Debe seleccionar el archivo de excel a cargar", "Business Internal Control");
      return false;
    }

    var str = files[0].name;
    var verext = str.split(".");
    var tam = verext.length;
    var ext = verext[tam-1];
    if(ext != 'xlsx')
    {
      $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensajevalidar").html("Debe seleccionar un archivo de excel con extensión .xlsx");
      $("#ModalValidar").modal("show");
      document.getElementById("archivoexcel").style.borderColor = "red";
      //alert("Debe seleccionar un archivo de excel con extensión xlsx", "Business Internal Control");
      return false;
    }
    if (val1.checked) {
      valradio = 1;
    }else if(val2.checked) {
      valradio = 0;
    }else {
      $("#mtituvalidar").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensajevalidar").html("Seleccione el tipo de Carga");
      $("#ModalValidar").modal("show");
      document.getElementById("archivoexcel").style.borderColor = "";
      //document.getElementsByName("modo").style.borderColor = "red";
      //document.getElementById("m1").focus();
      //val2.style.borderColor = "red";
     //alert("Seleccione una opción");
     return false;
    }

    //$("#cargando").show();
    data.append("cuantos",cuantos);
    data.append("excel",files[0]);
    data.append("modo",valradio);
    var url = '../Controllers/controller.cargaProdServ.php' + "?" + "cuantos=" + cuantos;

    $.ajax({
            type:'POST',
            async: true,
            //url:'../Controllers/controller.cargaProdServ.php',
            url : url,
            contentType:false,
            data:data,
            processData:false,
          }).done(function(respuesta)
          {
              $("#formularioProd")[0].reset();
              $("#mensaje").html("El proceso fué exitoso");
              $("#Modalmen").modal("show");
              $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaProdServ.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
              document.getElementById("archivoexcel").value = "";
              document.getElementById("m1").checked = false;
              document.getElementById("m2").checked = false;
         });

}

/***********************************************************************************************************************************/






 $(document).ready(function (a) {
            
      $("#jqGrid").jqGrid({
      url: '../Controllers/controller.listaProdServ.php',
      datatype: "json",
      styleUI : 'Bootstrap',
      height: 280,
        rowNum: 5,
        rowList: [5,10,15],
       colModel: [
        { label: 'ID', name: 'id', width: 10, key: true },
        { label: 'CLAVE SAT', name: 'clave_sat', width: 20 },
        { label: 'TIPO DEL PRODUCTO O SERVICIO', name: 'descripcion_sat', width: 50 },
        { label: 'CLAVE INTERNA', name: 'clave', width: 20 },
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
      $("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});
  });

// ***********AUTOCOMPLETAR*****
  $(function(){
    $("#informacionsat").autocomplete({
        source: "../Controllers/controller.informacionsat.php",
        minLength: 4,
        success:function(data){
          $('#informacionsat').val(data);
        }
    });
  });
/*******************************/
function guardar(){
            $("#formularioProd").on("submit", function(e){
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("formularioProd"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.agregaProd.php",
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
                       // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                        $("#mensaje").html("El Producto o Servicio ha sido registrado");
                        $("#Modalmen").modal("show");
                        $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaProdServ.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                       }
                       else
                       {
                       // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, el producto o servicio no se registro");
                        $("#Modalmen").modal("show");
                       }

                    });
                 
                e.preventDefault(); //stop default action
                e.unbind(); //unbind. to stop multiple form submit.
            });
          }

// *******************FUNCION DE CONFIRMACIÓN *****
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
      $("#confirmardelete").hide();
      $("#mtitucon").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
      $("#mensajecon").html("Esta seguro de editar esta fila");
      $("#Modalcon").modal("show");
      }
      else{
       $("#confirmared").hide();
      $("#confirmardelete").show();
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

// ***************************************************
function eliminar()
  {
    var grid = $("#jqGrid");
    var ret = grid.jqGrid('getGridParam',"selrow");
    if(ret!=null)
    {
          $.ajax({
            url: "../Controllers/controller.eliminarProd.php?id="+ret,
            type: "POST",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
              if(res == "1")
                {
                 // $("#mtitu").css({"background-color":"#3173ac","font-weight":"bold","color":"white"});
                  $("#mensaje").html("El Producto o Servicio ha sido borrado");
                  $("#Modalmen").modal("show");
                  $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/controller.listaProdServ.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
                }
              else
                {
                 // $("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                  $("#mensaje").html("Ocurrio un error, el producto o servicio no se pudo borrae");
                  $("#Modalmen").modal("show");
                }
             });
        }
  }


  function editar(){  
   var grid = $("#jqGrid");
   var ret = grid.jqGrid('getGridParam',"selrow");
   $("#botoneditar").show();
   $("#botonguardar").hide();
   
    if(ret!=null)
    {
      $.getJSON('../Controllers/controller.buscardatos.php?id='+ret,function(data){
         $.each(data, function(objeto,item){
                  $('#informacionsat').val(item.informacionsat);
                  $('#clave').val(item.clave);
                  $('#descripcion').val(item.descripcion);
                  $('#id').val(item.id); 
            }); 
      });
    }
    else
    {
      //$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
      $("#mensaje").html("Debe seleccionar una fila para editar");
      $("#Modalmen").modal("show");
    }
  }

 function guardaredit()
  {
     $("#formularioProd").on("submit", function(e){
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("formularioProd"));
                formData.append("dato", "valor");
                $.ajax({
                    url: "../Controllers/controller.editarProd.php",
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
                        $("#mensaje").html("El Producto o Servicio se ha editado correctamente");
                        $("#Modalmen").modal("show");
                        $('#jqGrid').jqGrid('setGridParam',{url: '../Controllers/controller.listaProdServ.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
            
                       }
                       else
                       {
                        //$("#mtitu").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
                        $("#mensaje").html("Ocurrio un error, el producto o servicio no se pudo editar");
                        $("#Modalmen").modal("show");
                       }
                    });
                e.preventDefault(); //stop default action
                e.unbind(); //unbind. to stop multiple form submit.
            });
  }
</script>
 <script src="../libs/js/actions.aiko.js"></script>
</body>
</html>

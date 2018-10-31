<?php
include('../models/model.factura.php');
$factura  = new factura();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Listado Facturas</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
   
    <link rel="stylesheet" href="../libs/css/bootstrap.min.css"/>
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
    <script src="../libs/js/timepicki.js" type="text/javascript"></script>
    <script src="../libs/js/jquery.timepicker.js" type="text/javascript"></script>
  <link href="../libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="../libs/css/design.aiko.css">

    <!-- <script src="../libs/js/actions.aiko.js"></script> -->

   
  	<script>
		 	$.jgrid.defaults.width = 768;
	    $.jgrid.defaults.responsive = true;
	    $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>
    
</head>


<body>
  <?php
    include("../menu.php");
  ?>
  <br><br>
  <div class="col-md-12">
    <div class="container-fluid">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Listado de Facturas
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
              <a href="view.factura.php"><button type="button" class="btn btn-primary" value="pre_factura" name="btn_prefactura" id="btn_prefactura"  ><span class="glyphicon glyphicon-file"></span> Nueva Factura</button></a>
              <button type="button" class="btn btn-primary" style="display:none; " value="dpdf" name="btnpdf" id="btnpdf"  onclick="descargarPDF();"><span class="glyphicon glyphicon-file"></span> Descargar PDF</button>
              <button type="button" class="btn btn-danger" value="dpdf" name="btnpdf" id="btnpdf" data-toggle="modal" data-target="#myModalCancelacion" onclick="contentCancelacion();" ><span class="glyphicon glyphicon-file"></span> Cancelar Factura</button>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalEliminacion" value="" name="eliminar" id="eliminar" ><i class="fa fa-file-text" aria-hidden="true"></i> Eliminar Registro</button>
              <a href="../index.php"><button type="button" class="btn btn-primary"  value="" name="eliminar" id="eliminar" ><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Regresar</button></a>
            </div>
            <div class="col-md-4">
               <div class="input-group" >
                 <input  type="text" name="buscar" id="buscar" onkeyup="buscarTodo();" class="form-control" placeholder="buscar..." >
                 <span class="input-group-addon" style="cursor:pointer;background-color: green;" onclick="buscarTodo();">
                    <i class="fa fa-search" aria-hidden="true" style="color:white"></i>
                 </span>
               </div>

                
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <input name = "id_xml"  id="id_xml"  value=" " type = "hidden">
              <input name = "uuid_xml"  id="uuid_xml"  value=" " type = "hidden"> 
              <table id="jqGrid" ></table>
              <div id="jqGridPager" style="height: 40px; width: 100%"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>





</body>

</html>


<!--modal para mostrar mensajes-->
<div class="modal fade bs-example-modal-sm" id="myModalMensajes" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index:1055">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header" id="modalheader">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          

          <h5 class="modal-title">Mensaje!! </h5>
        </div>
        <div class="modal-body">
         <p id="mensaje10"></p>
         <!-- <div id="Info"></div> -->
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmarenvio" onclick="modalcorreo(0)" style="display: none">No</button>
        <button class="btn btn-primary" id="confirmarenvio" onclick="modalcorreo(document.getElementById('confirmarenvio').value)" data-dismiss="modal" style="display: none">SI</button>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-example-modal-sm" id="myMensajeG" tabindex="-1"  data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" style="top: 10px; z-index: 1042;">
    <!--<div class="modal-dialog modal-sm" role="document">-->
      <div class="modal-content" style="width: 22%; margin-left: 40%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>          
        </div>
        <div class="modal-body" style="width:100%;">
            <center>
               <p id="mensajesGif" name ="mensajesGif"></p>
               <div id="mensajesC" name ="mensajesC" ></div>
            </center>
        </div>
    </div><!-- /.modal-content -->
  <!--</div><! /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-example-modal-sm" id="myModalCancelacion" tabindex="-1"  data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" style="top: 10px; z-index: 1042;">
    <!--<div class="modal-dialog modal-sm" role="document">-->
      <div class="modal-content" style="width: 22%; margin-left: 40%;">
        <div class="modal-header warning">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          CONFIRMACION
        </div>
        <div class="modal-body" style="width:100%;">
          <center>¿Esta seguro de cancelar la factura: <span id="factura"></span> con el folio fiscal: <span id="uuid"></span><br>Importe: <span id="totalFactura"></span>?</center>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" type="button" onclick="Cancelar();">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
    </div><!-- /.modal-content -->
  <!--</div><! /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade bs-example-modal-sm" id="myModalEliminacion" tabindex="-1"  data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" style="top: 10px; z-index: 1042;">
    <!--<div class="modal-dialog modal-sm" role="document">-->
      <div class="modal-content" style="width: 22%; margin-left: 40%;">
        <div class="modal-header warning">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          CONFIRMACION
        </div>
        <div class="modal-body" style="width:100%;">
          <center>¿Esta seguro de eliminar el registro?</center>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" type="button" onclick="eliminar();">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
    </div><!-- /.modal-content -->
  <!--</div><! /.modal-dialog -->
</div><!-- /.modal -->





<!-- ///javascript -->
<script type="text/javascript">
///===============================
$(document).ready(function () {
  $("#jqGrid").jqGrid({
        url: '../controllers/controller.listarfactura.php', 
        datatype: "json",
        mtype: 'GET',
        colModel: [
          { label: 'id', name: 'id', key: true, hidden: true },
          { label: 'Factura', name: 'factura', width: 20 },
          { label: 'RFC Receptor', name: 'rfc_receptor', width: 30 },
          { label: 'Razon Social', name: 'razon_social', width: 30 },
          { label: 'Municipio', name: 'municipio', width: 30 },
          { label: 'Subtotal', name: 'subtotal', width: 30 },
          { label: 'Total Traslado', name: 'totalTraslado', width: 30 },
          { label: 'Total Retencion', name: 'totalRetencion', width: 30 },
          { label: 'RFC Emisor', name: 'rfc_emisor', width: 30,hidden:true },
          { label: 'Total Facturado', name: 'total', width: 20 },
          { label: 'Fecha Timbrado', name: 'fecha_timbrado', width:30 },
          { label: 'Folio Fiscal', name: 'folio_fiscal', width: 60 },
          { label: 'Tipo', name: 'tipo_documento', width: 20,hidden:true },
          { label: 'Estatus', name: 'status_factura', width: 20 },
          { label: 'Docs', name: 'btn_accion', width: 20, align:'center' },
           { label: 'Pago', name: 'btn_pago', width: 10, align:'center' },
           { label: 'Complemento', name: 'btn_complemento', width: 10, align:'center' },
           { label: 'folio', name: 'folioconcepto', width: 10, align:'center',hidden:true },


           { label: 'Correo', name: 'btncorreo', width: 20, align:'center' }

        ],
        viewrecords: true,
        autowidth: true,
        height: 340,
        rowNum: 10,
        loadonce: true,
        pager: "#jqGridPager",
        ondblClickRow: function(rowId){
               var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
                var ret = $("#jqGrid").jqGrid('getRowData',id);
                if(ret.status_factura=="Pendiente"){
                  window.location.replace("view.factura.php?key="+id);
                }
            }
  });
  
  $("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});     

});


function eliminar(){
   var id =$("#jqGrid").jqGrid('getGridParam','selrow');
     var ret = $("#jqGrid").jqGrid('getRowData',id);
     if(id){

      if(ret.status_factura=="Pendiente"){
        var id=ret.id;
        var folioConcepto=ret.folioconcepto;
        $.ajax({
          data:  "id="+id+"&folio="+folioConcepto,
          url: '../controllers/controller.eliminaFactura.php',
          type: 'post',
          success: function(data){ 
            console.log(data);
            $("#myModalEliminacion").modal("show");
            recargar();
            // $('#btn_pdf').attr("style", "display=block");
            // $('#div_todo' ).html( data );
          }
        });  
      }else{
        $('#myModalMensajes').modal('show');
        $('#mensaje10').text("Solo se pueden eliminar facturas en estatus pendiente");
      }

     }else{
        $('#myModalMensajes').modal('show');
        $('#mensaje10').text("Seleccione un Registro");
     }
}

function contentCancelacion(){
  var id =$("#jqGrid").jqGrid('getGridParam','selrow');
     var ret = $("#jqGrid").jqGrid('getRowData',id);
     $("#factura").text(ret.factura);
     $("#uuid").text(ret.folio_fiscal);
     $("#totalFactura").text(ret.total);
}
function buscarTodo(){
  var valor=$("#buscar").val();
    $('#jqGrid').jqGrid('setGridParam',{url:'../controllers/controller.buscaFacturaCaract.php?valor='+valor, datatype:'json',type:'GET'}).trigger('reloadGrid');
}

//funcion para generar la prefactura ismael 111117
function pre_factra(){

  var id =$("#jqGrid").jqGrid('getGridParam','selrow');
  var parametros = {"id": id};  

  if(id){
     $.ajax({
      data:  parametros,
      url: '../controllers/controller.prefacturacion.php',
      type: 'post',
      beforeSend: function () {                                    
          $('#myMensajeG').modal('show');
          $('#mensajesGif').html('<img src="../img/loader1.gif"/>');
          $("#mensajesC").html("Procesando, espere por favor...");
      },
      success: function(data){ 
          $('#myMensajeG').modal('hide');

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
  }else{
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Seleccione un Registro");
  }
}

//para genera un pdf ismael 121117




///para timbrar la factura ismael 131117
function timbrar(){
  var id =$("#jqGrid").jqGrid('getGridParam','selrow');
  var parametros = {"id": id};  

  if(id){
     $.ajax({
      data:  parametros,
      url: '../controllers/controller.facturacion.class.php',
      type: 'post',
      beforeSend: function () {                                    
          $('#myMensajeG').modal('show');
          $('#mensajesGif').html('<img src="../img/loader1.gif"/>');
          $("#mensajesC").html("Procesando, espere por favor...");
      },
      success: function(data){ 
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

             //document.getElementById("btnpdf").style.display="block";
             
             downloadxml(devuelto);
          }
          if(mensaje=="error"){
             $('#myModalMensajes').modal('show');
             $('#mensaje10').text(devuelto);            
          }
       }

    });  
  }else{
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Seleccione un Registro");
  }
}


//para descargar el xml
function downloadxml(dato){
console.log(dato);
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

  }else{
      return false;
  }   
}

//para borrar las prefcaturas
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

//=====funcion apra generar el pdf 
function descargarPDF(){
 
  var folio=$("#id_xml").val(id);
  var id_doc=$("#uuid_xml").val(devuelto);


  var parametros = {"id" : id_doc,  "folio" : folio };
  r="../controllers/controller.funcion_MPDF.php";

   $.ajax({
      data:  parametros,
      url:   r,
      type:  'post',
      async: false,
      beforeSend: function () {
           $('#myModalMensajes').modal('show');
           $('#mensaje10').text("Procesando pdf, espere por favor...");
      },
      success:  function (response) {
        var dato=response;
        downloadpdf(dato);
      }
  }); 
}



function downloadpdf(dato){
  // var uu="";
  // ud=$("#uuid_xml").val();
  var uuid = dato;  

  var pdf = "../comprobantesCfdi/"+uuid+".pdf";
  //console.log(pdf);
  if( uuid != null ){  
      // var uuid = uui;
      var URL = pdf;
      window.location.href = '../Controllers/controller.descargarpdf.php?archivo='+URL+'&uuid='+uuid;
      $('#myModalMensajes').modal('hide');
      //document.getElementById("btnpdf").style.display="none";
      //recargar();
      
  }else{

      return false;
  }  
    
}

function recargar(){//funcion para recargar el jqgrid 
  $('#jqGrid').jqGrid('setGridParam',{url:'../controllers/controller.listarfactura.php', datatype:'json',type:'POST'}).trigger('reloadGrid');
}

///para descargar el pdf
function descpdf(id){

  //var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
  var ret = $("#jqGrid").jqGrid('getRowData',id);
  var u= ret.folio_fiscal;

  var tipo= ret.tipo_documento;//agregado nuevo

  var parametros = {"id" : id,  "folio" : u };
  r="../controllers/controller.funcion_MPDF.php";
  console.log(id+'|'+u);
 // if(id){
   $.ajax({
      data:  parametros,
      url:   r,
      type:  'post',
      async: false,
      beforeSend: function () {
           $('#myModalMensajes').modal('show');
           $('#mensaje10').text("Procesando pdf, espere por favor...");
      },
      success:  function (response) {
       // console.log(response);
        var dato=ret.folio_fiscal;
        downloadpdf(dato);
      }
  
  }); 
 //}else{
  //alert("Seleccione un registro");
 //}
}


function descxml(id){
   //var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
   var ret = $("#jqGrid").jqGrid('getRowData',id);
   var u= ret.folio_fiscal;

   var tipo= ret.tipo_documento;//agregado nuevo

  if(id){
      downloadxml(u);
  }else{
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Seleccione un Registro");
  }

}
function Cancelar(){
  var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
   var ret = $("#jqGrid").jqGrid('getRowData',id);
   if(id){
    $.ajax({
          data:  "uuid="+ret.folio_fiscal,
          url:   '../controllers/controller.cancelar.php',
          type:  'post',
          async: false,
          success:  function (response) {
            $("#jqGrid").setGridParam({datatype:"json"}).trigger('reloadGrid');
             $("#myModalCancelacion").modal("hide");
            $('#myModalMensajes').modal('show');
            $('#mensaje10').html(response);
                                            //$("#modalCancelacion").modal('toggle')
          }
     });
   }else{
    $("#myModalCancelacion").modal("hide");
     $('#myModalMensajes').modal('show');
     $('#mensaje10').text("Seleccione un registro");
   }
}
</script>
<script type="text/javascript">
function confirmarEnvioCorreo(uid){
  var id = uid;
  var s = document.getElementById("confirmarenvio");
  s.value = id;
  $("#mensaje10").html("¿Desea enviar el correo electrónico?");
  $("#myModalMensajes").modal("show");
  $("#noconfirmarenvio").show();
  $("#confirmarenvio").show();
  //document.getElementById("confirmarenvio").value = id;

  

}
function modalcorreo(id)
{
var uid = id;
if(uid != 0)
{
  //var uid = 66;
  enviarCorreo(uid);
}else
{
  return false;
}
}
function enviarCorreo(uid)
{
  var id = uid;
  //alert (id +"correo");

  $.ajax({
  method: "POST",
  url: "../controllers/controller.correoPDFXML.php",
  data: { id: id, opc: 1 }
})
   .done(function(respuesta) {
    var json = $.parseJSON(respuesta);
    var correo = json[0];
     if(correo != "")
     {    
      //alert(correo);
      $.ajax({
      method: "POST",
      url: "../controllers/controller.correoPDFXML.php",
      data: { id: id, opc: 2}
    })
      .done(function(respuesta) {
        
        if(respuesta == 1){
          //alert(respuesta);
        $("#noconfirmarenvio").hide();
        $("#confirmarenvio").hide();
        $("#mensaje10").html("El correo se ha enviado correctamente");
    		$("#myModalMensajes").modal("show");
        }else{
          $("#noconfirmarenvio").hide();
        $("#confirmarenvio").hide();
        $("#modalheader").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
        $("#mensaje10").html("Lo sentimos, el correo no se ha enviado");
    		$("#myModalMensajes").modal("show");
        }

      });





     }else{
      // alert("No existe correo registrado");
        $("#modalheader").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
    		$("#mensaje10").html("Lo sentimos, el Cliente no cuenta con un correo registrado");
    		$("#myModalMensajes").modal("show");    	
    		return false;
     }
  });
}


</script>


<script type="text/javascript" src="../libs/js/actions.aiko.js"></script>
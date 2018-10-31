<?php
include('../models/model.pagos.php');
$factura  = new pagos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Clientes</title>
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
  <div class="container-fluid">
  <div class="col-md-12">
    <div class="container-fluid">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Listado de Facturas
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-7">
              <button type="button" class="btn btn-primary" value="pre_factura" name="btn_prefactura" id="btn_prefactura" title="emitir pago a facturas" onclick="emitir_pago();"><span class="glyphicon glyphicon-usd"></span> Emitir Pago</button>  

                        
             
            </div>

            <div class="col-md-5">
              <div class="input-group">

               <input onChange="buscar_facturas();" type="text" name="cliente" id="cliente" class="form-control" placeholder="buscar cliente..." >

                <input type="hidden" name="id_cliente" id="id_cliente" class="form-control" value="0"> 
                <input type="hidden" name="rfc_cliente" id="rfc_cliente" class="form-control"> 
                <input type="hidden" name="razon_social" id="razon_social" class="form-control">

                 <input type="hidden" name="id_factura_original" id="id_factura_original" class="form-control">

                 <span class="input-group-btn"> <button type="button" onclick="buscar_facturas();" class="btn btn-success btn-sm"  title="Buscar Facturas" id="btn_bfc" name="btn_bfc" value=""><span class="glyphicon glyphicon-search" ></span> Mostrar</button></span>

              </div>
                        
            </div>
            <!-- div class="col-md-2">
               
            </div> -->

          </div>
          <!-- <br> -->

          <div class="row">
            <div class="col-md-12">

              <table id="jqGrid" ></table>
              <div id="jqGridPager" style="height: 40px; width: 100%"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <br>

  <div class="col-md-12" id="div_pagos" name="div_pagos" style="visibility: hidden;">
    <div class="container-fluid">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Listado de Pagos
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-7">
              <div class="btn-group"  style="float: left;">
                 <button type="button" class="btn btn-primary" value="pre_factura" name="btn_complemento" id="btn_complemento" title="Emitir Complemento de Pagos" onclick="generar_complemento();"><span class="glyphicon glyphicon-file"></span> Generar Complemento</button>         
 <!-- display:none; -->
                 <button type="button" class="btn btn-primary" style="display:none;" value="dpdf" name="btnpdf" id="btnpdf"  onclick="descargarPDF();"><span class="glyphicon glyphicon-file"></span> Descargar PDF</button> 

              </div>                
             
            </div>
          </div>          

          <div class="row" >
            <div class="col-md-12">
              <input name = "id_xml"  id="id_xml"  value=" " type = "hidden">
              <input name = "uuid_xml"  id="uuid_xml"  value=" " type = "hidden"> 
              <table id="jqGrid_pagos" ></table>
              <div id="jqGridPager_pagos" style="height: 40px; width: 100%"></div>
            </div>
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
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h5 class="modal-title">Mensaje!! </h5>
        </div>
        <div class="modal-body">
         <p id="mensaje10"></p>
         <!-- <div id="Info"></div> -->
        </div>
        <!-- <div class="modal-footer">
        </div -->
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
               <div id="mensajesC" name ="mensajesC" >
            </center>
        </div>
    </div><!-- /.modal-content -->
  <!--</div><! /.modal-dialog -->
</div><!-- /.modal -->


<!-- ///modal para generr los pagos ismale 151117 -->
<div class="modal fade" id="myModalPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body" id="contenidoPago">
       <form enctype="multipart/form-data" id="formulario_pago" method="post" role="form">
         <div class="row">

            <div class="col-md-4">
              <label>RFC</label>
              <input type="text" class="form-control" name="rfc_r" id="rfc_r" value="" readonly="readonly" />
              <input type="hidden" class="form-control" name="idRelacionado" id="idRelacionado" value=""  />
            </div>
            <div class="col-md-4">
              <label>UUID</label>
              <input type="text" class="form-control" name="uuid" id="uuid" value="" readonly="readonly" />
            </div>
            <div class="col-md-4">
              <label>Monto Actual</label>
              <input type="text" class="form-control" name="saldo" id="saldo" value="" readonly="readonly" />
            </div>
        </div>
          <br>
        <div class="row">
            <div class="col-md-4">
              <label>Moneda Pago</label>
              <select class="form-control" id="monedaP" name="monedaP">                
              </select>

            </div>
            <div class="col-md-4">
              <label>Forma de Pago</label>
              <select class="form-control" id="formaP" name="formaP">                
              </select>
            </div>
            <div class="col-md-4">
              <label>Numero de Parcialidad</label>
              <input type="number" class="form-control" name="parcialidad" id="parcialidad" readonly="readonly" />
            </div>
            <div class="col-md-4"></div>
            <!-- <div class="col-md-4">
              <label>Folio Pago</label>
              <input type="text" class="form-control" name="folioP" id="folioP">
            </div> -->
        </div>
        <br>

       
          
          <!-- //nuevo agregado ismael 151117 datos bancarios -->
        <div class="row" style="border: 1px solid #ccc; padding: 5px">
          
          <div class="col-md-4">
            <div class="input-group">
              <label>Cuenta Origen</label>
              <div class="input-group" >
                <select class="form-control" id="cuenta_origen" name="cuenta_origen">                
                </select>
                <div class="input-group-addon" style="color:green"><span class="glyphicon glyphicon-plus" onclick="add_cuenta_origen();"  title="Agregar nueva cuenta bancaria" id="btn_bfc" name="btn_bfc" value="" ></span></div>                
              </div>
            </div>
          </div>


          <div class="col-md-4">
              <label>Num. Operación</label>
              <input type="text" class="form-control" name="num_operacion" id="num_operacion" value=""  />
          </div>

          <div class="col-md-4">
            <div class="input-group">
              <label>Cuenta Destino</label>
              <div class="input-group " >
                <select class="form-control" id="cuenta_destino" name="cuenta_destino">                
                </select>
                <div class="input-group-addon" style="color:green"><span class="glyphicon glyphicon-plus" onclick="add_cuenta_destino();"  title="Agregar nueva cuenta bancaria" id="btn_a" name="btn_a" value="" ></span></div>                
              </div>
            </div>
          </div>
        </div>
          
        <br>
        <div class="row">
          
          <div class="col-md-4">
            <label>Importe de Pago</label>
            <input type="text" class="form-control" name="montoPago" id="montoPago" />
          </div>
          <div class="col-md-4">
            <label>Fecha de Pago</label>
            <input type="date" class="form-control" name="fechaP" id="fechaP" />
          </div>
        </div>
          
       </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="pagar_XML();" ><span class="glyphicon glyphicon-floppy-disk"></span>  Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- //fin modal para generar pagos -->


<!--modal para agregar nueva cuenta origen-->

<div class="modal fade" id="myModalCuenta_Origen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Nueva Cuenta Cliente</h5>
      </div>

      <div class="modal-body" id="">
       <form enctype="multipart/form-data" id="form_cuenta_o" method="post" role="form">
        <div class="row">
            <div class="col-md-4">
              <label>Nombre del Banco: </label>
              <input type="text" class="form-control" name="nom_banco_o" id="nom_banco_o" value="" required="true" />
            </div>
            <div class="col-md-4">
              <label>RFC del Banco: </label>
              <input type="text" class="form-control" name="rfc_cuenta_o" id="rfc_cuenta_o" value="" />
            </div>
            <div class="col-md-4">
              <label>Num. Cuenta: </label>
              <input type="text" class="form-control" name="num_cuenta_o" id="num_cuenta_o" value="" required="true"/>
            </div>
        </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="guardar_cuenta_o();" ><span class="glyphicon glyphicon-floppy-disk"></span>  Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal para agreagad nueva cuenta destino-->

<div class="modal fade" id="myModalCuenta_Destino" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Cuenta </h5>
      </div>
      <div class="modal-body" id="">
       <form enctype="multipart/form-data" id="form_cuenta_d" method="post" role="form">
        <div class="row">
            <div class="col-md-4">
              <label>Nombre del Banco: </label>
              <input type="text" class="form-control" name="nom_banco_d" id="nom_banco_d" value="" required="true"/>
            </div>
            <div class="col-md-4">
              <label>RFC del Banco: </label>
              <input type="text" class="form-control" name="rfc_cuenta_d" id="rfc_cuenta_d" value="" />
            </div>
            <div class="col-md-4">
              <label>Num. Cuenta: </label>
              <input type="text" class="form-control" name="num_cuenta_d" id="num_cuenta_d" value="" required="true"/>
            </div>
        </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="guardar_cuenta_d();" ><span class="glyphicon glyphicon-floppy-disk"></span>  Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModalArchivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <embed src="" width="100%" height="400" id="documentotxt">
          <input name="id_pdf"  value=""  id="id_pdf"  hidden = "hidden">
          <!-- <input name="idFactura" id="idFactura" value="" type="hidden"> -->
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-success  btn-sm" onclick="timbrar()" style="border-radius: 0px; float: left" title="Timbrar Factura"> <span class="glyphicon glyphicon-file" ></span> Timbrar</button>

        <!-- <button type="button" class="btn btn-primary  btn-sm" onclick="download()" style="border-radius: 0px"> <span class="glyphicon glyphicon-save-file" ></span> Descargar Pre PDF</button> -->

        <button type="button" class="btn btn-primary  btn-sm" data-dismiss="modal" style="border-radius: 0px"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>
</body>
<!-- ///javascript -->
<script type="text/javascript">
///===============================
$(document).ready(function(){//autocomplit para aduana
  $('#cliente').autocomplete({
         source: function( request, response ) {
         $.ajax({
            url : '../controllers/controller.selectclientes.php?action=buscar_cliente',
            dataType: "json",
            data: {name_startsWith: request.term },
            success: function( data ) {
                response( $.map( data, function( item ) {
                    return {
                      label: item.nombre,
                      value: item.nombre,                               
                         id: item.id,
                rfc_cliente: item.rfc_receptor,
                razon_social: item.razon_social
                    }
                }));
            }
        });
      },
      autoFocus: true,
      minLength: 0 ,
      select: function(event, ui) {
        $("#id_cliente").val(ui.item.id);
        $("#rfc_cliente").val(ui.item.rfc_cliente);
        $("#razon_social").val(ui.item.razon_social);         
      }       
  });
});


//para obtener el cliente 
function buscar_facturas(){//utilizado
   var cliente= $("#cliente").val();

   if(cliente==""){
     $("#id_cliente").val("0");
   }

  var id_cliente=$("#id_cliente").val();

  recargar(id_cliente);
}

$(document).ready(function () { //utilizado 

  var id_cliente=0;

  $("#jqGrid").jqGrid({
        url: '../controllers/controller.listartimbrados.php', 
        datatype: "json",
        // mtype: 'GET'
        postData: {"id_cliente": id_cliente},
        mtype: 'POST',
        colModel: [
          { label: 'id', name: 'id', key: true, hidden: true },
          { label: 'Factura', name: 'factura', width: 20, align:'center' },
          { label: 'RFC Emisor', name: 'rfc_emisor', width: 30 },
          { label: 'RFC Receptor', name: 'rfc_receptor', width: 30 },
          { label: 'Total Factura', name: 'total', width: 20 },
          { label: 'Fecha Timbrado', name: 'fecha_timbrado', width:30 },
          { label: 'Tipo', name: 'tipo_documento', width: 20, align:'center'},
          { label: 'Folio Fiscal', name: 'folio_fiscal', width: 60 },          
          { label: 'Estatus', name: 'status_factura', width: 20, align:'center'},
          { label: 'Pagado', name: 'btn', width: 10, align:'center' },
          { label: 'estado_pago', name: 'estado_pago', width: 10, align:'center', hidden: true  }

          // { label: 'Acciones', name: 'btn_accion', width: 20, align:'center' }
        ],
        viewrecords: true,
        autowidth: true,
        height: 210,
        rowNum: 5,
        loadonce: true,
        // multiselect: true,
        pager: "#jqGridPager",
        onSelectRow: function(id){
          if(id == null) {       
            
          } else {

            // alert(id);
            mostrar_pagos(id);                

            document.getElementById('div_pagos').style.visibility="visible";
          }
       }
  });
  
  $("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});     

});


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





//para descargar el xml
function downloadxml(dato){

  var xml="";
  var uuid= dato;

  xml = "../comprobantesPago/"+uuid+".xml";
 
  //xml = "comprobantes/"+uui+".XML";

  if(uuid != null ){ 
      con=0;
      var uuid = uuid;
      var URL = xml;
      // window.location.href = 'descargaxml.php?archivo='+URL+'&uuid='+uuid;
      window.location.href = '../controllers/controller.descargaxml_pago.php?archivo='+URL+'&uuid='+uuid;

  }else{
      return false;
  }   
}

//para borrar las prefcaturas
function borrar_pre(id){  
   
   var action="borrar_pre_pago";

  var id =id;
  if (id>0) {
    var reg= id;
    var r="";
    var parametros = {"id" : reg};
    r='../controllers/controller.selectclientes.php?action='+action,

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

  var id =$("#jqGrid_pagos").jqGrid('getGridParam','selrow'); 
  var ret = $("#jqGrid_pagos").jqGrid('getRowData',id);
  var u= ret.folio_fiscal;
  var id=0;

  id=ret.id_complemento;
 
  // var folio=$("#uuid_xml").val();
  // var id_doc=$("#id_xml").val();
  var folio=u;
  var id_doc=id;


  var parametros = {"id" : id_doc,  "folio" : folio };
  r="../controllers/controller.pdf_comprobante_pago.php";

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
        // alert(dato);
        downloadpdf(folio);
      }
  }); 
}



function downloadpdf(dato){
  // var uu="";
  // ud=$("#uuid_xml").val();
  var uuid = dato;  
  var pdf = "../comprobantesPago/"+uuid+".pdf";

  if( uuid != null ){  
      // var uuid = uui;
      var URL = pdf;
      window.location.href = '../controllers/controller.descargarpdf_pago.php?archivo='+URL+'&uuid='+uuid;
      
      document.getElementById("btnpdf").style.display="none";
      // recargar();
      
  }else{

      return false;
  }  
    
}

function recargar(id){//funcion para recargar el jqgrid 
  var id_cliente=id;

  $('#jqGrid').jqGrid('setGridParam',{url:'../controllers/controller.listartimbrados.php', postData: {"id_cliente": id_cliente},  datatype:'json',type:'POST'}).trigger('reloadGrid');
}

///para descargar el pdf
function descpdf(){

  var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
  var ret = $("#jqGrid").jqGrid('getRowData',id);
  var u= ret.folio_fiscal;

  var tipo= ret.tipo_documento;//agregado nuevo

  var parametros = {"id" : id,  "folio" : u };
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
        downloadpdf(u);
      }
  }); 
}


function descxml(){
   var id =$("#jqGrid").jqGrid('getGridParam','selrow'); 
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

///nuevo agregado ismale para emitir el pago
function emitir_pago(){


  var id_cliente="";
  var rfc_p="";

  id_cliente=$("#id_cliente").val();
  // rfc_p=$("#rfc_cliente").val();

  // $("#id_proveedor_p").val(pro);
  // $("#rfc_prov_p").val(rfc_p);
  ////====

  var id =$("#jqGrid").jqGrid('getGridParam','selrow');


  $("#id_factura_original").val(id);//

  var gr = $("#jqGrid").jqGrid('getGridParam','selrow');
  var ret = $("#jqGrid").jqGrid('getRowData',gr);

  var grid = $("#jqGrid");
  var rowKey = grid.getGridParam("selrow");
  

  var estado_pago=ret.estado_pago;//trae el satdo del pagod el registro

  var result= "";
  
  if (!rowKey){
     $('#myModalMensajes').modal('show');
     $('#mensaje10').text("Seleccione la factura a emitir pago");
  }else {
      if(estado_pago=='1'){
         $('#myModalMensajes').modal('show');
         $('#mensaje10').text("Esta factura ya fue pagada en su totalidad");
      }else{
         // var selectedIDs = grid.getGridParam("selarrrow");
         //  for (var i = 0; i < selectedIDs.length; i++) {
         //      result += selectedIDs[i] + ",";
         //  }
                 
        var id_factura='';
        id_factura=ret.id;

        procesar_pago(id_factura);//funcion para mostar el modal de pagos

        // $("#myModalPago").modal("show");

      }//fin del estado del pago        
    } 

}

function procesar_pago(id_factura){
   
  var id_factura=id_factura;//contiene el id de la factura

  $.getJSON('../controllers/controller.selectclientes.php?action=mostrar_info&id='+id_factura, function(data){
      $.each(data, function(objeto,item){

        $('#rfc_r').val(item.rfc_r);
        $('#idRelacionado').val(item.idRelacionado);
        $('#uuid').val(item.uuid);
        $('#saldo').val(item.saldo);
        $('#parcialidad').val(item.parcialidad);
      });
  });


    //  $.ajax({
    //     data:  parametros,
    //     url:  'operaciontrafico2.php?action=obtener_ref', 
    //     type:  'post',
    //     success: function(dato){
          
    //         $("#no_ref").val(dato);
    //          fecha_actual();
    //         $('#myModalPago').modal('show');
    //         // document.getElementById('btn_nuevo').style.display="block";
    //      }
    // }); 

    $("#myModalPago").modal("show");

}



//para el metodo de pago
$(function(){//listado metodo pago                  
   $.post('../controllers/controller.selectclientes.php?action=formaP' ).done(function(respuesta){
      $( '#formaP' ).html(respuesta);
   });                    
});

//para el metodo de pago
$(function(){//listado metodo pago                  
   $.post('../controllers/controller.selectclientes.php?action=monedaP' ).done(function(respuesta){
      $( '#monedaP' ).html (respuesta);
   });                    
});


///para mostrar los modal de agregar nuevas cuentas

function add_cuenta_origen(){
  $("#nom_banco_o").val("");
  $("#rfc_cuenta_o").val("");
  $("#num_cuenta_o").val("");

  $("#myModalCuenta_Origen").modal("show");
}
function add_cuenta_destino(){
  $("#nom_banco_d").val("");
  $("#rfc_cuenta_d").val("");
  $("#num_cuenta_d").val("");
  $("#myModalCuenta_Destino").modal("show");
}

function guardar_cuenta_o(){

    var nom_banco_o="";
    var num_cuenta_o="";

    var nom_banco_o=$("#nom_banco_o").val();
    var num_cuenta_o=$("#num_cuenta_o").val();


    var b=0;

    if(nom_banco_o != ""){
      if(num_cuenta_o != ""){
        b=1;  
      }else{
         $('#myModalMensajes').modal('show');
         $('#mensaje10').text("Ingrese número de cuenta");
      }
    }else{
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Ingres nombre de banco");    
    }

    if(b==1){

        var action="guardar_datos_o";
        var formData = new FormData(document.getElementById("form_cuenta_o"));

        $.ajax({                  
            url:  '../controllers/controller.selectclientes.php?action='+action,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            cache:false,
            success: function(data){ 

              if(data==1){
               //proceso correcto
               //
                cargar_cuenta_o();//llama a la funcion llenar la cuenta
                $("#myModalCuenta_Origen").modal("hide");
               
              }
              if(data==0){
                 // ocurrio un error
                $('#myModalMensajes').modal('show');
                $('#mensaje10').text("Ocurrio un error en el guardado");  
              }


            }
          });
    }

}
function guardar_cuenta_d(){

  var nom_banco_d="";
  var num_cuenta_d="";

  var nom_banco_d=$("#nom_banco_d").val();
  var num_cuenta_d=$("#num_cuenta_d").val();


  var b=0;

  if(nom_banco_d!=""){
    if(num_cuenta_d!=""){
      b=1; 
    }else{
       $('#myModalMensajes').modal('show');
       $('#mensaje10').text("Ingrese número de cuenta");
    }
  }else{
    $('#myModalMensajes').modal('show');
    $('#mensaje10').text("Ingres nombre de banco");    
  }

  if(b==1){

      var action="guardar_datos_d";
      var formData = new FormData(document.getElementById("form_cuenta_d"));

      $.ajax({                  
          url:  '../controllers/controller.selectclientes.php?action='+action,
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          cache:false,
          success: function(data){ 

            if(data==1){
             //proceso correcto
             //
              cargar_cuenta_d();//llama a la funcion llenar la cuenta
              $("#myModalCuenta_Destino").modal("hide");             
            }
            if(data==0){
              $('#myModalMensajes').modal('show');
              $('#mensaje10').text("Ocurrio un error en el guardado");  
            }
          }
        });
  }
  
}


function cargar_cuenta_o(){
  $.post('../controllers/controller.selectclientes.php?action=cuenta_origen' ).done(function(respuesta){
      $( '#cuenta_origen' ).html(respuesta);
   });
}
function cargar_cuenta_d(){
   $.post('../controllers/controller.selectclientes.php?action=cuenta_destino' ).done(function(respuesta){
      $( '#cuenta_destino' ).html (respuesta);
   });
}



//para el metodo de pago
$(function(){//listado metodo pago                  
   $.post('../controllers/controller.selectclientes.php?action=cuenta_origen' ).done(function(respuesta){
      $( '#cuenta_origen' ).html(respuesta);
   });                    
});

//para el metodo de pago
$(function(){//listado metodo pago                  
   $.post('../controllers/controller.selectclientes.php?action=cuenta_destino' ).done(function(respuesta){
      $( '#cuenta_destino' ).html (respuesta);
   });                    
});



function pagar_XML(){

  var id_doc=$("#idRelacionado").val();
  var SaldoAnt=$("#saldo").val();
  var SaldoPago=$("#montoPago").val();
  var parcialidad=$("#parcialidad").val();
  var fechaP=$("#fechaP").val();
  var monedaP=$("#monedaP").val();
  // var formaP=$("#formaP").val();
  // var folioP=$("#folioP").val();
  if(monedaP==""){
      $("#monedaP").focus();
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Seleccione una moneda"); 
      return false;
  }

  if(fechaP==""){
      $("#monedaP").focus();
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Ingrese una fecha de Pago"); 
      return false;
  }
  


  if(formaP==""){
      $("#formaP").focus();
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Seleccione una forma de Pago"); 
      return false;
  }
  if(SaldoPago==""){
      $("#SaldoPago").focus();
      $('#myModalMensajes').modal('show');
      $('#mensaje10').text("Ingrese un monto de pago");
      return false;
  }

  if(SaldoAnt<SaldoPago){
    $('#myModalMensajes').modal('show');
    $('#mensaje10').text("El monto pagado supera al monto deudor");
    return false;
  }


  var action="guardar_pago";
  var formData = new FormData(document.getElementById("formulario_pago"));

  $.ajax({                  
      url:  '../controllers/controller.selectclientes.php?action='+action,
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      cache:false,
      success: function(data){ 

        if(data==1){
         //proceso correcto
         //
          // cargar_cuenta_d();//llama a la funcion llenar la cuenta
          $('#myModalMensajes').modal('show');
          $('#mensaje10').text("Pago Correcto");  
          $("#myModalPago").modal("hide");
          limpiar();  

          recargar(0);
          mostrar_pagos(id_doc);      
        }
        if(data==0){
          $('#myModalMensajes').modal('show');
          $('#mensaje10').text("Ocurrio un error en el pago"); 

        }

        if(data !=0 && data != 1){
          $('#myModalMensajes').modal('show');
          $('#mensaje10').text(data);  
          limpiar();
        }
      }
  });

}

///para llenar el grid de pagos
// $(document).ready(function () { //utilizado 
$(document).ready(function () { //utilizado 

  var id_factura=0;

  $("#jqGrid_pagos").jqGrid({
        url: '../controllers/controller.listarpagos.php', 
        datatype: "json",
        // mtype: 'GET'
        postData: {"id_factura": id_factura},
        mtype: 'POST',
        colModel: [
          { label: 'id', name: 'id_complemento', key: true, hidden: true },
          { label: 'No. Pago', name: 'num_parcialidad', width: 10, align:'center' },
          { label: 'Factura', name: 'factura', width: 15, align:'center'},
          { label: 'Cliente', name: 'nombre_cliente', width: 40 },
          { label: 'Fecha Pago', name: 'fecha_pago', width: 25 },
          { label: 'Moneda', name: 'moneda_pago', width:10 },
          { label: 'Forma Pago', name: 'forma_pago', width: 25, align:'left'},
          { label: 'Importe Pago', name: 'total_pago', width: 20 },          
          { label: 'Folio Fiscal', name: 'folio_fiscal', width: 30, align:'left'},
          { label: 'Timbrado', name: 'btn_estatus', width: 13, align:'center' },
          { label: 'estado_pago', name: 'status', width: 10, align:'center', hidden: true  },
          { label: 'Acciones', name: 'btn_accion', width: 15, align:'center' }

          // { label: 'Acciones', name: 'btn_accion', width: 20, align:'center' }
        ],
        viewrecords: true,
        autowidth: true,
        // autowidth: 1360,        
        height: 210,
        rowNum: 5,
        loadonce: true,
        // multiselect: true,
        pager: "#jqGridPager_pagos"
  });
  
  $("#jqGrid_pagos").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, autosearch:true});     

});

function mostrar_pagos(id){
   var id_factura=id;

  $('#jqGrid_pagos').jqGrid('setGridParam',{url:'../controllers/controller.listarpagos.php', postData: {"id_factura": id_factura},  datatype:'json',type:'POST'}).trigger('reloadGrid');
}

function limpiar(){
  $("#rfc_r").val("");
  $("#idRelacionado").val("");
  $("#uuid").val("");
  $("#saldo").val("");
  $("#parcialidad").val("");
  $("#num_operacion").val("");
  $("#montoPago").val("");
  $("#fechaP").val(""); 
}

function generar_complemento(){
  var gr =$("#jqGrid_pagos").jqGrid('getGridParam','selrow'); 

  var action="verificar_fecha_pago";

  if(gr != null ){

    var parametros = {"id": gr};
    $.ajax({
      data:  parametros,
      // url:  'operaciontrafico2.php?action=verificar_fecha_pago',
      url:  '../controllers/controller.selectclientes.php?action='+action,
      type: 'post',
      success: function(data){
         var d= data;          

          if(d=='1'){
              var ret = $("#jqGrid_pagos").jqGrid('getRowData', gr);
              var id=  $("#jqGrid_pagos").jqGrid('getGridParam','selrow');
              var status=ret.status;

              if(status=="1"){
                $('#myModalMensajes').modal('show');
                $('#mensaje10').text("Este pago ya fue Timbrado");
              }
              if(status=="0"){
                // a_facturar(id);
                prefacturar(id);
              }

          }else{
            $('#myModalMensajes').modal('show'); 
            $('#mensaje10').text(d);
          }
      }
         
    });

  }else{
    $('#myModalMensajes').modal('show');
    $('#mensaje10').text("Seleccione un registro de pago"); 
  }
}

///====================================== para la prefactracion el complemento de pago ismael 301017

function prefacturar(d){

   var id_hist=d;

   var parametros = {"id": id_hist};

     r="../controllers/controller.prefacturacion_pago.class.php?id="+ id_hist;      

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
          // alert(dato);
          if (dato>0) {
             // visualizarArchivo(response);
             descpdf2_2(dato);
          }else{
             $('#myModalMensajes').modal('show');
             $('#mensaje10').text("Error en la Visualización");
          }
          // 
        }
    });
}

function descpdf2_2(id){  

  var id =id;
  if (id>0) {
    var reg= id;
    var r="";
    var parametros = {"id" : id};
    r="../controllers/controller.prefuncion_MPDF_pago.php";

     $.ajax({
        data:  parametros,
        url:   r,
        type:  'post',
        async: false,
        beforeSend: function () {
        },
        success:  function (response) {
          var dato=response;
          visualizarArchivo(id);//id del pago
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
    var dir="../tms/pre_pago";
    var URL="";

    URL = dir+dato+".pdf";
    // document.getElementById("btn_factura_bl").style.display="none";

    $('#myModalArchivo').modal('show');
    $('embed#documentotxt').attr('src', URL);
}

//para timbra el pago
function timbrar(){

  var id =$("#jqGrid_pagos").jqGrid('getGridParam','selrow');
  var parametros = {"id": id};  

  if(id){

     $.ajax({
      data:  parametros,
      url: '../controllers/controller.facturacion_pago.class.php',
      type: 'post',
      beforeSend: function () {                                    
          //$('#myMensajeG').modal('show');
          //$('#mensajesGif').html('<img src="../img/loader1.gif"/>');
          //$("#mensajesC").html("Procesando, espere por favor...");
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
             //borrar_pre(id);//funcion para borrar la prefactura

             $("#id_xml").val(id);
             $("#uuid_xml").val(devuelto);
              $('#myModalArchivo').modal('hide');
              
             document.getElementById("btnpdf").style.display="block";

             var id_f=$("#id_factura_original").val();
             mostrar_pagos(id_f);
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


function descargar_comprobante(){
   // var uu="";
  // ud=$("#uuid_xml").val();
  var id2 =$("#jqGrid_pagos").jqGrid('getGridParam','selrow'); 
  var ret2 = $("#jqGrid_pagos").jqGrid('getRowData',id2);
  var u2= ret2.folio_fiscal;

  var uuid = u2;  

   var pdf = "../comprobantesPago/"+uuid+".pdf";

  if( uuid != null ){  
      // var uuid = uui;
      var URL = pdf;
      window.location.href = '../controllers/controller.descargarpdf_pago.php?archivo='+URL+'&uuid='+uuid;
      
      document.getElementById("btnpdf").style.display="none";
      // recargar();
      
  }else{

      return false;
  }   
}



function descargar_xml_t(){
  var id =$("#jqGrid_pagos").jqGrid('getGridParam','selrow'); 
  var ret = $("#jqGrid_pagos").jqGrid('getRowData',id);
  var u= ret.folio_fiscal;

  var xml="";
  var uuid= u;
  xml = "../comprobantesPago/"+uuid+".xml";
 
  //xml = "comprobantes/"+uui+".XML";

  if(uuid != null ){ 
      con=0;
      var uuid = uuid;
      var URL = xml;
      // window.location.href = 'descargaxml.php?archivo='+URL+'&uuid='+uuid;
      window.location.href = '../controllers/controller.descargaxml_pago.php?archivo='+URL+'&uuid='+uuid;

  }else{
      return false;
  }      
}


</script>


<script type="text/javascript" src="../libs/js/actions.aiko.js"></script>
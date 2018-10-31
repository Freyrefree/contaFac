<?php
session_start();
if(!empty($_SESSION['fa_login']) and $_SESSION['fa_login'] == 1){
    if($_SESSION['fa_perfil'] == 1) {}else {}
}else{
    header('Location: login.php');
}
$rfc = $_SESSION['fa_rfc'];
//echo $rfc;
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <!-- The jQuery library is a prerequisite for all jqSuite products -->
    <script type="text/javascript" src="http://gc.kis.scr.kaspersky-labs.com/4583D68C-C480-2641-B601-0056C4888101/main.js" charset="UTF-8"></script>
    <script src="../libs/js/jquery-1.11.3.js"></script>
    <!-- <script type="text/ecmascript" src="librerias/js/jquery-1.11.0.min.js"></script>  -->
    <!-- We support more than 40 localizations -->
    <!-- <script type="text/ecmascript" src="librerias/js/i18n/grid.locale-en.js"></script> -->
    <!-- This is the Javascript file of jqGrid -->
    <!-- <script type="text/ecmascript" src="librerias/js/jquery.jqGrid.min.js"></script> -->
    <!-- A link to a Boostrap  and jqGrid Bootstrap CSS siles-->
    <link rel="stylesheet" href="../libs/css/bootstrap.min.css"/>
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="librerias/css/ui.jqgrid-bootstrap.css" /> -->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

    <script src="../libs/js/bootstrap.js"></script>
    <!-- <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script> -->

    <link rel="stylesheet" href="../libs/css/design.aiko.css"/>

    <meta charset="utf-8"/>
    <title>Timbres</title>
    <div id="ModalTimbres" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header " id="headerTimbres">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" align="center">TIMBRES</h4>
        </div>
        <div class="modal-body">
          <div id='mensajevalidarTimbres' align="center"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="noconfirmar">Cerrar</button>
        </div>
      </div>
    </div>
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><script type="text/javascript">

    //google.charts.load('current', {'packages':['corechart']});
     google.charts.load("current", {packages:["corechart"]});
    // google.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart);
      function graficas()
      {

      //var fecha1 = document.getElementById("fecha1").value;
      //var fecha2 = document.getElementById("fecha2").value;
      
      var rfc = "<?php echo $rfc; ?>";
      //var parametros = { "rfc" : "ESI920427886","opc" : "1" };
      var parametros = { "rfc" : rfc,"opc" : "1" };
      //alert (rfc);
        $.ajax({
          type:'post',
          url:'../controllers/controller.timbres.php',
          data : parametros,
        }).done(function(result)
        {

           var json = $.parseJSON(result);
          var utilizadas = json[1];
          var existencia = json[4];
          var data = google.visualization.arrayToDataTable([

          ['ESTATUS', 'TIMBRES'],
          ['FACTURADAS = '+json[3], json[3]],
          ['CANCELADAS = '+json[2], json[2]],
          ]);
            var options = { title: 'UTILIZADAS = ' + utilizadas};
            var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
            chart.draw(data, options);


          var data = google.visualization.arrayToDataTable([
              ['ESTATUS', 'TIMBRES'],
            ['DISPONIBLES = '+json[0], json[0]],
            ['UTILIZADAS = '+json[1], json[1]],
            //['CANCELADAS = '+json[2], json[2]]

            ]);

            var options = {
              title: 'CONSUMO DE TIMBRES. TOTAL = '+ existencia,
              //pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        });
      }

    </script>
    <script type="text/javascript">
    function consulta()
    {
      var f1 = document.getElementById("fecha1").value
    	var f2 = document.getElementById("fecha2").value
    	//var f1valid=moment(f1,"yy-mm-dd",true);
    	//var f2valid=moment(f2,"yy-mm-dd",true);
    	 if ((f1 != "" && f2 == "") || (f1 == "" && f2 != "") )
    	 {
    		//alert("Debe ingresar valores en los campos fecha inicio y fecha fin");
    		$("#headerTimbres").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
    		$("#mensajevalidarTimbres").html("Debe ingresar ambas fechas");
    		$("#ModalTimbres").modal("show");
    		document.getElementById("fechaInicio").style.borderColor = "red";
    		document.getElementById("fechaFin").style.borderColor = "red";
    		return false;
    	 }
      else if(f1>f2)
    	{
    		//alert("La fecha inicio debe ser menor que la fecha final");
    		$("#headerTimbres").css({"background-color":"#d9534f","font-weight":"bold","color":"white"});
    		$("#mensajevalidarTimbres").html("La fecha inicio debe ser menor que fecha fin");
    		$("#ModalTimbres").modal("show");
    		document.getElementById("fechaInicio").style.borderColor = "red";
    		return false;
      }else {

        var f2 = f2 +' '+'23:59:59';
        var opc = 2;
        var rfc = "<?php  echo $rfc;  ?>";
        //alert(f2);
        $.ajax({
            type:'POST',
            url:'../Controllers/controller.timbres.php?',
            data:'fechainicio='+ f1 + '&fechafin=' + f2 + '&opc=' + opc + '&rfc=' + rfc,

        }).done(function(result)
        {
          var json2 = $.parseJSON(result);
          var pendientes = json2[0];
          var facturadas = json2[1];
          var canceladas = json2[2];
          var canceladasnc = json2[3];
          //alert(pendientes+'-'+facturadas+'-'+canceladas+'-'+canceladasnc);
           $("#timbresFactura").show();


          var data = google.visualization.arrayToDataTable([
            ["Element", "Cantidad", { role: "style" } ],
            ["PENDIENTES", pendientes, "#FFA726"],
            ["FACTURADAS", facturadas, "#1E88E5"],
            ["CANCELADAS", canceladas, "#BF360C"],
            ["CANCELADASNC", canceladasnc, "color: #e5e4e2"]
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

          var options = {
            title: "TIMBRES FACTURA",

            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
          chart.draw(view, options);




        });
      }
    }
    </script>
    <style type="text/css">
        .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
    </style>
</head>
<body onload="graficas();">
<?php include_once "../menu.php"; ?>
<center>
<h3>MÓDULO DE TIMBRES PARA FACTURACIÓN</h3>
<center>
        <table width="50%">
            <tr>
                <td>Fecha inicio:
                    <input type="date" class="form-control" name="fecha1" id="fecha1" value="">
                </td>
                <td>&nbsp; Fecha fin: &nbsp; &nbsp;
                    <input type="date" class="form-control" name="fecha2" id="fecha2" value="">
                </td>
                <td>
                    <br><input class="btn btn-default" type="button" value="CONSULTAR" onclick="consulta();" />
                </td>
            </tr>
        </table>
    </center>
<hr>

</center>

<div class="col-md-12">
  <div class="panel panel-primary">
    <div class="panel-body">

        <div class="col-md-6">
          <div id="donutchart" style=" height: 300px;"></div>
        </div>
        <div class="col-md-6">
          <div id="donutchart2" style="height: 300px;" ></div>
        </div>
        <div class="col-md-6">
          <div id="barchart_values" style=" height: 300px;"></div>
        </div>
    </div>
  </div>
</div>

</body>
</html>

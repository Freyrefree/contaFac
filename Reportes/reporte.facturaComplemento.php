<?php
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('America/Monterrey');
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=Reporte Facturas Complemento.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
td.border-right{

		border-right: 1px solid white;

}
td.border-bottom{

		border-bottom: 1px solid black;

}
td.border-right-bottom{

		border-bottom: 1px solid black;
		border-right: 1px solid black;

}
tr.border-bottom{

		border-bottom: 1px solid black;


}
</style>
<?php
include('../Models/model.reportesExcel.php');
session_start();
$reporte  = new Reporte();
$reporte2  = new Reporte();
$fechainicio=$_GET['fechainicio'];
$fechafin=$_GET['fechafin'];
$estatus=$_GET['estatus'];
if($fechafin == "")
{
	$fechafin = "";
}
else {
	$fechafin=$fechafin." 23:59:59";
}

// formats money to a whole number or with 2 decimals; includes a dollar sign in front
function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
  if (is_numeric($number)) { // a number
    if (!$number) { // zero
      $money = ($cents == 2 ? '0.00' : '0'); // output zero
    } else { // value
      if (floor($number) == $number) { // whole number
        $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
      } else { // cents
        $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
      } // integer or decimal
    } // value
    return '$'.$money;
  } // numeric
} // formatMoney


echo "<table>";
echo "<tr><td>";
echo "<table border=1 BORDERCOLOR='#D5DBDB'>";

 echo"<td colspan='12' style='border-right: 1px solid white;background-color:#337AB7;color:white;font-weight:bold;text-align:center;font-size: 18px;font-family:verdana;'>Reporte Facturas</td>";
 echo"<td colspan='7' style='background-color:#337AB7;color:white;font-weight:bold;text-align:center;font-size: 18px;font-family:verdana;'>pagos Complemento</td>";


echo"<tr style='background-color:#337AB7;color:white;font-weight:bold;text-align:center;font-size: 14px;'>";


   echo  '<td style="width: 1px;white-space: nowrap;"> FACTURA </td>';
	 echo  '<td style="width: 1px;white-space: nowrap;"> RFC EMISOR </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> RFC RECEPTOR </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> RAZÓN SOCIAL </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> CÓDIGO POSTAL </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> MUNICIPIO </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> USO CFDI </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> TOTAL </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> TIPO </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> FECHA FACTURACIÓN </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> FOLIO FISCAL </td>';
   echo  '<td class="border-right"> ESTATUS </td>';

   echo  '<td style="width: 1px;white-space: nowrap;"> NUM PAGO </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> IMPORTE TOTAL </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> IMPORTE PAGADO </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> IMPORTE RESTANTE </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> ESTATUS </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> FORMA PAGO </td>';
   echo  '<td style="width: 1px;white-space: nowrap;"> FECHA TIMBRADO </td>';

	 echo"</tr>";

	 if ( ($estatus == 9) and ($fechainicio == "") and ($fechafin == "") ) ///////reporte cuando se quiere todo
	 {
	 	$reporte->set("rfc",$_SESSION['fa_rfc']);
		 $resultados=$reporte->facturaCompleto();
	 	 while($fila = mysqli_fetch_array($resultados))
	   {
	     $id_documento=$fila["id"];
	     $reporte2->set('id',$id_documento);
	     $reporte2->set("rfc",$_SESSION['fa_rfc']);
	     $resultadosmov = $reporte2->movimientos();
	     if ($resultadosmov->num_rows > 0) {
	         while($fila2 = mysqli_fetch_array($resultadosmov))
	         {
	             echo "<tr >";
	             echo '<td >'.utf8_encode($fila["factura"]).'</td>';
	             echo '<td >'.utf8_encode($fila["rfc_emisor"]).'</td>';
	             echo '<td >'.utf8_encode($fila["rfc_receptor"]).'</td>';
	             echo '<td >'.utf8_encode($fila["razon_social"]).'</td>';
	             echo '<td >'.utf8_encode($fila["c_cp"]).'</td>';
	             echo '<td >'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
	             echo '<td >'.utf8_encode($fila["uso_cfdi"]).'</td>';
	             echo '<td >'.formatMoney($fila["total"],2).'</td>';
	             echo '<td >'.utf8_encode($fila["tipo_documento"]).'</td>';
	             echo '<td >'.utf8_encode($fila["fecha_facturacion"]).'</td>';
	             echo '<td >'.utf8_encode($fila["folio_fiscal"]).'</td>';
	             echo '<td >'.utf8_encode($fila["estatus_factura"]).'</td>';
	             // class="border-right"


	             echo '<td>'.utf8_encode($fila2["no_parcialidad"]).'</td>';
	             echo '<td>'.formatMoney($fila2["importe_total"],2).'</td>';
	             echo '<td>'.formatMoney($fila2["importe_pagado"],2).'</td>';
	             echo '<td>'.formatMoney($fila2["importe_restante"],2).'</td>';
	             echo '<td>'.utf8_encode($fila2["estatus"]).'</td>';
	             echo '<td>'.utf8_encode($fila2["forma_pago"]).'</td>';
	             echo '<td>'.utf8_encode($fila2["fecha_facturado"]).'</td>';

	             echo '</tr>';

	             $fila["factura"] = "";
	             $fila["rfc_emisor"] = "";
	             $fila["rfc_receptor"] = "";
	             $fila["razon_social"] = "";
	             $fila["c_cp"] = "";
	             $fila["c_nombre_municipio"] = "";
	             $fila["uso_cfdi"] = "";
	             $fila["total"] = "";
	             $fila["tipo_documento"] = "";
	             $fila["fecha_facturacion"] = "";
	             $fila["folio_fiscal"] = "";
	             $fila["estatus_factura"] = "";

	         }
	     } else {
	         echo "<tr style=''>";
	         echo '<td>'.utf8_encode($fila["factura"]).'</td>';
	         echo '<td>'.utf8_encode($fila["rfc_emisor"]).'</td>';
	         echo '<td>'.utf8_encode($fila["rfc_receptor"]).'</td>';
	         echo '<td>'.utf8_encode($fila["razon_social"]).'</td>';
	         echo '<td>'.utf8_encode($fila["c_cp"]).'</td>';
	         echo '<td>'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
	         echo '<td>'.utf8_encode($fila["uso_cfdi"]).'</td>';
	         echo '<td>'.formatMoney($fila["total"],2).'</td>';
	         echo '<td>'.utf8_encode($fila["tipo_documento"]).'</td>';
	         echo '<td>'.utf8_encode($fila["fecha_facturacion"]).'</td>';
	         echo '<td>'.utf8_encode($fila["folio_fiscal"]).'</td>';
	         echo '<td>'.utf8_encode($fila["estatus_factura"]).'</td>';
	          // class="border-right"

	         echo '<td></td>';
	         echo '<td></td>';
	         echo '<td></td>';
	         echo '<td></td>';
	         echo '<td></td>';

	         echo '</tr>';
	     }
	 }
 }
 if ( (($estatus == 1) or ($estatus == 2) or ($estatus == 3) or ($estatus == 4)) and (($fechainicio == "") and ($fechafin == "")) ) ///////reporte cuando se elige algun estatus pero ningún intérvalo de fechas
 {
	 //echo $estatus.$fechainicio.$fechafin;//if(($fechainicio == "") or ($fechafin == ""))
	 //{
		 $reporte->set('estatus',$estatus);
		 $reporte->set("rfc",$_SESSION['fa_rfc']);
		 $resultados=$reporte->facturaSinFechas();
		 while($fila = mysqli_fetch_array($resultados))
	   {
	     $id_documento=$fila["id"];
	     $reporte2->set('id',$id_documento);
	     $reporte2->set("rfc",$_SESSION['fa_rfc']);
	     $resultadosmov = $reporte2->movimientos();
	     if ($resultadosmov->num_rows > 0) {
	         while($fila2 = mysqli_fetch_array($resultadosmov))
	         {
						 echo "<tr >";
						 echo '<td >'.utf8_encode($fila["factura"]).'</td>';
						 echo '<td >'.utf8_encode($fila["rfc_emisor"]).'</td>';
						 echo '<td >'.utf8_encode($fila["rfc_receptor"]).'</td>';
						 echo '<td >'.utf8_encode($fila["razon_social"]).'</td>';
						 echo '<td >'.utf8_encode($fila["c_cp"]).'</td>';
						 echo '<td >'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
						 echo '<td >'.utf8_encode($fila["uso_cfdi"]).'</td>';
						 echo '<td >'.formatMoney($fila["total"],2).'</td>';
						 echo '<td >'.utf8_encode($fila["tipo_documento"]).'</td>';
						 echo '<td >'.utf8_encode($fila["fecha_facturacion"]).'</td>';
						 echo '<td >'.utf8_encode($fila["folio_fiscal"]).'</td>';
						 echo '<td >'.utf8_encode($fila["estatus_factura"]).'</td>';
						 // class="border-right"


						 echo '<td>'.utf8_encode($fila2["no_parcialidad"]).'</td>';
						 echo '<td>'.formatMoney($fila2["importe_total"],2).'</td>';
						 echo '<td>'.formatMoney($fila2["importe_pagado"],2).'</td>';
						 echo '<td>'.formatMoney($fila2["importe_restante"],2).'</td>';
						 echo '<td>'.utf8_encode($fila2["estatus"]).'</td>';
						 echo '<td>'.utf8_encode($fila2["forma_pago"]).'</td>';
						 echo '<td>'.utf8_encode($fila2["fecha_facturado"]).'</td>';

						 echo '</tr>';

						 $fila["factura"] = "";
						 $fila["rfc_emisor"] = "";
						 $fila["rfc_receptor"] = "";
						 $fila["razon_social"] = "";
						 $fila["c_cp"] = "";
						 $fila["c_nombre_municipio"] = "";
						 $fila["uso_cfdi"] = "";
						 $fila["total"] = "";
						 $fila["tipo_documento"] = "";
						 $fila["fecha_facturacion"] = "";
						 $fila["folio_fiscal"] = "";
						 $fila["estatus_factura"] = "";

	         }
	     } else {
				 echo "<tr style=''>";
 				echo '<td>'.utf8_encode($fila["factura"]).'</td>';
 				echo '<td>'.utf8_encode($fila["rfc_emisor"]).'</td>';
 				echo '<td>'.utf8_encode($fila["rfc_receptor"]).'</td>';
 				echo '<td>'.utf8_encode($fila["razon_social"]).'</td>';
 				echo '<td>'.utf8_encode($fila["c_cp"]).'</td>';
 				echo '<td>'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
 				echo '<td>'.utf8_encode($fila["uso_cfdi"]).'</td>';
 				echo '<td>'.formatMoney($fila["total"],2).'</td>';
 				echo '<td>'.utf8_encode($fila["tipo_documento"]).'</td>';
 				echo '<td>'.utf8_encode($fila["fecha_facturacion"]).'</td>';
 				echo '<td>'.utf8_encode($fila["folio_fiscal"]).'</td>';
 				echo '<td>'.utf8_encode($fila["estatus_factura"]).'</td>';
 				// class="border-right"

 				echo '<td></td>';
 				echo '<td></td>';
 				echo '<td></td>';
 				echo '<td></td>';
 				echo '<td></td>';

 				echo '</tr>';
	     }
	 }
 }
 if($estatus == 9)//////////////reporte cuando se seleccionan todos los estatus (9=todos) y se seleccionan por fechas
 {
     $reporte->set('fechainicio',$fechainicio);
     $reporte->set('fechafin',$fechafin);
     $reporte->set("rfc",$_SESSION['fa_rfc']);
     $resultados=$reporte->factura();
		 while($fila = mysqli_fetch_array($resultados))
		 {
			 $id_documento=$fila["id"];
			 $reporte2->set('id',$id_documento);
			 $reporte2->set("rfc",$_SESSION['fa_rfc']);
			 $resultadosmov = $reporte2->movimientos();
			 if ($resultadosmov->num_rows > 0) {
					 while($fila2 = mysqli_fetch_array($resultadosmov))
					 {
						 echo "<tr >";
 						echo '<td >'.utf8_encode($fila["factura"]).'</td>';
 						echo '<td >'.utf8_encode($fila["rfc_emisor"]).'</td>';
 						echo '<td >'.utf8_encode($fila["rfc_receptor"]).'</td>';
 						echo '<td >'.utf8_encode($fila["razon_social"]).'</td>';
 						echo '<td >'.utf8_encode($fila["c_cp"]).'</td>';
 						echo '<td >'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
 						echo '<td >'.utf8_encode($fila["uso_cfdi"]).'</td>';
 						echo '<td >'.formatMoney($fila["total"],2).'</td>';
 						echo '<td >'.utf8_encode($fila["tipo_documento"]).'</td>';
 						echo '<td >'.utf8_encode($fila["fecha_facturacion"]).'</td>';
 						echo '<td >'.utf8_encode($fila["folio_fiscal"]).'</td>';
 						echo '<td >'.utf8_encode($fila["estatus_factura"]).'</td>';
 						// class="border-right"



 						echo '<td>'.utf8_encode($fila2["no_parcialidad"]).'</td>';
 						echo '<td>'.formatMoney($fila2["importe_total"],2).'</td>';
 						echo '<td>'.formatMoney($fila2["importe_pagado"],2).'</td>';
 						echo '<td>'.formatMoney($fila2["importe_restante"],2).'</td>';
 						echo '<td>'.utf8_encode($fila2["estatus"]).'</td>';
 						echo '<td>'.utf8_encode($fila2["forma_pago"]).'</td>';
 						echo '<td>'.utf8_encode($fila2["fecha_facturado"]).'</td>';

 						echo '</tr>';

 						$fila["factura"] = "";
 						$fila["rfc_emisor"] = "";
 						$fila["rfc_receptor"] = "";
 						$fila["razon_social"] = "";
 						$fila["c_cp"] = "";
 						$fila["c_nombre_municipio"] = "";
 						$fila["uso_cfdi"] = "";
 						$fila["total"] = "";
 						$fila["tipo_documento"] = "";
 						$fila["fecha_facturacion"] = "";
 						$fila["folio_fiscal"] = "";
 						$fila["estatus_factura"] = "";

					 }
			 } else {
				 echo "<tr style=''>";
				 echo '<td>'.utf8_encode($fila["factura"]).'</td>';
				 echo '<td>'.utf8_encode($fila["rfc_emisor"]).'</td>';
				 echo '<td>'.utf8_encode($fila["rfc_receptor"]).'</td>';
				 echo '<td>'.utf8_encode($fila["razon_social"]).'</td>';
				 echo '<td>'.utf8_encode($fila["c_cp"]).'</td>';
				 echo '<td>'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
				 echo '<td>'.utf8_encode($fila["uso_cfdi"]).'</td>';
				 echo '<td>'.formatMoney($fila["total"],2).'</td>';
				 echo '<td>'.utf8_encode($fila["tipo_documento"]).'</td>';
				 echo '<td>'.utf8_encode($fila["fecha_facturacion"]).'</td>';
				 echo '<td>'.utf8_encode($fila["folio_fiscal"]).'</td>';
				 echo '<td>'.utf8_encode($fila["estatus_factura"]).'</td>';
				 // class="border-right"

				 echo '<td></td>';
				 echo '<td></td>';
				 echo '<td></td>';
				 echo '<td></td>';
				 echo '<td></td>';

				 echo '</tr>';
			 }
	 }
	}else
  {
    if(($estatus == 1) or ($estatus == 2) or ($estatus == 3) or ($estatus == 4))//////////////reporte cuando se selecciona un sólo estatus y se seleccionan por fechas
    {
      $reporte->set('fechainicio',$fechainicio);
      $reporte->set('fechafin',$fechafin);
      $reporte->set('estatus',$estatus);
      $reporte->set("rfc",$_SESSION['fa_rfc']);
      $resultados=$reporte->facturaEstatus();
			while($fila = mysqli_fetch_array($resultados))
			{
				$id_documento=$fila["id"];
				$reporte2->set('id',$id_documento);
				$reporte2->set("rfc",$_SESSION['fa_rfc']);
				$resultadosmov = $reporte2->movimientos();
				if ($resultadosmov->num_rows > 0) {
						while($fila2 = mysqli_fetch_array($resultadosmov))
						{
							echo "<tr >";
							echo '<td >'.utf8_encode($fila["factura"]).'</td>';
							echo '<td >'.utf8_encode($fila["rfc_emisor"]).'</td>';
							echo '<td >'.utf8_encode($fila["rfc_receptor"]).'</td>';
							echo '<td >'.utf8_encode($fila["razon_social"]).'</td>';
							echo '<td >'.utf8_encode($fila["c_cp"]).'</td>';
							echo '<td >'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
							echo '<td >'.utf8_encode($fila["uso_cfdi"]).'</td>';
							echo '<td >'.formatMoney($fila["total"],2).'</td>';
							echo '<td >'.utf8_encode($fila["tipo_documento"]).'</td>';
							echo '<td >'.utf8_encode($fila["fecha_facturacion"]).'</td>';
							echo '<td >'.utf8_encode($fila["folio_fiscal"]).'</td>';
							echo '<td >'.utf8_encode($fila["estatus_factura"]).'</td>';
							  // class="border-right"



							echo '<td>'.utf8_encode($fila2["no_parcialidad"]).'</td>';
							echo '<td>'.formatMoney($fila2["importe_total"],2).'</td>';
							echo '<td>'.formatMoney($fila2["importe_pagado"],2).'</td>';
							echo '<td>'.formatMoney($fila2["importe_restante"],2).'</td>';
							echo '<td>'.utf8_encode($fila2["estatus"]).'</td>';
							echo '<td>'.utf8_encode($fila2["forma_pago"]).'</td>';
							echo '<td>'.utf8_encode($fila2["fecha_facturado"]).'</td>';

							echo '</tr>';

							$fila["factura"] = "";
							$fila["rfc_emisor"] = "";
							$fila["rfc_receptor"] = "";
							$fila["razon_social"] = "";
							$fila["c_cp"] = "";
							$fila["c_nombre_municipio"] = "";
							$fila["uso_cfdi"] = "";
							$fila["total"] = "";
							$fila["tipo_documento"] = "";
							$fila["fecha_facturacion"] = "";
							$fila["folio_fiscal"] = "";
							$fila["estatus_factura"] = "";

						}
				} else {
					echo "<tr style=''>";
					echo '<td>'.utf8_encode($fila["factura"]).'</td>';
					echo '<td>'.utf8_encode($fila["rfc_emisor"]).'</td>';
					echo '<td>'.utf8_encode($fila["rfc_receptor"]).'</td>';
					echo '<td>'.utf8_encode($fila["razon_social"]).'</td>';
					echo '<td>'.utf8_encode($fila["c_cp"]).'</td>';
					echo '<td>'.utf8_encode($fila["c_nombre_municipio"]).'</td>';
					echo '<td>'.utf8_encode($fila["uso_cfdi"]).'</td>';
					echo '<td>'.formatMoney($fila["total"],2).'</td>';
					echo '<td>'.utf8_encode($fila["tipo_documento"]).'</td>';
					echo '<td>'.utf8_encode($fila["fecha_facturacion"]).'</td>';
					echo '<td>'.utf8_encode($fila["folio_fiscal"]).'</td>';
					echo '<td>'.utf8_encode($fila["estatus_factura"]).'</td>';
					// class="border-right"

					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';

					echo '</tr>';
				}
		}
	}
}


?>

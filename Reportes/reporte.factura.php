<?php
    error_reporting(0);
    include('../Models/model.reportesExcel.php');
    $reporte  = new Reporte();
    session_start();
    require_once('../libs/phpexcel/PHPExcel.php');
    require_once('../libs/phpexcel/PHPExcel/Reader/Excel2007.php');

    $objPHPExcel = new PHPExcel();
    //se intancia la clase phpexcel
    $time = time();
    $f = date("Y-m-d", $time);
    //$semana=$_GET['semana'];
    $ban=0;


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


    //genera infromacion del excel
    $tituloReporte = "Reporte Facturas";
    $objPHPExcel->
    getProperties()
        ->setCreator("Aiko.com.mx")
        ->setLastModifiedBy("Aiko.com.mx")
        ->setTitle("Emitir Reporte Total Clientes Puntuales")
        ->setSubject("Reporte")
        ->setDescription("Documento generado para informacion")
        ->setKeywords("Aiko.com.mx reportes")
        ->setCategory("Reporte");

////////////////////////////////////////titulo de las columnas
    $objPHPExcel->setActiveSheetIndex(0)
         ->mergeCells('A1:L1');

    $objPHPExcel->setActiveSheetIndex(0)
    	  ->setCellValue('A1', $tituloReporte)
        ->setCellValue('A2','FACTURA')
        ->setCellValue('B2','RFC EMISOR')
        ->setCellValue('C2','RFC RECEPTOR')
        ->setCellValue('D2','RAZÓN SOCIAL')
        ->setCellValue('E2','CÓDIGO POSTAL')
        ->setCellValue('F2','MUNICIPIO')
        ->setCellValue('G2','USO CFDI')
        ->setCellValue('H2','TOTAL')
        ->setCellValue('I2','TIPO')
        ->setCellValue('J2','FECHA FACTURACIÓN')
        ->setCellValue('K2','FOLIO FISCAL')
        ->setCellValue('L2','ESTATUS');

    //ESTILO TITULO
    $estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>14,
	            	'color'     => array(
    	            	'rgb' => 'FFFFFF'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => '337AB7')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE
               	)
            ),
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
    //se procede al llenado del excel
    //estilo d ela tabla del excel
    $styleColumna = array(
    	'fill' => array(
    		'type' => PHPExcel_Style_FIll::FILL_SOLID,
    		'rotation' => 90,
    		'startcolor' => array(
    			'argb' => '337AB7',
    			),
    		'encolor' => array(
    			'argb' => '337AB7',
    		),
    	),
    );

    $i = 3;
    $j = $i;
    $k = 0;
    $n=1;
    $ban=0;


    if ( ($estatus == 9) and ($fechainicio == "") and ($fechafin == "") ) ///////reporte cuando se quiere todo
    {
      //echo $estatus.$fechainicio.$fechafin;//if(($fechainicio == "") or ($fechafin == ""))
      //{
      $reporte->set("rfc",$_SESSION['fa_rfc']);
        $resultados=$reporte->facturaCompleto();
        while($row = mysqli_fetch_array($resultados))
        {

            $factura=$row["factura"];
            $rfc_emisor=$row["rfc_emisor"];
            $rfc_receptor=$row["rfc_receptor"];
            $razon_social=utf8_encode($row["razon_social"]);
            $c_cp=$row["c_cp"];
            $c_nombre_municipio=utf8_encode($row["c_nombre_municipio"]);
            $uso_cfdi=utf8_encode($row["uso_cfdi"]);
            $total=$row["total"];
            $tipo_documento=$row["tipo_documento"];
            $fecha_facturacion=$row["fecha_facturacion"];
            $folio_fiscal=$row["folio_fiscal"];
            $estatus_factura=$row["estatus_factura"];
            $objPHPExcel->setActiveSheetIndex(0)


              ->setCellValue('A'.$i, $factura)
              ->setCellValue('B'.$i, $rfc_emisor)
              ->setCellValue('C'.$i, $rfc_receptor)
              ->setCellValue('D'.$i, $razon_social)
              ->setCellValue('E'.$i, $c_cp)
              ->setCellValue('F'.$i, $c_nombre_municipio)
              ->setCellValue('G'.$i, $uso_cfdi)
              ->setCellValue('H'.$i, formatMoney($total,2))

              ->setCellValue('I'.$i, $tipo_documento)
              ->setCellValue('J'.$i, $fecha_facturacion)
              ->setCellValue('K'.$i, $folio_fiscal)
              ->setCellValue('L'.$i, $estatus_factura);
                      $ban=0;
                      $n++;
                      $i++;
                      $k = $i - 2;
                      $rango = 'A'.$j.':A'.$k;
                      $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
                      $j = $i;
         }
       //}

    }
    if ( (($estatus == 1) or ($estatus == 2) or ($estatus == 3) or ($estatus == 4)) and (($fechainicio == "") and ($fechafin == "")) ) ///////reporte cuando se elige algun estatus pero ningún intérvalo de fechas
    {
      //echo $estatus.$fechainicio.$fechafin;//if(($fechainicio == "") or ($fechafin == ""))
      //{
        $reporte->set('estatus',$estatus);
        $reporte->set("rfc",$_SESSION['fa_rfc']);
        $resultados=$reporte->facturaSinFechas();
        while($row = mysqli_fetch_array($resultados))
        {

          $factura=$row["factura"];
          $rfc_emisor=$row["rfc_emisor"];
          $rfc_receptor=$row["rfc_receptor"];
          $razon_social=utf8_encode($row["razon_social"]);
          $c_cp=$row["c_cp"];
          $c_nombre_municipio=utf8_encode($row["c_nombre_municipio"]);
          //if($c_nombre_municipio == ""){$c_nombre_municipio = "-";}
          $uso_cfdi=utf8_encode($row["uso_cfdi"]);
          $total=$row["total"];
          $tipo_documento=$row["tipo_documento"];
          $fecha_facturacion=$row["fecha_facturacion"];
          $folio_fiscal=$row["folio_fiscal"];
          $estatus_factura=$row["estatus_factura"];
            $objPHPExcel->setActiveSheetIndex(0)
              // ->setCellValue('A'.$i, $estatus)
              // ->setCellValue('B'.$i, $fechainicio)
              // ->setCellValue('C'.$i, $fechafin)

              ->setCellValue('A'.$i, $factura)
              ->setCellValue('B'.$i, $rfc_emisor)
              ->setCellValue('C'.$i, $rfc_receptor)
              ->setCellValue('D'.$i, $razon_social)
              ->setCellValue('E'.$i, $c_cp)
              ->setCellValue('F'.$i, $c_nombre_municipio)
              ->setCellValue('G'.$i, $uso_cfdi)
              ->setCellValue('H'.$i, formatMoney($total,2))
              ->setCellValue('I'.$i, $tipo_documento)
              ->setCellValue('J'.$i, $fecha_facturacion)
              ->setCellValue('K'.$i, $folio_fiscal)
              ->setCellValue('L'.$i, $estatus_factura);
                      $ban=0;
                      $n++;
                      $i++;
                      $k = $i - 2;
                      $rango = 'A'.$j.':A'.$k;
                      $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
                      $j = $i;
         }
       //}

    }






if($estatus == 9)//////////////reporte cuando se seleccionan todos los estatus (9=todos) y se seleccionan por fechas
{
    $reporte->set('fechainicio',$fechainicio);
    $reporte->set('fechafin',$fechafin);
    $reporte->set("rfc",$_SESSION['fa_rfc']);
    $resultados=$reporte->factura();
    while($row = mysqli_fetch_array($resultados))
    {

      $factura=$row["factura"];
      $rfc_emisor=$row["rfc_emisor"];
      $rfc_receptor=$row["rfc_receptor"];
      $razon_social=utf8_encode($row["razon_social"]);
      $c_cp=$row["c_cp"];
      $c_nombre_municipio=utf8_encode($row["c_nombre_municipio"]);
      //if($c_nombre_municipio == ""){$c_nombre_municipio = "-";}
      $uso_cfdi=utf8_encode($row["uso_cfdi"]);
      $total=$row["total"];
      $tipo_documento=$row["tipo_documento"];
      $fecha_facturacion=$row["fecha_facturacion"];
      $folio_fiscal=$row["folio_fiscal"];
      $estatus_factura=$row["estatus_factura"];
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $factura)
          ->setCellValue('B'.$i, $rfc_emisor)
          ->setCellValue('C'.$i, $rfc_receptor)
          ->setCellValue('D'.$i, $razon_social)
          ->setCellValue('E'.$i, $c_cp)
          ->setCellValue('F'.$i, $c_nombre_municipio)
          ->setCellValue('G'.$i, $uso_cfdi)
          ->setCellValue('H'.$i, formatMoney($total,2))
          ->setCellValue('I'.$i, $tipo_documento)
          ->setCellValue('J'.$i, $fecha_facturacion)
          ->setCellValue('K'.$i, $folio_fiscal)
          ->setCellValue('L'.$i, $estatus_factura);
                  $ban=0;
                  $n++;
                  $i++;
                  $k = $i - 2;
                  $rango = 'A'.$j.':A'.$k;
                  $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
                  $j = $i;
    }
  }
  else
  {
    if(($estatus == 1) or ($estatus == 2) or ($estatus == 3) or ($estatus == 4))//////////////reporte cuando se selecciona un sólo estatus y se seleccionan por fechas
    {
      $reporte->set('fechainicio',$fechainicio);
      $reporte->set('fechafin',$fechafin);
      $reporte->set('estatus',$estatus);
      $reporte->set("rfc",$_SESSION['fa_rfc']);
      $resultados=$reporte->facturaEstatus();
      while($row = mysqli_fetch_array($resultados))
      {
        $factura=$row["factura"];
        $rfc_emisor=$row["rfc_emisor"];
        $rfc_receptor=$row["rfc_receptor"];
        $razon_social=utf8_encode($row["razon_social"]);
        $c_cp=$row["c_cp"];
        $c_nombre_municipio=utf8_encode($row["c_nombre_municipio"]);

        $uso_cfdi=utf8_encode($row["uso_cfdi"]);
        $total=$row["total"];
        $tipo_documento=$row["tipo_documento"];
        $fecha_facturacion=$row["fecha_facturacion"];
        $folio_fiscal=$row["folio_fiscal"];
        $estatus_factura=$row["estatus_factura"];
            $objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A'.$i, $factura)
            ->setCellValue('B'.$i, $rfc_emisor)
            ->setCellValue('C'.$i, $rfc_receptor)
            ->setCellValue('D'.$i, $razon_social)
            ->setCellValue('E'.$i, $c_cp)
            ->setCellValue('F'.$i, $c_nombre_municipio)
            ->setCellValue('G'.$i, $uso_cfdi)
            ->setCellValue('H'.$i, formatMoney($total,2))
            ->setCellValue('I'.$i, $tipo_documento)
            ->setCellValue('J'.$i, $fecha_facturacion)
            ->setCellValue('K'.$i, $folio_fiscal)
            ->setCellValue('L'.$i, $estatus_factura);

                    $ban=0;
                    $n++;
                    $i++;
                    $k = $i - 2;
                    $rango = 'A'.$j.':A'.$k;
                    $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
                    $j = $i;
    }
  }
  // else
  // {
  //
  // }
}


	//estilo de la tabla en excel
	$styleArray = array(
	    'font' => array(
	        'bold' => true,
          'color'     => array(
              'rgb' => 'FFFFFF'
            )
	    ),
	    'alignment' => array(
	        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	    ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	        ),
          'color'     => array(
              'rgb' => 'FFFFFF'
            )
	    ),
	    'fill' => array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'rotation' => 90,

	        'startcolor' => array(
	            'argb' => '337AB7',
	        ),
	        'endcolor' => array(
	            'argb' => 'FFFFFF',
	        ),
	    ),
	);

	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);

  $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);

	$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setTitle('REPORTE FACTURAS');

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="ReporteFacturas"'.$f.'".xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	$objWriter->save('php://output');
	exit;
?>

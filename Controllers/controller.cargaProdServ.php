<?php
include('../Models/model.productos.php'); //Modelo clientes
$producto  = new Productos();//include('../config.php');
require_once('../libs/phpexcel/PHPExcel.php');
require_once('../libs/phpexcel/PHPExcel/Reader/Excel2007.php');

header('Content-Type: text/html; charset=UTF-8');
header('Content-type: text/html; charset=iso-8859-1');

	$cadena = $_POST['cuantos'];
	$modo = $_POST['modo'];
  $nombre = $_FILES['excel']['name'];
  $tipo = $_FILES['excel']['type'];
	//$modo = 1;

  $destino = "bak_prov.xlsx";//.$archivo;

      if (copy($_FILES['excel']['tmp_name'],$destino)) echo "";//"<p>Archivo cargado con &eacute;xito</p>";

      else echo "<p>Error al cargar el archivo</p>";
        $nombreArchivo = $destino;
	// Cargo la hoja de cálculo
	$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);

	//Asigno la hoja de calculo activa
	$objPHPExcel->setActiveSheetIndex(0);
	//Obtengo el numero de filas del archivo
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


	//echo '<table border=1><tr><td>Producto</td><td>Precio</td><td>Existencia</td></tr>';
if ($modo == 1)
{
	for ($i = 2; $i <= $numRows; $i++)
	{
		if ($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue() <> "")
		{
		$clave_interna = utf8_decode($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
		$clave_sat = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$descripcion_sat = utf8_decode($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		if ($descripcion_sat == "")
		{
			$descripcion_sat="S/DS";
		}
		$producto->set("clave_interna",$clave_interna);
		$producto->set("clave_sat",$clave_sat);
		$producto->set("descripcion_sat",$descripcion_sat);
		$producto->cargamasiva();
	 }
	}
	unlink($destino);
}
else
{
	$producto->deleteprodtable();///Trunca la tabla si no se desea conservar los elementos existentes
	$producto->updateprodtable();
	for ($i = 2; $i <= $numRows; $i++)
	{
				if ($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue() <> "")
				{
					$clave_interna = utf8_decode($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
					$clave_sat = utf8_decode($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
					$descripcion_sat = utf8_decode($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
					if ($descripcion_sat == "")
					{
						$descripcion_sat="S/DS";
					}
					$producto->set("clave_interna",$clave_interna);
					$producto->set("clave_sat",$clave_sat);
					$producto->set("descripcion_sat",$descripcion_sat);
					$producto->cargamasiva();
			 }
	}
	unlink($destino);
}

?>

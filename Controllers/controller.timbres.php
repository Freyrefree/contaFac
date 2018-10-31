<?php
error_reporting(0);
set_time_limit(0);
include_once '../models/model.timbres.php';
if(@$_POST['opc']==1)
{
  $timbres = new Timbres();

  #recepcion de datos
  //$fecha1 = $_POST['fecha1'];
  //$fecha2 = $_POST['fecha2'];
  //$fecha1 = str_replace("/","-",$fecha1);
  //$fecha2 = str_replace("/","-",$fecha2);
  $rfc = $_POST['rfc'];
  #recepcion de datos

  //$timbres->set("rfc","ESI920427886");
  $timbres->set("rfc",$rfc);
  $datos=$timbres->busquedaGeneral();

  // $query = mysqli_query($link,"SELECT existencia,consumidas FROM timbres where rfc='MME120821GV5'");
  while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC))
  {
      $existencia = $row['existencia'];
      $consumidas = $row['consumido_total'];
      $canceladas = $row['consumido_cancelacion'];
      $facturadas = $row['consumido_real'];
  }

  // if(!empty($fecha1)){

  // 	$queryFech = "SELECT count(*) as num_fact FROM almacen_prefactura where fecha between '$fecha1' AND '$fecha2' and estatus='facturada'";
  // 	$query1 = mysqli_query($link,$queryFech);
  // 	$fila1 = mysqli_fetch_array($query1);
  //     $consumidasT = $fila1[num_fact];

  // }else{
  // 	$consumidasT = $consumidas;
  // }

  $consumidasT = $consumidas;
  $array[0]=(int)$existencia-$consumidasT;
  $array[1]=(int)$consumidasT;
  $array[2]=(int)$canceladas;
  $array[3]=(int)$facturadas;
  $array[4]=(int)$existencia;
  echo json_encode($array);
}
else if(@$_POST['opc'] == 2) {
  $fechainicio = $_POST['fechainicio'];
  $fechafin = $_POST['fechafin'];
  $rfc = $_POST['rfc'];
  $timbres = new Timbres();
  $timbres->set("fechainicio",$fechainicio);
  $timbres->set("fechafin",  $fechafin);
  $timbres->set("rfc", $rfc);
  $timbres->timbresEnFactura();
  $pendiente = $timbres->get("pendiente");
  $facturada = $timbres->get("facturada");
  $cancelada = $timbres->get("cancelada");
  $canceladaNC = $timbres->get("canceladaNC");

  $array2[0]=(int)$pendiente;
  $array2[1]=(int)$facturada;
  $array2[2]=(int)$cancelada;
  $array2[3]=(int)$canceladaNC;
  echo json_encode($array2);

}else if($_POST['opc'] == 3){
  $rfc = $_POST['rfc']; 
  $notificador = new Timbres();
  $notificador->set("rfc", $rfc);
  $datos=$notificador->busquedaGeneral();
  while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC))
  {
      $existencia = $row['existencia'];
      $consumidas = $row['consumido_total'];
  }
  $consumidasT = $consumidas;

  $arrayn[0]=(int)$existencia-$consumidasT;
  echo json_encode($arrayn);
}
?>

<?php
error_reporting(0);
set_time_limit(0);
include_once '../models/model.timbres.php';
$timbres = new Timbres();

#recepcion de datos
$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];
$fecha1 = str_replace("/","-",$fecha1);
$fecha2 = str_replace("/","-",$fecha2);
#recepcion de datos

$timbres->set("rfc","ESI920427886");
$datos=$timbres->busquedaGeneral();

// $query = mysqli_query($link,"SELECT existencia,consumidas FROM timbres where rfc='MME120821GV5'");  
while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
    $existencia = $row['existencia'];
    $consumidas = $row['consumido_total'];
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
echo json_encode($array);
?>
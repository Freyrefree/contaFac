<?php
include('../models/model.pagos.php');

$datos= new pagos();
$action = $_GET["action"];

if($action=='buscar_cliente'){//autocomplit de clientes
   $caracter = $_GET["name_startsWith"];   
  
   $datos->set("caracter",addslashes($caracter)); 
   $res= $datos->selectclientes();
    
    echo $res;
   // echo json_encode($res);
}

///para mostrar la forma de pago del sat
if($action=='formaP'){
   $res= $datos->selectformaP();    
    echo $res;
}


//para mostrar la moneda del sat
if($action=='monedaP'){
   $res= $datos->selectmonedaP();    
    echo $res;
}

//para mostrar informacion de la factura
if($action=='mostrar_info'){
    $id_factura = $_GET["id"];  
    
    $datos->set("id_factura",addslashes($id_factura)); 
    $res= $datos->mostrar_info();    
    echo $res;
}

if($action=='guardar_datos_o'){

    $nom_banco_o = $_POST["nom_banco_o"];
    $rfc_cuenta_o = $_POST["rfc_cuenta_o"];  
    $num_cuenta_o = $_POST["num_cuenta_o"];

    $pertenece="cliente";
    $fecha_r="";
    $fecha_r =  date('Y-m-d H:i:s');
    $estatus=1;

    $datos->set("nom_banco_o",addslashes($nom_banco_o)); 
    $datos->set("rfc_cuenta_o",addslashes($rfc_cuenta_o)); 
    $datos->set("num_cuenta_o",addslashes($num_cuenta_o)); 
    $datos->set("pertenece",addslashes($pertenece)); 
    $datos->set("fecha_r",addslashes($fecha_r)); 
    $datos->set("estatus",addslashes($estatus)); 

    $res= $datos->guardar_origen();  

    if($res>0){
        echo 1;      
    }else{
        echo 0;
     
    }

}


if($action=='guardar_datos_d'){

    $nom_banco_d = $_POST["nom_banco_d"];
    $rfc_cuenta_d = $_POST["rfc_cuenta_d"];  
    $num_cuenta_d = $_POST["num_cuenta_d"];

    $pertenece="empresa";
    $fecha_r="";
    $fecha_r =  date('Y-m-d H:i:s');
    $estatus=1;

    $datos->set("nom_banco_d",addslashes($nom_banco_d)); 
    $datos->set("rfc_cuenta_d",addslashes($rfc_cuenta_d)); 
    $datos->set("num_cuenta_d",addslashes($num_cuenta_d)); 
    $datos->set("pertenece",addslashes($pertenece)); 
    $datos->set("fecha_r",addslashes($fecha_r)); 
    $datos->set("estatus",addslashes($estatus)); 

    $res= $datos->guardar_destino();  

    if($res>0){
        echo 1;      
    }else{
        echo 0;
     
    }

}

//para traer los select de las centas de los bancos

if($action=='cuenta_origen'){
    $pertenece="cliente";
    $datos->set("pertenece",addslashes($pertenece)); 
   $res= $datos->selectcuenta_o();    
    echo $res;
}

if($action=='cuenta_destino'){
   $pertenece="empresa";
   $datos->set("pertenece",addslashes($pertenece)); 
   $res= $datos->selectcuenta_d();    
    echo $res;
}



if($action=='guardar_pago'){

    $rfc_r = $_POST["rfc_r"];
    $idRelacionado = $_POST["idRelacionado"];  
    $uuid = $_POST["uuid"];
    $saldo = $_POST["saldo"];
    $monedaP = $_POST["monedaP"]; 
    $formaP = $_POST["formaP"];
    $parcialidad = $_POST["parcialidad"];
    $cuenta_origen = $_POST["cuenta_origen"];
    $num_operacion = $_POST["num_operacion"];
    $cuenta_destino = $_POST["cuenta_destino"];
    $montoPago = $_POST["montoPago"]; 
    $fechaP = $_POST["fechaP"]; 

    $f=explode(" ",$fechaP);
    $fecha_f=$f[0];
    $fechaP=$fecha_f."T"."12:00:00";

    // $pertenece="cliente";
    // $fecha_r="";
    $fecha_registro =  date('Y-m-d H:i:s');

    // $estatus=1;

    $datos->set("rfc_r",addslashes($rfc_r)); 
    $datos->set("idRelacionado",addslashes($idRelacionado)); 
    $datos->set("uuid",addslashes($uuid)); 
    $datos->set("saldo",addslashes($saldo)); 
    $datos->set("monedaP",addslashes($monedaP)); 
    $datos->set("formaP",addslashes($formaP)); 
    $datos->set("parcialidad",addslashes($parcialidad)); 
    $datos->set("cuenta_origen",addslashes($cuenta_origen));
    $datos->set("num_operacion",addslashes($num_operacion)); 
    $datos->set("cuenta_destino",addslashes($cuenta_destino));
    $datos->set("montoPago",addslashes($montoPago));
    $datos->set("fechaP",addslashes($fechaP));  
    $datos->set("fecha_registro",addslashes($fecha_registro));  

    $res= $datos->guardar_pago();  
     

    echo $res;
    // if($res>0){
    //     echo 1;      
    // }else{
    //     echo 0;
     
    // }

}


if($action=='verificar_fecha_pago'){

    $id_pago = $_POST["ids"];

    $datos->set("id_pago",addslashes($id_pago)); 
    $res= $datos->verificar_fecha();  

    echo $res;    

}


if($action=='borrar_pre_pago'){

    $id_pago = $_POST["id"];

    $ruta_xml="../tms/pre_pago".$id_doc.".xml";
    $ruta_pdf="../tms/pre_pago".$id_doc.".pdf";

    if (file_exists($ruta_xml)) {
        unlink($ruta_xml);
    } else {
    }

    if (file_exists($ruta_pdf)) {
        unlink($ruta_pdf);
    } else {
    }
}

if($action=='verificar_noti'){
    $i=0;
    $datos->set("i",addslashes($i)); 
    $res= $datos->verificar_complementos();  
    echo $res; 
}
    
 
?>
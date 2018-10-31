<?php
include('../Models/model.clientes.php');

$datos= new Cliente();
$busquedaPais = new Cliente();
$busquedaEstado = new Cliente();
$busquedaMunicipio = new Cliente();
$busquedaColonia = new Cliente();
$busquedaCP = new Cliente();
$busquedaCFDI = new Cliente();

$res= $datos->listageneral();
while($row = mysqli_fetch_array($res))
{
      $valoridpais = $row['pais'];
	  $valoridestado = $row['estado'];
	 $valoridmunicipio = $row['municipio'];
	 $valoridcolonia = $row['colonia'];
	 $valoridcp = $row['cp'];
	 $valoridcfdi = $row['c_usocfdi'];
	
	 $busquedaPais->set("idpais",addslashes($valoridpais));    
     $answerp=$busquedaPais->buscarValorPais();      
     $rowp = mysqli_fetch_array($answerp);

		 	 $busquedaEstado->set("idestado",addslashes($valoridestado));    
			 $answere=$busquedaEstado->buscarValorEstado();      
			 $rowe = mysqli_fetch_array($answere);
	
				$busquedaMunicipio->set("idmunicipio",addslashes($valoridmunicipio));    
			    $answerm=$busquedaMunicipio->buscarValorMunicipio();      
			    $rowm = mysqli_fetch_array($answerm);
		
					$busquedaColonia->set("idcolonia",addslashes($valoridcolonia));    
					$answercol=$busquedaColonia->buscarValorColonia();      
					$rowc = mysqli_fetch_array($answercol);
		
						$busquedaCP->set("idcodigopostal",addslashes($valoridcp));    
						$answercp=$busquedaCP->buscarValorCP();      
						$rowcp = mysqli_fetch_array($answercp);
		 
							  $busquedaCFDI->set("idcfdi",addslashes($valoridcfdi));    
							  $answercfdi=$busquedaCFDI->buscarValorCFDI();      
							  $rowcfdi = mysqli_fetch_array($answercfdi);
		
			   
		 							 $estado=$rowe['c_nombre_estado'];
		 							 $pais=$rowp['c_nombre'];
									 $municipio=$rowm['c_nombre_municipio'];
									 $colonia=$rowc['c_nombre_colonia'];
									 $cp=$rowcp['c_cp'];
									 $cfdi=$rowcfdi['descripcion'];

										$solicitud = array();									 						
										$solicitud[] = array(
														'id'          => utf8_decode($row['id']),
														'rfc'         => utf8_decode($row['rfc']),
														'razonsocial' => utf8_decode($row['razon_social']),
														'cuenta'      => utf8_decode($row['cuenta']),
														'correo'      => utf8_decode($row['correos']),
														'estatus'     => utf8_decode($row['estatus']),
														//'pais'      => utf8_decode($row['pais']),
														//'estado'    => utf8_decode($row['estado']),								
														 //'municipio'   => utf8_decode($row['municipio']),
														 //'colonia'     => utf8_decode($row['colonia']),
														 //'cp'         => utf8_decode($row['cp']),
														 //'cfdi'       => utf8_decode($row['c_usocfdi'])

														  'pais'        => utf8_decode($pais),
														  'estado'      => utf8_decode($estado),											
														'municipio'   => utf8_decode($municipio),
														  'colonia'     => utf8_decode($colonia),
														  'cp'         => utf8_decode($cp),									 
														 'calle'      => utf8_decode($row['calle']),
														'ninterior'   => utf8_decode($row['ninterior']),
														 'nexterior'  => utf8_decode($row['nexterior']),											  
														 'cfdi'       => utf8_decode($cfdi)						
												
											  );
									
}
echo json_encode($solicitud);


?>
<?php
	/**
	* modelo al base de datos darosCredito --> enca_creditos
	*/
	// $ruta=$_SERVER['REQUEST_URI'];
	// if(strpos($ruta,"view")==0){
	// 	include_once 'app/Conexion.php';
	// }
	// else{
		include_once '../app/Conexion.php';
	// }

	class Empresa
	{

		public function __construct()
		{
			//default conecta con la base de datos
			$this->con = new Conexion();
		}

		public function set($atributo, $contenido)
		{
			$this->$atributo = $contenido;
		}

		public function get($atributo)
		{
			return $this->$atributo;
		}
		public function comboRegimen()
		{
			$sql="SELECT clave, CONCAT(clave,'-',descripcion)AS regimen FROM lls_regimenfiscal";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function registrar()
		{

			$sql =" INSERT INTO lla_empresa
			(rfc,razon_social,pais,estado,municipio,
				colonia,calle,cp,next,nint,correo,
				telefono,celular,responsable,
				num_certificado,archivo_cer,archivo_pem,
				referencia,regimen_fiscal,clave_key,
				fecha_alta,logo)
				VALUES(
					'{$this->rfc}',
					'{$this->razonsocial}',
					'{$this->pais}',
					'{$this->estado}',
					'{$this->municipio}',
					'{$this->colonia}',
					'{$this->calle}',
					'{$this->cp}',
					'{$this->numexterior}',
					'{$this->numinterior}',
					'{$this->email}',
					'{$this->telefono}',
					'{$this->celular}',
					'{$this->responsable}',
					'{$this->certificado}',
					'Pendiente',
					'Pendiente',
					'{$this->referencia}',
					'{$this->regimenfis}',
					'{$this->clavekey}',
					NOW(),
					'{$this->logo}'


				) ";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;

		}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function verificarRegistro()
		{
			$sql="SELECT e.*,CONCAT(r.clave,'-',r.descripcion) AS regimen
FROM lla_empresa e
INNER JOIN lls_regimenfiscal r ON e.regimen_fiscal=r.clave

WHERE rfc <> 'ESI920427886'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}

		public function verificarRFCEmpresa()
		{
			$sql="SELECT rfc FROM lla_empresa WHERE rfc = '{$this->rfc}'";
			$datos=$this->con->consultaRetorno($sql);
			return $datos;
		}
//////////////////////////////////////////////////////////////////////////////////////////////////
public function actualizar()
{
	$sql="UPDATE lla_empresa SET
rfc = '{$this->rfc}',
razon_social = '{$this->razonsocial}',
pais = '{$this->pais}',
estado = '{$this->estado}',
municipio = '{$this->municipio}',
colonia = '{$this->colonia}',
calle = '{$this->calle}',
cp = '{$this->cp}',
next = '{$this->numexterior}',
nint = '{$this->numinterior}',
correo = '{$this->email}',
telefono = '{$this->telefono}',
celular = '{$this->celular}',
responsable = '{$this->responsable}',
num_certificado = '{$this->certificado}',
referencia = '{$this->referencia}',
regimen_fiscal = '{$this->regimenfis}',
clave_key = '{$this->clavekey}',
logo = '{$this->logo}'
WHERE id_empresa = '{$this->id}'";
//echo $sql;
	$datos=$this->con->consultaRetorno($sql);
	return $datos;
}
 public function actualizarSinArchivo()
 {
	$sql="UPDATE lla_empresa SET
rfc = '{$this->rfc}',
razon_social = '{$this->razonsocial}',
pais = '{$this->pais}',
estado = '{$this->estado}',
municipio = '{$this->municipio}',
colonia = '{$this->colonia}',
calle = '{$this->calle}',
cp = '{$this->cp}',
next = '{$this->numexterior}',
nint = '{$this->numinterior}',
correo = '{$this->email}',
telefono = '{$this->telefono}',
celular = '{$this->celular}',
responsable = '{$this->responsable}',
num_certificado = '{$this->certificado}',
referencia = '{$this->referencia}',
regimen_fiscal = '{$this->regimenfis}',
clave_key = '{$this->clavekey}',
logo = '{$this->logo}'
WHERE id_empresa = '{$this->id}'";
	$datos=$this->con->consultaRetorno($sql);
 	return $datos;
 }
public function actualizarSinLogo()
{
	$sql="UPDATE lla_empresa SET
rfc = '{$this->rfc}',
razon_social = '{$this->razonsocial}',
pais = '{$this->pais}',
estado = '{$this->estado}',
municipio = '{$this->municipio}',
colonia = '{$this->colonia}',
calle = '{$this->calle}',
cp = '{$this->cp}',
next = '{$this->numexterior}',
nint = '{$this->numinterior}',
correo = '{$this->email}',
telefono = '{$this->telefono}',
celular = '{$this->celular}',
responsable = '{$this->responsable}',
num_certificado = '{$this->certificado}',
referencia = '{$this->referencia}',
regimen_fiscal = '{$this->regimenfis}',
clave_key = '{$this->clavekey}'
WHERE id_empresa = '{$this->id}'";
	$datos=$this->con->consultaRetorno($sql);
	return $datos;
}

public function actualizarSinLogoySinArchivo()
{
	$sql="UPDATE lla_empresa SET
rfc = '{$this->rfc}',
razon_social = '{$this->razonsocial}',
pais = '{$this->pais}',
estado = '{$this->estado}',
municipio = '{$this->municipio}',
colonia = '{$this->colonia}',
calle = '{$this->calle}',
cp = '{$this->cp}',
next = '{$this->numexterior}',
nint = '{$this->numinterior}',
correo = '{$this->email}',
telefono = '{$this->telefono}',
celular = '{$this->celular}',
responsable = '{$this->responsable}',
num_certificado = '{$this->certificado}',
referencia = '{$this->referencia}',
regimen_fiscal = '{$this->regimenfis}',
clave_key = '{$this->clavekey}'
WHERE id_empresa = '{$this->id}'";
	$datos=$this->con->consultaRetorno($sql);
	return $datos;
}
	/* agregado Jesus 15/01/2018 */
	public function listarRFC(){
		// $sql="SELECT rfc from lla_empresa ";
		$sql="SELECT rfc from lla_empresa WHERE rfc <> 'ESI920427886'";
		$datos=$this->con->consultaRetorno($sql);
		return $datos;
	}



	}
 ?>

<?php 
	/**
	* modelo al base de datos usuario --> lla_usuario
	*/
	include_once 'app/Conexion.php';
	//include_once '../app/Conexion.php';


	
	class Usuario {

		private $id;
		private $nombre;
		private $email;
		private $password;
		private $perfil;

		public function __construct(){
			//default conecta con la base de datos
			$this->con = new Conexion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
		}
		
		public function validar(){
			$sql = "SELECT lu.*,la.rfc FROM lla_usuario as lu,lla_empresa as la WHERE lu.login='$this->email' AND lu.clave_seguridad='$this->password' and lu.id_empresa=la.id_empresa";
			$datos = $this->con->consultaRetorno($sql);
			while($row = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
				$this->id        = $row['id'];
				$this->nombre    = $row['nombre'];
				$this->perfil    = $row['perfil'];
				$this->rfc 		 = $row['rfc'];
				
			}
		}

		
	}
 ?>
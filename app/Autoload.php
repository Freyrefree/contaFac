<?php
	$autoload = new Autoload();
  	$autoload->run();
  	
	class Autoload{

		public static function run(){
			spl_autoload_register(function($clase){
				$ruta = str_replace("\\", "/", $clase). ".php";
				echo "Ruta: ".$ruta;
				//include_once $ruta;
			});
		}

	}

?>
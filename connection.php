<?php

class connection {
	
	protected $link;
	private $dsn, $user, $password;
	
	public function __construct() { // CONSTRUCTOR
		$this->dsn = 'mysql:host=localhost; dbname=transitnet;';
		$this->user = 'root';
		$this->password = '';
	}
	
	public function __destruct() { // DESTRUCTOR
		$this->dsn;
		$this->user;
		$this->password;
	}
	
	public function connect() { // CONEXION
		try {
			$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true); // OPCIONES DE LA CONEXION PDO
			$this->link = new PDO($this->dsn, $this->user, $this->password, $options); // CADENA DE CONEXION
		} catch(PDOException $e) {
			echo "¡Error!: ".$e->getMessage(); // MENSAJE DE ERROR
		}	
	}
	
	public function disconnect() { // DESCONEXION
		$this->link = null; // CONEXION CERRADA O ANULADA
	}
		
}

?>
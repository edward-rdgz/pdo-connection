<?php
/*******************
** Nombre: Consulta
** Descripcion: Crea un objeto que se enlaza a la bd para realizar consultas
** Fecha: Julio 7 de Mayo
** Autor: Villegas Alonzo
*******************/
class driversql{
	private $conection;
	private $hostname;
	private $username;
	private $passw;
	private $bd;
	//lastID conserva el id de la ultima insercion de la base de datos
	public $lastID;  
	
	function __construct(){		
		/*** mysql hostname ***/
		$this->hostname = 'localhost';
		/*** mysql username ***/
		$this->username = 'root';
		/*** mysql password ***/
		$this->password = '';
		/*** mysql BD ***/
		$this->bd= 'rem';
		/** El ultimo ID insertado en la tabla**/
		$this->lastID = 0;
		if ($_SERVER['SERVER_NAME'] == $this->hostname) {
			$this->inicia_local($this->hostname,$this->username,$this->password,$this->bd);
		} else {
			$this->inicia_local($this->hostname,$this->username,$this->password,$this->bd);
		}
	}
	
	public function inicia_local($host,$user,$pass,$bd){		
		/*** mysql hostname ***/
		$this->hostname = $host;
		/*** mysql username ***/
		$this->username = $user;
		/*** mysql password ***/
		$this->password = $pass;
		/*** mysql BD ***/
		$this->bd= $bd;
		/** El ultimo ID insertado en la tabla**/
		$this->lastID= 0;
	}
	
	private function conectar(){
		try {
			$opt = array(
				// any occurring errors will be thrown as PDOException
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				// an SQL command to execute when connecting
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
			);
		$this->conection = new PDO("mysql:host=$this->hostname;dbname=$this->bd", $this->username, $this->password, $opt);	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	private function desconectar(){
		/*** close the database connection ***/
		$this->conection = null;
	}
	
	public function consulta_simple($sql){
		$this->conectar();
		$stmt = $this->conection->query($sql);
		/*** fetch into an PDOStatement object ***/
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->desconectar();
		return json_encode($result);
	}
	
	public function consulta($sql){
		try{
			$this->conectar();
			$stmt = $this->conection->query($sql);
			/*** fetch into an PDOStatement object ***/
			$result = $stmt->fetchALL();
			$this->desconectar();
			return json_encode($result);
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function consulta_regresa_id($sql){
		try{
		$this->conectar();
		$stmt = $this->conection->query($sql);
		/*** Regresa el Ultimo ID Insertado ***/
		$last_id = $stmt->lastInsertId();
		$this->desconectar();
		return $last_id;
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function ejecutar($sql){
		try{
			$this->conectar();
			/*** Insertamos el nuevo registro ***/
			$this->conection->exec($sql);
			/*** display the id of the last INSERT ***/
			$this->lastID = $this->conection->lastInsertId();
			$this->desconectar();
		}
		catch(PDOException $e){
			echo $e->getMessage()." ".$e->getLine()." ".$sql;
		}
	}
	
}

$con = new driversql();
$resultado = $con->consulta_simple("SELECT * FROM departamento");
print_r($resultado);
?>
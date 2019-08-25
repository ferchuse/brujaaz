<?php
	/*	
		//https://www.modelit.xyz/blog/connection-mysql-php-dao/
		//http://blog.chapagain.com.np/php-crud-add-edit-delete-view-application-using-oop-object-oriented-programming/
		
		class Conexi 
		{    
    private $_host = 'localhos';
		private $_database = 'microsit_brujaaz';
    private $_username = 'microsit_practic';
    private $_password = 'UAEH@2018';
    private $error = [];
		
    protected $connection;
    
    public function __construct(){
		if (!isset($this->connection)) {
		
		$this->connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
		
		if (!$this->connection) {
		echo 'No es posible conectar a la Base de Datos';
		exit;
		}            
		}    
		
		return $this->connection;
		}
		
		public function query($sql) {
		
		$result = $this->connection->query($sql);
		if($result == false){
		return $this->connection->error;
		
		}
		else{
		return $result;
		}
		
		
		
		}
		}
		
		
		class Table extends Conexi {
		private $table;
		private $result;
		protected $connection;
		
		public function __construct($table) {
		$this->setTable($table);
		$this->connection = new Conexi();
		}
		
		// Define get/set
		public function getTable() { return $this->table; }
		public function setTable($name) { $this->table = $name; }
		public function getConnection() { return $this->connection; }
		
		public function getAll(){
		// echo "getAll()";
		$filas = ["1"];
		$this->result = parent::query('SELECT * FROM ' . $this->table) or DIE("Error Table". $this->connection->error);
		if($this->result  == false){
		// echo "Error". $this->connection->error;
		return $this->result ;
		}
		else{
		// echo "success";
		while ($fila = $this->result->fetch_assoc()) {
		$filas[] = $fila;
		}
		return $filas;
		
		}
		
		
		}
		public function getById($id) {  }
		public function deleteById($id) {  }
		
	}*/  
	
	function Conectarse()
	{
	
	$host="localhost";
	
	if($_SERVER["SERVER_NAME"] == "brujaaz.com"){
	
		$db="brujaaz_brujaaz";
		$usuario="brujaaz_sistemas";
		$pass="Glifom3dia";
	}
	else{
		$db="brujaaz";
		$usuario="sistemas";
		$pass="Glifom3dia";
		
	}
	
	
		$set_local = "SET time_zone = '-05:00'";
		$set_names = "SET NAMES 'utf8'";
		date_default_timezone_set('America/Mexico_City');
		
    if (!($link=mysqli_connect($host,$usuario,$pass)))
		{
			die( "Error conectando a la base de datos.". mysqli_error($link));
		}
		
		if (!mysqli_select_db($link, $db))
		{
			die( "Error seleccionando la base de datos.". mysqli_error($link));
		}
		
		mysqli_query($link, "SET NAMES 'utf8'") or die("Error Cambiando charset").mysqli_error($link);
		
		setlocale(LC_ALL,"es_ES");
		mysqli_query($link, "SET CHARACTER SET utf8") or die("Error en charset UTF8".mysqli_error($link));
		
		
		
		return $link;
	}
?>
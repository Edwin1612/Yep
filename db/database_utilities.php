<?php
	require_once('database_credentials.php');

	//Se realiza la conexion a la base de datos, utilizando las constantes definidas en database_credentials.php
	

	function getPDO() 
	{
	    $host = DB_SERVER;
	    $dbname = DB_DATABASE;
	    $port = DB_PORT;
	    $connStr =  "mysql:host={$host};dbname={$dbname};port={$port}";
	    $dbOpt = array(
	        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    );

    	return new PDO($connStr, DB_USER, DB_PASSWORD, $dbOpt);
	}

	$conn = getPDO();


	//Funcion que permite agregar un nuevo usuario a la base de datos, requiere nombre y correo.
	function add($nombre,$correo){
		global $conn;
		//$sql = "INSERT INTO usuario (nombre,correo) VALUES ('$nombre','$correo')";
		$stmt = $conn->prepare('INSERT INTO user (email,nombre) VALUES ( :email,:password)');
		//$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':email', $nombre);
		$stmt->bindParam(':password', $correo);
		$stmt->execute();
		//$conn->query($sql);
	}

	//Funcion que permite actualizar los atributos de un usuario existente, requiere nombre, correo y su id.
	function update($id,$nombre,$correo){
		global $conn;
		$sql = "UPDATE user SET password='$nombre', email='$correo' where id=$id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
	}

	//Funcion que permite eliminar un usuario de la base de datos utilizando su id.
	function delete($id){
		global $conn;
		$sqlCmd = "DELETE FROM user WHERE id=:id";
		$stmt = $conn->prepare($sqlCmd);
		$stmt->bindParam(':id',$id);
		$stmt->execute();
	}

	//Funcion que permite obtener todos los registros encontrados en la tabla usuarios de la base de datos.
	function get_all(){
		global $conn;
		//$sql = 'SELECT * FROM user';
		//$r = $conn->prepare($sql);
	//		return $r;
	//	return $r;

		$stmt = $conn->prepare('SELECT *FROM user');
	// Ejecutamos el Statement.
		$stmt->execute();
		return $stmt;

	}

	//Funcion que permite realizar una busqueda de un usuario para obtener todos sus atributos mediante su id.
	function search($id){
		global $conn;
		$sql = "SELECT * FROM user where id=$id";
		$stmt = $conn->prepare($sql);
		$r = $conn->query($sql);
		return $r;
	}
?>
<?php
	function getDB() {
		$dbhost=DB_SERVER;
		$dbuser=DB_USERNAME;
		$dbpass=DB_PASSWORD;
		$dbname=DB_DATABASE;
		try {
			$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
			$dbConnection->exec("set names utf8");
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
		catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
	function loggedin() {
		if(isset($_SESSION["username"])) {  
			return true; 
		} else {  
			return false;
		}  
	}

	function logout() {
		session_destroy();
		unset($_SESSION['username']);
		return true;
	}

	function redirect($url) {
		header("Location: $url");
	}
	function getSingleValue($tableName, $prop, $value, $columnName) {
		$db = getDB();
		$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
		$f = $q->fetch();
		$result = $f[$columnName];
		return $result;
	}
?>
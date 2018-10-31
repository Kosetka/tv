<?php
	include("config.php"); 
	$db = getDB();

	if(!isset($_GET["sid"]) && !isset($_GET["did"])) {
		$statement = $db->prepare("SELECT * FROM depts");
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		$json = json_encode($results);
		//foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {

		//}
		echo $json;
	} elseif(isset($_GET["sid"]) && !isset($_GET["did"])) {
		$sid = $_GET["sid"];
		//echo "sid";
		$statement = $db->prepare("SELECT * FROM screen WHERE id = '$sid'");
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		$json = json_encode($results);
		echo $json;
	} elseif(!isset($_GET["sid"]) && isset($_GET["did"])) {
		$did = $_GET["did"];
		//echo "sid";
		$statement = $db->prepare("SELECT * FROM display WHERE sid = '$did'");
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		$json = json_encode($results);
		echo $json;
	} elseif(isset($_GET["sid"]) && isset($_GET["did"])) {
		echo "sid & did";
	} else {
		echo "???";
	}
	
?>

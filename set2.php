<?php
include("config.php"); 
$db = getDB();

if(isset($_GET["did"])) {
	$did = $_GET["did"];
	if($did<>13) {
		$statement = $db->prepare("UPDATE depts SET sid = 3 WHERE did = $did");
		$statement->execute();
	}
} else {
	echo "???";
}
?>

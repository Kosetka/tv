<?php
	include("config.php"); 
	$db = getDB();

	if(isset($_GET["did"])) {
		$did = $_GET["did"];
		$statement = $db->prepare("SELECT * FROM summary WHERE did = $did ORDER BY id DESC LIMIT 2");
		$statement->execute();
		$arr = array();
		$now = date("Y-m-d H:i:s");
		$none = true;
		$i = 0;
		foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
			echo $row["sid"]." ";
			$sid = $row["sid"];
			$statement2 = $db->prepare("SELECT * FROM screen WHERE date_from<='$now' AND date_to>='$now' AND id='$sid' ORDER BY important DESC"); //
			$statement2->execute();
			$test = $statement2->fetchAll();
			if(count($test)>0) {
				$arr[$i]['important'] = $test[0]['important'];
				$arr[$i]['id'] = $test[0]['id'];
				$none = false;
			}
			echo '<pre>';
			print_r($test);
			echo '</pre>';
			$i++;
		}
		if(!$none) {
			if($arr[0]['important']>=$arr[1]['important']) {
				$temp = $arr[0]['id'];
			} else {
				$temp = $arr[1]['id'];
			}
		} else {
			if($did == 13) {
				$temp = 5;
			} else {
				$temp = 3;
			}
		}
		if($temp == 3 || $temp == 5) {
			if($did == 13) {
				$statement3 = $db->prepare("UPDATE depts SET sid = 5 WHERE did = 13");
				$statement3->execute();
			} else {
				$statement3 = $db->prepare("UPDATE depts SET sid = 3 WHERE did = $did");
				$statement3->execute();
			}
		} else {
			$statement3 = $db->prepare("UPDATE depts SET sid = $temp WHERE did = $did");
			$statement3->execute();
		}
	} else {
		echo "???";
	}
?>

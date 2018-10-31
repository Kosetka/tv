<?php  
include("../config.php"); 
if(!loggedin()) redirect('index.php');
?>  
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="../style.css<?php echo '?'.mt_rand(); ?>">
		<title>Historia - Panel administratorski</title>
	</head>
	<body style="width: 100wv; height: 100hv;">
		<?php
		require('nav.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-sm">
					<h2>Historia ekranów</h2>
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Oddział</th>
								<th scope="col">Ekran</th>
								<th scope="col">Data od</th>
								<th scope="col">Data do</th>
								<th scope="col">Opis</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$depts = [];
							$display = [];
							$screen = [];
							$depts[] = 0;
							$display[] = 0;
							$screen[] = 0;
							$db = getDB();
							$statement = $db->prepare("SELECT * FROM departments ORDER BY id ASC");
							$statement->execute();
							foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
								$depts[] = $row["name"];
							}
							$statement = $db->prepare("SELECT * FROM screen");
							$statement->execute();
							$i = 1;
							foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
								$screen[$i]["date_from"] = $row["date_from"];
								$screen[$i]["date_to"] = $row["date_to"];
								$i++;
							}
							$statement = $db->prepare("SELECT * FROM display ORDER BY id ASC");
							$statement->execute();
							$i = 1;
							foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
								$display[$i]["sid"] = $row["sid"];
								$display[$i]["opis"] = $row["opis"];
								$i++;
							}
							$statement = $db->prepare("SELECT * FROM summary ORDER BY id DESC");
							$statement->execute();
							$i = 1;
							foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
								$did = $row["did"];
								$sid = $row["sid"];
								echo '<tr><td>'.$i.'</td><td>'.$depts[$did].'</td><td>'.$sid.'</td><td>'.$screen[$sid]["date_from"].'</td><td>'.$screen[$sid]["date_to"].'</td><td>'.$display[$sid]["opis"].'</td></tr>';
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
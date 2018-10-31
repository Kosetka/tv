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
		<title>Oddziały - Panel administratorski</title>
	</head>
	<body style="width: 100wv; height: 100hv;">
		<?php
			require('nav.php');
		?>
		<?php
		if(isset($_POST["deptSend"])) {
			$db = getDB();
			$position = $_POST["deptPosition"];
			$name = $_POST["deptName"];
			$statement = $db->prepare("INSERT INTO departments(name, position) VALUES (:name, :position)");
			$statement->bindParam(':position',$position); 
			$statement->bindParam(':name',$name); 
			$statement->execute();
			echo 'Oddział został dodany';


		}	
		?>
		<div class="container">
			<div class="row">
				<div class="col-sm">
					<h2>Dodaj oddział</h2>
					<form action="" method="POST">
						<div class="form-group">
							<label for="deptName">Nazwa oddziału</label>
							<input type="text" class="form-control" id="deptName" required>
						</div>
						<div class="form-group">
							<label for="position">Pozycja</label>
							<input type="number" name="deptPosition" class="form-control" id="position" required>
						</div>
						<button type="submit" name="deptSend" class="btn btn-primary">Zapisz</button>
					</form>
				</div>
				<div class="col-sm">
					<h2>Lista oddziałów</h2>
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nazwa</th>
								<th scope="col">Pozycja</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$db = getDB();
							$statement = $db->prepare("SELECT * FROM departments ORDER BY id ASC");
							$statement->execute();
							foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
								$name = $row["name"];
								$pos = $row["position"];
								$id = $row["id"];
								echo "<tr>
										<th scope='row'>$id</th>
										<td>$name</td>
										<td>$pos</td>
									</tr>";
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
		//$did = $_GET["id"];
		//echo $did;



		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
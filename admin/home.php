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
		<title>Panel administratorski</title>
	</head>
	<body style="width: 100wv; height: 100hv;">
		<?php
			require('nav.php');
		?>
	<?php
		if(isset($_POST["deptSend"])) {
			echo $_POST["deptName"];
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
			<form action="">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="selectAll" onClick="toggle(this)">
					<label class="form-check-label" for="selectAll">Zaznacz wszystko</label>
				</div>
				<?php
					$db = getDB();
					$statement = $db->prepare("SELECT * FROM departments ORDER BY position ASC");
					$statement->execute();
					foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
						$name = $row["name"];
						$id = $row["id"];
						echo '<div class="form-check">';
						echo "<input class='form-check-input' type='checkbox' name='dep' id='dept$id' value='$id'>";
						echo "<label class='form-check-label' for='dept$id'>$name</label>";
						echo '</div>';
					}
				?>
			</form>
		</div>
		<div class="container">
			dodaj oddział
			
			<form action="" method="POST">
				<label for="deptName">Nazwa oddziału:</label>
				<input type="text" name="deptName" required>
				<label for="deptPosition">Pozycja:</label>
				<input type="number" name="deptPosition">
				<input type="submit" name="deptSend">
			</form>
		</div>
		<?php
		//$did = $_GET["id"];
		//echo $did;



		?>
		<?php
		/*<div class="Vcontainer">
		<iframe src="https://www.youtube.com/embed/z0G7UHnIQXA?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>


	</div>


	<div class="Vcontainer">
		<img src="test.png" width="100%">
	</div>

	<div class="Vcontainer">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate.</p>
	</div>

		
	<div class="Vcontainer">
		<iframe src="http://teambox.pl/dept/3" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>
	</div>*/
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script language="JavaScript">
			function toggle(source) {
				checkboxes = document.getElementsByName('dep');
				for(var i=0, n=checkboxes.length;i<n;i++) {
					checkboxes[i].checked = source.checked;
				}
			}
		</script>
	</body>
</html>
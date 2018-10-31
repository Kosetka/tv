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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="../style.css<?php echo '?'.mt_rand(); ?>">
		<title>Dodaj Ekran - Panel administratorski</title>
	</head>
	<body style="width: 100wv; height: 100hv;">
		<?php
		require('nav.php');
		?>
		<?php
		if(isset($_POST["send"])) {
			echo "data od: ".$_POST["dtp_input1"]."<br>";
			echo "data do: ".$_POST["dtp_input2"]."<br>";
			foreach($_POST["dep"] as $dept) {
				echo "oddziały: ".$dept."<br>";
			}
			echo "typ: ".$_POST["type"]."<br>";
			echo "link: ".$_POST["link"]."<br>";
			echo "img: ".$_POST["img"]."<br>";
			echo "txt: ".$_POST["txt"]."<br>";
			echo "opis: ".$_POST["opis"]."<br>";
			echo "important: ".$_POST["important"]."<br>";
			
			$date_from = $_POST["dtp_input1"];
			$date_to = $_POST["dtp_input2"];
			$date = "2018-10-19 16:00:00";
			$uid = "1";
			$turn = "1";
			$important = $_POST["important"];
			
			$type = $_POST["type"];
			$link = $_POST["link"];
			$img = $_POST["img"];
			$txt = $_POST["txt"];
			$opis = $_POST["opis"];
			$results = "";
			
			$db = getDB();
			$statement = $db->prepare("INSERT INTO screen(date_from, date_to, date, uid, turn, important) VALUES (:date_from, :date_to, :date, :uid, :turn, :important)");
			$statement->bindParam(':date_from',$date_from); 
			$statement->bindParam(':date_to',$date_to); 
			$statement->bindParam(':date',$date); 
			$statement->bindParam(':uid',$uid); 
			$statement->bindParam(':turn',$turn); 
			$statement->bindParam(':important',$important); 
			$statement->execute();
			$sid = $db->lastInsertId();
			
			$statement = $db->prepare("INSERT INTO display(sid, type, link, text, results, image, opis) VALUES (:sid, :type, :link, :text, :results, :image, :opis)");
			$statement->bindParam(':sid',$sid); 
			$statement->bindParam(':type',$type); 
			$statement->bindParam(':link',$link); 
			$statement->bindParam(':text',$txt); 
			$statement->bindParam(':results',$results); 
			$statement->bindParam(':image',$img); 
			$statement->bindParam(':opis',$opis); 
			$statement->execute();
			
			foreach($_POST["dep"] as $did) {
				$statement = $db->prepare("INSERT INTO summary(sid, did) VALUES (:sid, :did)");
				$statement->bindParam(':sid',$sid); 
				$statement->bindParam(':did',$did); 
				$statement->execute();
			}
			echo '<div class="container">
			<div class="alert alert-success" role="alert">
				Ekran został dodany pomyślnie.
			</div>
		</div>';
			
		}	
		?>
		
		
		<div class="container">
			<div class="row">
				<div class="col-sm">
					<h2>Dodawanie ekranu</h2>
					<form action="" method="POST">
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<label for="dtp_input1" class="control-label">Wybierz datę rozpoczęcia:</label>
									<div class="input-group date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
										<input class="form-control" size="16" type="text" value="" required>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
									<input type="hidden" id="dtp_input1" name="dtp_input1" value=""><br>
								</div>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<label for="dtp_input2" class="control-label">Wybierz datę zakończenia:</label>
									<div class="input-group date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input2">
										<input class="form-control" size="16" type="text" value="" required>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
									<input type="hidden" id="dtp_input2" name="dtp_input2" value=""><br>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label for="dep" class="control-label">Wybierz oddziały:</label>
								<!---<div class="form-check" style="margin-bottom: 20px;">
									<input type="checkbox" class="form-check-input" id="selectAll" onClick="toggle(this)">
									<label class="form-check-label" for="selectAll">Zaznacz wszystko</label>
								</div>!--->
									<?php
										$db = getDB();
										$statement = $db->prepare("SELECT * FROM departments ORDER BY position ASC");
										$statement->execute();
										foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
											$name = $row["name"];
											$id = $row["id"];
											echo '<div class="form-check">';
											echo "<input class='form-check-input' type='checkbox' name='dep[]' id='dept$id' value='$id'>";
											echo "<label class='form-check-label' for='dept$id'>$name</label>";
											echo '</div>';
										}
									?>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<label for="type">Wybierz typ:</label>
									<select class="form-control" id="type" name="type">
										<option value="1">Film</option>
										<option value="2">Wiadomość tekstowa</option>
										<option value="3">Wyniki z TeamBoxa</option>
										<option value="4">Zdjęcie</option>
										<option value="5">Pingowanie oddziałów</option>
										<option value="6">Wyniki potwierdzanie</option>
									</select>
								</div>
								<div class="form-group" id="linkHide">
									<div class="form-group">          
										<label for="link">ID filmu:</label>
										<input type="text" class="form-control" id="link" name="link" placeholder="np. z0G7UHnIQXA">
									</div>
								</div>
								<div class="form-group" id="imgHide">
									<div class="form-group">          
										<label for="link">Link do zdjęcia:</label>
										<input type="text" class="form-control" id="img" name="img" placeholder="np. img">
									</div>
								</div>
								
								<div class="form-group" id="txtHide">
									<div class="form-group">
										<label for="txt">Wiadomość:</label>
										<textarea class="form-control" id="txt" name="txt" rows="3"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="opis">Opis:</label>
									<textarea class="form-control" id="opis" name="opis" rows="3" required></textarea>
								</div>
								<div class="form-group" id="important">
									<div class="form-group">          
										<label for="link">Priorytet:</label>
										<input type="number" class="form-control" id="important" name="important" value="1">
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="send">
						<button type="submit" class="btn btn-primary col-12" style="margin-top: 50px;" id="checkBtn">Dodaj ekran</button>
					</form>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/bootstrap-datetimepicker.pl.js"></script>
		
		<script src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script src="js/bootstrap-datetimepicker.pl.js" charset="UTF-8"></script>
		<script language="JavaScript">
			var currentDate = new Date().toISOString().slice(0, 10);
			currentDate = currentDate + ' 08:00';
			function toggle(source) {
				checkboxes = document.getElementsByName('dep');
				for(var i=0, n=checkboxes.length;i<n;i++) {
					checkboxes[i].checked = source.checked;
				}
			}
		</script>
		<script type="text/javascript">
			$(".form_datetime").datetimepicker({
				language:  'pl',
				format: "yyyy-mm-dd hh:ii:ss",
				autoclose: true,
				todayBtn: true,
				todayHighlight: 1,
				startDate: currentDate,
				minuteStep: 1
			});
		</script> 
		<script>
			$('#imgHide').fadeOut(0);
			$('#txtHide').fadeOut(0);
			$(document).ready(function(){
				$('#type').change(function(){
					if(this.value == 1) {
						$('#linkHide').fadeIn(0);
						$('#imgHide').fadeOut(0);
						$('#txtHide').fadeOut(0);
						
					} else if(this.value == 4) {
						$('#imgHide').fadeIn(0);
						$('#linkHide').fadeOut(0);
						$('#txtHide').fadeOut(0);
					} else if(this.value == 2) {
						$('#imgHide').fadeOut(0);
						$('#linkHide').fadeOut(0);
						$('#txtHide').fadeIn(0);
						
					} else {
						$('#imgHide').fadeOut(0);
						$('#linkHide').fadeOut(0);
						$('#txtHide').fadeOut(0);
						
					}

				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function () {
				$('#checkBtn').click(function() {
					checked = $("input[type=checkbox]:checked").length;

					if(!checked) {
						alert("Musisz zaznaczyć co najmniej 1 oddział.");
						return false;
					}

				});
			});

		</script>
	</body>
</html>
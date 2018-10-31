<?php  
	include("config.php"); 
	//if(!loggedin()) redirect('index.php');
?>  
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<!---<meta http-equiv="refresh" content="300">!--->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css<?php echo '?'.mt_rand(); ?>">
	<title>Test</title>
</head>
<body style="width: 100wv; height: 100hv; background-color: white">
	<div class="Vcontainer" id="data">
	</div>
	<?php
		$did = $_GET["id"];
		//echo $did;
	?>
	<?php /*
	
	<div class="Vcontainer" id="data">
	
	</div>
	<div class="Vcontainer" id="film">
		<iframe src="https://www.youtube.com/embed/z0G7UHnIQXA?autoplay=1&vq=medium" frameborder="0" allow="autoplay; encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>
		
		
	</div>

	
	<div class="Vcontainer" id="image">
		<img src="test.png" width="100%">
	</div>
	
	<div class="Vcontainer" id="text">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, quos unde deserunt eligendi quas provident inventore ratione voluptas soluta cupiditate.</p>
	</div>
		
	
	<div class="Vcontainer" id="results">
		<?php echo $_GET["id"];?>
		<iframe src="http://teambox.pl/dept/<?php echo $_GET["id"];?>" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>
	</div>
		
	
	<div class="Vcontainer" id="ping">
		<iframe src="http://10.200.39.102/pingok/" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>
	</div>*/ ?>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		var department = <?php echo $_GET["id"]?>;
		var lastSID = 0;
		setInterval(function() {
			$.ajax({
				url: "set.php?did=" + department,
				dataType : 'json',
				type: "get"
			})
			
			$.ajax({
				url: "test.php",
				dataType : 'json',
				type: "get"
			})
			.done(function(res) {
				let sid = res[department-1]["sid"];
				if(lastSID!==sid) {
					let elementExists = document.getElementById("id-1");
					if(elementExists) {
						removeElement("id-1");
					}
					lastSID = sid;
					//console.log(res[department-1]["sid"]);
					let did = res[department-1]["did"];
					//console.log(did + " = " + department);
					//show(did);
					$.ajax({
						url: "test.php?sid=" + sid,
						dataType : 'json',
						type: "get"
					})
					.done(function(res) {
						let date_from = new Date(res[0]["date_from"]);
						let date_to = new Date(res[0]["date_to"]);
						let d = new Date();
						let now = d.getFullYear()  + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " +
							d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
						now = new Date(now);

						if(date_to>=now && date_from<=now || sid==3 || sid==5) {
							$.ajax({
								url: "test.php?did=" + sid,
								dataType : 'json',
								type: "get"
							})
							.done(function(res) {
								let type = res[0]["type"];
								if(type==1) { //film
									let temp = res[0]["link"];
									console.log(temp);
									let html = '<iframe src="https://www.youtube.com/embed/' + temp + '?autoplay=1&vq=medium" frameborder="0" allow="autoplay; encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>';
									addElement('data','div','id-1',html);

								} else if(type==2) { //tekst
									let temp = res[0]["text"];
									let html = temp;
									addElement('data','div','id-1',html);

								} else if(type==3) { //wyniki
									let temp = res[0]["results"];
									let html = '<iframe src="http://teambox.pl/dept/<?php echo $_GET["id"];?>" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>';
									addElement('data','div','id-1',html);
									
								} else if(type==4) { //zdjęcie
									let temp = res[0]["image"];
									let html = '<img src="' + temp + '" width="100%">';
									addElement('data','div','id-1',html);
									
								} else if(type==5) { //ping
									let temp = 'http://10.200.39.102/pingok/';
									let html = '<iframe src="' + temp + '" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>';
									addElement('data','div','id-1',html);

								} else if(type==6) { //wyniki potwierdzanie
									let temp = 'http://10.200.39.102/pingok/';
									let html = '<iframe src="' + temp + '" frameborder="0" allow="encrypted-media" fullscreen allowfullscreen="allowfullscreen"></iframe>';
									addElement('data','div','id-1',html);

								} else {
									console.log("??");
								}

							})


						} else {
							let elementExists = document.getElementById("id-1");
							if(elementExists) {
								removeElement("id-1");
							}
							lastSID = 0;
							// ustawienie w DEPTS odpowiedniego ID DISPLAY
							$.ajax({
								url: "set2.php?did=" + did,
								dataType : 'json',
								type: "get"
							})
						}
					})

				}
			})
			.fail(function() {
				console.warn('wystąpił błąd');
			})
		}, 1000 * 5);
		
		function show(id) {
			console.log(id);
		}
		function addElement(parentId, elementTag, elementId, html) {
			var p = document.getElementById(parentId);
			var newElement = document.createElement(elementTag);
			newElement.setAttribute('id', elementId);
			newElement.innerHTML = html;
			p.appendChild(newElement);
		}
		function removeElement(elementId) {
			// Removes an element from the document
			var element = document.getElementById(elementId);
			element.parentNode.removeChild(element);
		}
	</script>

</body>
</html>
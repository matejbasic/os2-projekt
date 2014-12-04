<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Net/SSH2.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>OS2 - projekt</title>
	</head>
	<style>
		.hidden {
			visibility: hidden;
		}
		body {
			background: none repeat scroll 0% 0% #F5F5F5;
			
		}
		textarea {
			width: 517px;
height: 563px;
border: 1px solid #BCBCBC;
		}
		button {
			background: #3677a3;
			background-image: -webkit-linear-gradient(top, #3677a3, #2282bd);
			background-image: -moz-linear-gradient(top, #3677a3, #2282bd);
			background-image: -ms-linear-gradient(top, #3677a3, #2282bd);
			background-image: -o-linear-gradient(top, #3677a3, #2282bd);
			background-image: linear-gradient(to bottom, #3677a3, #2282bd);
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0px;
			font-family: Arial;
			color: #ffffff;
			font-size: 20px;
			padding: 10px 20px 10px 20px;
			text-decoration: none;
		}
	</style>
	<body>
		<!-- interface -->
		<div>
			<button id="generateKeysBtn">Generiraj ključeve</button>
		</div>
		<br/>
		<div id="keysLinks" class="hidden">
			<a href="/keys/tajni_kljuc.txt" target="_blank">tajni_kljuc.txt</a>
			<a href="/keys/javni_kljuc.txt" target="_blank">javni_kljuc.txt</a>
			<a href="/keys/privatni_kljuc.txt" target="_blank">privatni_kljuc.txt</a>
		</div>
		<br/>
		<textarea rows="8" cols="80" id="txtPlain">
		
		</textarea>
		<button id="generateTxtBtn">Ispuni tekstom</button>
		<br/>
		
		<button id="savePlainBtn">Spremi tekst</button>
		<button id="asymetricCryptBtn">Asimetrično kriptiranje</button>
		<button id="symetricCryptBtn">Simetrično kriptiranje</button>
		<br/><br/><br/>
		<div id="dataLinks">
			<a href="/data/obican.txt" target="_blank" class="hidden" id="obicanLink">obican.txt</a>
			<a href="/data/rsa_kriptirano.txt" target="_blank" id="rsaKriptiranoLink" class="hidden">rsa_kriptirano.txt</a>
			<a href="/data/aes_kriptirano.txt" target="_blank" id="aesKriptiranoLink" class="hidden">aes_kriptirano.txt</a>
		</div>
		<br/>
		<footer>
			<br/>Lib: <a href="http://phpseclib.sourceforge.net/" target="_blank">PhpSecLib</a><br/>
		</footer>
	</body>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
		
			$('#generateKeysBtn').click(function(){
				
				var ajaxurl = 'keys_generator.php';
				$.post(ajaxurl, "", function (response) {
					if (response == "generated" ) {
						alert("Ključevi generirani!");
						$("#keysLinks").removeClass("hidden");
					}
					else {
						alert("Nešto je pošlo po krivu!");
					}
				});
			});
			
			$("#generateTxtBtn").click(function() {
				var date = new Date();
				var dateNow = date.getHours().toString() + ":" + date.getMinutes().toString() + ":" + date.getSeconds().toString()
							  + " " + date.getDate().toString() + "." + (date.getMonth()+1).toString() + "." + date.getFullYear().toString() + "." ; 
				var txtPlain = $("#txtPlain");
				var LoremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eodem modo is enim tibi nemo dabit, quod, expetendum sit, id esse laudabile. Ergo in gubernando nihil, in officio plurimum interest, quo in genere peccetur. Duo Reges: constructio interrete. Sed finge non solum callidum eum, qui aliquid improbe faciat, verum etiam praepotentem, ut M. Sed tu istuc dixti bene Latine, parum plane. Nam et a te perfici istam disputationem volo, nec tua mihi oratio longa videri potest.";
				
				$("#txtPlain").val("");
				$('#txtPlain').val($('#txtPlain').val() + dateNow + "\n" + LoremIpsum);
				
				
			});
			
			$("#savePlainBtn").click(function() {
				var ajaxurl = 'save_text_to_file.php';
				var txtPlain = $("#txtPlain").val();
				var txtTemp = txtPlain.trim();
				if ( txtTemp !== "" ) {
					data = {text: txtPlain};
					$.post(ajaxurl, data, function (response) {
						console.log(response);
						if (response == "saved") {
							alert("Tekst pohranjen!");
							$("#obicanLink").removeClass("hidden");
						}
						else {
							alert("Nešto je pošlo po krivu! Sigurno je server...");
						}
					});
				}
				else {
					alert("Prazan tekst!");
				}
			});
			
			$("#asymetricCryptBtn").click(function() {
				var ajaxurl = 'cryptr.php';
				
				data = {type: "asymetric"};
				$.post(ajaxurl, data, function (response) {
					console.log(response);
					if (response == "encrypted") {
						alert("Tekst asimetrično kriptiran!");
						$("#rsaKriptiranoLink").removeClass("hidden");
					}
					else {
						alert("Nešto je pošlo po krivu!");
					}
				});
			});
			
			$("#symetricCryptBtn").click(function() {
				var ajaxurl = 'cryptr.php';
				
				data = {type: "symetric"};
				$.post(ajaxurl, data, function (response) {
					console.log(response);
					if (response == "encrypted") {
						alert("Tekst simetrično kriptiran!");
						$("#aesKriptiranoLink").removeClass("hidden");
					}
					else {
						alert("Nešto je pošlo po krivu! Sigurno je server...");
					}
				});
			});
		});
	</script>
	
	
</html>
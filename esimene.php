<?php
	//muutujad 
	$myName = "Raili";
	$myFamilyName = "Mikksaar";
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	//var_dump ($monthNamesEt);
	//echo $monthNamesEt [8];
	$monthNow = $monthNamesEt[date("n")-1];
	
	//hindan päeva osa, võrdlemine <= väiksem võrdne, >= suuremvõrdne, == võrdne, != mittevõrdne
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow <16){
		$partOfDay = "koolipäev";
	}
	if ($hourNow >16) {
		$partOfDay = "vaba aeg";
	}
	//echo $partOfDay;
	//vanusega tegelemine
	//var_dump ($_POST);
	//echo $_POST["birthYear"];
	$myBirthYear;
	$ageNotice = "";
	if (isset($_POST["birthYear"]) and $_POST["birthYear"] !=0){
		$myBirthYear = $_POST["birthYear"];
		$myAge = date("Y") - $_POST["birthYear"];
		$ageNotice = "<p>Te olete umbkaudu " .$myAge ."aastat vana.</p>";
		
		$ageNotice .= "<p>Olete elanud järgnevatel aastatel:</p> <ol>";
		for ($i = $myBirthYear; $i <= date("Y"); $i ++){
			$ageNotice .= "<li>" .$i ."</li>";
		}
		$ageNotice .= "</ol>";
		
	}
	
	/*for ($i = 0; $i < 5; $i ++){
		echo "ha";
	}*/
	?>
	

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hariduslikul eesmärgil loodud leht</title>
</head>
<body>
	<h1><?php echo $myName ." " .$myFamilyName; ?>, Veebiprogrammeerimine, pealkiri</h1>
	<p>Sain sisse logimisega kodus hakkama!   </p>
	<?php 
	echo "<p>Algas PHP õppimine.</p>";
	echo "<p>Täna on ";
	echo date("d. ") .$monthNow .date(" Y") .", lehe avamise hetkel oli kell " .date("H:i:s");
	echo ", hetkel on " .$partOfDay .".</p>";
	
	?>
	<h2>Natuke vanusest</h2>
	<form method="POST">
	<label>Teie sünniaasta: </label>
	<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear; ?>" min="1900" max="2017">
	<input name="submitBirthYear" type="submit" value="Sisesta">
	</form>
	<?php
	if ($ageNotice !=""){
		echo $ageNotice;
	}
	?>
	
</body>
</html>
<?php
	//muutujad 
	$myName = "Raili";
	$myFamilyName = "Mikksaar";
	
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
	echo $partOfDay;
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
	echo date("d.m.Y") .", lehe avamise hetkel oli kell " .date("H:i:s");
	echo ", hetkel on " .$partOfDay .".</p>";
	
	?>
</body>
</html>
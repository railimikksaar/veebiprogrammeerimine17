<?php
//et pääseks ligi sessioonile ja funktsioonile
require("functions.php");

//kui pole sisseloginud, liigume login lehele
if(!isset($_SESSION["userId"])){
	header("Location: login.php");
	exit();
}
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: login.php");
	exit();
	
}
	//muutujad 
	$myName = "Raili";
	$myFamilyName = "Mikksaar";
	
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	$allFiles = array_slice (scandir($picDir), 2);
	foreach ($allFiles as $file) {
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array ($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}
	//var_dump($allFiles);
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count ($picFiles);
	$picNumber = mt_rand (0, $picFileCount - 1);
	$picFile = $picFiles[$picNumber];
	
	
	?>
	

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		<?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"]; ?>
		 veebiprogrammeerimise asjad
	</title>
</head>
<body>
	<h1><?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"]; ?></h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="usersinfo.php">Kasutajate info</a></p>
	<p><a href="userideas.php">Head mõtted</a></p>
	<img src="<?php echo $picDir .$picFile; ?>" alt="Tallinna ülikool">
</body>
</html>
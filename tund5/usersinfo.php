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
	$firstName;
	$lastName;
	
	while($stmt->fetc()){
          //siia read, mis loovad iga kasutaja kohta tabeli rea
        }
	
	
	
	?>
	

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hariduslikul eesmärgil loodud leht</title>
</head>
<body>
	<h1><?php echo $firstName ." " .$lastName; ?></h1>
	<p>Sisu pole tõsiseltvõetav </p>
	
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="?">Pealehele</a></p>
	
	<table border="1" style="border: 1px solid black; border-collapse: collapse">
	<tr>
		<th>Eesnimi</th><th>perekonnanimi</th><th>e-posti aadress</th>
	</tr>
	<tr>
		<td>Juku</td><td>Porgand</td><td>juku.porgand@aed.ee</td>
	</tr>
	<tr>
		<td>Mari</td><td>Karus</td><td>mari.karus@aed.ee</td>
	</tr>
	</table>
	
</body>
</html>
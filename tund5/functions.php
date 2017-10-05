<?php
$database = "if17_raili";
//alustame sessionni
session_start();

//logimise funktsioon
function signIn($email, $password){
	$notice ="";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT id, email, password FROM vpusers WHERE email = ?");
	$stmt->bind_param("s",$email);
	$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
	$stmt->execute();
	
	//kontrollime kasutajat
	if($stmt->fetch()){
		$hash = hash("sha512", $password);
		if($hash == $passwordFromDb){
			$notice = "Kõik korras! Logisimegi sisse!";
			//salvestame muutujaid
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			
			
			//liigume pealehele
			header("Location: main.php");
			exit();
		}else{
			$notice = "Sisestasite vale salasõna!";
		}
		}else {
		$notice = "Sellist kasutajat (" .$email .") ei ole!";
	}
	return $notice;
}


//uue kasutaja andmebaasi lisamine
function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
	//loome andmebaasi ühenduse
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
}
//sisestuse kontrollimine
	function test_input($data){
		$data = trim($data);//eemaldab lõpust tühiku, tab vms
		$data = stripslashes($data);//eemaldab"\"
		$data = htmlspecialchars($data);//eemaldab keelatud märgid
		return $data;	
	}

	/*$x=8;
	$y=5;
	echo "Esimene summa on: " .($x+$y);
	addValues();
	
	function addValues(){
		echo "Teine summa on: " .($GLOBALS["x"]+$GLOBALS["y"]);
		$a=4;
		$b=1;
		echo "Kolmas summa on: " .($a+$b);
	}
	
	echo "Neljas summa on: " .($a+$b);*/
	
?>
		
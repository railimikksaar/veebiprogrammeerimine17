<?php

$database = "if17_raili";
require("../../../config.php");

//alustame sessionni
session_start();

//logimise funktsioon
function signIn($email, $password){
	$notice ="";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT id, email, password, firstname, lastname FROM vpusers WHERE email = ?");
	$stmt->bind_param("s",$email);
	$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $nameFromDb, $lastNameFromDb);
	$stmt->execute();
	
	//kontrollime kasutajat
	if($stmt->fetch()){
		$hash = hash("sha512", $password);
		if($hash == $passwordFromDb){
			$notice = "Kõik korras! Logisimegi sisse!";
			//salvestame muutujaid
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			$_SESSION["firstName"] = $nameFromDb;
			$_SESSION["lastName"] = $lastNameFromDb;
			
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

function saveMyIdea($idea, $color){
		echo $idea;
	
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpuserideas (userid, idea, ideacolor) VALUES(?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("iss", $_SESSION["userId"], $idea, $color);
		if($stmt->execute()){
			$notice = "Mõte on salvestatud";
		}else{
			$notice = "Salvestamisel tekkis viga: " .$stmt->error;
			}
			
			
		$stmt->close();
		$mysqli->close();
		return $notice;
		
}
	
	function listIdeas(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare ("SELECT idea, ideacolor FROM vpuserideas");
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas ORDER BY id DESC"); //kõigi mõtted, uuemad ees
		$stmt = $mysqli->prepare ("SELECT id, idea, ideacolor FROM vpuserideas WHERE userid = ? AND deleted IS NULL ORDER BY id DESC"); //1 kasutaja mõtted, uuemad ees
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		$stmt->bind_result($id, $idea, $color);
		$stmt->execute();
		
		while($stmt->fetch()){
			//<p style="background-color: #ff5577">Hea mõte</p>
			//$notice .= '<p style="background-color: ' .$color .'">' .$idea ."</p> \n";
			$notice .= '<p style="background-color: ' .$color .'">' .$idea .' | <a href="edituseridea.php?id=' .$id .'">Toimeta</a>' ."</p> \n";
			//<p style="background-color: #ff5577">Huvitav mõte!</p>
			//<p style="background-color: #ff5577">Huvitav mõte! | <a href="edituseridea.php?id=34">Toimeta</a></p> näide
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function latestIdea(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea FROM vpuserideas WHERE id = (SELECT MAX(id) FROM vpuserideas WHERE deleted IS NULL)");
		echo $mysqli->error;
		$stmt->bind_result ($idea);
		$stmt->execute();
		$stmt->fetch();
			
		
		
		$stmt->close();
		$mysqli->close();
		return $idea;
		
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
		
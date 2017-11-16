<?php

	$database = "if17_raili";

	require("../../../config.php");

	

	//alustame sessiooni

	session_start();

	

	//sisselogimise funktsioon

	function signIn($email, $password){

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, email, password FROM vpusers WHERE email = ?");

		$stmt->bind_param("s", $email);

		$stmt->bind_result($id, $firstnameFromDb, $lastnameFromDb, $emailFromDb, $passwordFromDb);

		$stmt->execute();

		

		//kontrollime vastavust

		if ($stmt->fetch()){

			$hash = hash("sha512", $password);

			if ($hash == $passwordFromDb){

				$notice = "Logisite sisse!";

				

				//Määran sessiooni muutujad

				$_SESSION["userId"] = $id;

				$_SESSION["firstname"] = $firstnameFromDb;

				$_SESSION["lastname"] = $lastnameFromDb;

				$_SESSION["userEmail"] = $emailFromDb;

				

				//liigume pealehele

				header("Location: main.php");

				exit();

			} else {

				$notice = "Sisestasite vale salasõna!";

			}

		} else {

			$notice = "Sellist kasutajat (" .$email .") ei ole!";

		}

		return $notice;

	}

	

	//uue kasutaja andmebaasi lisamine

	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){

		//loome andmebaasiühenduse

		

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

	

	function saveIdea($idea, $color){

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO vpuserideas (userid, idea, ideacolor) VALUES (?, ?, ?)");

		echo $mysqli->error;

		$stmt->bind_param("iss", $_SESSION["userId"], $idea, $color);

		if($stmt->execute()){

			$notice = "Mõte on salvestatud!";

		} else {

			$notice = "Salvestamisel tekkis viga: " .$stmt->error;

		}

			

		$stmt->close();

		$mysqli->close();

		return $notice;

	}

	

	function listIdeas(){

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp1userideas");

		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vp1userideas ORDER BY id DESC");

		$stmt = $mysqli->prepare("SELECT id, idea, ideacolor FROM vpuserideas WHERE userid = ? AND deleted IS NULL ORDER BY id DESC");

		echo $mysqli->error;

		$stmt->bind_param("i", $_SESSION["userId"]);

		$stmt->bind_result($id, $idea, $color);

		$stmt->execute();

		

		while($stmt->fetch()){

			//<p style="background-color: #ff5577">Hea mõte</p>

			//$notice .= '<p style="background-color: ' .$color .'">' .$idea ."</p> \n";

			$notice .= '<p style="background-color: ' .$color .'">' .$idea .' | <a href="edituseridea.php?id=' .$id .'">Toimeta</a>' ."</p> \n";

			//<p style="background-color: #ffff80">Kõike saab paremini seletada!</p>

//<p style="background-color: #ffff80">Kõike saab paremini seletada! | <a href="edituseridea.php?id=34">Toimeta</a></p>

		}

		

		$stmt->close();

		$mysqli->close();

		return $notice;

	}

	

	function latestIdea(){

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT idea FROM vpuserideas WHERE id = (SELECT MAX(id) FROM vpuserideas WHERE deleted IS NULL)");

		echo $mysqli->error;

		$stmt->bind_result($idea);

		$stmt->execute();

		$stmt->fetch();

		

		$stmt->close();

		$mysqli->close();

		return $idea;

	}

	

	//sisestuse kontrollimine

	function test_input($data){

		$data = trim($data);//eemaldab lõpust tühiku, tab vms

		$data = stripslashes($data);//eemaldab "\"

		$data = htmlspecialchars($data);//eemaldab keelatud märgid

		return $data;

	}

	

	/*$x = 8;

	$y = 5;

	echo "Esimene summa on: " .($x + $y);

	addValues();

	

	function addValues(){

		echo "Teine summa on: " .($GLOBALS["x"] + $GLOBALS["y"]);

		$a = 4;

		$b = 1;

		echo "Kolmas summa on: " .($a + $b);

	}

	

	echo "Neljas summa on: " .($a + $b);*/

?>
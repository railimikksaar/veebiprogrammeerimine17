<?php
	require("functions.php");
	$notice="";
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	//kui soovitakse ideed salvestada
	if(isset($_POST["ideaBtn"])){
		//echo $_POST["ideaColor"];
		if(isset($_POST["userIdea"]) and isset($_POST["ideaColor"]) and !empty($_POST["userIdea"]) and !empty($_POST["ideaColor"])){
			$myIdea = test_input($_POST["userIdea"]);
			$notice = saveMyIdea($myIdea, $_POST["ideaColor"]);
		}
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Raili Mikksaar veebiprogrammeerimine</title>
</head>
<body>
	<h1>Ideed</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>Head mõtted</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Hea mõte: </label>
		<input name="userIdea" type="text">
		<br>
		<label>Mõttega seostuv värv: </label>
		<input name="ideaColor" type="color">
		<br>
		<input name="ideaBtn" type="submit" value="Salvesta mõte!"><span><?php echo $notice; ?></span>
	</form>
	<hr>
	<h2>Palju toredaid mõtteid</h2>
	<div style="width: 40%">
		<?php echo listIdeas(); ?>
	</div>
	
	
</body>
</html>


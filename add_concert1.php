<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}

if(isset($_POST['sent'])){
	if(empty($_POST['comps'])){
		echo "<br>Nezvolili jste zadne skladby!<br><a href=\"add_concert.php\">Zpet vyber skladeb</a><br>";
		die();
	}
	else{		
		$_SESSION['compositions'] = $_POST['comps'];
	}
}

?>
<html>
<title>
Pridat koncert
</title>

<body>

<form method="post" action="add_concert2.php">
	Vyberte datum koncertu: <br>
	<input type="text" value="2015.1.1" name="date">*<br><br>
	<input type="submit" name="sent" value="Pokracovat">
</form>

<a href="index.php">Zpet na hlavni stranu</a>

</body>
</html>
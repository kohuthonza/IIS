<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if($_SESSION['role'] != 1){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>



<html>
<title>
Pridat hudebnika
</title>

<body>

Prosim, vyplnte udaje o hudebnikovi:
<form method="post" action="add_musician.php">
	Jmeno:<br>
	<input type="text" name="name">*<br><br>
	Prijmeni:<br>
	<input type="text" name="sname">*<br><br>
	Rodne cislo:<br>
	<input type="text" name="rc">*<br><br>
	Telefon:<br>
	<input type="text" name="phone">*<br><br>
	Email:<br>
	<input type="text" name="email">*<br><br>
	Mesto (adresa):<br>
	<input type="text" name="town">*<br><br>
	<input type="submit" value="Pridat hudebnika">
</form>

<br> Udaje oznacene * jsou povinne <br><br>
<a href="index.php">Zpet na hlavni stranu</a><br>
<a href="personel.php">Zpet na hudebniky</a>
<br>

</body>
</html>


<?php


if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');

	$name = htmlspecialchars($_POST['name']);
	$sname = htmlspecialchars($_POST['sname']);
	$rc = htmlspecialchars($_POST['rc']);

	$phone = htmlspecialchars($_POST['phone']);
	$email = htmlspecialchars($_POST['email']);
	$town = htmlspecialchars($_POST['town']);
	
			
	$db = $_SESSION['db'];

	$cmmnd = "insert into musicians (Name, SName, RC, Phone, Email, Town) values ('$name', '$sname', '$rc', '$phone', '$email', '$town')";
			
	if(mysql_query($cmmnd, $db)){
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
}

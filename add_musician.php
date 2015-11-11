<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if($_SESSION['role'] != 1){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 1<br>
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
	
	Umi smycec:<br>
	<input type="text" name="sm">*<br><br>
	Umi dech:<br>
	<input type="text" name="d">*<br><br>
	Umi strunny:<br>
	<input type="text" name="str">*<br><br>
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
	
	$str = htmlspecialchars($_POST['str']);
	$d = htmlspecialchars($_POST['d']);
	$sm = htmlspecialchars($_POST['sm']);
	
	if($str != 'F' and $str != 'T')
		die("Nespravna hodnota u 'Umi strunny'! Zadejte T/F.<br><a href=\"add_musician.php\">Znovu nacist</a>");
			
	if($sm != 'F' and $sm != 'T')
		die("Nespravna hodnota u 'Umi smycec'! Zadejte T/F.<br><a href=\"add_musician.php\">Znovu nacist</a>");
			
	if($d != 'F' and $d != 'T')
		die("Nespravna hodnota u 'Umi dech'! Zadejte T/F.<br><a href=\"add_musician.php\">Znovu nacist</a>");
			
	$db = $_SESSION['db'];

	$cmmnd = "insert into musicians (Name, SName, RC, Phone, Email, Town, Sm, D, Str) values ('$name', '$sname', '$rc', '$phone', '$email', '$town', '$sm', '$d', '$str')";
			
	if(mysql_query($cmmnd, $db)){
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
}

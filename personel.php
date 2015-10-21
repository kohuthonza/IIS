<html>
<head>

<title>Seznam hudebniku</title>
</head>
<body>

Zaznamy od lidech:<br>

<a href="index.php">Zpet na hlavni stranu</a>
<br>
<a href="index.php">Pridat hudebnika</a>

<?php
session_start();
if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}
if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}

$SQL = "select * from musicians";

#nastavit tak, aby nahore prvni 2cm byly ovladaci prvky (zpet na hl. stranu,
#pridat hudebnika, pridat formular, ktery ubde fungovat jako filtr pro tabulku


?>




</body>
</html>

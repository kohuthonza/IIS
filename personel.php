<html>
<head>

<title>Seznam hudebniku</title>
</head>
<body>

Zaznamy o lidech:<br>

<a href="index.php">Zpet na hlavni stranu</a>
<br>
<a href="index.php">Pridat hudebnika</a>
<table border=1>
		<tr>
		<th>Jmeno</th>
		<th>Rodne cislo</th>
		<th>Adresa</th>
		<th>Telefon</th>
		<th>Email</th>
		</tr>
<form method=post action=personel.php>
	<tr>
	<td><input type=text name=Fname value=> </td>
	<td><input type=text name=Frc value=> </td>
	<td><input type=text name=Faddr value=> </td>
	<td><input type=text name=Fphone value=> </td>
	<td><input type=text name=Femail value=> </td>
	<td><input type=submit name=filter value=Filtrovat></td>
</form>
</table>

	<br><br>
<?php
session_save_path("./tmp");
session_start();
include_once('functions.php');

if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}
if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}

if(!db_connect())
	die("Nepodarilo se pripojit k databazi!");

//if the page recieved a command to update a specific row of the table
if(isset($_POST['update'])){
	$updateQry = "update musicians set Name='$_POST[name]', Address='$_POST[addr]', RC='$_POST[rc]', Phone='$_POST[phone]', Email='$_POST[email]' where RC='$_POST[hidden]'";

};


$SQL = "select * from musicians";
$retval = mysql_query($SQL, $_SESSION['db']);

echo "<table border=1>
		<tr>
		<th>Jmeno</th>
		<th>Rodne cislo</th>
		<th>Adresa</th>
		<th>Telefon</th>
		<th>Email</th>
		</tr>";

while($row = mysql_fetch_array($retval)){
	echo "<form method=post action=personel.php>";
	echo "<tr>";
	echo "<td>" . "<input type=text name=name value=" . $row['Name'] . " </td>";
	echo "<td>" . "<input type=text name=rc value=" . $row['RC'] . " </td>";
	echo "<td>" . "<input type=text name=addr value=" . $row['Address'] . " </td>";
	echo "<td>" . "<input type=text name=phone value=" . $row['Phone'] . " </td>";
	echo "<td>" . "<input type=text name=email value=" . $row['Email'] . " </td>";
	echo "<td>" . "<input type=hidden name=hidden value=" . $row['RC'] . " </td>";
	echo "<td>" . "<input type=submit name=update value=Upravit" . " </td>";
	echo "</form>";
}
echo "</table>";
mysql_close($_SESSION['db']);


#nastavit tak, aby nahore prvni 2cm byly ovladaci prvky (zpet na hl. stranu,
#pridat hudebnika, pridat formular, ktery ubde fungovat jako filtr pro tabulku


?>




</body>
</html>

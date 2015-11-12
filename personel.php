<?php
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}

if($_SESSION['role'] != 1){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 1<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>


<html>
<head>

<title>Seznam hudebniku</title>
</head>
<body>

Zaznamy o lidech:<br>

<a href="index.php">Zpet na hlavni stranu</a>
<br>
<a href="add_musician.php">Pridat hudebnika</a>
<table border=1>
		<tr>	
		<th>Jmeno</th>
		<th>Prijmeni</th>
		<th>Rodne cislo</th>
		<th>Mesto</th>
		<th>Telefon</th>
		<th>Email</th>
		<th><form method=post action=personel.php><input type=submit name=clear value=Vycistit></form></td>
		</tr>
<form method=post action=personel.php>
	<tr>
	<td><input type=text name=Fname value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fname'])){ echo $_POST['Fname'];}?>'> </td>
	<td><input type=text name=Fsname value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fsname'])){ echo $_POST['Fsname'];}?>'> </td>
	<td><input type=text name=Frc value=<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Frc'])){ echo $_POST['Frc'];}?>> </td>
	<td><input type=text name=Ftown value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Ftown'])){ echo $_POST['Ftown'];}?>'> </td>
	<td><input type=text name=Fphone value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fphone'])){ echo $_POST['Fphone'];}?>'> </td>
	<td><input type=text name=Femail value=<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Femail'])){ echo $_POST['Femail'];}?>> </td>
	<td><input type=submit name=filter value=Filtrovat></td>
</form>
</table>

	<br><br>
<?php

if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}

if(!db_connect())
	die("Nepodarilo se pripojit k databazi!");

//if the page recieved a command to update a specific row of the table
if(isset($_POST['updatebtn'])){
	if($_POST['sm'] != 'F' and $_POST['sm'] != 'T')
		die("Nespravne zadana hodnota 'umi smycec'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	if($_POST['d'] != 'F' and $_POST['d'] != 'T')
		die("Nespravne zadana hodnota 'umi dech'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	if($_POST['str'] != 'F' and $_POST['str'] != 'T')
		die("Nespravne zadana hodnota 'umi strunny'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	$updateQry = "update musicians set Name='$_POST[name]', SName='$_POST[Sname]', Town='$_POST[town]', RC='$_POST[rc]', Phone='$_POST[phone]', Email='$_POST[email]', Sm='$_POST[sm]', D='$_POST[d]', Str='$_POST[str]' where RC='$_POST[hidden]'";

	mysql_query($updateQry, $_SESSION['db']);
};

if(isset($_POST['deletebtn'])){
	$deleteQry = "delete from musicians where RC='$_POST[hidden]'";
	mysql_query($deleteQry, $_SESSION['db']);
};

$SQL = "select * from musicians";

if(isset($_POST['filter'])){
	$where = "where";
	if(!empty($_POST['Fname'])){
		$SQL = $SQL . " $where Name='$_POST[Fname]'";
		$where = " and";
	}
	if(!empty($_POST['Fsname'])){
		$SQL = $SQL . " $where SName='$_POST[Fsname]'";
		$where = " and";
	}
	if(!empty($_POST['Frc'])){
		$SQL = $SQL . " $where RC='$_POST[Frc]'";
		$where = " and";			
	}
	if(!empty($_POST['Ftown'])){
		$SQL = $SQL . " $where Town='$_POST[Ftown]'";
		$where = " and";
	}
	if(!empty($_POST['Fphone'])){
		$SQL = $SQL . " $where Phone='$_POST[Fphone]'";
		$where = " and";
	}
	if(!empty($_POST['Femail'])){
		$SQL = $SQL . " $where Email='$_POST[Femail]'";
		$where = " and";
	}
	
};
#echo $SQL;

$retval = mysql_query($SQL, $_SESSION['db']);

echo "<table border=1>
		<tr>
		<th>Jmeno</th>
		<th>Prijmeni</th>
		<th>Rodne cislo</th>
		<th>Mesto</th>
		<th>Telefon</th>
		<th>Email</th>
		<th>Umi smycec</th>
		<th>Umi dech</th>
		<th>Umi strunny</th>
		</tr>";

while($row = mysql_fetch_array($retval)){
	echo "<form method=post action=personel.php>";
	echo "<tr>";
	echo "<td>" . "<input type=text name=name value='" . $row['Name'] . "' </td>";
	echo "<td>" . "<input type=text name=Sname value='" . $row['SName'] . "' </td>";
	echo "<td>" . "<input type=text name=rc value=" . $row['RC'] . " </td>";
	echo "<td>" . "<input type=text name=town value='" . $row['Town'] . "' </td>";
	echo "<td>" . "<input type=text name=phone value='" . $row['Phone'] . "' </td>";
	echo "<td>" . "<input type=text name=email value=" . $row['Email'] . " </td>";	
	echo "<td>" . "<input type=text name=sm value=" . $row['Sm'] . " </td>";
	echo "<td>" . "<input type=text name=d value=" . $row['D'] . " </td>";
	echo "<td>" . "<input type=text name=str value=" . $row['Str'] . " </td>";
	echo "<td>" . "<input type=hidden name=hidden value=" . $row['RC'] . " </td>";
	echo "<td>" . "<input type=submit name=updatebtn value=Upravit" . " </td>";
	echo "<td>" . "<input type=submit name=deletebtn value=Odstranit" . " </td>";
	echo "</tr>";
	echo "</form>";
}
echo "</table>";
mysql_close($_SESSION['db']);

?>




</body>
</html>

<?php
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}

if($_SESSION['role'] != 3){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>


<html>
<head>

<title>Seznam skladeb</title>
</head>
<body>

Zaznamy o skladbach:<br>

<a href="index.php">Zpet na hlavni stranu</a>
<br>
<a href="add_comp.php">Pridat skladbu</a>
<table border=1>
		<tr>	
		<th>Nazev</th>
		<th>Tonina</th>
		<th><form method=post action=comps.php><input type=submit name=clear value=Vycistit></form></td>
		</tr>
<form method=post action=comps.php>
	<tr>
	<td><input type=text name=Fname value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fname'])){ echo $_POST['Fname'];}?>'> </td>
	<td><input type=text name=Fkey value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fkey'])){ echo $_POST['Fkey'];}?>'> </td>
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
	$updateQry = "update compositions set Name='$_POST[name]', Comp_Key='$_POST[key]', Sm='$_POST[sm]', D='$_POST[d]', Str='$_POST[str]' where ID=$_POST[hidden]";

	#echo $updateQry;
	mysql_query($updateQry, $_SESSION['db']);
	#echo mysql_error($_SESSION['db']);
};

if(isset($_POST['deletebtn'])){
	$deleteQry = "delete from compositions where ID='$_POST[hidden]'";
	mysql_query($deleteQry, $_SESSION['db']);
};

$SQL = "select * from compositions";

if(isset($_POST['filter'])){
	$where = "where";
	if(!empty($_POST['Fname'])){
		$SQL = $SQL . " $where Name='$_POST[Fname]'";
		$where = " and";
	}
	if(!empty($_POST['Fkey'])){
		$SQL = $SQL . " $where Comp_Key='$_POST[Fkey]'";
		$where = " and";
	}
	
};
#echo $SQL;

$retval = mysql_query($SQL, $_SESSION['db']);

echo "<table border=1>
		<tr>
		<th>Nazev</th>
		<th>Tonina</th>		
		<th># Smyccu</th>
		<th># Dechu</th>
		<th># Strunnych</th>
		</tr>";

while($row = mysql_fetch_array($retval)){
	echo "<form method=post action=comps.php>";
	echo "<tr>";
	echo "<td>" . "<input type=text name=name value='" . $row['Name'] . "' </td>";
	echo "<td>" . "<input type=text name=key value='" . $row['Comp_Key'] . "' </td>";
	echo "<td>" . "<input type=text name=sm value='" . $row['Sm'] . "' </td>";
	echo "<td>" . "<input type=text name=d value='" . $row['D'] . "' </td>";
	echo "<td>" . "<input type=text name=str value='" . $row['Str'] . "' </td>";
	echo "<td>" . "<input type=hidden name=hidden value=" . $row['ID'] . " </td>";
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
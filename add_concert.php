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
?>
<html>
<title>
Pridat hudebnika
</title>

<body>


Prosim, vyplnte udaje o koncertu:
<form method="post" action="add_concert.php">
	Nazev koncertu:<br>
	<input type="text" name="Cname">*<br><br>
	Datum:<br>
	<input type="text" name="Cdate">*<br><br>
	Vyberte hudebniky: <br>
	<select name="musics[]" multiple>
	
<?php
if(!db_connect())
	die('Nepodarilo se pripojit k databazi');

$SQL = "select Name, SName, RC from musicians";
$retval = mysql_query($SQL, $_SESSION['db']);

while($row = mysql_fetch_array($retval)){
	echo "<option value=" . $row['RC'] . ">" . $row['Name'] . " " . $row['SName'] . "</option>";
	//echo "<option value=1>text</option>";
}

echo "</select><br><br>Vyberte skladby:<br>";
echo "<select name=\"comps[]\" multiple>";

$SQL2 = "select ID, Name from compositions";
$retval2 = mysql_query($SQL2, $_SESSION['db']);

while($row2 = mysql_fetch_array($retval2)){
	echo "<option value=" . $row2['ID'] . ">" . $row2['Name'] . "</option>";
}


mysql_close($_SESSION['db']);	
?>
	</select>
	<br>
	<input type="submit" name="sent" value="Pridat koncert">

<?php
if(!isset($_POST['sent']))
	die();

if(empty($_POST['Cname']))
	die("<br>prazne jmeno<br>");


if(!db_connect())
	die('Nepodarilo se pripojit k databazi');


echo "<br>nazev koncertu:<br>" . $_POST['Cname'] . "<br>datum:<br>" . $_POST['Cdate'];


$cmmnd = "insert into concerts (ID, Name, Date) values (NULL, '$_POST[Cname]', '1994.5.4')";
mysql_query($cmmnd, $_SESSION['db']);

//echo "posledni zaznam:" . mysql_insert_id();

//tady pripojit k databazi
//skontrolovat vstup
//parsovat datum
//nahrat do SQL prikazu
//ulozit do DB
//ukoncit spojeni

$idx = mysql_insert_id();


echo "pridavam hudebniky s RC:<br>";
foreach ($_POST['musics'] as $selectedOption){
	echo $selectedOption."<br>";
	$cmmnd = "insert into _concerts_M (ID, RC) values ('$idx', '$selectedOption')";
	mysql_query($cmmnd, $_SESSION['db']);
}
    
	
echo "pridavam skladby s ID:<br>";	
foreach ($_POST['comps'] as $selectedOption){
	echo $selectedOption."<br>";
	$cmmnd = "insert into _concerts_C (ID, ID_comp) values ('$idx', '$selectedOption')";
	mysql_query($cmmnd, $_SESSION['db']);
}

mysql_close($_SESSION['db']);	

?>

</form>


</body>
</html>

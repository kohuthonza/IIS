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
Pridat koncert
</title>

<body>


Prosim, vyplnte nasledujici fomrulare pro pridani koncertu:
<br><br>
<form method="post" action="add_concert1.php">
	Vyberte skladby pozadovane pro koncert: <br>
	<select name="musics[]" multiple>
	
<?php
if(!db_connect())
	die('Nepodarilo se pripojit k databazi');

$SQL2 = "select ID, Name from compositions";
$retval2 = mysql_query($SQL2, $_SESSION['db']);

while($row2 = mysql_fetch_array($retval2)){
	echo "<option value=" . $row2['ID'] . ">" . $row2['Name'] . "</option>";
}

mysql_close($_SESSION['db']);	
?>
	</select>
	<br>
	<input type="submit" name="sent" value="Pokracovat">

<?php
if(!isset($_POST['sent']))
	die();

//$cmmnd = "insert into concerts (ID, Name, Date) values (NULL, '$_POST[Cname]', '1994.5.4')";
//mysql_query($cmmnd, $_SESSION['db']);

//echo "posledni zaznam:" . mysql_insert_id();

//tady pripojit k databazi
//skontrolovat vstup
//parsovat datum
//nahrat do SQL prikazu
//ulozit do DB
//ukoncit spojeni

//$idx = mysql_insert_id();
	
echo "pridavam skladby s ID:<br>";	
foreach ($_POST['comps'] as $selectedOption){
	echo $selectedOption."<br>";
	$cmmnd = "insert into _concerts_C (ID, ID_comp) values ('$idx', '$selectedOption')";
	//mysql_query($cmmnd, $_SESSION['db']);
}

mysql_close($_SESSION['db']);	

?>

</form>


</body>
</html>

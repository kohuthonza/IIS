<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}
if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("<html>
		<title>Pridat koncert</title><body>
		Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
		</body></html>
		");
}
?>
<html>
<title>
Pridat koncert
</title>

<body>


Prosim, vyplnte nasledujici formulare pro pridani koncertu:
<br><br>
<form method="post" action="add_concert1.php">
	Zadejte nazev koncertu:<br>
	<input type="text" name="Cname"><br>
	Vyberte skladby pozadovane pro koncert: <br>
	<select name="comps[]" multiple>
	
<?php
if(!db_connect())
	die('Nepodarilo se pripojit k databazi');

$SQL2 = "select ID, Name from compositions";
$retval2 = mysql_query($SQL2, $_SESSION['db']);

while($row2 = mysql_fetch_array($retval2)){
	echo "<option value=" . $row2['ID'] . ">" . $row2['Name'] . "</option>";
}

$_SESSION['concert_added'] = false;

mysql_close($_SESSION['db']);	
?>
	</select>
	<br>
	<input type="submit" name="sent" value="Pokracovat">
</form>

<a href="index.php">Zpet na hlavni stranu</a>
</body>
</html>

<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if($_SESSION['role'] != 3){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>

<html>
<title>
Pridat skladbu
</title>

<body>

Prosim, vyplnte udaje o skladbe:
<form method="post" action="add_comp.php">
	Nazev skladby:<br>
	<input type="text" name="name">*<br><br>
	Tonina:<br>
	<input type="text" name="key">*<br><br>
	Pocet smyccovych nastroju:<br>
	<input type="text" name="sm">*<br><br>
	Pocet dechovych nastroju:<br>
	<input type="text" name="d">*<br><br>
	Pocet strunnych nastroju:<br>
	<input type="text" name="str">*<br><br>
	<input type="submit" value="Pridat skladbu">
</form>

<br> Udaje oznacene * jsou povinne <br><br>
<a href="index.php">Zpet na hlavni stranu</a><br>
<a href="comps.php">Zpet na skladby</a>
<br>

</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');

	$name = htmlspecialchars($_POST['name']);
	$key = htmlspecialchars($_POST['key']);
	$sm = htmlspecialchars($_POST['sm']);
	$d = htmlspecialchars($_POST['d']);
	$str = htmlspecialchars($_POST['str']);

			
	$db = $_SESSION['db'];

	$cmmnd = "insert into compositions (ID, Name, Comp_Key, Sm, D, Str) values (NULL, '$name', '$key', '$sm', '$d', '$str')";
			
	if(mysql_query($cmmnd, $db)){
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
}

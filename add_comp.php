<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}
if($_SESSION['role'] != 3){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 3<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>

<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<title>
Přidat skladbu
</title>
</head>
<body>



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

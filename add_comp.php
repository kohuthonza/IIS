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

<style>
body {background-image:url(http://www.stud.fit.vutbr.cz/~xkohut08/profile_comps_background.png);
	  background-repeat: no-repeat;
	  background-position: 125% -58px;}
</style>


<title>
Přidat skladbu
</title>


</head>
<body>


<form method="post" action="add_comp.php">



<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<div class="form-group row">
			<label for="comp_name" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Název skladby</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="comp_name" placeholder="Název skladby" name="name" required>
			</div>
			<label for="comp_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="key" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Tónina</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="key" placeholder="Tónina" name="key" required>
			</div>
			<label for="key" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="takt" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Takt</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="takt" placeholder="Takt" name="takt" required>
			</div>
			<label for="takt" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="temp" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Tempo</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="temp" placeholder="Tempo" name="tempo" required>
			</div>
			<label for="temp" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="sm" class="col-lg-3 control-label input-lg text-right">Počet smyčcových nástrojů</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="sm" placeholder="Počet smyčcových nástrojů" name="sm" required>
			</div>
			<label for="sm" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="d" class="col-lg-3 control-label input-lg text-right">Počet dechových nástrojů</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="d" placeholder="Počet dechových nástrojů" name="d" required>
			</div>
			<label for="d" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="str" class="col-lg-3 control-label input-lg text-right">Počet strunných nástrojů</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="str" placeholder="Počet dechových nástrojů" name="str" required>
			</div>
			<label for="str" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit">Přidat skladbu</button>
			</div>
			<div class="col-lg-2">
			    <span class="pull-right">
				<a class="btn btn-warning btn-lg" href="comps.php" role="button">Zpět na skladby</a>
				</span>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Všechny údaje označené * jsou povinné</strong>
			</div>
		</div>

</form>


</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');

	$name = htmlspecialchars($_POST['name']);
	$key = htmlspecialchars($_POST['key']);
	$takt = htmlspecialchars($_POST['takt']);
	$tempo = htmlspecialchars($_POST['tempo']);
	$sm = htmlspecialchars($_POST['sm']);
	$d = htmlspecialchars($_POST['d']);
	$str = htmlspecialchars($_POST['str']);

			
	$db = $_SESSION['db'];

	$cmmnd = "insert into compositions (ID, Name, Comp_Key, Takt, Tempo, Sm, D, Str) values (NULL, '$name', '$key', '$takt', '$tempo', '$sm', '$d', '$str')";
	//echo $cmmnd;	
	if(mysql_query($cmmnd, $db)){
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
}

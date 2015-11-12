<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
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


<head>
<html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<style>
body {background-image:url(http://www.stud.fit.vutbr.cz/~xkohut08/profile_personel_background.jpg);
	  background-repeat: no-repeat;
	  background-position: 117% 10px;}
</style>

<title>
Přidat hudebníka
</title>



</head>

<body>


<form method="post" action="add_musician.php">

	<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<div class="form-group row">
			<label for="first_name" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Jméno</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="first_name" placeholder="Jméno" name="name" required>
			</div>
			<label for="first_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="second_name" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Příjmení</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="second_name" placeholder="Příjmení" name="sname" required>
			</div>
			<label for="second_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="rc" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Rodné číslo</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="rc" placeholder="Rodné číslo" name="rc" required>
			</div>
			<label for="rc" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="tel" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Telefon</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="tel" placeholder="Telefon" name="phone" required>
			</div>
			<label for="tel" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="email" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">E-mail</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="email" placeholder="E-mail" name="email" required>
			</div>
			<label for="email" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="town" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Město (adresa)</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="town" placeholder="Město" name="town" required>
			</div>
			<label for="email" class="control-label input-lg text-right">*</label>
		</div>
		<h3>
		<div class="form-group row">
			<label class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Hraje na nástroje</label>
			<div class="col-lg-4">
			<div class="checkbox">
				<label class="checkbox-inline"><input type="checkbox" name="sm" value="">Smyčcové</label>
				<label class="checkbox-inline"><input type="checkbox" name="d" value="">Dechové</label>
				<label class="checkbox-inline"><input type="checkbox" name="str" value="">Strunné</label>
			</div>
			</div>
		</div>
		</h3>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit">Přidat hudebníka</button>
			</div>
			<div class="col-lg-2">
			    <span class="pull-right">
				<a class="btn btn-warning btn-lg" href="personel.php" role="button">Zpět na hudebníky</a>
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
	$sname = htmlspecialchars($_POST['sname']);
	$rc = htmlspecialchars($_POST['rc']);

	$phone = htmlspecialchars($_POST['phone']);
	$email = htmlspecialchars($_POST['email']);
	$town = htmlspecialchars($_POST['town']);
	
	$str = 'F';
	$d = 'F';
	$sm = 'F';	
	
	if(isset($_POST['str']))
		$str = 'T';

	if(isset($_POST['sm']))
		$sm = 'T';

	if(isset($_POST['d']))
		$d = 'T';	
			
	if(strlen($rc) != 11)
		die("Nespravna delka rodneho cisla!");
	
	$db = $_SESSION['db'];

	$cmmnd = "insert into musicians (Name, SName, RC, Phone, Email, Town, Sm, D, Str) values ('$name', '$sname', '$rc', '$phone', '$email', '$town', '$sm', '$d', '$str')";
			
	if(mysql_query($cmmnd, $db)){
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
}

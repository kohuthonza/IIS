<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
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
				<label class="checkbox-inline"><input type="checkbox" value="">Smyčcové</label>
				<label class="checkbox-inline"><input type="checkbox" value="">Dechové</label>
				<label class="checkbox-inline"><input type="checkbox" value="">Strunné</label>
			</div>
			</div>
			<label class="control-label input-lg text-left">*</label>
			</label>
		</div>
		</h3>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit">Přidat hudebníka</button>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Všechny údaje označené * jsou povinné</strong>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-2">
				<a class="btn btn-warning btn-lg" href="index.php" role="button">Zpět na hlavní stranu</a>
			</div>
			<div class="col-lg-2">
				<a class="btn btn-warning btn-lg" href="personel.php" role="button">Zpět na hudebníky</a>
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
	
	$str = htmlspecialchars($_POST['str']);
	$d = htmlspecialchars($_POST['d']);
	$sm = htmlspecialchars($_POST['sm']);
	
	if($str != 'F' and $str != 'T')
		die("Nespravna hodnota u 'Umi strunny'! Zadejte T/F.");
			
	if($sm != 'F' and $sm != 'T')
		die("Nespravna hodnota u 'Umi smycec'! Zadejte T/F.");
			
	if($d != 'F' and $d != 'T')
		die("Nespravna hodnota u 'Umi dech'! Zadejte T/F.");
			
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

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

<html>
<head>


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

<?php


if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if (!$_SESSION['musician_added']){
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
		$_SESSION['musician_added'] = true;
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
	}
}
?>

<form method="post" action="add_musician.php">

	<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<?php
		$_SESSION['musician_added'] = isset($_POST['name']) ? $_SESSION['musician_added'] : false;
		$_SESSION['musician_added'] = isset($_SESSION['musician_added']) ? $_SESSION['musician_added'] : false;
		if ($_SESSION['musician_added']){
			
			echo"<div class=\"form-group row\">
				<div class=\"col-lg-5 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h1>
				<strong>Hudebník přidán</strong>
				</h1>
				</span>
				</div>
				<div class=\"form-group row\">
				&nbsp;
				</div>
				</div>";
		}
		?>
		
		
		
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Jméno:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['name'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"first_name\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Jméno</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"first_name\" placeholder=\"Jméno\" name=\"name\" required>
				</div>
				<label for=\"first_name\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Příjmení:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['sname'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"second_name\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Příjmení</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"second_name\" placeholder=\"Příjmení\" name=\"sname\" required>
				</div>
				<label for=\"second_name\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
		
			
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Rodné číslo:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['rc'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"rc\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Rodné číslo</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"rc\" placeholder=\"Rodné číslo\" name=\"rc\" required>
				</div>
				<label for=\"rc\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Telefon:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['phone'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"tel\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Telefon</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"tel\" placeholder=\"Telefon\" name=\"phone\" required>
				</div>
				<label for=\"tel\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>E-mail:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['email'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"email\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">E-mail</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"email\" placeholder=\"E-mail\" name=\"email\" required>
				</div>
				<label for=\"email\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Město:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['town'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"town\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Město (adresa)</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"town\" placeholder=\"Město\" name=\"town\" required>
				</div>
				<label for=\"email\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			?>
		
			
		</div>
		
		
		<?php 
			if ($_SESSION['musician_added']){
				echo"
				<div class=\"form-group row\">
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Hraje na nástroje:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
				
					if(isset($_POST['sm'])){
						echo "Smyčcové ";
					}
					if(isset($_POST['d'])){
						echo "Dechové ";
					}
					if(isset($_POST['str'])){
						echo "Strunné";
					}
				
				echo
				"</strong></h4></div></div>";
					
			}
			else{
				echo"
				<h3>
				<div class=\"form-group row\">
				<label class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Hraje na nástroje</label>
				<div class=\"col-lg-4\">
				<div class=\"checkbox\">
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"sm\" value=\"\">Smyčcové</label>
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"d\" value=\"\">Dechové</label>
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"str\" value=\"\">Strunné</label>
				</div>
				</div>
				</div>
				</h3>";
			}
			
			?>
		
		
		<div class="form-group row">
		
			<?php 
			if (!$_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-3\">
				<button class=\"btn btn-success btn-lg\" type=\"submit\">Přidat hudebníka</button>
				</div>
				<div class=\"col-lg-2\">
			    <span class=\"pull-right\">
				<a class=\"btn btn-warning btn-lg\" href=\"personel.php\" role=\"button\">Zpět na hudebníky</a>
				</span>
				</div>";
					
			}
			else{
				echo"
				<div class=\"col-lg-2 col-lg-offset-2\">
					<span class=\"pull-right\">
					<a class=\"btn btn-default btn-lg\" href=\"personel.php\" role=\"button\">Zpět na hudebníky</a>
					</span>
				</div>
				<div class=\"col-lg-2 col-lg-offset-1\">
					<a class=\"btn btn-default btn-lg\" href=\"add_musician.php\" role=\"button\">Přidat dalšího hudebníka</a>
				</div>";
			}
			?>
		
		</div>
		<div class="form-group row">
			<?php 
			if (!$_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-4 col-lg-offset-3\">
					<strong>Všechny údaje označené * jsou povinné</strong>
				</div>";
					
			}
			?>
		</div>






</form>

</body>
</html>



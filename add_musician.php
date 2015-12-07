<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}
if(time() - $_SESSION['timestamp'] > $_SESSION['timeout']) { //subtract new timestamp from the old one
	unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
	unset($_SESSION['logged']);
	logout_msg();
	//header('Location: index.php'); //redirect to index.php
	exit;
} else {
	$_SESSION['timestamp'] = time(); //set new timestamp
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
body {background-image:url(./profile_personel_background.jpg);
	  background-repeat: no-repeat;
	  background-position: 117% 10px;}
</style>

<title>
Přidat hudebníka
</title>



</head>

<body>
<form method="post" action="add_musician.php">
<?php


if($_SERVER['REQUEST_METHOD'] == 'POST'){


	if(isset($_POST['return'])){
		$_SESSION['ret'] = true;
	}
	else{
		$_SESSION['ret'] = false;
	}


	if (isset($_POST['name'])){
		$_SESSION['fl_name'] =  $_POST['name'];
	}
	if (isset($_POST['sname'])){
		$_SESSION['fl_sname'] =  $_POST['sname'];
	}
	if (isset($_POST['rc'])){
		$_SESSION['fl_rc'] =  $_POST['rc'];
	}
	if (isset($_POST['rc2'])){
		$_SESSION['fl_rc2'] =  $_POST['rc2'];
	}
	if (isset($_POST['phone'])){
		$_SESSION['fl_phone'] =  $_POST['phone'];
	}
	if (isset($_POST['email'])){
		$_SESSION['fl_email'] =  $_POST['email'];
	}
	if (isset($_POST['town'])){
		$_SESSION['fl_town'] =  $_POST['town'];
	}
	if (isset($_POST['str'])){
		$_SESSION['fl_str'] =  $_POST['str'];
	}
	if (isset($_POST['sm'])){
		$_SESSION['fl_sm'] =  $_POST['sm'];
	}
	if (isset($_POST['d'])){
		$_SESSION['fl_d'] =  $_POST['d'];
	}


	if (!$_SESSION['musician_added'] and !$_SESSION['ret']){
	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');

	$name = htmlspecialchars($_POST['name']);
	$sname = htmlspecialchars($_POST['sname']);
	$rc = htmlspecialchars($_POST['rc'] . "/" . $_POST['rc2']);
	$rc1 = htmlspecialchars($_POST['rc']);
	$rc2 = htmlspecialchars($_POST['rc2']);
	
	$phone = htmlspecialchars($_POST['phone']);
	$email = htmlspecialchars($_POST['email']);
	$town = htmlspecialchars($_POST['town']);
	
	$str = 'F';
	$d = 'F';
	$sm = 'F';	
	echo "ahoj";
	if(isset($_POST['str']))
		$str = 'T';

	if(isset($_POST['sm']))
		$sm = 'T';

	if(isset($_POST['d']))
		$d = 'T';	
			
	if((strlen($rc1) != 6 and strlen($rc1) != 5) or strlen($rc2) != 4){
		echo "
			
			
			<div class=\"container-fluid\">
			
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
			
			<h3><strong><p class=\"text-center\">Špatná délka rodného čísla</p></strong></h3>
		
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"col-lg-2 col-lg-offset-5\">
				<span class=\"pull-right\">
				<button class=\"btn btn btn-lg\" name=\"return\" type=\"submit\" value=\"true\">Zpět na přidání hudebníka</button>
				</span>
			</div>
			</div>
		
			</form>
			
			</body>
			</html>
			
			";

			
		
			die();
			
		
	}
	
	$db = $_SESSION['db'];

	$cmmnd = "insert into musicians (Name, SName, RC, Phone, Email, Town, Sm, D, Str) values ('$name', '$sname', '$rc', '$phone', '$email', '$town', '$sm', '$d', '$str')";
	
	if(mysql_query($cmmnd, $db)){
		$_SESSION['musician_added'] = true;
	}
	else{
		if (mysql_errno($db) == 1062) {
			echo "
			
			
			<div class=\"container-fluid\">
			
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
			
			<h3><strong><p class=\"text-center\">Hudebník s tímto rodným číslem <br> již existuje</p></strong></h3>
		
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"col-lg-2 col-lg-offset-5\">
				<span class=\"pull-right\">
				<button class=\"btn btn btn-lg\" name=\"return\" type=\"submit\" value=\"true\">Zpět na přidání hudebníka</button>
				</span>
			</div>
			
			</div>
			</form>
			</body>
			</html>
			
			
			";
			
		}
		else{
			echo "error: ", mysql_error($db);
			
		}
		die();
	}

	mysql_close($db);
	}
}
?>



	<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<?php
		$_SESSION['musician_added'] = isset($_POST['name']) ? $_SESSION['musician_added'] : false;
		$_SESSION['musician_added'] = isset($_SESSION['musician_added']) ? $_SESSION['musician_added'] : false;
		$_SESSION['filled'] = isset($_SESSION['filled']) ? $_SESSION['filled'] : false;
		$_SESSION['ret'] = isset($_SESSION['ret']) ? $_SESSION['ret'] : false;
		
		if ($_SESSION['ret']){
			$_SESSION['filled'] = false;
		}
		
		if(!$_SESSION['filled']){
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
		}
		?>
		
		
		
		<div class="form-group row">
		
			<?php
			if(!$_SESSION['filled']){
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
				<input type=\"text\" class=\"form-control input-lg\" id=\"first_name\" placeholder=\"Jméno\" name=\"name\" value=\"";
				if(isset($_SESSION['fl_name'])){ echo $_SESSION['fl_name'];} else{ echo "";}; 
				echo "\" required>
				</div>
				<label for=\"first_name\" class=\"control-label input-lg text-right\">*</label>";
				unset($_SESSION['fl_name']);
			}
			}
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
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
				<input type=\"text\" class=\"form-control input-lg\" id=\"second_name\" placeholder=\"Příjmení\" name=\"sname\" value=\"";
				if(isset($_SESSION['fl_sname'])){ echo $_SESSION['fl_sname'];} else{ echo "";}; 
				echo "\" required>
				</div>
				<label for=\"second_name\" class=\"control-label input-lg text-right\">*</label>";
				unset($_SESSION['fl_sname']);
			}
			}
			?>
		
			
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
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
					$_POST['rc'] . "/" . $_POST['rc2'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"rc\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Rodné číslo</label>
				<div class=\"col-lg-3\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"rc\" placeholder=\"Rodné číslo                                   /\" name=\"rc\" value=\"";if(isset($_SESSION['fl_rc'])){ echo $_SESSION['fl_rc'];} else{ echo "";}; echo "\" required>
				</div>
				<div class=\"col-lg-1\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"rc\" placeholder=\"\" name=\"rc2\" value=\"";
				if(isset($_SESSION['fl_rc2'])){ echo $_SESSION['fl_rc2'];} else{ echo "";}; 
				echo "\" required>
				</div>
				<label for=\"rc2\" class=\"control-label input-lg text-right\">*</label>";
				unset($_SESSION['fl_rc']);
				unset($_SESSION['fl_rc2']);
			}
			}
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
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
				<input type=\"text\" class=\"form-control input-lg\" id=\"tel\" placeholder=\"Telefon\" name=\"phone\" value=\"";
				if(isset($_SESSION['fl_phone'])){ echo $_SESSION['fl_phone'];} else{ echo "";};
				echo "\">
				</div>
				";
				unset($_SESSION['fl_phone']);
			}
			}
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
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
				<input type=\"text\" class=\"form-control input-lg\" id=\"email\" placeholder=\"E-mail\" name=\"email\" value=\"";
				if(isset($_SESSION['fl_email'])){ echo $_SESSION['fl_email'];} else{ echo "";}; 
				echo "\">
				</div>
				";
				unset($_SESSION['fl_email']);
			}
			}
			?>
		
		</div>
		<div class="form-group row">
		
			<?php
			if(!$_SESSION['filled']){			
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
				<input type=\"text\" class=\"form-control input-lg\" id=\"town\" placeholder=\"Město\" name=\"town\" value=\"";
				if(isset($_SESSION['fl_town'])){ echo $_SESSION['fl_town'];} else{ echo "";};
				echo "\">
				</div>
				";
				unset($_SESSION['fl_town']);
			}
			}
			?>
		
			
		</div>
		
		
		<?php 
			if(!$_SESSION['filled']){
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
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"sm\" value=\"\""; 
					if(isset($_SESSION['fl_sm'])){ echo " checked";} else{ echo "";}; 
					echo ">Smyčcové</label>
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"d\" value=\"\""; 
					if(isset($_SESSION['fl_d'])){ echo " checked";} else{ echo "";}; 
					echo ">Dechové</label>
					<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"str\" value=\"\""; 
					if(isset($_SESSION['fl_str'])){ echo " checked";} else{ echo "";}; 
					echo ">Strunné</label>
				</div>
				</div>
				</div>
				</h3>";
				unset($_SESSION['fl_sm']);
				unset($_SESSION['fl_d']);
				unset($_SESSION['fl_str']);
			}
			}
			?>
		
		
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
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
			}
			?>
		
		</div>
		<div class="form-group row">
			<?php 
			if(!$_SESSION['filled']){
			if (!$_SESSION['musician_added']){
				echo"
				<div class=\"col-lg-4 col-lg-offset-3\">
					<strong>Všechny údaje označené * jsou povinné</strong>
				</div>";
					
			}
			}
			?>
		</div>






</form>

</body>
</html>



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
body {background-image:url(./profile_comps_background.png);
	  background-repeat: no-repeat;
	  background-position: 125% -58px;}
</style>


<title>
Přidat skladbu
</title>


</head>
<body>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	

	if (!$_SESSION['comp_added']){
	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');

	$name = htmlspecialchars($_POST['name']);
	$key = htmlspecialchars($_POST['key']);
	$takt = htmlspecialchars($_POST['takt1'] . "/" . $_POST['takt2']);
	$tempo = htmlspecialchars($_POST['tempo']);
	$sm = isset($_POST['sm']) ? htmlspecialchars($_POST['sm']) : "0";
	$d = isset($_POST['d']) ? htmlspecialchars($_POST['d']) : "0";
	$str = isset($_POST['str']) ? htmlspecialchars($_POST['str']) : "0";

	
	$_SESSION['takt'] = $takt;
			
	$db = $_SESSION['db'];

	$cmmnd = "insert into compositions (ID, Name, Comp_Key, Takt, Tempo, Sm, D, Str) values (NULL, '$name', '$key', '$takt', '$tempo', '$sm', '$d', '$str')";
	//echo $cmmnd;	
	if(mysql_query($cmmnd, $db)){
		$_SESSION['comp_added'] = true;
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	mysql_close($db);
	}
}
?>



<form method="post" action="add_comp.php">



<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<?php
		$_SESSION['comp_added'] = isset($_POST['name']) ? $_SESSION['comp_added'] : false;
		$_SESSION['comp_added'] = isset($_SESSION['comp_added']) ? $_SESSION['comp_added'] : false;
		if ($_SESSION['comp_added']){
			
			echo"<div class=\"form-group row\">
				<div class=\"col-lg-5 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h1>
				<strong>Skladba přidána</strong>
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
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Název skladby:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['name'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"comp_name\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Název skladby</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"comp_name\" placeholder=\"Název skladby\" name=\"name\" required>
				</div>
				<label for=\"comp_name\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
			
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Tónina:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['key'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"key\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Tónina</label>
				<div class=\"col-lg-4\">
				<select required class=\"form-control\"  name=\"key\">
					<option value=\"\" disabled selected>Tónina</option>
					<option value=\"C\">C</option>
					<option value=\"C#\">C#</option>
					<option value=\"Cb\">Cb</option>
					<option value=\"D\">D</option>
					<option value=\"D#\">D#</option>
					<option value=\"Db\">Db</option>
					<option value=\"E\">E</option>
					<option value=\"E#\">E#</option>
					<option value=\"Eb\">Eb</option>
					<option value=\"F\">F</option>
					<option value=\"F#\">F#</option>
					<option value=\"Fb\">Fb</option>
					<option value=\"G\">G</option>
					<option value=\"G#\">G#</option>
					<option value=\"Gb\">Gb</option>
					<option value=\"A\">A</option>
					<option value=\"A#\">A#</option>
					<option value=\"Ab\">Ab</option>
					<option value=\"B\">B</option>
					<option value=\"B#\">B#</option>
					<option value=\"Bb\">Bb</option>
					<option value=\"H\">H</option>
					<option value=\"H#\">H#</option>
					<option value=\"Hb\">Hb</option>
				</select>
				
				</div>
				<label for=\"key\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Takt:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_SESSION['takt'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"takt\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Takt</label>
				<div class=\"col-lg-1\">
				<select required class=\"form-control\"  name=\"takt1\">
					<option value=\"\" disabled selected>N</option>";
					for ($i = 1; $i <= 20; $i++) : 
						echo "<option value=\"" . $i . "\">" . $i . "</option>";
					endfor;
				echo"	
				</select>
				</div>
				
				<div class=\"col-lg-1\">
	
				<select required class=\"form-control\"  name=\"takt2\">
					<option value=\"\" disabled selected>N</option>";
					for ($i = 1; $i <= 20; $i++) : 
						echo "<option value=\"" . $i . "\">/" . $i . "</option>";
					endfor;
				echo"	
				</select>
		
				</div>
				<div class=\"col-lg-2\">
				</div>
				<label for=\"takt\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Tempo:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['tempo'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"temp\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Tempo</label>
				<div class=\"col-lg-4\">
				<select required class=\"form-control\"  name=\"tempo\">
					<option value=\"\" disabled selected>Tempo</option>";
					for ($i = 1; $i <= 300; $i++) : 
						echo "<option value=\"" . $i . "\">" . $i . "</option>";
					endfor;
				echo"	
				</select>
				</div>
				<label for=\"temp\" class=\"control-label input-lg text-right\">*</label>";
			}
			
			
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-3\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Počet smyčcových nástrojů:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
				if (isset($_POST['sm'])){
					echo $_POST['sm'];
				}
				else{
					echo "0";
				};
				echo "</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"sm\" class=\"col-lg-3 control-label input-lg text-right\">Počet smyčcových nástrojů</label>
				<div class=\"col-lg-4\">
				<select class=\"form-control\"  name=\"sm\">
					<option value=\"\" disabled selected>Počet smyčcových nástrojů</option>";
					for ($i = 1; $i <= 500; $i++) : 
						echo "<option value=\"" . $i . "\">" . $i . "</option>";
					endfor;
				echo"	
				</select>
				</div>
				";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-3\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Počet dechových nástrojů:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
				if (isset($_POST['d'])){
					echo $_POST['d'];
				}
				else{
					echo "0";
				};
				echo "</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"d\" class=\"col-lg-3 control-label input-lg text-right\">Počet dechových nástrojů</label>
				<div class=\"col-lg-4\">
				<select class=\"form-control\"  name=\"d\">
					<option value=\"\" disabled selected>Počet dechových nástrojů</option>";
					for ($i = 1; $i <= 500; $i++) : 
						echo "<option value=\"" . $i . "\">" . $i . "</option>";
					endfor;
				echo"
				</select>
				</div>
				";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if ($_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-3\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Počet strunných nástrojů:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
				if (isset($_POST['str'])){
					echo $_POST['str'];
				}
				else{
					echo "0";
				};
				echo "</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"str\" class=\"col-lg-3 control-label input-lg text-right\">Počet strunných nástrojů</label>
				<div class=\"col-lg-4\">
				<select class=\"form-control\"  name=\"str\">
					<option value=\"\" disabled selected>Počet strunných nástrojů</option>";
					for ($i = 1; $i <= 500; $i++) : 
						echo "<option value=\"" . $i . "\">" . $i . "</option>";
					endfor;
				echo"	
				</select>
				</div>
				";
			}
			
			
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if (!$_SESSION['comp_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-3\">
				<button class=\"btn btn-success btn-lg\" type=\"submit\">Přidat skladbu</button>
				</div>
				<div class=\"col-lg-2\">
			    <span class=\"pull-right\">
				<a class=\"btn btn-warning btn-lg\" href=\"comps.php\" role=\"button\">Zpět na skladby</a>
				</span>
				</div>";
					
			}
			else{
				echo"
				<div class=\"col-lg-2 col-lg-offset-2\">
					<span class=\"pull-right\">
					<a class=\"btn btn-default btn-lg\" href=\"comps.php\" role=\"button\">Zpět na skladby</a>
					</span>
				</div>
				<div class=\"col-lg-2 col-lg-offset-1\">
					<a class=\"btn btn-default btn-lg\" href=\"add_comp.php\" role=\"button\">Přidat další skladbu</a>
				</div>";
			}
			?>
		
		</div>
		<div class="form-group row">
			<?php 
			if (!$_SESSION['comp_added']){
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



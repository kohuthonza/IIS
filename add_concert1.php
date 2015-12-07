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
	///header('Location: index.php'); //redirect to index.php
	exit;
} else {
	$_SESSION['timestamp'] = time(); //set new timestamp
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

if(isset($_POST['sent'])){
	if(empty($_POST['comps']) or empty($_POST['Cname'])){
		echo "<br>Nezvolili jste zadne skladby nebo jmeno!<br><a href=\"add_concert.php\">Zpet vyber skladeb</a><br>";
		die();
	}
	else{
	
		$_SESSION['compositions'] = $_POST['comps'];
		$_SESSION['concert_name'] = $_POST['Cname'];
	}
}

?>
<html>
<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<style>
	body {background-image:url(./profile_concerts_background.png);
		  background-repeat: no-repeat;
		  background-position: 90% 37px;}
</style>

<title>
Přidat koncert
</title>
</head>
<body>

<div class="container-fluid">

<form class="form-horizontal" method="post" action="add_concert2.php">
		<div class="form-group row">
			&nbsp;
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<h4>
				<strong>Název koncertu:</strong>
				</h4>
				</span>
			</div>
			<div class="col-lg-9">
			    <h4>
				<strong>
				<?php 
				
				$name_con = isset($_POST['Cname']) ? $_POST['Cname'] : $_SESSION['concert_name'];
				echo $name_con;
				
				
				?>
				</strong>
				</h4>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<h4>
				<strong>Seznam skladeb:</strong>
				</h4>
				</span>
			</div>
			<div class="col-lg-9">
			    <h4>
				<strong>
				<?php
				
				if(!db_connect())
				die('Nepodarilo se pripojit k databazi');

				        $SQL2 = "select ID, Name from compositions";
				        $retval2 = mysql_query($SQL2, $_SESSION['db']);
						$tracks = isset($_POST['comps']) ? $_POST['comps'] : $_SESSION['compositions'];
						
						
						while($row2 = mysql_fetch_array($retval2)){
							if (in_array($row2['ID'], $tracks)){
								echo $row2['Name'];
								echo "<br>";
							}
						}

						$_SESSION['concert_added'] = false;

						mysql_close($_SESSION['db']);	
				
				?>
				</strong>
				</h4>
			</div>
		</div>
		
		<div class="form-group row">
			<label for="con_date" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Datum koncertu</label>
			<div class="col-lg-1">
				<select required class="form-control" id="con_date" name="day">
					<option value="" disabled selected>DD</option>
					<?php for ($i = 1; $i <= 31; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-lg-1">
				<select required class="form-control" name="month">
					 <option value="" disabled selected>MM</option>
					<?php for ($i = 1; $i <= 12; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-lg-2">
				<select required class="form-control" name="year">
				<option value="" disabled selected>RRRR</option>
					<?php for ($i = 2015; $i <= 2100; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<label for="con_date" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<div class="col-lg-1 col-lg-offset-2">
				<a class="btn btn-warning btn-lg" href="add_concert.php" role="button">Zpět</a>
			</div>
			<div class="col-lg-1">
				<button class="btn btn-success btn-lg" type="submit" name="sent">Pokračovat</button>
			</div>
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<a class="btn btn-danger btn-lg" href="concerts.php" role="button">Zpět na koncerty</a>
				</span>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Všechny údaje označené * jsou povinné</strong>
			</div>
		</div>
	</form>


</div>
</body>
</html>


	



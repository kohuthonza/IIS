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

<form class="form-horizontal" method="post" action="add_concert1.php">
		<div class="form-group row">
			&nbsp;
		</div>
		<div class="form-group row">
			<label for="con_name" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Název koncertu</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="con_name" placeholder="Název koncertu" name="Cname" required>
			</div>
			<label for="con_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="comp_list" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Skladby</label>
			<div class="col-lg-4">
				<select name="comps[]" multiple class="form-control" size="22" required>
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
			</div>
			<label for="comp_list" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit" name="sent">Pokračovat</button>
			</div>
			<div class="col-lg-2">
			    <span class="pull-right">
				<a class="btn btn-warning btn-lg" href="concerts.php" role="button">Zpět na koncerty</a>
				</span>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Pro vícenásobný výběr použijte CTRL + Click</strong>
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

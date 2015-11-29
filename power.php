<?php
session_save_path("./tmp");
session_start();
header("Content-Type: text/html; charset=UTF-8");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include_once 'functions.php';
	
	if($_GET['logout'] == 0){

		if(!db_connect())
			die('nepodarilo se pripojit k databazi');

		$login = htmlspecialchars($_POST['login']);
		$pass = htmlspecialchars($_POST['passwd']);
		if(empty($pass) or empty($login)){
			die('Spatne heslo<br><a href="index.php">Zpet na hlavni stranu</a>');
		}
		
		login($login, $pass);
		//echo $_SESSION['role'];
		Header('Location: profile.php');

		mysql_close($_SESSION['db']);
	}
	else{
		session_destroy();
		$_SESSION = array();
		//mysql_close($_SESSION['db']);
		//unset($_SESSION['logged']);
		
		echo "
		<html>
		<html>
		<head>
		<meta charset=\"utf-8\">
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
		<link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
		<title>
		Odhlášení
		</title>

		</head>

		<body>
		
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
		
		<h2><strong><p class=\"text-center\">Byl jste odhlášen</p></strong></h2>
	
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
			<a class=\"btn btn-default btn-lg\" href=\"index.php\" role=\"button\">Zpět na hlavní stranu</a>
			</span>
		</div>
		
		</div>
		
		</body>
		</html>
		
		
		";
		
		
		
		
	}

}
?>


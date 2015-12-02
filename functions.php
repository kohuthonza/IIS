<?php

function login($login, $pass){

	$cmmnd = "select * from users where Login='$login'";

	$retval = mysql_query($cmmnd, $_SESSION['db']);
	$row = mysql_fetch_array($retval, MYSQL_ASSOC);
	$pass_DB =  $row['Password'];

	if($pass_DB != $pass){
		
		echo "
			<html>
			<html>
			<head>
			<meta charset=\"utf-8\">
			<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
			<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
			<link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
			<title>
			Špatné heslo, nebo login
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
			
			<h2><strong><p class=\"text-center\">Špatné heslo, nebo login</p></strong></h2>
		
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
			die();
		
		die();
		}

	$_SESSION['logged'] = true;
	$_SESSION['login'] = $login;
	$_SESSION['role'] = $row['Role'];
	$_SESSION['name'] = $row['Name'];
	$_SESSION['date'] = $row['Date'];
	
	$_SESSION['timestamp'] = time();
	
	$_SESSION['timeout'] = 300;
	
	/*if(!db_connect()){
		die("<br>Nepovedlo se pripojit k DB!<br>");
	}*/

}

function db_connect(){
	//if(isset($_SESSION['connected']) and $_SESSION['connected'] == true)
	//	return true;
	//session_save_path("./tmp");
	//session_start();
	
	$db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xknote11', 'peron9ur');

	if(!$db){
		echo ('nelze se pripojit k databazi');
		return false;
	}
	if(!mysql_select_db('xknote11', $db)){
		echo('databeze nedostupna');
		return false;
	}
	
	mysql_set_charset("utf8");


	$_SESSION['connected'] = true;
	$_SESSION['db'] = $db;

	return true;

}

function logout_msg(){
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
		
		<h2><strong><p class=\"text-center\">Byl jste automaticky odhlášen.<br>Přihlašte se prosím znovu.</p></strong></h2>
	
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

?>


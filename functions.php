<?php

function login($login, $pass){

	$cmmnd = "select * from users where Login='$login'";

	$retval = mysql_query($cmmnd, $_SESSION['db']);
	$row = mysql_fetch_array($retval, MYSQL_ASSOC);
	$pass_DB =  $row['Password'];

	if($pass_DB != $pass)
		die('Spatne heslo');

	$_SESSION['logged'] = true;
	$_SESSION['login'] = $login;
	$_SESSION['role'] = $row['Role'];
	$_SESSION['name'] = $row['Name'];
	$_SESSION['date'] = $row['Date'];
	
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

	$_SESSION['connected'] = true;
	$_SESSION['db'] = $db;

	return true;

}

?>


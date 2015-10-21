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

}

function db_connect(){
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


<?php
session_start();



function login($login, $pass){
$cmmnd = "select Password, Role from users where Login='$login'";

$retval = mysql_query($cmmnd, $_SESSION['db']);
$row = mysql_fetch_array($retval, MYSQL_ASSOC);
$pass_DB =  $row['Password'];
$role = $row['Role'];

if($pass_DB != $pass)
		die('Spatne heslo<br><a href="index.php">Zpet na hlavni stranu</a>');

switch($role){
	case 1:
			//echo "spravce koncertu";
			//header('Location: /~xknote11/personel.php');
			$_SESSION['role'] = 1;
			break;
	case 2:
			//echo "spravce koncertu";
			break;
	case 3:
			//echo "spravce skladeb";
			break;
	default:
			break;

}

$_SESSION['logged'] = true;
$_SESSION['login'] = $login;

}

function db_connect(){
$db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xknote11', 'peron9ur');

if(!$db) 
		die('nelze se pripojit k databazi');
if(!mysql_select_db('xknote11', $db))
		die('databeze nedostupna');

$_SESSION['connected'] = true;
$_SESSION['db'] = $db;

}


?>


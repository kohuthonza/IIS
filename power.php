ahoj
<br>

<?php
$login = htmlspecialchars($_POST['login']);

$pass = htmlspecialchars($_POST['passwd']);
if(empty($pass) or empty($login)){
	echo "zadejte heslo nebo login";
	die();
}

echo '<br/>';

$db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xknote11', 'peron9ur');
if(!$db) 
		die('nelze se pripojit k databazi');
if(!mysql_select_db('xknote11', $db))
		die('databeze nedostupna');

$cmmnd = "select password from passwords where login='$login'";

$retval = mysql_query($cmmnd, $db);
$row = mysql_fetch_array($retval, MYSQL_ASSOC);
$pass_DB =  $row['password'];

if($pass_DB != $pass)
		die('wrong password');
else
		echo 'OK!';

mysql_close($db);
?>

<br>
dobre ty

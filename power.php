ahoj
<br>

<?php
$login = htmlspecialchars($_POST['login']);

$pass = htmlspecialchars($_POST['password']);
if(empty($pass) or empty($login)){
	echo "zadejte heslo nebo login";
	die();
}

echo $login;
echo ":";
echo $pass;

?>

<br>
dobre ty

<html>
<title>Vas profil</title>
<body>

Uzivatel:

<?php
session_save_path("./tmp");
session_start();
if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		die();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
$login = $_SESSION['login'];

echo 
"
 $name
<br>
Login: $login
<br>
Role: 
";
switch($role){
	case 1:
		echo "Spravce konceru";
		break;
	case 2:
		echo "Spravce hudebniku";
		break;
	case 3:
		echo "Spravce skladeb";
		break;

}
echo "<br><br>";
?>




<form action="power.php?logout=1" method="post">
	<input type="submit" value="Odhlasit" >	
</form>
<form action="add_user.php">
	<input type="submit" value="Pridat uzivatele" >	
</form>

<?php
switch($role){
	case 1:
		echo "<form action=\"concerts.php\">";
		echo "<input type=\"submit\" value=\"Koncerty\" >";
		break;
	case 2:
		echo "<form action=\"personel.php\">";
		echo "<input type=\"submit\" value=\"Hudebnici\" >";
		break;
	case 3:
		echo "<form action=\"comps.php\">";
		echo "<input type=\"submit\" value=\"Skladby\" >";
		break;
}
echo "</form>";
?>

</body>

</html>

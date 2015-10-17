<html>
Informacni system Spravce Koncertu
<br><br>

<body>

<?php
session_start();

if($_SESSION['logged'] != true){
	$_SESSION['logged'] = false;
	$_SESSION['connected'] = false;
	echo "Prosim, prohlaste se:";

	echo
	"
	<br><br>

	<form method=\"post\" action=\"power.php?logout=0form\">
		Login:<br>
		<input type=\"text\" name=\"login\">
		<br>
		Heslo:<br>
		<input type=\"password\" name=\"passwd\">
		<br>
		<input type=\"submit\" value=\"Prihlasit\" >	
	</form>

	<br/>
	Nebo muzete <a href=\"add_user.php\">pridat uzivatele<a/>
	";
	die();
}
echo $_SESSION['login'];
echo " prihlasen";
echo "
	<br>
	<form method=\"post\" action=\"power.php?logout=1\">
		<input type=\"submit\" value=\"Odhlasit\"  >	
	</form>
	</form>
	";
	
	
	
?>

</body>
</html>

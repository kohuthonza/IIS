<?php
session_start();
if(isset($_SESSION['logged'])){
	header('Location: profile.php');
}
	
?>


<html>
<head>

<title>
Informacni system Sprava Filharmonie
</title>

Informacni system Sprava Filharmonie
<br><br>

<body>
Prosim, prohlaste se:
	<br><br>

	<form method="post" action="power.php?logout=0">
		Login:<br>
		<input type="text" name="login">
		<br>
		Heslo:<br>
		<input type="password" name="passwd">
		<br>
		<input type="submit" value="Prihlasit" >	
	</form>

	<br/>
	Nebo muzete <a href="add_user.php">pridat uzivatele<a/>

</body>
</html>

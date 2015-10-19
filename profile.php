<?php
session_start();
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}



?>

<html>
<title>Vas profil</title>

<body>


tvuj profil

<form action="power.php?logout=1" method="post">

	<input type="submit" value="Odhlasit" >	
</form>

</body>

</html>

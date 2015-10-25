<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();
if(isset($_SESSION['logged'])){
	header('Location: profile.php');
}
	
?>


<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>
Filharmonie
</title>
</head>

<body>
	<div type="headline">
		Filharmonie
	</div>
	<form method="post" action="power.php?logout=0">
		<br>
		<span></span>
			<input type="text" name="login" placeholder="Přihlašovací jméno">
		<span></span>
		<br>
		<span></span>
			<input type="password" name="passwd" placeholder="Heslo">
		<span></span>
		<br>
		<span></span>
			<input type="submit" value="Přihlásit se" >
		<span></span>
	</form>
	<div type="new_user">
		Nebo můžete <a href="add_user.php">přidat uživatele<a/>
	</div>	
</body>
</html>

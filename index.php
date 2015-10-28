<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
if(isset($_SESSION['logged'])){
	header('Location: profile.php');
}
	
?>


<html>
<head>
<link rel="stylesheet" href="index.css" type="text/css">
<title>
Filharmonie
</title>
</head>

<body>
	<div type="headline">
		Filharmonie
	</div>
	<br>
	<div type="border">
	</div>
	<form method="post" action="power.php?logout=0">
		<br>
			<input type="text" name="login" placeholder="Přihlašovací jméno">
		<br>
			<input type="password" name="passwd" placeholder="Heslo">
		<br>
			<input type="submit" value="Přihlásit se" >
	</form>
	<div type="new_user">
		Nebo můžete <a href="add_user.php">přidat uživatele<a/>
	</div>
</body>
</html>

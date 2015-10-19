<html>
<title>
Pridat uzivatele
</title>

<body>

Prosim, vyplnte udaje o uzivateli:
<form method="post" action="add_user.php">
	Jmeno:<br>
	<input type="text" name="name">*<br><br>
	Login:<br>
	<input type="text" name="login">*<br><br>
	Heslo:<br>
	<input type="password" name="passwd">*<br><br>
	Datum Narozeni:<br><font size="2">(Den/Mesic/Rok)</font><br>
	<input type="text" name="day" size="5">/
	<input type="text" name="month" size="5">/
	<input type="text" name="year" size="10"><br><br>
	Role:<br>
	<select required name="role">
		<option value="1">Spravce personalu</option>
		<option value="2">Spravce koncertu</option>
		<option value="3">Spravce skladeb</option>
	</select>*
	<br><br>
	<input type="submit" value="Pridat uzivatele">
</form>

<br> Udaje oznacene * jsou povinne <br><br>
<a href="index.php">Zpet na hlavni stranu</a>
<br>

</body>
</html>


<?php

session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include_once 'functions.php';

	if(!db_connect())
			die('Nepodarilo se pripojit k databazi');

		$login = htmlspecialchars($_POST['login']);
		$pass = htmlspecialchars($_POST['passwd']);
		$name = htmlspecialchars($_POST['name']);

		$year = htmlspecialchars($_POST['year']);
		$month = htmlspecialchars($_POST['month']);
		$day = htmlspecialchars($_POST['day']);
	
		if(!((is_numeric($year) and is_numeric($month) and is_numeric($day)) or
				(empty($year) and empty($month) and empty($day) ) ) ){
			die("<font color=\"red\">Nepsravne datum narozeni!</font>");
		}

		$birth = $year . '.' . $month . '.' . $day;

		$role = htmlspecialchars($_POST['role']);

		if(empty($login) or empty($pass) or empty($name)){
			die("<font color=\"red\">Vyplnte vsechny povinne udaje!</font>");
		}
			
		$db = $_SESSION['db'];

		$cmmnd = "insert into users (Name, Login, Password, Date, Role) values ('$name', '$login', '$pass', '$birth', '$role')";
			
		if(mysql_query($cmmnd, $db)){
			echo "pridano";
		}
		else{
			echo "error: ", mysql_error($db);
			die();
		}

		echo "<br>login: ", $login;
		echo "<br>pass: ", $pass;
		echo "<br>name: ", $name;
		echo "<br>date: ", $birth;
		echo "<br>role: ", $role;

		mysql_close($db);
}

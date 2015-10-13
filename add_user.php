<html>
<body>

Prosim, vyplnte udaje o uzivateli:
<form method="post" action="add_user.php">
	Jmeno:<br>
	<input type="text" name="name">*<br>
	Login:<br>
	<input type="text" name="login">*<br>
	Heslo:<br>
	<input type="password" name="passwd">*<br>
	<input type="submit" value="Pridat">
</form>
<br>

<a href="index.php">Zpet na hlavni stranu</a>
<br>

</body>
</html>


<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$login = htmlspecialchars($_POST['login']);
			$pass = htmlspecialchars($_POST['passwd']);
			$name = htmlspecialchars($_POST['name']);
			if(empty($login) or empty($pass) or empty($name)){
				die("vyplnte vsechny povinne udaje");
			}
			
			$db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xknote11', 'peron9ur');
			if(!$db) 
				die('nelze se pripojit k databazi');
			if(!mysql_select_db('xknote11', $db))
				die('databeze nedostupna');
			
			$cmmnd = "insert into passwords (login, password, name) values ('$login', '$pass', '$name')";
			
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

			mysql_close($db);
	}

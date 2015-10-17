<br>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include_once 'functions.php';

	if($_GET['logout'] == 0){

		if($_SESSION['connected'] == false)
			db_connect();
		if($_SESSION['connected'] == false)
			die('Nepodarilo se pripojit k databazi');


		$login = htmlspecialchars($_POST['login']);
		$pass = htmlspecialchars($_POST['passwd']);
		if(empty($pass) or empty($login)){
			die('Spatne heslo<br><a href="index.php">Zpet na hlavni stranu</a>');
		}

		login($login, $pass);
		echo $_SESSION['role'];

		//mysql_close($db);
	}
	else{
		$_SESSION['logged'] = false;
		echo "byl jste odhlasen<br>";
		echo "<a href=\"index.php\">Zpet na hlavni stranu</a>";
	}

}
?>


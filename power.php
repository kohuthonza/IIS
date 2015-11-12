<br>

<?php
session_save_path("./tmp");
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include_once 'functions.php';
	
	if($_GET['logout'] == 0){

		if(!db_connect())
			die('nepodarilo se pripojit k databazi');

		$login = htmlspecialchars($_POST['login']);
		$pass = htmlspecialchars($_POST['passwd']);
		if(empty($pass) or empty($login)){
			die('Spatne heslo<br><a href="index.php">Zpet na hlavni stranu</a>');
		}
		
		login($login, $pass);
		//echo $_SESSION['role'];
		Header('Location: profile.php');

		mysql_close($_SESSION['db']);
	}
	else{
		session_destroy();
		$_SESSION = array();
		//mysql_close($_SESSION['db']);
		//unset($_SESSION['logged']);
		echo "byl jste odhlasen<br>";
		echo "<a href=\"index.php\">Zpet na hlavni stranu</a>";
	}

}
?>


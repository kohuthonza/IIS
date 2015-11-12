<?php
include_once('functions.php');
session_save_path("./tmp");
session_start();
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}
if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("<html>
		<title>Pridat koncert</title><body>
		Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
		</body></html>
		");
}

if(isset($_POST['sent'])){
	if(empty($_POST['comps']) or empty($_POST['Cname'])){
		echo "<br>Nezvolili jste zadne skladby nebo jmeno!<br><a href=\"add_concert.php\">Zpet vyber skladeb</a><br>";
		die();
	}
	else{		
		$_SESSION['compositions'] = $_POST['comps'];
		$_SESSION['name'] = $_POST['Cname'];
	}
}

?>
<html>
<title>
Pridat koncert
</title>

<body>

<form method="post" action="add_concert2.php">
	Vyberte datum koncertu (tvar YYYY-MM-DD !!): <br>
	<!-- tady je schvalne datum napevno v 1 formulari, abys sem mohl hodit ten css vyber data
	potom je nutne naparsovat datum dokopy na tvar YYYY-MM-DD aby se spravne ulozilo do DB-->
	<input type="text" value="2015-1-1" name="date">*<br><br>
	<input type="submit" name="sent" value="Pokracovat">
</form>

<a href="index.php">Zpet na hlavni stranu</a>

</body>
</html>
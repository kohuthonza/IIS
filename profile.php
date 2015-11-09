<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
?>

<html>
<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<title>

Vas profil

</title>
</head>
<body>


<div class="container-fluid">
	

	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		<div class="col-lg-1 col-lg-offset-1"><h1>Profil<h1></div>
	</div>




<?php
if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		die();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
$login = $_SESSION['login'];
/**
$year = $_SESSION['year'];
$month = $_SESSION['month'];
$day = $_SESSION['day'];
**/
echo 
"
	<div class=\"row\">
		<div class=\"col-lg-2 text-right\"><h2>Uživatel:<h2></div>
		<div class=\"col-lg-4 col-lg-offset-1\"><h2>$name<h2></div>
	</div>
	<div class=\"row\">
		<div class=\"col-lg-2 text-right\"><h2>Login:<h2></div>
		<div class=\"col-lg-4 col-lg-offset-1\"><h2>$login<h2></div>
	</div>
	<div class=\"row\">
		<div class=\"col-lg-2 text-right\"><h2>Narození:<h2></div>
		<div class=\"col-lg-4 col-lg-offset-1\"><h2>. . <h2></div>
	</div>


";
switch($role){
	case 1:
		echo "
			<div class=\"row\">
				<div class=\"col-lg-1 col-lg-offset-1 text-right\"><h2>Role:<h2></div>
				<div class=\"col-lg-3 col-lg-offset-1\"><h2>Správce hudebníků<h2></div>
			</div>
			 ";
		break;
	case 2:
		echo "
			<div class=\"row\">
				<div class=\"col-lg-1 col-lg-offset-1 text-right\"><h2>Role:<h2></div>
				<div class=\"col-lg-3 col-lg-offset-1\"><h2>Správce koncertů<h2></div>
			</div>
			 ";
		break;
	case 3:
		echo "
			<div class=\"row\">
				<div class=\"col-lg-1 col-lg-offset-1 text-right\"><h2>Role:<h2></div>
				<div class=\"col-lg-3 col-lg-offset-1\"><h2>Správce skladeb<h2></div>
			</div>
			 ";
		break;

}
echo "<br><br>";
?>

	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>


<form action="power.php?logout=1" method="post">
	<input type="submit" value="Odhlasit" >	
</form>
<form action="add_user.php">
	<input type="submit" value="Pridat uzivatele" >
</form>




<?php
switch($role){	
	case 1:
		echo "<form action=\"personel.php\">";
		echo "<input type=\"submit\" value=\"Hudebnici\" >";
		break;
	case 2:
		echo "<form action=\"concerts.php\">";
		echo "<input type=\"submit\" value=\"Koncerty\" >";
		break;
	case 3:
		echo "<form action=\"comps.php\">";
		echo "<input type=\"submit\" value=\"Skladby\" >";
		break;
}
echo "</form>";
?>

</div>

</body>

</html>

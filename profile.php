<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}
if(time() - $_SESSION['timestamp'] > $_SESSION['timeout']) { //subtract new timestamp from the old one
	unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
	unset($_SESSION['logged']);
	logout_msg();
	//header('Location: index.php'); //redirect to index.php
	exit;
} else {
	$_SESSION['timestamp'] = time(); //set new timestamp
}
?>

<html>
<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<?php
if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		die();
}
$role = $_SESSION['role'];
		
switch($role){	
	//Spravce hudebniku
	case 1:
		echo "<style>
    		  	body {background-image:url(./profile_personel_background.jpg);
				      background-repeat: no-repeat;
					  background-position: 117% 10px;}
			  </style>";		
		break;
	//Spravce koncertu
	case 2:
		echo "<style>
				body {background-image:url(./profile_concerts_background.png);
					  background-repeat: no-repeat;
					  background-position: 90% 37px;}
			  </style>";
		break;
	//Spravce skladeb
	case 3:
		echo "<style>
    		  	body {background-image:url(./profile_comps_background.png);
					  background-repeat: no-repeat;
					  background-position: 117% -58px;}
			  </style>";
		}
?>


<title>

Váš profil

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
	<div class="col-lg-6 col-lg-offset-1">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><h1>Profil</h1></h1>
		</div>
		<div class="panel-body">
			<?php
			if(!isset($_SESSION['logged'])){
				header('Location: index.php');
				die();
				}

			$name = $_SESSION['name'];
			$role = $_SESSION['role'];
			$login = $_SESSION['login'];
			$date = $_SESSION['date'];
			
			
	
			$data_date = explode("-", $date);
			$data_date[1] = preg_replace('/^0*(.*)/', '$1', $data_date[1]);
			$data_date[2] = preg_replace('/^0*(.*)/', '$1', $data_date[2]);

			echo 
			"
				<div class=\"row\">
					<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Uživatel:</span><h3></div>
					<div class=\"col-lg-6 col-lg-offset-1\"><h3>$name<h3></div>
				</div>
				<div class=\"row\">
					<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Login:</span><h3></div>
					<div class=\"col-lg-6 col-lg-offset-1\"><h3>$login<h3></div>
				</div>
				<div class=\"row\">
					<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Narození:</span><h3></div>
					<div class=\"col-lg-6 col-lg-offset-1\"><h3>$data_date[2]. $data_date[1]. $data_date[0]<h3></div>
				</div>


			";
			switch($role){
				case 1:
					echo "
						<div class=\"row\">
							<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Role:</span><h3></div>
							<div class=\"col-lg-6 col-lg-offset-1\"><h3>Správce hudebníků<h3></div>
						</div>
						 ";
					break;
				case 2:
					echo "
						<div class=\"row\">
							<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Role:</span><h3></div>
							<div class=\"col-lg-6 col-lg-offset-1\"><h3>Správce koncertů<h3></div>
						</div>
						 ";
					break;
				case 3:
					echo "
						<div class=\"row\">
							<div class=\"col-lg-3 text-right\"><h3><span class=\"pull-right\">Role:</span><h3></div>
							<div class=\"col-lg-6 col-lg-offset-1\"><h3>Správce skladeb<h3></div>
						</div>
						 ";
					break;

			}

			?>

	</div>
	</div>
	</div>
	</div>
   

	
	<div class="row">
		&nbsp;
	</div>
	<div class="row">
		&nbsp;
	</div>
	

	

	<div class="row">

		<div class="col-lg-1 col-lg-offset-1">
		<?php
		switch($role){	
			case 1:
				echo "<form action=\"personel.php\">";
				echo "<button class=\"btn btn-primary btn-lg pull-left\" type=\"submit\">Hudebníci</button>";
				break;
			case 2:
				echo "<form action=\"concerts.php\">";
				echo "<button class=\"btn btn-primary btn-lg\" type=\"submit\">Koncerty</button>";
				break;
			case 3:
				echo "<form action=\"comps.php\">";
				echo "<button class=\"btn btn-primary btn-lg\" type=\"submit\">Skladby</button>";
				break;
				}
				echo "</form>";
		?>

		</div>
		<div class="col-lg-3">
			<form action="add_user.php">
				<span class="pull-right">
				<button class="btn btn-lg" type="submit">Přidat uživatele</button>
				</span>
			</form>
		</div>
		<div class="col-lg-2">
			<form action="power.php?logout=1" method="post">
				<span class="pull-right">
				<button class="btn btn-danger btn-lg" type="submit">Odhlásit se</button>
				</span>
			</form>
		</div>
	</div>

</body>

</html>

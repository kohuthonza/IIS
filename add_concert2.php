<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
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
	
	$year = htmlspecialchars(isset($_POST['year']) ? $_POST['year'] : null);
	$month = htmlspecialchars(isset($_POST['month']) ? $_POST['month'] : null);
	$day = htmlspecialchars(isset($_POST['day']) ? $_POST['day'] : null);
	
	if(!((is_numeric($year) and is_numeric($month) and is_numeric($day)) or
		(empty($year) and empty($month) and empty($day) ) ) ){
			die("<font color=\"red\">Nezvolili jste zadne datum!</font>");
			}

	$date = $year . '.' . $month . '.' . $day;
		
	$_SESSION['conct_date'] = $date;
	}

if(isset($_POST['addC'])){
	if(!empty($_POST['musics'])){
		if(!$_SESSION['concert_added']){
			
			if(!db_connect())
				die("<html>
					<title>Pridat koncert</title><body>
					nepodarilo se pripojit k DB!<br>
					<a href=\"index.php\">Zpet na hlavni stranu</a>
					</body></html>
				");
			
			$SQL = "insert into concerts (ID, Name, Date) values (NULL, '$_SESSION[name]', '$_SESSION[conct_date]')";
			mysql_query($SQL, $_SESSION['db']);
						
			$idx = mysql_insert_id();
			
			$_SESSION['musics'] = $_POST['musics'];
			foreach ($_SESSION['compositions'] as $selectedOption){		
				$SQL = "insert into concert_composition (concert_ID, comp_ID) values ('$idx', '$selectedOption')";
				mysql_query($SQL, $_SESSION['db']);		
			}
			foreach ($_SESSION['musics'] as $selectedOption){
				$SQL = "insert into concert_musician (concert_ID, music_RC) values ('$idx', $selectedOption)";
				mysql_query($SQL, $_SESSION['db']);
			}
			
			
			//tady pripojit a pridat vsechny veci do DB
			
			$_SESSION['concert_added'] = true;
			
		
			
		}
	}
	else{
		echo "Vyberte nejake hudebniky pro koncert!<br>";
	}
	
}

?>


<html>
<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<style>
	body {background-image:url(./profile_concerts_background.png);
		  background-repeat: no-repeat;
		  background-position: 90% 37px;}
</style>


<title>
Přidat koncert
</title>
</head>
<body>
<div class="container-fluid">


<form class="form-horizontal" method="post" action="add_concert2.php">
		<div class="form-group row">
			&nbsp;
		</div>
		<?php
		if(isset($_POST['addC'])){
			
        echo"<div class=\"form-group row\">
			 <div class=\"col-lg-5 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h1>
				<strong>Koncert přidán</strong>
				</h1>
				</span>
			</div>
			<div class=\"form-group row\">
			&nbsp;
		    </div>
		</div>";
		}
		?>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<h4>
				<strong>Název koncertu:</strong>
				</h4>
				</span>
			</div>
			<div class="col-lg-9">
			    <h4>
				<strong><?php echo $_SESSION['concert_name']?></strong>
				</h4>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<h4>
				<strong>Seznam skladeb:</strong>
				</h4>
				</span>
			</div>
			<div class="col-lg-9">
			    <h4>
				<strong>
				<?php
				
				if(!db_connect())
				die('Nepodarilo se pripojit k databazi');

				        $SQL2 = "select ID, Name from compositions";
				        $retval2 = mysql_query($SQL2, $_SESSION['db']);

						while($row2 = mysql_fetch_array($retval2)){
							if (in_array($row2['ID'], $_SESSION['compositions'])){
								echo $row2['Name'];
								echo "<br>";
							}
						}

						mysql_close($_SESSION['db']);	
				
				?>
				</strong>
				</h4>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-1">
			    <span class="pull-right">
				<h4>
				<strong>Datum koncertu:</strong>
				</h4>
				</span>
			</div>
			<div class="col-lg-9">
			    <h4>
				<?php
				if(isset($_POST['addC'])){
					
					$data_date = explode(".", $_SESSION['conct_date']);
					$data_date[1] = preg_replace('/^0*(.*)/', '$1', $data_date[1]);
					$data_date[2] = preg_replace('/^0*(.*)/', '$1', $data_date[2]);
					
					echo "<strong>" . $data_date[2] . ". " . $data_date[1] . ". " . $data_date[0] . "</strong>";
				}
				else{
					echo "<strong>" . $_POST['day'] . ". " . $_POST['month'] . ". " . $_POST['year'] . "</strong>";
					$_SESSION['concert_added'] = false;
				}
				?>
				</h4>
			</div>
		</div>
		<div class="form-group row">
		    <?php
				if(isset($_POST['addC'])){
					echo "
					<div class=\"col-lg-2 col-lg-offset-1\">
					<span class=\"pull-right\">
					<h4>
					<strong>Seznam hudebníků:</strong>
					</h4>
					</span>
					</div>
					<div class=\"col-lg-9\">
					<h4>
					<strong>";
					
					
				if(!db_connect())
							die('Nepodarilo se pripojit k databazi');

				        $SQL2 = "select RC, Name, SName from musicians";
				        $retval2 = mysql_query($SQL2, $_SESSION['db']);

						while($row2 = mysql_fetch_array($retval2)){
							if (in_array($row2['RC'], $_SESSION['musics'])){
								echo $row2['Name'] . " " . $row2['SName'];
								echo "<br>";
							}
						}

						mysql_close($_SESSION['db']);	
						
				echo "
					</strong>
					</h4>
					</div>";
				}
				else{
					echo "<label for=\"list_mus\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Hudebníci</label>";
					echo "<div class=\"col-lg-4\">";
					echo "<select name=\"musics[]\" multiple class=\"form-control\" size=\"5\" required>";
					
						if(!db_connect())
							die('Nepodarilo se pripojit k databazi');

						$SQL2 = "select RC, Name, SName from musicians where RC not in (SELECT music_RC FROM concert_musician WHERE concert_ID in (select concert_ID from concerts where Date='$_POST[date]'))";

						$retval2 = mysql_query($SQL2, $_SESSION['db']);

						while($row2 = mysql_fetch_array($retval2)){
						echo "<option value=" . $row2['RC'] . ">" . $row2['Name'] . " " . $row2['SName'] . "</option>";
						}

						mysql_close($_SESSION['db']);
					
				echo "</select>";
				echo "</div>";
				echo "<label for=\"list_mus\" class=\"control-label input-lg text-right\">*</label>";	
					
				}
				
			?>
		</div>
		
		
		<div class="form-group row">
		    <?php
		    if(!isset($_POST['addC'])){
				
		echo"	<div class=\"col-lg-1 col-lg-offset-2\">
				<a class=\"btn btn-warning btn-lg\" href=\"add_concert1.php\" role=\"button\">Zpět</a>
			</div>
			
			<div class=\"col-lg-1\">
				<button class=\"btn btn-success btn-lg\" type=\"submit\" name=\"addC\">Přidat koncert</button>
			</div>
			<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<a class=\"btn btn-danger btn-lg\" href=\"concerts.php\" role=\"button\">Zpět na koncerty</a>
				</span>
			</div>";
			}
			
			else{
			echo"
			<div class=\"form-group row\">
			&nbsp;
		    </div>
			
			<div class=\"col-lg-2 col-lg-offset-2\">
				<span class=\"pull-right\">
				<a class=\"btn btn-default btn-lg\" href=\"add_concert.php\" role=\"button\">Přidat další koncert</a>
				</span>
			</div>
			<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<a class=\"btn btn-default btn-lg\" href=\"concerts.php\" role=\"button\">Zpět na koncerty</a>
				</span>
			</div>";
				
			}
			?>
		</div>
		<?php
		if(!isset($_POST['addC'])){
		echo"<div class=\"form-group row\">
	        <div class=\"col-lg-4 col-lg-offset-3\">
				<strong>Pro vícenásobný výběr použijte CTRL + Click</strong>
			</div>
		</div>
		<div class=\"form-group row\">
			<div class=\"col-lg-4 col-lg-offset-3\">
				<strong>Všechny údaje označené * jsou povinné</strong>
			</div>
		</div>";
		}
		?>
	</form>




</div>
</body>
</html>
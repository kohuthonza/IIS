<?php
header("Content-Type: text/html; charset=UTF-8");
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

if(!isset($_POST['CID']))
	die("Neni vybran zadny koncert!<br><a href=\"concerts.php\">Zpet na vyber koncertu</a>");
		
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
		  background-position: 90% 135px;}
</style>



<title>
Detail koncertu
</title>

</head>
<body>

<div class="container-fluid">

<div class="row">
		&nbsp;
	</div>
	
	

	<div class="form-group row">
		<div class="col-lg-2">
		    <form action="add_concert.php">
			<button class="btn btn-lg" type="submit">Přidat koncert</button>
			</form>
		</div>
		<div class="col-lg-2 col-lg-offset-3">
		    <form action="concerts.php">
			<span class="pull-right">
			<button class="btn btn-lg" type="submit">Zpět na koncerty</button>
			</span>
			</form>
		</div>
		<div class="col-lg-2 col-lg-offset-3">
			<form action="power.php?logout=1" method="post">
				<span class="pull-right">
				<button class="btn btn btn-lg" type="submit">Odhlásit se</button>
				</span>
			</form>
		</div>
	</div>



<form method="post" action="show_concert.php">
<?
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(!db_connect()){
		die("Nepodarilo se pripojit k DB!");
	}	
	if(isset($_POST['deleteC'])){
		$concert_ID = $_POST['CID'];
		$SQL = "delete from concerts where ID=$concert_ID";
		mysql_query($SQL, $_SESSION['db']);	
		
		$SQL = "delete from concert_composition where concert_ID=$concert_ID";
		mysql_query($SQL, $_SESSION['db']);
		
		$SQL = "delete from concert_musician where concert_ID=$concert_ID";
		mysql_query($SQL, $_SESSION['db']);
		
		echo"<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			<div class=\"form-group row\">
				&nbsp;
			</div>
			 <div class=\"form-group row\">
			 <div class=\"col-lg-5 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h1>
				<strong>Koncert odstraněn</strong>
				</h1>
				</span>
			</div>
			<div class=\"form-group row\">
			&nbsp;
		    </div>
		</div>";
		
		die();
		//DELETE FROM `concerts` WHERE ID=14
	}
	
	if(isset($_POST['update'])){
		//update vetev
		
		
		$year = htmlspecialchars(isset($_POST['year']) ? $_POST['year'] : null);
		$month = htmlspecialchars(isset($_POST['month']) ? $_POST['month'] : null);
		$day = htmlspecialchars(isset($_POST['day']) ? $_POST['day'] : null);
	
		if(!((is_numeric($year) and is_numeric($month) and is_numeric($day)) or	
		(empty($year) and empty($month) and empty($day) ) ) ){
			die("<font color=\"red\">Nezvolili jste zadne datum!</font>");
			}

		$original_date = $year . '.' . $month . '.' . $day;
		
		//$SQL = "select ID from concerts where Date='$original_date'";
		//$retval = mysql_query($SQL, $_SESSION['db']);
		//$row = mysql_fetch_array($retval);
		//echo mysql_error();
		
		$concert_ID = $_POST['CID'];
		//echo "original: $original_date -> $row[ID] <br>";
		
		$SQL = "UPDATE concerts SET Name='$_POST[Cname]', Date='$original_date' WHERE ID='$concert_ID'";
		mysql_query($SQL, $_SESSION['db']);
		echo mysql_error();
		
		//projit vsechny musicians_to_add
		if(isset($_POST['musicians_to_add']))
			foreach ($_POST['musicians_to_add'] as $selectedOption){
					//echo $selectedOption."<br>";				
					$SQL = "insert into concert_musician (concert_ID, music_RC) values ('$concert_ID', '$selectedOption')";
					mysql_query($SQL, $_SESSION['db']);	
			}
			
			
		//prjit vsehny comps_to_add
		if(isset($_POST['comps_to_add']))
			foreach ($_POST['comps_to_add'] as $selectedOption){
					//echo $selectedOption."<br>";				
					$SQL = "insert into concert_composition (concert_ID, comp_ID) values ('$concert_ID', '$selectedOption')";
					mysql_query($SQL, $_SESSION['db']);	
			}
			
		
	}	
	if(isset($_POST['deleteMID'])){
		$concert_ID = $_POST['CID'];
		$SQL = "delete from concert_musician where music_RC=$_POST[deleteMID] and concert_ID=$concert_ID";
		//echo $SQL;
		mysql_query($SQL, $_SESSION['db']);
		echo "Hudebnik odstranen!<br>";
		//header('Location: show_concert.php');
	}
	
	if(isset($_POST['deleteCompID'])){
		$concert_ID = $_POST['CID'];
		$SQL = "delete from concert_composition where comp_ID=$_POST[deleteCompID] and concert_ID=$concert_ID";
		//echo $SQL;
		mysql_query($SQL, $_SESSION['db']);

		//header('Location: show_concert.php');
	}
	
	
	echo"
	<div class=\"form-group row\">
			&nbsp;
		</div>
		<div class=\"form-group row\">
			<label for=\"con_name\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Název koncertu</label>
			<div class=\"col-lg-4\">
				<input type=\"text\" value=\"$_POST[Cname]\" class=\"form-control input-lg\" id=\"con_name\" placeholder=\"Název koncertu\" name=\"Cname\" required>
			</div>
		</div>
	";
	
	
	$date = isset($_POST['Cdate']) ? $_POST['Cdate'] : $_POST['year'] ."-". $_POST['month'] ."-". $_POST['day'];
	
	$data_date = explode("-", $date);
	$data_date[1] = preg_replace('/^0*(.*)/', '$1', $data_date[1]);
	$data_date[2] = preg_replace('/^0*(.*)/', '$1', $data_date[2]);
	
	echo"
	
	<div class=\"form-group row\">
			<label for=\"con_date\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Datum koncertu</label>
			<div class=\"col-lg-1\">
				<select required class=\"form-control\" id=\"con_date\" name=\"day\">
					<option value=\"1\" disabled>DD</option>";
					 for ($i = 1; $i <= 31; $i++) : 
					  if($i == $data_date[2]){
						echo	"<option value=" . $i . " selected>" . $i . "</option>";	
						
						}
						else{
				echo	"<option value=" . $i . ">" . $i . "</option>";
						}
					 endfor; 
	echo"				
				</select>
			</div>
			<div class=\"col-lg-1\">
				<select required class=\"form-control\" name=\"month\">
					 <option value=\"\" disabled>MM</option>";
					for ($i = 1; $i <= 12; $i++) : 
					    if($i == $data_date[1]){
						echo	"<option value=" . $i . " selected>" . $i . "</option>";	
						
						}
						else{
						echo	"<option value=" . $i . ">" . $i . "</option>";
						}
					endfor;
	echo"		
				</select>
			</div>
			<div class=\"col-lg-2\">
				<select required class=\"form-control\" name=\"year\">
				<option value=\"\" disabled>RRRR</option>";
					for ($i = 2015; $i <= 2100; $i++) : 
					 if($i == $data_date[0]){
						echo	"<option value=" . $i . " selected>" . $i . "</option>";	
						
						}
					else{	
						echo	"<option value=" . $i . ">" . $i . "</option>";
					}
					endfor;
	echo"				
				</select>
			</div>
		</div>
	";

	
	echo "<input type=hidden name=\"CID\" value=\"$_POST[CID]\">";
	/*
	echo "Hudebnici v koncertu:<br>";
	
	$SQL = "select Name, SName, RC from musicians where RC in (select music_RC from concert_musician where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[CID]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());

	while($row = mysql_fetch_array($retval)){
		echo "<input type=text value=\"$row[Name]" . " " . $row['SName'] . "\">
				<input type=submit name=deleteM value=\"Odstranit hudebnika\">" . 
				"<input type=hidden name=deleteMID value=$row[RC]><br>";
	}*/

	
	$SQL = "select Name, ID, Sm, D, Str from compositions where ID not in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
	
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
?>

	<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<h4><strong>Můžete přidat následující skladby:</strong></h4>
			</div>
		</div>
	<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<select name="comps_to_add[]" multiple class="form-control" size="5">
					<?php
					
					while($row = mysql_fetch_array($retval)){
					echo "<option value=" . $row['ID'] . ">" . $row['Name'] . " ($row[Sm]) ($row[D]) ($row[Str])" . "</option>";
					}				
?>
				
				</select>
			</div>

		<div class="form-group row">
			&nbsp;
		</div>
		

<?php	
	$SQL = "select Name, SName, RC, Sm, D, Str from musicians where RC not in (select music_RC from concert_musician where concert_ID in (select ID from concerts where Date='$date'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
?>
	<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<h4><strong>Můžete přidat následující hudebníky:</strong></h4>
			</div>
		</div>
	<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<select name="musicians_to_add[]" multiple class="form-control" size="5">
					<?php
					
					while($row = mysql_fetch_array($retval)){
					echo "<option value=" . $row['RC'] . ">" . $row['Name'] ." " . $row['SName'] . " ($row[Sm]) ($row[D]) ($row[Str])" . "</option>";
					}		
?>
				
				</select>
			</div>
	
		<div class="form-group row">
			&nbsp;
		</div>
		

	
		


	
<?php
	
	
	//mysql_close($_SESSION['db']);
}
?>

		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit" name="update">Upravit koncert</button>
			</div>
			<div class="col-lg-2">
			    <span class="pull-right">
				<button class="btn btn-danger btn-lg" type="submit" name="deleteC">Odstranit koncert</button>
				</span>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Pro vícenásobný výběr použijte CTRL + Click</strong>
			</div>
		</div>


</form>

		
		<div class="form-group row">
			&nbsp;
		</div>
		
		

<?php

	$SQL = "select Name, ID, Sm, D, Str from compositions where ID in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
	echo "		<div class=\"row\">
				<div class=\"col-lg-4 col-lg-offset-3\">
				<div class=\"panel panel-danger\">
				<div class=\"panel-heading\">
				<h4 class=\"panel-title\"><h4>Můžete odstranit následující skladby:</h1></h1>
				</div>
				<div class=\"panel-body\">";
	while($row = mysql_fetch_array($retval)){
		echo "<form method=post action=show_concert.php>
				<div class=\"form-group row\">
				<div class=\"col-lg-11\">".
				"<h4><strong>" . $row['Name']. " ($row[Sm]) ($row[D]) ($row[Str])" . "</h4></strong>".
				"</div>
				<div class=\"col-lg-1\">
				<span class=\"pull-right\">
				<button class=\"btn btn-lg btn-danger\" type=\"submit\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>
				</span>
				</div>
				
				</div>
			
				" . 
				"<input type=hidden name=deleteCompID value=$row[ID]>".
				"<input type=hidden name=CID value=$_POST[CID]>" . 
				"<input type=hidden name=Cname value=\"$_POST[Cname]\">" . 
				"<input type=hidden name=Cdate value=\"$date\">" . 
				"</form>";			
	}
	echo "</div></div></div></div>";

	echo "
	
		<div class=\"form-group row\">
			&nbsp;
		</div>"
		

	;
	
	$SQL = "select Name, SName, RC, Sm, D, Str from musicians where RC in (select music_RC from concert_musician where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[CID]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
	echo "		<div class=\"row\">
				<div class=\"col-lg-4 col-lg-offset-3\">
				<div class=\"panel panel-danger\">
				<div class=\"panel-heading\">
				<h4 class=\"panel-title\"><h4>Můžete odstranit následující hudebníky:</h1></h1>
				</div>
				<div class=\"panel-body\">";
	while($row = mysql_fetch_array($retval)){
		echo "<form method=post action=show_concert.php>
		        <div class=\"form-group row\">
				<div class=\"col-lg-11\">".
				"<h4><strong>". $row['Name'] . " " . $row['SName'] . " ($row[Sm]) ($row[D]) ($row[Str])"."</strong></h4>".
				"</div>
				<div class=\"col-lg-1\">
				<span class=\"pull-right\">
				<button class=\"btn btn-lg btn-danger\" type=\"submit\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>
				</span>
				</div>
				
				</div>" . 
				"<input type=hidden name=deleteMID value=$row[RC]>".
				"<input type=hidden name=CID value=$_POST[CID]>" . 
				"<input type=hidden name=Cname value=\"$_POST[Cname]\">" . 
				"<input type=hidden name=Cdate value=\"$date\">" . 
				"</form>";
	}
	echo "</div></div></div></div>";
	
	mysql_close($_SESSION['db']);
?>



</div>
</body>
</html>

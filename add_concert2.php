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
	if(empty($_POST['date'])){
		echo "<br>Nezvolili jste zadne datum!<br><a href=\"add_concert1.php\">Zpet vyber data</a><br>";
		die();
	}
	else{
		//echo "pridavam datum:<br>" . $_POST['date'];	
		
		$_SESSION['conct_date'] = $_POST['date'];
	}
}
if(isset($_POST['addC'])){
	if(!empty($_POST['musics'])){
		if(!$_SESSION['concert_added']){
			echo "<br>pridavam koncert data: " . $_SESSION['conct_date'] . "<br>";
			
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
			echo "pridavam skladby s ID:<br>";	
			foreach ($_SESSION['compositions'] as $selectedOption){
				echo $selectedOption."<br>";				
				$SQL = "insert into concert_composition (concert_ID, comp_ID) values ('$idx', '$selectedOption')";
				mysql_query($SQL, $_SESSION['db']);		
			}
			echo "pridavam hudebniky s RC:<br>";
			foreach ($_SESSION['musics'] as $selectedOption){
				echo $selectedOption."<br>";
				$SQL = "insert into obsazeni (concert_date, comp_ID, musician_ID) values ('$_SESSION[conct_date]', '1', $selectedOption)";
				mysql_query($SQL, $_SESSION['db']);
			}
			
			
			//tady pripojit a pridat vsechny veci do DB
			unset($_SESSION['conct_date'], $_SESSION['musics'], $_SESSION['compositions']);
			$_SESSION['concert_added'] = true;
			
		}
		else{
			die("<html>
				<title>Pridat koncert</title><body>
				koncert uz byl pridan!<br>
				<a href=\"add_concert.php\">Pridat novy koncert</a>
				<a href=\"index.php\">Zpet na hlavni stranu</a>
				</body></html>
				");
		}		
	}
	else{
		echo "Vyberte nejake hudebniky pro koncert!<br>";
	}
	
}

?>
<html>
<title>
Pridat koncert
</title>

<body>

<form method="post" action="add_concert2.php">
	Vyberte hudebniky pozadovane pro koncert: <br>
	<select name="musics[]" multiple>
	
<?php
if(!db_connect())
	die('Nepodarilo se pripojit k databazi');


$SQL2 = "select RC, Name, SName from musicians where RC not in (SELECT musician_ID FROM `obsazeni` WHERE concert_date = '$_SESSION[conct_date]')";

$retval2 = mysql_query($SQL2, $_SESSION['db']);

while($row2 = mysql_fetch_array($retval2)){
	echo "<option value=" . $row2['RC'] . ">" . $row2['Name'] . " " . $row2['SName'] . "</option>";
}

mysql_close($_SESSION['db']);
?>
	</select>
	<br>
	<input type="submit" name="addC" value="Pridat koncert">
</form>

<a href="index.php">Zpet na hlavni stranu</a>

</body>
</html>
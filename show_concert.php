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
?>


<?
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	echo "Nazev koncertu: ";
	echo $_POST['Cname'] . "<br>" . "Datum koncertu: " . $_POST['Cdate'] . "<br>";
	echo "Skladby v koncertu:<br>";
	
	if(!db_connect()){
		die("Nepodarilo se pripojit k DB!");
	}	
	
	$SQL = "select comp_ID from concert_composition where concert_ID in (select ID from concerts where Date='$_POST[Cdate]')";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
	//$SQL2 = "select ID, Name from compositions";
	//$retval2 = mysql_query($SQL2, $_SESSION['db']);

	while($row = mysql_fetch_array($retval)){
		echo $row['comp_ID'] . "<br>";
		
	}
	
	echo "Hudebnici v koncertu:<br>";
	
	$SQL = "select musician_ID from obsazeni where concert_date='$_POST[Cdate]'";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
	//$SQL2 = "select ID, Name from compositions";
	//$retval2 = mysql_query($SQL2, $_SESSION['db']);

	while($row = mysql_fetch_array($retval)){
		echo $row['musician_ID'] . "<br>";
		
	}
	
	
	//foreach($compid as $retval)
}

?>
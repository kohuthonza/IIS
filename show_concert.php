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
<a href="index.php">Zpet na hlavni stranu</a><br>
<a href="concerts.php">Zpet na koncerty</a><br>
<form method=post action="show_concert.php">
<?
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(!db_connect()){
		die("Nepodarilo se pripojit k DB!");
	}	
	
	if(isset($_POST['update'])){
		//update vetev
		$original_date = $_POST['cdate'];
		
		//$SQL = "select ID from concerts where Date='$original_date'";
		//$retval = mysql_query($SQL, $_SESSION['db']);
		//$row = mysql_fetch_array($retval);
		//echo mysql_error();
		
		$concert_ID = $_POST['cid'];
		//echo "original: $original_date -> $row[ID] <br>";
		
		$SQL = "UPDATE concerts SET Name='$_POST[cname]', Date='$_POST[cdate]' WHERE ID='$concert_ID'";
		mysql_query($SQL, $_SESSION['db']);
		echo mysql_error();
		die("ulozeno!</form>");
		
	}else{
		echo "<br>ID koncertu:<br>" . $_POST['CID'];
		
		echo "<br>Nazev koncertu:<br>";
		echo "<input type=text name=\"cname\" value=\"$_POST[Cname]\"><br><br>";

		echo "Datum koncertu (YYYY-MM-DD):<br>";
		echo "<input type=text name=\"cdate\" value=\"$_POST[Cdate]\"><br><br>";
		
		echo "<input type=hidden name=\"cid\" value=\"$_POST[CID]\"><br><br>";
		
		echo "Hudebnici v koncertu:<br>";
		
		$SQL = "select Name, SName from musicians where RC in (select music_RC from concert_musician where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[CID]'))";
		//$SQL = "select Name, SName from musicians where RC in (select musician_ID from obsazeni where concert_date='$_POST[Cdate]')";
		$retval = mysql_query($SQL, $_SESSION['db']);
		echo(mysql_error());

		while($row = mysql_fetch_array($retval)){
			echo $row['Name'] . " " . $row['SName'] . "<br>";
		}
		
		echo "<br>Muzete pridat nasledujici hudebniky:<br>";
		//$SQL = "select Name, SName, RC from musicians where RC not in (select musician_ID from obsazeni where concert_date='$_POST[Cdate]')";
		$SQL = "select Name, SName, RC from musicians where RC not in (select music_RC from concert_musician where concert_ID in (select ID from concerts where Date='$_POST[Cdate]'))";
		$retval = mysql_query($SQL, $_SESSION['db']);
		echo(mysql_error());
?>
		<select multiple name="musicians_to_add[]">
<?php
		while($row = mysql_fetch_array($retval)){
			echo "<option value=" . $row['RC'] . ">" . $row['Name'] ." " . $row['SName'] . "</option>";
		}		
?>
		</select>
<?php

		
		echo "<br><br>skladby v koncertu:<br>";
		$SQL = "select Name from compositions where ID in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
		$retval = mysql_query($SQL, $_SESSION['db']);
		echo(mysql_error());

		while($row = mysql_fetch_array($retval)){
			echo $row['Name'] . "<br>";		
		}
		
			
		echo "<br>Muzete pridat nasledujici skladby:<br>";
		$SQL = "select Name, ID from compositions where ID not in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
		
		$retval = mysql_query($SQL, $_SESSION['db']);
		echo(mysql_error());
?>
		<select multiple name="comps_to_add[]">
<?php
		while($row = mysql_fetch_array($retval)){
			echo "<option value=" . $row['ID'] . ">" . $row['Name'] . "</option>";
		}		
?>
		</select>
<?php
	}
	
	mysql_close($_SESSION['db']);
}
?>
<input type=submit name=update value=Upravit>
</form>

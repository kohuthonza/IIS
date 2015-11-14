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

if(!isset($_POST['CID']))
	die("Neni vybran zadny koncert!<br><a href=\"concerts.php\">Zpet na vyber koncertu</a>");
		
?>
<a href="index.php">Zpet na hlavni stranu</a><br>
<a href="concerts.php">Zpet na koncerty</a><br>
<form method=post action="show_concert.php">
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
		
		die("<br>Zaznam odstranen</form><br>");
		//DELETE FROM `concerts` WHERE ID=14
	}
	
	if(isset($_POST['update'])){
		//update vetev
		$original_date = $_POST['Cdate'];
		
		//$SQL = "select ID from concerts where Date='$original_date'";
		//$retval = mysql_query($SQL, $_SESSION['db']);
		//$row = mysql_fetch_array($retval);
		//echo mysql_error();
		
		$concert_ID = $_POST['CID'];
		//echo "original: $original_date -> $row[ID] <br>";
		
		$SQL = "UPDATE concerts SET Name='$_POST[Cname]', Date='$_POST[Cdate]' WHERE ID='$concert_ID'";
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
			
		echo "ulozeno!";
		
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
		echo "Skladba odstranena!<br>";
		//header('Location: show_concert.php');
	}
	
	echo "<br>Nazev koncertu:<br>";
	echo "<input type=text name=\"Cname\" value=\"$_POST[Cname]\"><br>";

	echo "Datum koncertu (YYYY-MM-DD):<br>";
	echo "<input type=text name=\"Cdate\" value=\"$_POST[Cdate]\"><br>";
	
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
	
	echo "<br>Muzete pridat nasledujici hudebniky:<br>";
	$SQL = "select Name, SName, RC, Sm, D, Str from musicians where RC not in (select music_RC from concert_musician where concert_ID in (select ID from concerts where Date='$_POST[Cdate]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
?>
	<select name="musicians_to_add[]" multiple>
<?php
	while($row = mysql_fetch_array($retval)){
		echo "<option value=" . $row['RC'] . ">" . $row['Name'] ." " . $row['SName'] . " ($row[Sm]) ($row[D]) ($row[Str])" . "</option>";
	}		
?>
	</select>
<?php

	
		
	echo "<br>Muzete pridat nasledujici skladby:<br>";
	$SQL = "select Name, ID, Sm, D, Str from compositions where ID not in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
	
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());
?>
	<select name="comps_to_add[]" multiple>
<?php
	while($row = mysql_fetch_array($retval)){
		echo "<option value=" . $row['ID'] . ">" . $row['Name'] . " ($row[Sm]) ($row[D]) ($row[Str])" . "</option>";
	}		
?>
	</select>
<?php
	
	
	//mysql_close($_SESSION['db']);
}
?>
<br>
<input type=submit name=update value="Upravit koncert">
<input type=submit name=deleteC value="Odstranit koncert">
</form>

<?php
	echo "Hudebnici v koncertu:<br>";
	
	$SQL = "select Name, SName, RC, Sm, D, Str from musicians where RC in (select music_RC from concert_musician where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[CID]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());

	while($row = mysql_fetch_array($retval)){
		echo "<form method=post action=show_concert.php>
				<input type=text value=\"$row[Name]" . " " . $row['SName'] . " ($row[Sm]) ($row[D]) ($row[Str])" . "\">
				<input type=submit value=\"Odstranit hudebnika\">" . 
				"<input type=hidden name=deleteMID value=$row[RC]>".
				"<input type=hidden name=CID value=$_POST[CID]>" . 
				"<input type=hidden name=Cname value=\"$_POST[Cname]\">" . 
				"<input type=hidden name=Cdate value=$_POST[Cdate]>" . 
				"</form>";
	}
	
	echo "Skladby v koncertu:<br>";
	$SQL = "select Name, ID, Sm, D, Str from compositions where ID in (select comp_ID from concert_composition where concert_ID = $_POST[CID])";//in (select ID from concerts where Date='$_POST[Cdate]'))";
	$retval = mysql_query($SQL, $_SESSION['db']);
	echo(mysql_error());

	while($row = mysql_fetch_array($retval)){
		echo "<form method=post action=show_concert.php>
				<input type=text value=\"$row[Name] ($row[Sm]) ($row[D]) ($row[Str])\">
				<input type=submit value=\"Odstranit skladbu\">" . 
				"<input type=hidden name=deleteCompID value=$row[ID]>".
				"<input type=hidden name=CID value=$_POST[CID]>" . 
				"<input type=hidden name=Cname value=\"$_POST[Cname]\">" . 
				"<input type=hidden name=Cdate value=$_POST[Cdate]>" . 
				"</form>";			
	}
	
	mysql_close($_SESSION['db']);
?>

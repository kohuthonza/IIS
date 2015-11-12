<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}

if($_SESSION['role'] != 1){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 1<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}
?>


<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="personel.css" rel="stylesheet">

<title>Seznam hudebníků</title>
</head>
<body>
<div class="container-fluid">
	
	<div class="row">
		&nbsp;
	</div>
	
	

	<div class="form-group row">
		<div class="col-lg-2">
		    <form action="add_user.php">
			<button class="btn btn-lg" type="submit">Přidat hudebníka</button>
			</form>
		</div>
		<div class="col-lg-2 col-lg-offset-3">
		    <form action="index.php">
			<span class="pull-right">
			<button class="btn btn-lg" type="submit">Zpět na hlavní stranu</button>
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
	
	<div class="row">
		&nbsp;
	</div>


<table class="table table-bordered table-condensed">
<form method="post" action="personel.php">
		<tr>	
		<th>Jméno</th>
		<th>Příjmení</th>
		<th>Rodné číslo</th>
		<th>Město</th>
		<th>Telefon</th>
		<th>E-mail</th>
		<th><button class="btn btn-md" type="submit" name="clear">Vyčistit</button></th>
		</tr>
</form>		
<form method=post action=personel.php>
	<tr>
	<td><input type=text name=Fname value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fname'])){ echo $_POST['Fname'];}?>'> </td>
	<td><input type=text name=Fsname value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fsname'])){ echo $_POST['Fsname'];}?>'> </td>
	<td><input type=text name=Frc value=<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Frc'])){ echo $_POST['Frc'];}?>> </td>
	<td><input type=text name=Ftown value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Ftown'])){ echo $_POST['Ftown'];}?>'> </td>
	<td><input type=text name=Fphone value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fphone'])){ echo $_POST['Fphone'];}?>'> </td>
	<td><input type=text name=Femail value=<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Femail'])){ echo $_POST['Femail'];}?>> </td>
	<td><button class="btn btn-md" type="submit" name="filter">Filtrovat</button></td>
</form>
</table> 



<?php

if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}

if(!db_connect())
	die("Nepodarilo se pripojit k databazi!");

//if the page recieved a command to update a specific row of the table
if(isset($_POST['updatebtn'])){
	if($_POST['sm'] != 'F' and $_POST['sm'] != 'T')
		die("Nespravne zadana hodnota 'umi smycec'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	if($_POST['d'] != 'F' and $_POST['d'] != 'T')
		die("Nespravne zadana hodnota 'umi dech'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	if($_POST['str'] != 'F' and $_POST['str'] != 'T')
		die("Nespravne zadana hodnota 'umi strunny'! Zadejte T/F!<br><a href=\"personel.php\">Znovu nacist</a>");
	
	$updateQry = "update musicians set Name='$_POST[name]', SName='$_POST[Sname]', Town='$_POST[town]', RC='$_POST[rc]', Phone='$_POST[phone]', Email='$_POST[email]', Sm='$_POST[sm]', D='$_POST[d]', Str='$_POST[str]' where RC='$_POST[hidden]'";

	mysql_query($updateQry, $_SESSION['db']);
};

if(isset($_POST['deletebtn'])){
	$deleteQry = "delete from musicians where RC='$_POST[hidden]'";
	mysql_query($deleteQry, $_SESSION['db']);
};

$SQL = "select * from musicians";

if(isset($_POST['filter'])){
	$where = "where";
	if(!empty($_POST['Fname'])){
		$SQL = $SQL . " $where Name='$_POST[Fname]'";
		$where = " and";
	}
	if(!empty($_POST['Fsname'])){
		$SQL = $SQL . " $where SName='$_POST[Fsname]'";
		$where = " and";
	}
	if(!empty($_POST['Frc'])){
		$SQL = $SQL . " $where RC='$_POST[Frc]'";
		$where = " and";			
	}
	if(!empty($_POST['Ftown'])){
		$SQL = $SQL . " $where Town='$_POST[Ftown]'";
		$where = " and";
	}
	if(!empty($_POST['Fphone'])){
		$SQL = $SQL . " $where Phone='$_POST[Fphone]'";
		$where = " and";
	}
	if(!empty($_POST['Femail'])){
		$SQL = $SQL . " $where Email='$_POST[Femail]'";
		$where = " and";
	}
	
};
#echo $SQL;

$retval = mysql_query($SQL, $_SESSION['db']);

echo "<table class=\"table table-bordered table-hover table-condensed\">
		<tr class=\"info\">
		<th>Jméno</th>
		<th>Příjmení</th>
		<th>Rodné číslo</th>
		<th>Město</th>
		<th>Telefon</th>
		<th>E-mail</th>
		<th>Smyčcové</th>
		<th>Dechové</th>
		<th>Strunné</th>
		</tr>";

while($row = mysql_fetch_array($retval)){
	echo "<form method=post action=personel.php>";
	echo "<tr class=\"warning\">";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=name value='" . $row['Name'] . "'></td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=Sname value='" . $row['SName'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=rc value=" . $row['RC'] . " </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=town value='" . $row['Town'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=phone value='" . $row['Phone'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=email value=" . $row['Email'] . " </td>";	
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=text name=sm value=" . $row['Sm'] . " </td>";
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=text name=d value=" . $row['D'] . " </td>";
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=text name=str value=" . $row['Str'] . " </td>";
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=hidden name=hidden </td>";
	echo "<td class=\"col-lg-1\">" . "<button class=\"btn btn-md btn-success\" type=\"submit\" name=\"updatebtn\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button>" . " </td>";
	echo "<td class=\"col-lg-1\">" . "<button class=\"btn btn-md btn-danger\" type=\"submit\" name=\"deletebtn\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>" . " </td>";
	echo "</tr>";
	echo "</form>";
}
echo "</table>";
mysql_close($_SESSION['db']);

?>



</div>
</body>
</html>

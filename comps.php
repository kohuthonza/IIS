<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}

if($_SESSION['role'] != 3){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
		<a href=\"index.php\">Zpet na hlavni stranu</a>
			");
}

$_SESSION['comp_added'] = false;
?>


<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<title>Seznam skladeb</title>
</head>
<body>
<div class="container-fluid">

<div class="row">
		&nbsp;
	</div>
	
	

	<div class="form-group row">
		<div class="col-lg-2">
		    <form action="add_comp.php">
			<button class="btn btn-lg" type="submit">Přidat skladbu</button>
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
		<tr>	
		<th class="col-lg-2">Název</th>
		<th class="col-lg-1">Tónina</th>
		<th class="col-lg-1">Takt</th>
		<th class="col-lg-2">Tempo</th>
		<th class="col-lg-2">Počet smyčců</th>
		<th class="col-lg-2">Počet dechů</th>
		<th class="col-lg-2">Počet strunných</th>
		<th class="col-lg-1"></th>
		<th class="col-lg-1"><font color="white">******</font></th>
		<th><form method="post" action="comps.php"><button class="btn btn-md" type="submit" name="clear"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button></form></th>
		</tr>
		
<form method="post" action="comps.php">
	<tr>
	<td class="col-lg-2"><input class="form-control" type="text" name="Fname" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fname'])){ echo $_POST['Fname'];}?>'> </td>
	<td class="col-lg-1"><input class="form-control" type="text" name="Fkey" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fkey'])){ echo $_POST['Fkey'];}?>'> </td>
	<td class="col-lg-1"><input class="form-control" type="text" name="Ftakt" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Ftakt'])){ echo $_POST['Ftakt'];}?>'> </td>
	<td class="col-lg-2"><input class="form-control" type="text" name="Ftempo" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Ftempo'])){ echo $_POST['Ftempo'];}?>'> </td>
	<td class="col-lg-2"><input class="form-control" type="text" name="Fsm" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fsm'])){ echo $_POST['Fsm'];}?>'> </td>
	<td class="col-lg-2"><input class="form-control" type="text" name="Fd" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fd'])){ echo $_POST['Fd'];}?>'> </td>
	<td class="col-lg-2"><input class="form-control" type="text" name="Fstr" value='<?php if(isset($_POST['filter']) and !isset($_POST['clear']) and !empty($_POST['Fstr'])){ echo $_POST['Fstr'];}?>'> </td>
	<td class="col-lg-1"></td>
	<td class="col-lg-1"></td>
	<td><button class="btn btn-md" type="submit" name="filter"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
</form>
</table>

	<br><br>
<?php

if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}

if(!db_connect())
	die("Nepodarilo se pripojit k databazi!");

//if the page recieved a command to update a specific row of the table
if(isset($_POST['updatebtn'])){
	$updateQry = "update compositions set Name='$_POST[name]', Comp_Key='$_POST[key]', Takt='$_POST[takt]', Tempo='$_POST[tempo]', Sm='$_POST[sm]', D='$_POST[d]', Str='$_POST[str]' where ID=$_POST[hidden]";

	#echo $updateQry;
	mysql_query($updateQry, $_SESSION['db']);
	#echo mysql_error($_SESSION['db']);
};

if(isset($_POST['deletebtn'])){
	$deleteQry = "delete from compositions where ID='$_POST[hidden]'";
	mysql_query($deleteQry, $_SESSION['db']);
	
	$deleteQry = "delete from concert_composition where ID='$_POST[hidden]'";
	mysql_query($deleteQry, $_SESSION['db']);
};

$SQL = "select * from compositions";

if(isset($_POST['filter'])){
	$where = "where";
	if(!empty($_POST['Fname'])){
		$SQL = $SQL . " $where Name='$_POST[Fname]'";
		$where = " and";
	}
	if(!empty($_POST['Fkey'])){
		$SQL = $SQL . " $where Comp_Key='$_POST[Fkey]'";
		$where = " and";
	}
	if(!empty($_POST['Ftakt'])){
		$SQL = $SQL . " $where Takt='$_POST[Ftakt]'";
		$where = " and";
	}
	if(!empty($_POST['Ftempo'])){
		$SQL = $SQL . " $where Tempo='$_POST[Ftempo]'";
		$where = " and";
	}
	if(!empty($_POST['Fsm'])){
		$SQL = $SQL . " $where Sm='$_POST[Fsm]'";
		$where = " and";
	}
	if(!empty($_POST['Fd'])){
		$SQL = $SQL . " $where D='$_POST[Fd]'";
		$where = " and";
	}
	if(!empty($_POST['Fstr'])){
		$SQL = $SQL . " $where Str='$_POST[Fstr]'";
		$where = " and";
	}
	
};
#echo $SQL;

$retval = mysql_query($SQL, $_SESSION['db']);

echo "<table class=\"table table-bordered table-hover table-condensed\">
		<tr class=\"info\">
		<th>Název</th>
		<th>Tónina</th>	
		<th>Takt</th>	
		<th>Tempo</th>			
		<th>Počet smyčců</th>
		<th>Počet dechů</th>
		<th>Počet strunných</th>
		</tr>";

while($row = mysql_fetch_array($retval)){
	echo "<form method=post action=comps.php>";
	echo "<tr class=\"warning\">";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=name value='" . $row['Name'] . "' </td>";
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=text name=key value='" . $row['Comp_Key'] . "' </td>";
	echo "<td class=\"col-lg-1\">" . "<input class=\"form-control\" type=text name=takt value='" . $row['Takt'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=tempo value='" . $row['Tempo'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=sm value='" . $row['Sm'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=d value='" . $row['D'] . "' </td>";
	echo "<td class=\"col-lg-2\">" . "<input class=\"form-control\" type=text name=str value='" . $row['Str'] . "' </td>";
	echo "<td>" . "<input type=hidden name=hidden value=" . $row['ID'] . " </td>";
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
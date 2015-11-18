<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("./tmp");
session_start();
include_once('functions.php');
if(!isset($_SESSION['logged'])){
	header('Location: index.php');
}

if($_SESSION['role'] != 2){
	$val = $_SESSION['role'];
	die("Na tuto stranku nemate pristup! Vase role: $val. Potrebna role: 2<br>
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

<title>Seznam koncertů</title>
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






<?php

if(!db_connect())
	die("Nepodarilo se pripojit k databazi!");


if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
  $startrow = 0;
} 
else {
  $startrow = (int)$_GET['startrow'];
}

$SQL = "SELECT * FROM concerts ORDER BY Date LIMIT $startrow, 10";
//$retval = mysql_query($SQL, $_SESSION['db']);

$fetch = mysql_query($SQL, $_SESSION['db'])or
die(mysql_error());
?>

<?php
   $num=Mysql_num_rows($fetch);
        if($num>0)
        {
        echo "<table class=\"table-bordered table-condensed\">";
        echo "<tr><th>Název koncertu</th><th>Datum koncertu</th></tr>";
        for($i=0;$i<$num;$i++){
			$row=mysql_fetch_row($fetch); 
?>
			<form method="post" action="show_concert.php">
			<tr>				
				<td><input type="hidden" name="Cname" value="<?php echo $row[1]; ?>"></input><?php echo $row[1]; ?></td>
				<td><input type="hidden" name="Cdate" value="<?php echo $row[2]; ?>"></input><?php echo $row[2]; ?></td>
				<td><input type="hidden" name="CID" value="<?php echo $row[0]; ?>"></input></td>
				<td><button class="btn btn-md btn-success" type="submit" name="select"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>
			</tr>
			</form>
<?PHP       
		}//for
        echo"</table>";
        }
?>	




<?php

$prev = $startrow - 10;

if ($prev >= 0){
    echo "
	   <div class=\"form-group row\">
	   <div class=\"col-lg-2\">
	   <form method=\"post\" action=".$_SERVER['PHP_SELF']."?startrow=".$prev.">".
      "<button class=\"btn btn-md btn-danger\" type=\"submit\"><span class=\"glyphicon glyphicon-arrow-left\" aria-hidden=\"true\"></span></span></button>".
	  "</form></div>";
}
else
    echo "<div class=\"form-group row\">";

echo "<div class=\"col-lg-2\">
      <form method=\"post\" action=".$_SERVER['PHP_SELF']."?startrow=".($startrow+10).">".
      "<button class=\"btn btn-md btn-success\" type=\"submit\"><span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span></span></button>".
	  "</form>
	   </div>
	   </div>";

?>

</div>
</body>
</html>
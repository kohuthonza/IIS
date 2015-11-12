<?php
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

<a href="add_concert.php">pridat koncert</a><br>
<a href="index.php">Zpet na hlavni stranu</a><br>
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
        echo "<table class=\"table\" id=\"adjudication\">";
        echo "<tr><th>Nazev koncertu</th><th>Datum oncertu</th></tr>";
        for($i=0;$i<$num;$i++){
			$row=mysql_fetch_row($fetch); 
?>
			<form method=post action=show_concert.php>
			<tr>				
				<td><input type=hidden name=Cname value="<?php echo $row[1]; ?>"></input><?php echo $row[1]; ?></td>
				<td><input type=hidden name=Cdate value="<?php echo $row[2]; ?>"></input><?php echo $row[2]; ?></td>
				<td><input type=hidden name=CID value="<?php echo $row[0]; ?>"></input></td>
				<td><input type=submit name=select value=Vybrat></td>
			</tr>
			</form>
<?PHP       
		}//for
        echo"</table>";
        }
?>	



<?php
echo '<div class="pagination"><ul><li class="next"><a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'">Next</a></li>';

$prev = $startrow - 10;

if ($prev >= 0)
    echo '<li class="prev"><a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'">Previous</a></li></ul></div>';
?>
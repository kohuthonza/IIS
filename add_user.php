<?php
header("Content-Type: text/html; charset=UTF-8");
include_once('functions.php');
session_save_path("./tmp");
session_start();
?>

<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="add_user.css" rel="stylesheet">
<title>
Přidat uživatele
</title>

</head>

<body>

<form method="post" action="add_user.php">

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['return'])){
		$_SESSION['ret'] = true;
	}
	else{
		$_SESSION['ret'] = false;
	}
    
	
	
	if (isset($_POST['name'])){
		$_SESSION['name'] =  $_POST['name'];
	}
	if (isset($_POST['sname'])){
		$_SESSION['sname'] =  $_POST['sname'];
	}
	if (isset($_POST['year'])){
		$_SESSION['year'] =  $_POST['year'];
	}
	if (isset($_POST['month'])){
		$_SESSION['month'] =  $_POST['month'];
	}
	if (isset($_POST['day'])){
		$_SESSION['day'] =  $_POST['day'];
	}
	if (isset($_POST['login'])){
		$_SESSION['login'] =  $_POST['login'];
	}
	if (isset($_POST['role'])){
		$_SESSION['role'] =  $_POST['role'];
	}
	if (isset($_POST['tel'])){
		$_SESSION['phone'] =  $_POST['tel'];
	}
	
	
	
	
	if (!$_SESSION['user_added'] and !$_SESSION['ret']){
	if(!db_connect())
		die('Nepodarilo se pripojit k databazi');
    
	$login = htmlspecialchars($_POST['login']);
	$pass = htmlspecialchars($_POST['passwd']);
	$name = htmlspecialchars($_POST['name']) . " " . htmlspecialchars($_POST['sname']); 
    
	$year = htmlspecialchars($_POST['year']);
	$month = htmlspecialchars($_POST['month']);
	$day = htmlspecialchars($_POST['day']);
	
	if(!((is_numeric($year) and is_numeric($month) and is_numeric($day)) or
			(empty($year) and empty($month) and empty($day) ) ) ){
		die("<font color=\"red\">Nepsravne datum narozeni!</font>");
	}

	$birth = $year . '.' . $month . '.' . $day;

	$role = htmlspecialchars($_POST['role']);

	if(empty($login) or empty($pass) or empty($name)){
		die("<font color=\"red\">Vyplnte vsechny povinne udaje!</font>");
	}
			
	$db = $_SESSION['db'];

	$cmmnd = "insert into users (Name, Login, Password, Date, Role) values ('$name', '$login', '$pass', '$birth', '$role')";
			
	if(mysql_query($cmmnd, $db)){
		$_SESSION['user_added'] = true;
	}
	else{
		if (mysql_errno($db) == 1062) {
			echo "
			
			<div class=\"container-fluid\">
			
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
			
			<h3><strong><p class=\"text-center\">Uživatel s tímto loginem již existuje</p></strong></h3>
		
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
			<div class=\"col-lg-2 col-lg-offset-5\">
				<span class=\"pull-right\">
				<button class=\"btn btn btn-lg\" name=\"return\" type=\"submit\" value=\"true\">Zpět na přidání uživatele</button>
				</span>
			</div>
			
			</div>
			
			
			
			";
			$_SESSION['filled'] = true;
		}
		else{
			echo "error: ", mysql_error($db);
			die();
		}
	}
	mysql_close($db);
    }

	
}
?>


	
	<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<?php
		$_SESSION['user_added'] = isset($_POST['name']) ? $_SESSION['user_added'] : false;
		$_SESSION['user_added'] = isset($_SESSION['user_added']) ? $_SESSION['user_added'] : false;
		$_SESSION['filled'] = isset($_SESSION['filled']) ? $_SESSION['filled'] : false;
		$_SESSION['ret'] = isset($_SESSION['ret']) ? $_SESSION['ret'] : false;
		
		if ($_SESSION['ret']){
			$_SESSION['filled'] = false;
		}
		
		if(!$_SESSION['filled']){
		if ($_SESSION['user_added']){
			
			echo"<div class=\"form-group row\">
				<div class=\"col-lg-5 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h1>
				<strong>Uživatel přidán</strong>
				</h1>
				</span>
				</div>
				<div class=\"form-group row\">
				&nbsp;
				</div>
				</div>";
		}
		}
		?>
		<div class="form-group row">
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Jméno:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['name'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"first_name\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Jméno</label>
				<div class=\"col-lg-4\">
					<input type=\"text\" class=\"form-control input-lg\" id=\"first_name\" placeholder=\"Jméno\" name=\"name\" value=\""; if(isset($_SESSION['name'])){ echo $_SESSION['name'];} else{ echo "";}; echo "\" required>
				</div>
				<label for=\"first_name\" class=\"control-label input-lg text-right\">*</label>";
				unset($_SESSION['name']);
			}
			}
			
			?>
		</div>
		<div class="form-group row">
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Příjmení:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['sname'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"second_name\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Příjmení</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"second_name\" placeholder=\"Příjmení\" name=\"sname\" value=\""; if(isset($_SESSION['sname'])){ echo $_SESSION['sname'];} else{ echo "";}; echo "\" required>
				</div>
				<label for=\"second_name\" class=\"control-label input-lg text-right\">*</label>";
				unset($_SESSION['sname']);
			}
			}
			?>
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Datum narození:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['day'] . ". " . $_POST['month'] . ". " . $_POST['year'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"birth_date\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Datum narození</label>
				
				<div class=\"col-lg-1\">
				<select required class=\"form-control\"  name=\"day\">
					<option value=\"\" disabled selected>DD</option>";
					for ($i = 1; $i <= 31; $i++) : 
						if (isset($_SESSION['day'])){
							if ($i == $_SESSION['day']){
								echo "<option value=\"" . $i . "\"selected>" . $i . "</option>";
							}
							else{
								echo "<option value=\"" . $i . "\">" . $i . "</option>";
							}
						}
						else{
							echo "<option value=\"" . $i . "\">" . $i . "</option>";
						}
					endfor;
					unset($_SESSION['day']);
				echo"	
				</select>
				</div>
				
				
				<div class=\"col-lg-1\">
				<select required class=\"form-control\" name=\"month\">
					<option value=\"\" disabled selected>MM</option>";
					for ($j = 1; $j <= 12; $j++) :
						if (isset($_SESSION['month'])){
							if ($j == $_SESSION['month']){
								echo "<option value=\"" . $j . "\"selected>" . $j . "</option>";
							}
							else{
								echo "<option value=\"" . $j . "\">" . $j . "</option>";
							}
						}
						else{
							echo "<option value=\"" . $j . "\">" . $j . "</option>";
						}
					endfor;
					unset($_SESSION['month']);
				echo"
				</select>
				</div>
				
				<div class=\"col-lg-2\">
				<select required class=\"form-control\" name=\"year\">
				<option value=\"\" disabled selected>RRRR</option>";
					for ($k = 1880; $k <= 2015; $k++) : 
						if (isset($_SESSION['year'])){
							if ($k == $_SESSION['year']){
								echo "<option value=\"" . $k . "\"selected>" . $k . "</option>";
							}
							else{
								echo "<option value=\"" . $k . "\">" . $k . "</option>";
							}
						}
						else{
							echo "<option value=\"" . $k . "\">" . $k . "</option>";
						}
					endfor;
					unset($_SESSION['year']);
				echo"
				</select>
				</div>
				
				<label for=\"birth_date\" class=\"control-label input-lg text-right\">*</label>";
			}
			}
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Telefon:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
					$_SESSION['tel'] = isset($_POST['user_added']) ? $_SESSION['user_added'] : "";
					echo $_SESSION['tel'];
				echo	
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"tel\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Telefon</label>
				<div class=\"col-lg-4\">
				<input type=\"tel\" class=\"form-control input-lg\" id=\"tel\" placeholder=\"Telefon\" name=\"tel\" value=\"";if(isset($_SESSION['phone'])){ echo $_SESSION['phone'];} else{ echo "";}; echo "\">
				</div>";
			}
			}
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Role:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>";
					switch($_POST['role']){
						case 1:
							echo "Správce personálu";
							break;
						case 2:
							echo "Správce koncertů";
							break;
						case 3:
							echo "Správce skladeb";
							break;
						default:
							break;
							
					};
				echo	
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"role\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Role</label>
				<div class=\"col-lg-4\">
				<select required class=\"form-control input-lg\" id=\"role\" name=\"role\">
					<option value=\"\" disabled selected>Vyberte roli</option>";
					if (isset($_SESSION['role'])){
						switch($_SESSION['role']){
							case 1:
								echo"
								<option value=\"1\" selected>Správce personálu</option>
								<option value=\"2\">Správce koncertů</option>
								<option value=\"3\">Správce skladeb</option>";	
								break;
							case 2:
								echo"
								<option value=\"1\">Správce personálu</option>
								<option value=\"2\" selected>Správce koncertů</option>
								<option value=\"3\">Správce skladeb</option>";	
								break;
							case 3:
								echo"
								<option value=\"1\">Správce personálu</option>
								<option value=\"2\">Správce koncertů</option>
								<option value=\"3\" selected>Správce skladeb</option>";	
								break;
						}
					}
					else{
						echo"
						<option value=\"1\">Správce personálu</option>
						<option value=\"2\">Správce koncertů</option>
						<option value=\"3\">Správce skladeb</option>";	
					}
				echo"	
				</select>
				</div>
				<label for=\"role\" class=\"control-label input-lg text-right\">*</label>";
			}
			}
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if ($_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-1\">
			    <span class=\"pull-right\">
				<h4>
				<strong>Přihlašovací jméno:</strong>
				</h4>
				</span>
				</div>
				<div class=\"col-lg-4\"><h4><strong>".
					$_POST['login'] .
				"</strong></h4></div>";
					
			}
			else{
				echo"
				<label for=\"login\" class=\"col-lg-2 col-lg-offset-1 control-label input-lg text-right\">Přihlašovací jméno</label>
				<div class=\"col-lg-4\">
				<input type=\"text\" class=\"form-control input-lg\" id=\"login\" placeholder=\"Přihlašovací jméno\" name=\"login\" value=\"";if(isset($_SESSION['login'])){ echo $_SESSION['login'];} else{ echo "";}; echo "\"required>
				</div>
				<label for=\"login\" class=\"control-label input-lg text-right\">*</label>";
			}
			}
			?>
		
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if (!$_SESSION['user_added']){
				
				echo"
				<label for=\"passwd\" class=\"col-lg-1 col-lg-offset-2 control-label input-lg text-right\">Heslo</label>
				<div class=\"col-lg-4\">
				<input type=\"password\" class=\"form-control input-lg\" id=\"passwd\" placeholder=\"Heslo\" name=\"passwd\" required>
				</div>
				<label for=\"passwd\" class=\"control-label input-lg text-right\">*</label>";
			}
			}
			?>
			
		</div>
		<div class="form-group row">
		
			<?php 
			if(!$_SESSION['filled']){
			if (!$_SESSION['user_added']){
				echo"
				<div class=\"col-lg-2 col-lg-offset-3\">
					<button class=\"btn btn-success btn-lg\" type=\"submit\">Přidat uživatele</button>
				</div>
				<div class=\"col-lg-2\">
					<a class=\"btn btn-warning btn-lg\" href=\"index.php\" role=\"button\">Zpět na hlavní stranu</a>
				</div>";
					
			}
			else{
				echo"
				<div class=\"col-lg-2 col-lg-offset-2\">
					<span class=\"pull-right\">
					<a class=\"btn btn-default btn-lg\" href=\"index.php\" role=\"button\">Zpět na hlavní stranu</a>
					</span>
				</div>
				<div class=\"col-lg-2 col-lg-offset-1\">
					<a class=\"btn btn-default btn-lg\" href=\"add_user.php\" role=\"button\">Přidat dalšího uživatele</a>
				</div>";
			}
			}
			?>
		
			
		</div>
		<div class="form-group row">
			<?php 
			if(!$_SESSION['filled']){
			if (!$_SESSION['user_added']){
				echo"
				<div class=\"col-lg-4 col-lg-offset-3\">
					<strong>Všechny údaje označené * jsou povinné</strong>
				</div>";
					
			}
			}
			?>
			
		</div>
	</form>
	</div>
</body>
</html>




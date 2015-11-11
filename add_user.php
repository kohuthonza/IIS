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

<body >

<form method="post" action="add_user.php">
	
	<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group row">
			&nbsp;
		</div>
		<div class="form-group row">
			<label for="first_name" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Jméno</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="first_name" placeholder="Jméno" name="name" required>
			</div>
			<label for="first_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="second_name" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Příjmení</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="second_name" placeholder="Příjmení" name="sname" required>
			</div>
			<label for="second_name" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="birth_date" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Datum narození</label>
			<div class="col-lg-1">
				<select required class="form-control" id="birth_date" name="day">
					<option value="" disabled selected>DD</option>
					<?php for ($i = 1; $i <= 31; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-lg-1">
				<select required class="form-control" name="month">
					 <option value="" disabled selected>MM</option>
					<?php for ($i = 1; $i <= 12; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-lg-2">
				<select required class="form-control" name="year">
				<option value="" disabled selected>RRRR</option>
					<?php for ($i = 1880; $i <= 2015; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<label for="birth_date" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="tel" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Telefon</label>
			<div class="col-lg-4">
				<input type="tel" class="form-control input-lg" id="tel" placeholder="Telefon">
			</div>
		</div>
		<div class="form-group row">
			<label for="role" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Role</label>
			<div class="col-lg-4">
				<select required class="form-control input-lg" id="role" name="role">
					<option value="" disabled selected>Vyberte roli</option>
					<option value="1">Správce hudebíků</option>
					<option value="2">Správce koncertů</option>
					<option value="3">Správce skladeb</option>	
				</select>
			</div>
			<label for="role" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="login" class="col-lg-2 col-lg-offset-1 control-label input-lg text-right">Přihlašovací jméno</label>
			<div class="col-lg-4">
				<input type="text" class="form-control input-lg" id="login" placeholder="Přihlašovací jméno" name="login" required>
			</div>
			<label for="login" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<label for="passwd" class="col-lg-1 col-lg-offset-2 control-label input-lg text-right">Heslo</label>
			<div class="col-lg-4">
				<input type="password" class="form-control input-lg" id="passwd" placeholder="Heslo" name="passwd" required>
			</div>
			<label for="passwd" class="control-label input-lg text-right">*</label>
		</div>
		<div class="form-group row">
			<div class="col-lg-2 col-lg-offset-3">
				<button class="btn btn-success btn-lg" type="submit">Přidat uživatele</button>
			</div>
			<div class="col-lg-2">
				<a class="btn btn-warning btn-lg" href="index.php" role="button">Zpět na hlavní stranu</a>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-4 col-lg-offset-3">
				<strong>Všechny údaje označené * jsou povinné</strong>
			</div>
		</div>
	</form>
	</div>
</body>
</html>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

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
		echo "pridano";
	}
	else{
		echo "error: ", mysql_error($db);
		die();
	}

	echo "<br>login: ", $login;
	echo "<br>pass: ", $pass;
	echo "<br>name: ", $name;
	echo "<br>date: ", $birth;
	echo "<br>role: ", $role;

	mysql_close($db);
}

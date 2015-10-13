<? echo "Informacni system Spravce Koncertu"; ?>
<br><br>
<? echo "Prosim, prohlaste se:"; ?>
<br><br>

<form method="post" action="power.php">
	Login:<br>
	<input type="text" name="login">
	<br>
	Heslo:<br>
	<input type="password" name="passwd">
	<br>
	<input type="submit" value="Prihlasit" >	
</form>

<br/>
Nebo muzete <a href="add_user.php">pridat uzivatele<a/>

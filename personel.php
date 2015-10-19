<html>
<head>

<title>Seznam hudebniku</title>
</head>
<body>

<?php
session_start();
if(!isset($_SESSION['logged'])){
	Header('Location: index.php');

}

?>


</body>
Zaznamy od lidech:<br>
<a href="index.php">Zpet na hlavni stranu</a>
</html>

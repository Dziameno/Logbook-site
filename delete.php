<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$time = time();
	
include "config.php";
$id = $_GET['id'];

$del = mysqli_query($link,"DELETE FROM flights WHERE nr_lotu = '$id'");
?>
 
<!DOCTYPE html>
<html lang="PL">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Strona Główna</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
	<img src = "logbook.svg" style="width: 40vw;"/>
    <h3> &nbsp </h3>
		<center>
		<div id ="tabs" style="width: 50%">
		<div><?php echo(date("d-m-y",$time));?></div>
		<div><?php echo(date("H:i",$time));?></div>
		</div>	
		
		<nav class="navbar navbar-dark bg-dark" style="width: 50%">
		<button class="button"><a href="welcome.php" >Menu Główne</a></button><br>
		<button class="button"><a href="new.php" >Nowy wpis</a></button><br>
        <button class="button"><a href="database.php" >Baza lotów</a></button><br>
		
		
		<div class="dropdown">
		<button class="dropbtn"><?php echo htmlspecialchars($_SESSION["username"]); ?></button>
			<div class="dropdown-content">
				<a href="settings.php">Ustawienia</a>
				<a href="logout.php">Wyloguj</a>	
			</div>
		</div> 
		
		</center>
		<br><h3>
		<?php
		if($del===TRUE)
			{
				mysqli_close($link);
				header("location:database.php");
				exit;	
			}
			else
			{
				echo "Nie udało się usunąć wpisu z bazy danych!";
			}
		?></h3>
        
</body>
</html>
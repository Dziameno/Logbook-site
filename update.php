<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$time = time();
	
include "config.php";
$id = $_POST['nr_lotu'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$producer = $_POST['aircraft'];
$registration = $_POST['aircraft_nr'];
$dep_ariport = $_POST['dep_airport'];
$dep_date = $_POST['dep_date'];
$dep_time = $_POST['dep_time'];
$arr_ariport = $_POST['arr_airport'];
$arr_date = $_POST['arr_date'];
$arr_time = $_POST['arr_time'];

$update = mysqli_query($link,"UPDATE flights SET 
name = '$name',
surname = '$surname',
producer = '$producer',
registration = '$registration',
dep_ariport = '$dep_ariport',
dep_date = '$dep_date',
dep_time = '$dep_time',
arr_ariport = '$arr_ariport',
arr_date = '$arr_date',
arr_time = '$arr_time' WHERE nr_lotu = '$id'");

?>
 
<!DOCTYPE html>
<html lang="PL">
<head>
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
		if($update===TRUE)
			{
				mysqli_close($link);
				header("location:database.php");
				exit;	
			}
			else
			{
				echo "Nie udało się zaktualizować wpisu!";
			}
		?></h3>
        
</body>
</html>
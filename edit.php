<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$time = time();
	
include "config.php";
$edit = $_GET['id'];

$update = mysqli_query($link,"SELECT * FROM flights WHERE nr_lotu = '$edit'");
$row = mysqli_fetch_array($update)
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
		
		<center>
		<form action="update.php" method="post">
			<table class="table table-striped" style="width: 50%">
					<input type="hidden" value="<?php echo $row['nr_lotu'];?>" name="nr_lotu">
					<tr><td>Pilot</td>
					<td><input type="text" value="<?php echo $row['name'];?>" name="name" required></td>
					<td><input type="text" value="<?php echo $row['surname'];?>" name="surname" required></td><td></td></tr>
					<tr><td>Samolot </td>
					<td>Producent/Model <input type="text" value="<?php echo $row['producer'];?>" name="aircraft"></td>
					<td>Rejestracja <input type="text" value="<?php echo $row['registration'];?>" name="aircraft_nr" required></td><td></td></tr>
					<tr><td>Wylot </td> 
					<td>Lotnisko <input type="text" value="<?php echo $row['dep_ariport'];?>" name="dep_airport" required></td>
					<td>Data<br><input type="date" value="<?php echo $row['dep_date'];?>" min="2020-05-01" name="dep_date" required></td>
					<td>Godzina <input type="time" value="<?php echo $row['dep_time'];?>" name="dep_time" required></td></tr>
					<tr><td>Przylot </td>
					<td>Lotnisko <input type="text" value="<?php echo $row['arr_ariport'];?>" name="arr_airport" required></td>
					<td>Data<br><input type="date" value="<?php echo $row['arr_date'];?>" min="2020-05-01" name="arr_date" required></td>
					<td>Godzina <input type="time" value="<?php echo $row['arr_time'];?>" name="arr_time" required></td></tr>
				
			</table>
			<nav class="navbar navbar-dark bg-dark" style="width: 50%">
			<input type="submit" style="margin: 0px 765px" class="button" name="submit" value="Zaktualizuj!">
		</form>
		</center>
		
</body>
</html>
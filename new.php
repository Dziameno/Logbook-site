<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$time = time();
?>

<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="UTF-8">
    <title>Nowy wpis</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
	<center>
	<img src = "logbook.svg" style="width: 40vw;"/>
	<h3> &nbsp </h3>
	<center>
		<div id ="tabs" style="width: 50%">
		<div><?php echo(date("d-m-y",$time));?></div>
		<div><?php echo(date("H:i:s",$time));?></div>
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
        
	<h1 class="">Nowy wpis do dziennika</h1>
		<?php
			require_once "config.php";

			if($_SERVER["REQUEST_METHOD"] == "POST"){

			$sql = mysqli_query($link,"INSERT INTO flights(name,surname,producer,registration,
			dep_ariport,dep_date,dep_time,arr_ariport,arr_date,arr_time,users_name) VALUES('".$_REQUEST['name']."',
			'".$_REQUEST['surname']."','".$_REQUEST['aircraft']."','".$_REQUEST['aircraft_nr']."',
			'".$_REQUEST['dep_airport']."','".$_REQUEST['dep_date']."','".$_REQUEST['dep_time']."',
			'".$_REQUEST['arr_airport']."','".$_REQUEST['arr_date']."','".$_REQUEST['arr_time']."','".$_SESSION["username"]."')");
			
			
			if($sql === TRUE){
				echo "Pomyślnie zapisano lot!";
			} else {
				echo "Coś poszło nie tak. Nie udało się zapisać lotu!";
			}

			mysqli_close($link);
			}			
		?>
		<form action="" method="post">
			<table class="table table-striped" style="width: 50%">
					<tr><td>Pilot</td>
					<td><input type="text" placeholder="Imię" name="name" required></td>
					<td><input type="text" placeholder="Nazwisko" name="surname" required></td><td></td></tr>
					<tr><td>Samolot </td>
					<td>Producent/Model <input type="text"placeholder="AIRBUS A320"  name="aircraft"></td>
					<td>Rejestracja <input type="text" placeholder="SP-ABC" name="aircraft_nr" required></td><td></td></tr>
					<tr><td>Wylot </td> 
					<td>Lotnisko <input type="text" placeholder="ICAO/IATA" name="dep_airport" required></td>
					<td>Data<br><input type="date"  min="2020-05-01" name="dep_date" required></td>
					<td>Godzina <input type="time" name="dep_time" required></td></tr>
					<tr><td>Przylot </td>
					<td>Lotnisko <input type="text" placeholder="ICAO/IATA" name="arr_airport" required></td>
					<td>Data<br><input type="date" min="2020-05-01" name="arr_date" required></td>
					<td>Godzina <input type="time" name="arr_time" required></td></tr>
				
			</table>
			<nav class="navbar navbar-dark bg-dark" style="width: 50%">
			<input type="submit" style="margin: 0px 745px" class="button" name="submit" value="Zapisz w bazie">
		</form>
	
	</center>
</body>
</html>
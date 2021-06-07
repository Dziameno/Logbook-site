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
    <title>Baza lotów</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
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
        
	<h1 class="">Baza lotów</h1>
		<center>
				<table class="table table-striped" style="width: 90%">
					<div class = "">
					<tr class="table-dark"><td></td>
					<td colspan="3">Pilot</td>
					<td colspan="3">Samolot</td>
					<td colspan="3">Wylot</td>
					<td colspan="4">Przylot</td>
					<td>Czas lotu</td><td></td></tr>
					</div>
					<tr class="table-dark"><td></td><td>Imie</td>
					<td>Nazwisko<td></td></td>
					<td>Producent/Model</td>
					<td>Rejestracja</td><td></td>
					<td>Lotnisko</td>
					<td>Data</td>
					<td>Godzina<td></td> </td>
					<td>Lotnisko</td>
					<td>Data</td>
					<td>Godzina</td>
					<td>HH:MM:SS</td><td></td></tr>
					<?php 
					require_once "config.php";

					$sql = mysqli_query($link,"SELECT * FROM flights INNER JOIN users ON users_name = username WHERE username = '".$_SESSION["username"]."'");
					$time = mysqli_query($link,"SELECT TIMEDIFF(arr_time, dep_time) AS time FROM flights INNER JOIN users ON users_name = username WHERE username = '".$_SESSION["username"]."'");
					
					while($row = mysqli_fetch_array($sql)){
					$time_result = implode (",",mysqli_fetch_row($time));
					
					echo "<tr><td></td>
					<td>".$row['name']."</td>
					<td>".$row['surname']."</td><td></td>
					<td>".$row['producer']."</td>
					<td>".$row['registration']."</td><td></td>
					<td>".$row['dep_ariport']."</td>
					<td>".$row['dep_date']."</td>
					<td>".$row['dep_time']."</td><td></td>
					<td>".$row['arr_ariport']."</td>
					<td>".$row['arr_date']."</td>
					<td>".$row['arr_time']."</td>
					<td>".$time_result."</td>
					<td><a id='delete' href='delete.php?id=".$row['nr_lotu']."'>Usuń</a></td></tr>";
					}
					mysqli_close($link);
					?>
				</table>
				
			<form method="post">		
				<button class="button" style="float: right; margin: 0px 96px"><a href="export.php">Export!</button>
			</form>
		</center>	
	</body>
</html>
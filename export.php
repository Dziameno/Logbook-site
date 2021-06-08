<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once "config.php";

function filterData(&$str) {
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if(strstr($str,'""')) $str = '"'.str_replace ('"','""', $str).'"';
}

$fileName = "Logbook-".date('d-m-y').".xls";

$fields = array('Imie','Nazwisko','Producent','Znak Rejestracyjny','Wylot',' ',' ','Przylot',' ',' ');

$excel = implode("\t", array_values($fields))."\n";

$query = mysqli_query($link,"SELECT name,surname,producer,registration,dep_ariport,dep_date,dep_time,arr_ariport,arr_date,arr_time FROM flights INNER JOIN users ON users_name = username WHERE username = '".$_SESSION["username"]."'");


if(mysqli_num_rows($query) > 0)
{
	$i=0;
	while($row = mysqli_fetch_array($query)) {
		$i++;
		$rowData = array($row['name'], $row['surname'], $row['producer'], $row['registration'], $row['dep_ariport'], $row['dep_date'], $row['dep_time'], $row['arr_ariport'], $row['arr_date'], $row['arr_time']);
		array_walk($rowData,'filterData');
		$excel .= implode("\t", array_values($rowData))."\n";
	}
		
}
else
{
	echo "Nie udało się wyexportować bazy danych do Excela!";
}

header("Content-Disposition: attachement; filename=\"$fileName\"");
header("Content-Type: application/vnd.ms-excel");

echo $excel;

exit;

?>

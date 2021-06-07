<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'logbook site');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
    die("ERROR: Utracono połączenie. " . mysqli_connect_error());
}

/* Heroku remote server */
$i++;
$cfg["Servers"][$i]["host"] = "eu-cdbr-west-03.cleardb.net"; //provide hostname
$cfg["Servers"][$i]["user"] = "b13fd7b0a07e94"; //user name for your remote server
$cfg["Servers"][$i]["password"] = "3ac53242"; //password
$cfg["Servers"][$i]["auth_type"] = "config"; // keep it as config
?>
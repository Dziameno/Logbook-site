<?php
define('DB_SERVER', 'eu-cdbr-west-01.cleardb.com');
define('DB_USERNAME', 'b13fd7b0a07e94');
define('DB_PASSWORD', '3ac53242');
define('DB_NAME', 'heroku_c856f6eb5222ec9');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
    die("ERROR: Utracono połączenie. " . mysqli_connect_error());
}

?>
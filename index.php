<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
    header("location: welcome.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Musisz podać nazwę!";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Musisz podać hasło!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: welcome.php");
                        } else{
                            $login_err = "Niepoprawne hasło lub nazwa użytkownika!";
                        }
                    }
                } else{
                    $login_err = "Niepoprawne hasło lub nazwa użytkownika!";
                }
            } else{
                echo "Coś poszło nie tak! Spróbuj ponownie.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="UTF-8">
    <title>Strona Logowania</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
	<img src = "logbook.svg">
	<h3> &nbsp </h3>
	
	<center>
	<?php 
    if(!empty($login_err)){
        echo '<div class="alert alert-warning" role="alert" style="width: 30%">' . $login_err . '</div>';}
	if(!empty($username_err)){
        echo '<div class="alert alert-warning" role="alert" style="width: 30%">' . 'Nie podałeś nazwy użytkownika!' . '</div>';}	
	if(!empty($password_err)){
        echo '<div class="alert alert-warning" role="alert" style="width: 30%">' . 'Musisz podać jeszcze hasło!' . '</div>';}	
	?>

	
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
		<table class="table table-striped" style="width: 30%">
		<tr class="table-dark">
			<td>Użytkownik</td>
			<td><input type="text" name="username"  value="<?php echo $username; ?>"></td>
			<tr class="table-dark">
			<td>Hasło</td>
			<td>
			<input type="password" name="password" >
			</td>
		</tr>
		</table>
		
		<div id ="tabs" style="width:30%">
		<div><button class="button" style="margin:0px 0px 0px"><a href="register.php">Zarejestruj!</button></div>
		<div><input type="submit" class="button" style="margin:0px 280px 0px"  value="Zaloguj"></div>

	</form>	
	</center>

</body>
</html>
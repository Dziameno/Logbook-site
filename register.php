<?php
require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Musisz podać nazwę!";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
				
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Użytkownik o takiej nazwie już istnieje!";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Coś poszło nie tak! Spróbuj ponownie.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Musisz podać hasło!";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Hasło musi mieć minimum 8 znaków!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Musisz potwierdzić hasło!";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Hasła do siebie nie pasują!";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //Hashowanie hasła
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Rejestracja konta</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="styles.css" type="text/css"/>
	<body>
		<img src = "logbook.svg"/>

		<center>
			<?php 
			if(!empty($username_err)){
			echo '<div class="alert alert-warning" role="alert" style="width: 50%">' . $username_err . '</div>';}
			?>
			
			<?php 
			if(!empty($password_err)){
			echo '<div class="alert alert-warning" role="alert" style="width: 50%">' . $password_err . '</div>';}
			?>

			<?php 
			if(!empty($confirm_password_err)){
			echo '<div class="alert alert-warning" role="alert" style="width: 50%">' . $confirm_password_err . '</div>';}
			?>
		</center>
		
		<center>
			<nav class="navbar navbar-dark bg-dark" style="width: 50%">
			<h4 style="color: white; margin: 0px 20px">Rejestracja konta w serwisie Logbook</h4>
			<button class="button"><a href="index.php" >Powrót na stronę logowania</a></button>
		</center>
		
		<center>	
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				
				<table class="table table-striped" style="width: 50%">    
				<tr><td>Nazwa użytkownika</td><td>
				<input type="text" name="username" <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?> value="<?php echo $username; ?>"></td></tr>
					   
				<tr><td>Hasło</td><td>
				<input type="password" name="password" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $password; ?>"></td></tr>
					  
				<tr><td>Potwierdź hasło</td>
				<td><input type="password" name="confirm_password" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $confirm_password; ?>"></td></tr>
				</table>
				
				<table>
				<nav class="navbar navbar-dark bg-dark" style="width: 50%">
				<input type="submit" class="button" style="margin: 0px 750px" value="Zarejestruj!">
				</table>
				
			</form>
		</center>
	</body>
</html>
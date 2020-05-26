<?php
// Initialiseer de sessie
session_start();
 
// Controleer of de gebruiker al is ingelogd, zo ja, stuur hem dan om naar de welkomstpagina
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// Inclusief configuratiebestand
require_once "config.php";
 
// Definieer variabelen en initialiseer met lege waarden
$username = $password = "";
$username_err = $password_err = "";
 
// Formuliergegevens verwerken wanneer het formulier is ingediend
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Controleer of gebruikersnaam ingevuld is
    if(empty(trim($_POST["username"]))){
        $username_err = "Voer gebruikersnaam in.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Controleer of het wachtwoord ingevuld is
    if(empty(trim($_POST["password"]))){
        $password_err = "Voer uw wachtwoord in.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Inloggegevens valideren
    if(empty($username_err) && empty($password_err)){
        // Bereid een select statement voor
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Koppel variabelen aan de voorbereide instructie als parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Stel parameters in
            $param_username = $username;
            
            // Probeer de voorbereide verklaring uit te voeren
            if(mysqli_stmt_execute($stmt)){
                // Resultaat opslaan
                mysqli_stmt_store_result($stmt);
                
                // Controleer of de gebruikersnaam bestaat, zo ja, controleer dan het wachtwoord
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Koppel resultaatvariabelen
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Wachtwoord is correct, start een nieuwe sessie
                            session_start();
                            
                            // Sla gegevens op in sessievariabelen
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Leid de gebruiker om naar de welkomstpagina
                            header("location: welcome.php");
                        } else{
                            //Geef een foutmelding weer als het wachtwoord niet geldig is
                            $password_err = "Het wachtwoord dat je hebt ingevoerd is onjuist.";
                        }
                    }
                } else{
                    //Geef een foutmelding weer als de gebruikersnaam niet bestaat
                    $username_err = "Geen account gevonden met die gebruikersnaam.";
                }
            } else{
                echo "Oeps! Er is iets fout gegaan. Probeer het later opnieuw.";
            }

            // Sluiten verklaring
            mysqli_stmt_close($stmt);
        }
    }
    
    // Sluit verbinding
    mysqli_close($link);
}
?>
 
 <?php include 'inc/header.php';?>


<div class="wrapper">
        <div >
            <div>
                <div class="col-md-12">
                    <div class="title" >
                    <h2>Login</h2>
       
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <label>Gebruikersnaam</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>    
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label>Wachtwoord</label>
                                <input type="password" name="password" class="form-control">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                            
                        </form>
                    </div>
    
                </div>
            </div>        
        </div>
    </div>
    <?php include 'inc/footer.php';?>
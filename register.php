<?php
// Configuratiebestand opnemen
require_once "config.php";
 
// Definieer variabelen en initialiseer met lege waarden
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Formuliergegevens verwerken wanneer het formulier is ingediend
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Valideer gebruikersnaam
    if(empty(trim($_POST["username"]))){
        $username_err = "Vulgebruikersnaam in.";
    } else{
        // Bereid een select statement voor
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Koppel variabelen aan de voorbereide instructie als parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Stel parameters in
            $param_username = trim($_POST["username"]);
            
            // Probeer de voorbereide verklaring uit te voeren
            if(mysqli_stmt_execute($stmt)){
                // resultaat opslaan
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Deze gebruikersnaam is al in gebruik.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oeps! Er is iets fout gegaan. Probeer het later opnieuw.";
            }

            // Sluiten instructie
            mysqli_stmt_close($stmt);
        }
    }
    
    // Bevestig wachtwoord
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Wachtwoord moet minimaal 6 tekens bevatten.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Bevestig het wachtwoord
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Bevestig het wachtwoord.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Wachtwoord komt niet overeen.";
        }
    }
    
    // Controleer invoerfouten voordat u deze in de database invoegt
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Bereid een invoeginstructie voor
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            //Koppel variabelen aan de voorbereide instructie als parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Stel parameters in
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Probeer de voorbereide verklaring uit te voeren
            if(mysqli_stmt_execute($stmt)){
                // Omleiden naar inlogpagina
                header("location: login.php");
            } else{
                echo "Er is iets fout gegaan. Probeer het later opnieuw.";
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
        <h2>Nieuwe gebruiker</h2>
        <p>Vul dit formulier in om een account aan te maken.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Bevestig wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Bevestig">
                <a href="welcome.php" class="btn btn-default">Annuleren</a>
            </div>
            <!-- <p>Already have an account? <a href="login.php">Login here</a>.</p> -->
        </form>
        <?php include 'inc/footer.php';?>
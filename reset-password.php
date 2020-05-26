<?php
// Initialiseer de sessie
session_start();
 
// Controleer of de gebruiker is ingelogd, anders doorverwijzen naar de inlogpagina
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Configuratiebestand opnemen
require_once "config.php";
 
// Definieer variabelen en initialiseer met lege waarden
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Formuliergegevens verwerken wanneer het formulier is ingediend
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Bevestig een nieuw wachtwoord
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Bevestig het wachtwoord
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Controleer invoerfouten voordat u de database bijwerkt
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Bereid een updateverklaring voor
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Koppel variabelen aan de voorbereide instructie als parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Stel parameters in
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Probeer de voorbereide verklaring uit te voeren
            if(mysqli_stmt_execute($stmt)){
                // wachtwoord succesvol bijgewerkt. Vernietig de sessie en stuur door naar de inlogpagina
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Sluit verklaring
            mysqli_stmt_close($stmt);
        }
    }
    
    // Sluit verbinding
    mysqli_close($link);
}
?>
 
 <?php include 'inc/header.php';?>
    <div class="wrapper">
        <h2>Wachtwoord veranderen</h2>
        <p></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nieuw wachtwoord</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Herhaal wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Opslaan">
                <a class="btn btn-link" href="welcome.php">Annuleren</a>
            </div>
        </form>
    </div>    
    <?php include 'inc/footer.php';?>
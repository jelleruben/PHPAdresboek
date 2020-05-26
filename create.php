<?php
// Configuratiebestand opnemen
require_once "config.php";
 
//Definieer variabelen en initialiseer met lege waarden
$name = $address = $town =$country = $email = $phone = "";
$name_err = $address_err = $town_err = $country_err = $email_err = $phone_err = "";
 
// Formuliergegevens verwerken wanneer het formulier is ingediend
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Valideren name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Vul een naam in.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Vul een geldige naam.";
    } else{
        $name = $input_name;
    }
    
    // Valideren address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Vul het adres in.";     
    } else{
        $address = $input_address;
    }
    
    // Valideren town
    $input_town = trim($_POST["town"]);
    if(empty($input_town)){
        $town_err = "Vul stadsnaam in.";     
    } else{
        $town = $input_town;
    }

    // Valideren country
    $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "Vul land in.";     
    } else{
        $country = $input_country;
    }

    // Valideren email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Vul E-Mail adres in.";     
    } else{
        $email = $input_email;
    }

    // Valideren phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Vul telefoonnr in.";     
    } else{
        $phone = $input_phone;
    }
    
    // Controleer invoerfouten voordat u deze in de database invoegt
    if(empty($name_err) && empty($address_err) && empty($town_err) && empty($country_err) && empty($email_err) && empty($phone_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO gegevens (name, address, town, country, email, phone) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Koppel variabelen aan de voorbereide instructie als parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_address, $param_town, $param_country, $param_email, $param_phone);
            
            // Stel parameters in
            $param_name = $name;
            $param_address = $address;
            $param_town = $town;
            $param_country = $country;
            $param_email = $email;
            $param_phone = $phone;
            
            // Probeer de voorbereide verklaring uit te voeren
            if(mysqli_stmt_execute($stmt)){
                // Records succesvol aangemaakt. Omleiden naar bestemmingspagina
                header("location: list.php");
                exit();
            } else{
                echo "Er is iets verkeerds gegaan, probeer het later nog eens.";
            }
        }
         
        // Sluiten verklaring
        mysqli_stmt_close($stmt);
    }
    
    // Sluit verbinding
    mysqli_close($link);
}
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <?php include 'inc/header.php';?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Nieuw Adres</h2>
                    </div>
                    <p></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Naam</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Adres</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($town_err)) ? 'has-error' : ''; ?>">
                            <label>Stad</label>
                            <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                            <span class="help-block"><?php echo $town_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>Land</label>
                            <select name="country" class="form-control" value="<?php echo $country; ?>">
                                <option value="Nederland" <?php if($options=="Nederland"); ?> >Nederland</option>
                                <option value="Duitsland" <?php if($options=="Duitsland"); ?> >Duitsland</option>
                            </select>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail adres</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Telefoon</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Opslaan">
                        <a href="index.php" class="btn btn-default">Annuleren</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <?php include 'inc/footer.php';?>
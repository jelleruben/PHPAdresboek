<?php
// Proces verwijder bewerking na bevestiging
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Bereid een verwijderingsverklaring voor
    $sql = "DELETE FROM gegevens WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Koppel variabelen aan de voorbereide instructie als parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Stel parameters in
        $param_id = trim($_POST["id"]);
        
        // Probeer de voorbereide verklaring uit te voeren
        if(mysqli_stmt_execute($stmt)){
            // Records zijn verwijderd. Omleiden naar bestemmingspagina
            header("location: list.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Sluiten verklaring
    mysqli_stmt_close($stmt);
    
    // Sluit verbinding
    mysqli_close($link);
} else{
    // Controleer het bestaan van de id-parameter
    if(empty(trim($_GET["id"]))){
        // URL bevat geen id-parameter. Omleiden naar foutpagina
        header("location: error.php");
        exit();
    }
}
?>

<?php
// Initialiseer de sessie
session_start();
 
// Controleer of de gebruiker is ingelogd, zo niet, stuur hem dan om naar de inlogpagina
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
                        <h1>Verwijder adres <?php echo $id; ?></h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Weet u zeker dat u <b><?php echo $row["name"]; ?></b> adres wilt verwijderen?</p><br>
                            <p>
                                <input type="submit" value="Ja" class="btn btn-danger">
                              
                                <a href="list.php" class="btn btn-default">Nee</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <?php include 'inc/footer.php';?>
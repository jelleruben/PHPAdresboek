<?php
// Controleer het bestaan van de id-parameter voordat u verder gaat
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Bereid een select statement voor
    $sql = "SELECT * FROM gegevens WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Koppel variabelen aan de voorbereide instructie als parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Stel parameters in
        $param_id = trim($_GET["id"]);
        
        // Probeer de voorbereide verklaring uit te voeren
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Haal de resultaatrij op als een associatieve array. Aangezien het resultaat is ingesteld
                 bevat slechts één rij, we hoeven de while-lus niet te gebruiken */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Haal individuele veldwaarde op
                $id = $row["id"];
                $name = $row["name"];
                $address = $row["address"];
                $town = $row["town"];
                $email = $row["email"];
                $phone = $row["phone"];
               
            } else{
                // URL bevat geen geldige id-parameter. Omleiden naar foutpagina
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oeps! Er is iets fout gegaan. Probeer het later opnieuw.";
        }
    }
     
    // Sluiten verklaring
    mysqli_stmt_close($stmt);
    
    //Sluit de verbinding
    mysqli_close($link);
} else{
    // URL bevat geen id-parameter. Omleiden naar foutpagina
    header("location: error.php");
    exit();
}
?>


<?php include 'inc/header.php';?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Adres details van <b><?php echo $row["name"]; ?></b></h1>
                    </div>
                    <div class="form-group">
                        <label>Naam</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Adres</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Stad</label>
                        <p class="form-control-static"><?php echo $row["town"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Land</label>
                        <p class="form-control-static"><?php echo $row["country"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Telefoon</label>
                        <p class="form-control-static"><?php echo $row["phone"]; ?></p>
                    </div>
                    <div class="anker">
                    
                    <?php if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
                    {
                    ?>
                        <a href="update.php?id=<?php echo $id; ?>" class="btn btn-primary">Bewerk</a>
                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Verwijder</a>
                    <?php }else{ ?> 
                        <a href="update.php?id=<?php echo $id; ?>" class="btn btn-primary">Bewerk</a>
                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Verwijder</a>
                    <?php } ?>


                    <a href="list.php" class="btn btn-default">Terug</a>

      
                    
                    </div>
                </div>
            </div>        
        </div>
    </div>

    <?php include 'inc/footer.php';?>
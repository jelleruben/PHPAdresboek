
<?php include 'inc/header.php';?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Adressen</h2>
                        <!-- <a href="create.php" class="btn btn-success pull-right">Voeg nieuwe adres toe</a> -->
                    </div>
                    <?php
                    // config bestand laden
                        require_once "config.php";
                        
                        // Query selectie
                        $sql = "SELECT * FROM gegevens";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>Naam</th>";
                                            echo "<th>Adres</th>";
                                            echo "<th>Plaats</th>";

                                            echo "<th></th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['town'] . "</td>";

                                            echo "<td>";
                                                echo "<a href='read.php?id=". $row['id'] ."' title='Bekijk Adres' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>Er zijn geen adressen gevonden.</em></p>";
                        }
                    } else{
                        echo "ERROR: Kon niet uitvoeren $sql. " . mysqli_error($link);
                    }
 
                    // Verbinding sluiten
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
    <?php include 'inc/footer.php';?>
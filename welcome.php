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
        <div >
        
            <div>
                <div class="col-md-12">
                    <div class="title" >
                    <h1>Welkom <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
                    <p class="usermenu">
                        <a href="create.php"class="btn btn-success">Nieuwe adres toevoegen</a><br>
                        <a href="register.php" class="btn btn-success">Nieuwe Gebruiker</a><br>
                        <a href="reset-password" class="btn btn-danger">Wachtwoord veranderen</a><br>
                        <a href="logout.php" class="btn btn-danger">Log uit</a>
                    </p>
                    </div>
    
                </div>
            </div>        
        </div>
    </div>
    <?php include 'inc/footer.php';?>
<?php
// Initialiseer de sessie
session_start();
 
// Schakel alle sessievariabelen uit
$_SESSION = array();
 
// Vernietig de sessie.
session_destroy();
 
// Omleiden naar inlogpagina
header("location: list.php");
exit;
?>
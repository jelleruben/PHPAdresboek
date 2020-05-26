<?php
/* Database variablen. */
define('DB_SERVER', '*******');
define('DB_USERNAME', '**********');
define('DB_PASSWORD', '*********');
define('DB_NAME', '**********');
define('DB_PORT', ******);
 
/* Connectie naar Database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
 
// controleer verbinding
if($link === false){
    die("ERROR: Geen verbinding. " . mysqli_connect_error());
}
?>

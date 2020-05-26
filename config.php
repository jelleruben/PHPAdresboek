<?php
/* Database variablen. */
define('DB_SERVER', '192.168.178.13');
define('DB_USERNAME', 'jelleruben');
define('DB_PASSWORD', '@11AuGu78!');
define('DB_NAME', 'adresboek');
define('DB_PORT', 3307);
 
/* Connectie naar Database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
 
// controleer verbinding
if($link === false){
    die("ERROR: Geen verbinding. " . mysqli_connect_error());
}
?>
<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'projects');
define('DB_NAME', 'shop');
 

//  define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'dmitryznak');
// define('DB_PASSWORD', '99Rhjirf99');
// define('DB_NAME', 'dmitryznak');
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
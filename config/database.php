<?php
// define('DB_HOST', '192.168.177.20:3307');
// define('DB_USER', 'german');
// define('DB_PASS', 'german');
// define('DB_NAME', 'rmv_cims');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rmv_cims');

// Create a database connection
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (!$conn){
   die ("Connecton failed: " . mysqli_connect_error());
}
?>
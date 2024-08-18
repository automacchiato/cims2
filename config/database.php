<?php
define('DB_HOST', 'root');
define('DB_USER', '');
define('DB_PWD', '');
define('DB_NAME', 'rmvproject');

//Create a database connection
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

//Check connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}


?>
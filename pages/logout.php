<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: dashboard.php");
exit;
?>
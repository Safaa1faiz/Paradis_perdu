<?php
session_name('user');

session_start(); // start the session

// remove all session variables
session_unset();

// destroy the session
session_destroy();

// redirect to the login page
header("Location: index.php");
exit;
?>
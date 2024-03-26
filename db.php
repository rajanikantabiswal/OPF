<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$servername = "localhost:3306"; // Replace with your server name
$username = "root"; // Replace with your username
$password = "root@123"; // Replace with your password
$dbname = "pincodes"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection sfailed: " . $conn->connect_error);
}
?>


<?php
// config.php
$servername = "localhost";
$username = "root";  // Update with your database username
$password = "";      // Update with your database password
$database = "voting_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

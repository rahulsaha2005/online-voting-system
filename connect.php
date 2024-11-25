<?php
// Database connection details
$servername = "localhost"; // Your database server (typically 'localhost' for local XAMPP setup)
$username = "root"; // Your database username (default for XAMPP)
$password = ""; // Your database password (default for XAMPP is empty)
$database = "voting"; // Your database name (change to match your actual database)

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

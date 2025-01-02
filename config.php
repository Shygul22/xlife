<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = "127.0.0.1";
$db_user = "root";
$db_pass = "";
$db_name = "user_auth";

try {
    // First connect without database selection
    $conn = mysqli_connect($db_host, $db_user, $db_pass);
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating database: " . mysqli_error($conn));
    }

    // Select the database
    if (!mysqli_select_db($conn, $db_name)) {
        throw new Exception("Error selecting database: " . mysqli_error($conn));
    }

    // Create users table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        reset_token VARCHAR(64) DEFAULT NULL,
        reset_token_expiry DATETIME DEFAULT NULL
    )";
    
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating table: " . mysqli_error($conn));
    }

} catch (Exception $e) {
    die("Setup failed: " . $e->getMessage());
}
?>

<?php
$host = 'localhost';
$dbname = 'zenjourney_db';
$username = 'root';
$password = '';

try {
    // First try to connect to the database
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        // If database doesn't exist, create it
        if($e->getCode() == 1049) {
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
            $pdo->exec("USE $dbname");
            
            // Create users table
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
        } else {
            throw $e;
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>

<?php
function getDB() {
    static $db = null;
    if ($db === null) {
        $host = 'localhost';
        $dbname = 'zenjourney_db'; // Updated database name
        $user = 'root';
        $pass = '';
        
        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }
    return $db;
}

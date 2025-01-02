<?php
function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check for session hijacking
    if (!isset($_SESSION['ip']) || $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
        logout();
        exit();
    }
    
    // Check for session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        logout();
        exit();
    }
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: /zenjourney files/login.php");
        exit();
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();
    return $_SESSION['user_id'];
}

function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['ip']) && 
           $_SESSION['ip'] === $_SERVER['REMOTE_ADDR'];
}

function logout() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
    header("Location: /zenjourney files/login.php");
    exit();
}

function initSession($user_id, $username) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['last_activity'] = time();
    session_regenerate_id(true); // Prevent session fixation
}
?>

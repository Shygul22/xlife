<?php
require_once 'includes/auth.php';
$pageTitle = 'Welcome to Task Manager';

$isLoggedIn = isLoggedIn();

require_once 'includes/header.php';

if ($isLoggedIn) {
    // If logged in, include the task management interface
    header("Location: includes/index.php");
    exit();
} else {
    // If not logged in, show the landing page
    require_once 'https://zenjourney.in/';
}

require_once 'includes/footer.php';
?>

<?php
session_start();
session_destroy();
header("Location: auth.php");  // Changed from login.php to auth.php
exit();
?>
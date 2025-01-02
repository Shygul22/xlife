<?php
require_once 'config.php';
require_once 'includes/auth.php';
session_start();

// Already logged in users should be redirected
if (isLoggedIn()) {
    header("Location: includes/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    // Add brute force protection
    if (checkLoginAttempts($_SERVER['REMOTE_ADDR'])) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                // Initialize secure session
                initSession($row['id'], $row['username']);
                resetLoginAttempts($_SERVER['REMOTE_ADDR']);
                header("Location: includes/index.php");
                exit();
            }
        }
        recordFailedLogin($_SERVER['REMOTE_ADDR']);
        $error = "Invalid username or password";
    } else {
        $error = "Too many failed attempts. Please try again later.";
    }
}

// Brute force protection functions
function checkLoginAttempts($ip) {
    $attempts = isset($_SESSION['login_attempts'][$ip]) ? $_SESSION['login_attempts'][$ip] : ['count' => 0, 'time' => time()];
    
    // Reset attempts after 15 minutes
    if (time() - $attempts['time'] > 900) {
        $_SESSION['login_attempts'][$ip] = ['count' => 0, 'time' => time()];
        return true;
    }
    
    return $attempts['count'] < 5;
}

function recordFailedLogin($ip) {
    if (!isset($_SESSION['login_attempts'][$ip])) {
        $_SESSION['login_attempts'][$ip] = ['count' => 0, 'time' => time()];
    }
    $_SESSION['login_attempts'][$ip]['count']++;
}

function resetLoginAttempts($ip) {
    $_SESSION['login_attempts'][$ip] = ['count' => 0, 'time' => time()];
}

$pageTitle = 'Login';
require_once 'includes/header.php';
?>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.7)] p-8 mt-10">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800 tracking-wide">Login</h2>
        <?php if(isset($error)) echo "<p class='text-red-500 text-center mb-6 bg-red-50 py-2 rounded'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Username:</label>
                <input type="text" name="username" required 
                    class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
            </div>
            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Password:</label>
                <input type="password" name="password" required 
                    class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
            </div>
            <button type="submit" 
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                Login
            </button>
        </form>
        <p class="text-center mt-6 text-gray-600">
            Don't have an account? 
            <a href="register.php" class="text-blue-500 hover:text-blue-700 font-semibold transition-colors duration-200">Register here</a>
        </p>
    </div>
</body>
</html>

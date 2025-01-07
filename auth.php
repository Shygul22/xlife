<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'register') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            if ($password !== $confirm_password) {
                $error = "Passwords do not match!";
            } else {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                
                if ($stmt->rowCount() > 0) {
                    $error = "Email already exists!";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    if ($stmt->execute([$username, $email, $hashed_password])) {
                        $_SESSION['success'] = "Registration successful! Please login.";
                        header("Location: auth.php");
                        exit();
                    }
                }
            }
        } elseif ($_POST['action'] === 'login') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register - ZenJourney</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .auth-container {
            min-height: calc(100vh - 2rem);
            background: linear-gradient(135deg, #f6f7ff 0%, #e9ebff 100%);
        }
        .form-transition {
            transition: all 0.3s ease-in-out;
        }
        .auth-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="auth-container flex items-center justify-center p-4">
        <div class="auth-card rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <!-- Logo and Title -->
            <div class="text-center py-6 bg-gradient-to-r from-blue-500 to-blue-600">
                <h1 class="text-2xl font-bold text-white">ZenJourney</h1>
                <p class="text-blue-100">Your Journey Begins Here</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="mx-4 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="mx-4 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Tab Navigation -->
            <div class="flex border-b bg-gray-50">
                <button onclick="toggleForm('login')" id="loginTab" 
                    class="flex-1 py-3 px-4 text-center font-semibold transition-all duration-200">
                    Login
                </button>
                <button onclick="toggleForm('register')" id="registerTab"
                    class="flex-1 py-3 px-4 text-center font-semibold transition-all duration-200">
                    Register
                </button>
            </div>

            <!-- Forms Container -->
            <div class="p-6">
                <!-- Login Form -->
                <form id="loginForm" method="POST" action="" class="form-transition">
                    <input type="hidden" name="action" value="login">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="login-email">Email</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="login-email" name="email" type="email" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="login-password">Password</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="login-password" name="password" type="password" required>
                        </div>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                            type="submit">Login</button>
                    </div>
                </form>

                <!-- Register Form -->
                <form id="registerForm" method="POST" action="" class="hidden form-transition">
                    <input type="hidden" name="action" value="register">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="username" name="username" type="text" required>
                        </div>
                         <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="register-email">Email</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="register-email" name="email" type="email" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="register-password">Password</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="register-password" name="password" type="password" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">Confirm Password</label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="confirm_password" name="confirm_password" type="password" required>
                        </div>
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                            type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleForm(formType) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            
            const activeClasses = 'bg-white text-blue-600 border-b-2 border-blue-600';
            const inactiveClasses = 'text-gray-500 hover:text-gray-700';

            if (formType === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTab.className = `flex-1 py-3 px-4 text-center font-semibold ${activeClasses}`;
                registerTab.className = `flex-1 py-3 px-4 text-center font-semibold ${inactiveClasses}`;
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                registerTab.className = `flex-1 py-3 px-4 text-center font-semibold ${activeClasses}`;
                loginTab.className = `flex-1 py-3 px-4 text-center font-semibold ${inactiveClasses}`;
            }
        }

        // Initialize the form state
        document.addEventListener('DOMContentLoaded', () => toggleForm('login'));
    </script>
</body>
</html>

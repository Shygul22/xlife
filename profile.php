<?php
require_once 'config.php';
session_start();
$pageTitle = 'Profile';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

require_once 'includes/header.php';
?>
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">User Profile</h1>
        <div class="space-y-4">
            <div class="flex border-b py-2">
                <span class="font-bold w-32 text-gray-600">Username:</span>
                <span class="text-gray-800"><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            <div class="flex border-b py-2">
                <span class="font-bold w-32 text-gray-600">Email:</span>
                <span class="text-gray-800"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="flex border-b py-2">
                <span class="font-bold w-32 text-gray-600">Mobile:</span>
                <span class="text-gray-800"><?php echo htmlspecialchars($user['mobile']); ?></span>
            </div>
            <div class="flex border-b py-2">
                <span class="font-bold w-32 text-gray-600">Member Since:</span>
                <span class="text-gray-800"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></span>
            </div>
        </div>
    </div>
</body>
</html>


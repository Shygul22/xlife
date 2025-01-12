<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Database connection
require_once __DIR__ . '/../config/db.php';

// Get user data with proper error handling
$user_id = $_SESSION['user_id'];
try {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception('User not found');
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Set default values if fields are not set
$first_name = isset($user['first_name']) ? $user['first_name'] : '';
$last_name = isset($user['last_name']) ? $user['last_name'] : '';
$email = isset($user['email']) ? $user['email'] : '';
$username = isset($user['username']) ? $user['username'] : '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize and validate inputs
        $updates = [
            'first_name' => trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING)),
            'last_name' => trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING)),
            'email' => trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)),
            'phone' => trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)),
            'location' => trim(filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING)),
            'bio' => trim(filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING))
        ];

        // Validate required fields
        if (empty($updates['email'])) {
            throw new Exception('Email is required');
        }

        // Begin transaction
        $conn->beginTransaction();

        // Update database
        $stmt = $conn->prepare("
            UPDATE users 
            SET first_name = ?, 
                last_name = ?, 
                email = ?,
                phone = ?,
                location = ?,
                bio = ?
            WHERE id = ?
        ");

        $success = $stmt->execute([
            $updates['first_name'],
            $updates['last_name'],
            $updates['email'],
            $updates['phone'],
            $updates['location'],
            $updates['bio'],
            $_SESSION['user_id']
        ]);

        if (!$success) {
            throw new Exception('Failed to update profile');
        }

        $conn->commit();

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
            exit;
        }

        header('Location: index.php?page=profile&updated=1');
        exit;

    } catch (Exception $e) {
        if (isset($conn)) {
            $conn->rollBack();
        }

        error_log('Profile Update Error: ' . $e->getMessage());

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }

        $error = $e->getMessage();
    }
}

// Add better data validation
$user_data = [
    'display_name' => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: $user['username'],
    'email' => $user['email'] ?? '',
    'phone' => $user['phone'] ?? '',
    'location' => $user['location'] ?? '',
    'bio' => $user['bio'] ?? '',
    'avatar_letter' => strtoupper(substr($user['first_name'] ?: $user['username'], 0, 1))
];

// Sanitize all user data
foreach ($user_data as $key => $value) {
    $user_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar Section -->
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-4xl font-bold text-blue-600">
                        <?php echo strtoupper(substr($first_name ?: $username, 0, 1)); ?>
                    </span>
                </div>
                
                <!-- Updated User Info Section -->
                <div class="flex-grow">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="space-y-2">
                            <h1 class="text-2xl font-bold text-gray-800 username-display">
                                <?php echo $user_data['display_name']; ?>
                            </h1>
                            <div class="flex items-center text-gray-600 text-sm space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo $user_data['email']; ?>
                                </span>
                                <?php if (!empty($user_data['phone'])): ?>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <?php echo $user_data['phone']; ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($user_data['location'])): ?>
                        <div class="mt-4 md:mt-0">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 11a3 3 0 11-6 0 3 3 0z"/>
                                </svg>
                                <span class="text-sm"><?php echo $user_data['location']; ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($user_data['bio'])): ?>
                    <div class="mt-6 text-gray-600">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">About</h3>
                        <p class="text-sm whitespace-pre-line"><?php echo nl2br($user_data['bio']); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['updated'])): ?>
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative">
                        <span class="block sm:inline">Profile updated successfully!</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
            </h2>

            <!-- Success Message -->
            <?php if (isset($_GET['updated'])): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative">
                <span class="block sm:inline">Profile updated successfully!</span>
            </div>
            <?php endif; ?>

            <form id="profile-form" method="POST" class="space-y-6">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" 
                               value="<?php echo htmlspecialchars($first_name); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" 
                               value="<?php echo htmlspecialchars($last_name); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required
                               value="<?php echo htmlspecialchars($email); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" name="phone"
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               pattern="[0-9+\-\s()]*">
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" name="location"
                           value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea name="bio" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                </div>

                <!-- Add message div that was missing -->
                <div id="profile-message" class="hidden mt-4"></div>
                <div id="profile-spinner" class="hidden">
                    <!-- Spinner SVG -->
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="reset" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profile-form');
    const messageDiv = document.getElementById('profile-message');
    
    if (profileForm) {
        profileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(profileForm);
            
            try {
                const response = await fetch('index.php?page=profile', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                
                messageDiv.textContent = result.message;
                messageDiv.className = `mt-4 p-3 rounded ${
                    result.success ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'
                }`;
                messageDiv.classList.remove('hidden');

                if (result.success) {
                    setTimeout(() => window.location.reload(), 1500);
                }
            } catch (error) {
                messageDiv.textContent = 'An error occurred. Please try again.';
                messageDiv.className = 'mt-4 p-3 rounded bg-red-50 text-red-600';
                messageDiv.classList.remove('hidden');
            }
        });
    }
});
</script>

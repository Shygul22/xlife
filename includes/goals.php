<?php
// Security check
if (!defined('ALLOW_ACCESS')) {
    die('Access Denied');
}

// Initialize variables
$message = '';
$messageType = '';

// Get any stored messages
if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
    $message = $_SESSION['messages']['text'] ?? '';
    $messageType = $_SESSION['messages']['type'] ?? '';
    // Clear messages after displaying
    $_SESSION['messages'] = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goalText = trim($_POST['goal_text'] ?? '');
    $goalType = $_POST['goal_type'] ?? '';
    
    // Validate input
    if (empty($goalText)) {
        $_SESSION['messages'] = [
            'text' => "Goal text cannot be empty.",
            'type' => "error"
        ];
    } elseif (!in_array($goalType, ['today', 'weekly'])) {
        $_SESSION['messages'] = [
            'text' => "Invalid goal type selected.",
            'type' => "error"
        ];
    } else {
        try {
            // Get existing goals from cookie
            $cookieName = $goalType . 'Goals';
            $goals = isset($_COOKIE[$cookieName]) ? json_decode($_COOKIE[$cookieName], true) : [];
            
            if (!is_array($goals)) {
                $goals = [];
            }

            // Add new goal
            $goals[] = htmlspecialchars($goalText, ENT_QUOTES, 'UTF-8');

            // Set cookie
            if (setcookie($cookieName, json_encode($goals), [
                'expires' => time() + (86400 * 30),
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ])) {
                $_COOKIE[$cookieName] = json_encode($goals);
                $_SESSION['messages'] = [
                    'text' => "Goal added successfully!",
                    'type' => "success"
                ];
            }
        } catch (Exception $e) {
            $_SESSION['messages'] = [
                'text' => "Error saving goal: " . $e->getMessage(),
                'type' => "error"
            ];
        }
        // Redirect using JavaScript instead of headers
        echo "<script>window.location.href = window.location.href;</script>";
        exit();
    }
}

// Load existing goals
try {
    $todayGoals = isset($_COOKIE['todayGoals']) ? json_decode($_COOKIE['todayGoals'], true) : [];
    $weeklyGoals = isset($_COOKIE['weeklyGoals']) ? json_decode($_COOKIE['weeklyGoals'], true) : [];

    if (!is_array($todayGoals)) $todayGoals = [];
    if (!is_array($weeklyGoals)) $weeklyGoals = [];

} catch (Exception $e) {
    $todayGoals = [];
    $weeklyGoals = [];
    $message = "Error loading goals: " . $e->getMessage();
    $messageType = "error";
}
?>

<!-- Goals Dashboard -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-4 sm:py-8">
    <?php if ($message): ?>
        <div class="mb-4 sm:mb-6 p-4 rounded-lg shadow-sm transform transition-all duration-300 animate-fade-in <?php echo $messageType === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'; ?>">
            <div class="flex items-center">
                <i class="<?php echo $messageType === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-circle text-red-400'; ?> mr-3"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Goals Overview Cards -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 animate-fade-in">
            <i class="fas fa-chart-line mr-2 text-blue-500"></i>Goal Dashboard
        </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <!-- Today's Progress Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 sm:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold">Today's Progress</h3>
                    <span class="text-2xl font-bold"><?php echo count($todayGoals); ?> Goals</span>
                </div>
                <div class="w-full bg-blue-400 rounded-full h-2.5">
                    <div class="bg-white rounded-full h-2.5" style="width: <?php echo count($todayGoals) ? (count(array_filter($todayGoals)) / count($todayGoals) * 100) : 0; ?>%"></div>
                </div>
                <div class="mt-2 text-sm text-blue-100">
                    Click to add or manage your daily goals
                </div>
            </div>
            
            <!-- Weekly Progress Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold">Weekly Progress</h3>
                    <span class="text-2xl font-bold"><?php echo count($weeklyGoals); ?> Goals</span>
                </div>
                <div class="w-full bg-purple-400 rounded-full h-2.5">
                    <div class="bg-white rounded-full h-2.5" style="width: <?php echo count($weeklyGoals) ? (count(array_filter($weeklyGoals)) / count($weeklyGoals) * 100) : 0; ?>%"></div>
                </div>
                <div class="mt-2 text-sm text-purple-100">
                    Click to add or manage your weekly goals
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Add Goal Form -->
    <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8 transform transition-all duration-300 hover:shadow-xl animate-fade-in">
        <form id="goalForm" method="POST" class="space-y-4 sm:space-y-6" autocomplete="off">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-grow relative">
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-bullseye text-gray-400"></i>
                        </div>
                        <input type="text" id="goal_text" name="goal_text" 
                               class="block w-full pl-10 pr-12 py-3 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required maxlength="255" placeholder="What's your next goal?">
                    </div>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <span class="text-xs text-gray-400" id="charCount">255</span>
                    </div>
                </div>
                <div class="w-full md:w-48">
                    <select id="goal_type" name="goal_type" 
                            class="block w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="today">Today's Goal</option>
                        <option value="weekly">Weekly Goal</option>
                    </select>
                </div>
                <button type="submit" 
                        class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>Add Goal
                </button>
            </div>
        </form>
    </div>

    <!-- Goals Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
        <!-- Today's Goals -->
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 transform transition-all duration-300 hover:shadow-xl animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Today's Goals</h2>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    <?php echo count($todayGoals); ?> goals
                </span>
            </div>
            <?php if (empty($todayGoals)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No goals set for today</p>
                </div>
            <?php else: ?>
                <ul class="space-y-3">
                    <?php foreach ($todayGoals as $index => $goal): ?>
                        <li class="group flex items-center p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-all duration-200">
                            <i class="fas fa-circle text-xs text-blue-400 mr-3"></i>
                            <span class="flex-grow text-gray-700"><?php echo htmlspecialchars($goal, ENT_QUOTES, 'UTF-8'); ?></span>
                            <button onclick="deleteGoal('today', <?php echo $index; ?>)" 
                                    class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 transition-all duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Weekly Goals -->
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 transform transition-all duration-300 hover:shadow-xl animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Weekly Goals</h2>
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                    <?php echo count($weeklyGoals); ?> goals
                </span>
            </div>
            <?php if (empty($weeklyGoals)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No goals set for this week</p>
                </div>
            <?php else: ?>
                <ul class="space-y-3">
                    <?php foreach ($weeklyGoals as $index => $goal): ?>
                        <li class="group flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition-all duration-200">
                            <i class="fas fa-circle text-xs text-purple-400 mr-3"></i>
                            <span class="flex-grow text-gray-700"><?php echo htmlspecialchars($goal, ENT_QUOTES, 'UTF-8'); ?></span>
                            <button onclick="deleteGoal('weekly', <?php echo $index; ?>)" 
                                    class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 transition-all duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-blue-500"></div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Touch-friendly styles */
    @media (max-width: 640px) {
        button, a {
            min-height: 44px;
            min-width: 44px;
        }
        
        input, select {
            font-size: 16px; /* Prevent zoom on iOS */
        }
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    function deleteGoal(type, index) {
        const cookieName = type + 'Goals';
        let goals = JSON.parse(getCookie(cookieName) || '[]');
        
        if (goals[index] !== undefined) {
            goals.splice(index, 1);
            document.cookie = `${cookieName}=${JSON.encode(goals)}; path=/; secure; samesite=Strict`;
            location.reload(); // Reload to reflect changes
        }
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Add smooth animations for goal deletion
    function animateDelete(element) {
        element.style.transition = 'all 0.3s ease-out';
        element.style.transform = 'translateX(100%)';
        element.style.opacity = '0';
        setTimeout(() => element.remove(), 300);
    }

    // Character counter
    document.getElementById('goal_text').addEventListener('input', function(e) {
        const remaining = 255 - e.target.value.length;
        document.getElementById('charCount').textContent = remaining;
    });

    // Loading state
    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('hidden');
        document.getElementById('loadingOverlay').classList.remove('flex');
    }

    // Enhanced form submission
    document.getElementById('goalForm').addEventListener('submit', function(e) {
        showLoading();
    });

    // Enhanced delete animation
    function deleteGoal(type, index) {
        const element = event.target.closest('li');
        animateDelete(element);
        
        setTimeout(() => {
            // ...existing delete logic...
            showLoading();
        }, 300);
    }

    // Enhanced touch feedback
    document.querySelectorAll('button, a').forEach(element => {
        element.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.95)';
        });
        
        element.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Debounced save function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>
</body>
</html>

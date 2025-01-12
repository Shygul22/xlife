<?php
// Prevent direct file access
if (!defined('ALLOW_ACCESS')) {
    define('ALLOW_ACCESS', true);
}

// Block directory traversal attempts
$requested_page = isset($_GET['page']) ? $_GET['page'] : 'home';
if (preg_match('/\.\./', $requested_page)) {
    header('HTTP/1.0 403 Forbidden');
    exit('Access Denied');
}

// Validate file paths
function validatePath($path) {
    return !preg_match('/(?:\.{2}|[<>:&\\\\])/', $path);
}

// Basic access control
if (!isset($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] !== 'localhost') {
    header('HTTP/1.0 403 Forbidden');
    exit('Access Denied');
}

session_start();

// Protected pages that require login
$protected_pages = ['dashboard', 'tasks', 'profile'];

// Check if trying to access protected page without login
if (in_array($_GET['page'] ?? 'home', $protected_pages) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=auth');
    exit;
}

// Validate and get the requested page
$allowed_pages = [
    'home' => 'includes/home.php',
    'dashboard' => 'includes/dashboard.php',
    'tasks' => 'includes/tasks.php',
    'profile' => 'includes/profile.php',
    'auth' => 'includes/auth.php'
];

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page_path = isset($allowed_pages[$page]) ? $allowed_pages[$page] : $allowed_pages['home'];

// Modify sidebar visibility based on login status
function shouldShowNavItem($page) {
    global $protected_pages;
    if (in_array($page, $protected_pages)) {
        return isset($_SESSION['user_id']);
    }
    return true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
          rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" 
          rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" 
            crossorigin="anonymous"></script>
    <style>
        /* Fixed navbar and sidebar styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
        }
        .sidebar {
            position: fixed;
            top: 64px; /* Navbar height */
            left: 0;
            bottom: 0;
            z-index: 40;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 30;
        }
        .main-content {
            padding-top: 64px; /* Navbar height */
            margin-left: 16rem;
            min-height: 100vh;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .overlay.active {
                display: block;
            }
            body.mobile-menu-open {
                overflow: hidden;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>

    <!-- Navbar -->
    <nav class="navbar bg-white shadow">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center">
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-blue-700 hover:bg-gray-100 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-xl text-blue-700 font-bold ml-2">ZenJourney</h1>
            </div>
            <div class="space-x-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <!-- <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm md:text-base">Logout</a> -->
                <?php else: ?>
                    <a href="./auth.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm md:text-base">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar -->
    <div id="sidebar" class="fixed flex flex-col top-16 left-0 w-64 bg-white h-full border-r pt-4 sidebar">
    <div class="flex items-center justify-center h-14 border-b">
        <div class="font-bold">Navigation</div>
    </div>
    <div class="overflow-y-auto overflow-x-hidden flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
        <li class="px-5">
          <div class="flex flex-row items-center h-8">
            <div class="text-sm font-light tracking-wide text-gray-500">Menu</div>
          </div>
        </li>
        
        <!-- Always show Home -->
        <li>
            <a href="index.php?page=home" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                <span class="inline-flex justify-center items-center ml-4">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </span>
                <span class="ml-2 text-sm tracking-wide truncate">Home</span>
            </a>
        </li>

        <!-- Show protected items only when logged in -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <li>
                <a href="index.php?page=dashboard" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                </a>
            </li>
            <li>
              <a href="index.php?page=tasks" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                <span class="inline-flex justify-center items-center ml-4">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </span>
                <span class="ml-2 text-sm tracking-wide truncate">Tasks</span>
              </a>
            </li>
            <li>
              <a href="index.php?page=profile" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'border-indigo-500' : 'border-transparent'; ?> hover:border-indigo-500 pr-6">
                <span class="inline-flex justify-center items-center ml-4">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </span>
                <span class="ml-2 text-sm tracking-wide truncate">Profile</span>
              </a>
            </li>
            <li>
              <a href="logout.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-red-500 pr-6">
                <span class="inline-flex justify-center items-center ml-4">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </span>
                <span class="ml-2 text-sm tracking-wide truncate">Logout</span>
              </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

    <!-- Main Content -->
    <main class="main-content flex-grow">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <?php include($page_path); ?>
        <?php else: ?>
            <div class="p-4 md:p-8">
                <div class="container mx-auto">
                    <?php include($page_path); ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMobileMenu() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('mobile-menu-open');
        }

        mobileMenuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMobileMenu();
        });

        overlay.addEventListener('click', () => {
            toggleMobileMenu();
        });

        // Close menu on window resize if mobile menu is open
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
                toggleMobileMenu();
            }
        });

        // Add active class to current navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = '<?php echo $page; ?>';
            const navLinks = document.querySelectorAll('#sidebar a');
            
            navLinks.forEach(link => {
                const href = new URLSearchParams(link.getAttribute('href').split('?')[1]).get('page');
                if (href === currentPage) {
                    link.classList.add('border-indigo-500');
                    link.classList.remove('border-transparent');
                } else {
                    link.classList.add('border-transparent');
                    link.classList.remove('border-indigo-500');
                }
            });
        });
    </script>
</body>
</html>

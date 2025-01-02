<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo isset($pageTitle) ? $pageTitle : 'User Management'; ?></title>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EBVPEW30HK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EBVPEW30HK');
</script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Mobile menu button -->
            <div class="lg:hidden absolute right-4 top-4">
                <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex justify-between">
                <div class="flex space-x-7">
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../index.php' : 'index.php'; ?>" 
                       class="flex items-center py-4">
                        <span class="font-semibold text-gray-500 text-lg">zenjourney</span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="relative group">
                            <a href="#" class="py-2 px-4 text-gray-500 hover:text-gray-900">Task Manager</a>
                            <div class="absolute hidden group-hover:block w-48 bg-white shadow-lg mt-1 rounded-lg">
                                <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? 'index.php' : 'includes/index.php'; ?>" 
                                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Task Dashboard</a>
                            </div>
                        </div>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../profile.php' : 'profile.php'; ?>" 
                           class="py-2 px-4 text-gray-500 hover:text-gray-900">Profile</a>
                        <span class="text-gray-500 hidden md:inline"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../logout.php' : 'logout.php'; ?>" 
                           class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../login.php' : 'login.php'; ?>" 
                           class="py-2 px-4 text-gray-500 hover:text-gray-900">Login</a>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../register.php' : 'register.php'; ?>" 
                           class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">Register</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="lg:hidden hidden">
                <div class="flex flex-col space-y-2 py-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? 'index.php' : 'includes/index.php'; ?>" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Task Dashboard</a>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../profile.php' : 'profile.php'; ?>" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <span class="px-4 py-2 text-gray-500"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../logout.php' : 'logout.php'; ?>" 
                           class="block px-4 py-2 text-white bg-red-500 hover:bg-red-600">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../login.php' : 'login.php'; ?>" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
                        <a href="<?php echo dirname($_SERVER['PHP_SELF']) == '/zenjourney files/includes' ? '../register.php' : 'register.php'; ?>" 
                           class="block px-4 py-2 text-white bg-blue-500 hover:bg-blue-600">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });

        // Close mobile menu on window resize if it's open
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) { // lg breakpoint
                document.getElementById('mobile-menu')?.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

<?php
$isLoggedIn = isset($_SESSION['user_id']);

// SEO Meta Data
$metaTitle = "ZenJourney - Smart Task & Goal Management Platform";
$metaDescription = "Transform your productivity with ZenJourney. An intuitive platform for managing tasks, tracking goals, and achieving personal growth. Start your journey to better productivity today.";
 
// Add feature highlights data
$features = [
    [
        'icon' => 'fas fa-brain',
        'title' => 'AI-Powered Insights',
        'description' => 'Smart task prioritization and personalized productivity recommendations'
    ],
    [
        'icon' => 'fas fa-chart-line',
        'title' => 'Progress Tracking',
        'description' => 'Visual analytics and milestone tracking to keep you motivated'
    ],
    [
        'icon' => 'fas fa-mobile-alt',
        'title' => 'Mobile Friendly',
        'description' => 'Access your tasks and goals from any device, anytime'
    ]
];

// Add testimonials data
$testimonials = [
    [
        'name' => 'Sarah Johnson',
        'role' => 'Product Manager',
        'image' => 'assets/images/testimonial1.jpg',
        'quote' => 'ZenJourney transformed how I manage my projects.',
        'company' => 'Tech Corp'
    ],
    // Add more testimonials...
];
?>

<?php if (!$isLoggedIn): ?>
<!-- SEO Optimized Head Section -->
<head>
    <title><?php echo htmlspecialchars($metaTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="task management, productivity, goal tracking, personal development, time management">
    <meta property="og:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta property="og:type" content="website">
    <link rel="canonical" href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
</head>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Enhanced Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 transform skew-y-3"></div>
        <div class="relative container mx-auto px-4 pt-20 pb-16">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-8 leading-tight animate-fade-in">
                    Transform Your Life with
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        ZenJourney
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Join thousands of successful individuals who use ZenJourney to track goals, 
                    boost productivity, and achieve personal growth through mindful task management.
                </p>
                
                <!-- Enhanced CTA Buttons -->
                <div class="space-y-4 md:space-y-0 md:space-x-4 mb-16">
                    <a href="auth.php?action=register" 
                       class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Start Your Free Trial
                        <span class="block text-sm font-normal">No Credit Card Required</span>
                    </a>
                    <a href="auth.php?action=login" 
                       class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg border-2 border-blue-600">
                        Sign In
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto mb-20">
                    <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">2k+</div>
                        <div class="text-gray-600 text-sm">Active Users</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">10k+</div>
                        <div class="text-gray-600 text-sm">Tasks Completed</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">99%</div>
                        <div class="text-gray-600 text-sm">Satisfaction Rate</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">4.9★</div>
                        <div class="text-gray-600 text-sm">User Rating</div>
                    </div>
                </div>
            </div>

            <!-- Interactive Demo Preview -->
            <div class="mt-12 relative">
                <div class="bg-white rounded-lg shadow-2xl p-6 max-w-4xl mx-auto transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="animate-pulse">
                            <div class="h-8 bg-gray-200 rounded w-3/4"></div>
                            <div class="mt-4 space-y-3">
                                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Features Section -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Powerful Features</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Everything you need to boost your productivity</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php foreach ($features as $feature): ?>
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="<?php echo $feature['icon']; ?> text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo $feature['title']; ?></h3>
                        <p class="text-gray-600"><?php echo $feature['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Interactive Feature Demo -->
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">See It In Action</h2>
                        <div class="space-y-6">
                            <div class="feature-demo cursor-pointer p-4 rounded-lg border border-transparent hover:border-blue-500 hover:bg-white transition-all duration-300">
                                <h3 class="font-semibold mb-2">Task Management</h3>
                                <p class="text-gray-600">Create, organize, and track tasks with ease</p>
                            </div>
                            <!-- Add more interactive features -->
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg" id="featurePreview">
                        <!-- Dynamic feature preview content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Proof Section -->
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Trusted by Professionals</h2>
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center mb-4">
                        <img src="assets/images/testimonial1.jpg" alt="User Profile" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="font-semibold">Sarah Johnson</h4>
                            <p class="text-sm text-gray-600">Product Manager</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"ZenJourney has completely transformed how I manage my projects and personal goals. The interface is intuitive and the progress tracking is invaluable."</p>
                </div>
                <!-- Add more testimonials -->
            </div>
        </div>
    </div>

    <!-- FAQ Section for SEO -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
            <div class="space-y-6">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">How does ZenJourney help with productivity?</h3>
                    <p class="text-gray-600">ZenJourney combines task management, goal tracking, and progress analytics to help you stay focused and achieve more.</p>
                </div>
                <!-- Add more FAQs -->
            </div>
        </div>
    </div>

    <!-- Enhanced Final CTA -->
    <div class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-8">Ready to Start Your Journey?</h2>
                <p class="text-xl text-gray-600 mb-8">Join thousands of productive users today.</p>
                <div class="space-x-4">
                    <a href="auth.php?action=register" 
                       class="inline-block bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Get Started Free
                    </a>
                    <a href="#features" 
                       class="inline-block bg-gray-100 text-gray-700 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-200 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php else: ?>
<!-- Welcome Message for Logged In Users -->
<div class="text-center py-16 bg-white rounded-lg shadow-sm mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </h1>
    <p class="text-xl text-gray-600 mb-8">
        Ready to be productive today?
    </p>
    <div class="space-x-4">
        <a href="index.php?page=dashboard" 
           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Go to Dashboard
        </a>
        <a href="index.php?page=tasks" 
           class="inline-block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
            View Tasks
        </a>
    </div>
</div>

<!-- Quick Features Access -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <!-- Task Management -->
    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
        <div class="text-blue-500 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Task Management</h3>
        <p class="text-gray-600 mb-4">Create, organize, and track your tasks efficiently.</p>
        <a href="index.php?page=tasks" class="text-blue-600 hover:text-blue-700 font-medium">
            Manage Tasks →
        </a>
    </div>

    <!-- Analytics -->
    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
        <div class="text-green-500 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Analytics Dashboard</h3>
        <p class="text-gray-600 mb-4">View your productivity metrics and insights.</p>
        <a href="index.php?page=dashboard" class="text-green-600 hover:text-green-700 font-medium">
            View Analytics →
        </a>
    </div>

    <!-- Profile & Settings -->
    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
        <div class="text-purple-500 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37.996.608 2.296.07 2.572-1.065z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Profile Settings</h3>
        <p class="text-gray-600 mb-4">Customize your account preferences.</p>
        <a href="index.php?page=profile" class="text-purple-600 hover:text-purple-700 font-medium">
            Update Settings →
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Recent Activity
    </h2>
    <div id="recent-activity" class="divide-y divide-gray-100">
        <div class="animate-pulse space-y-4">
            <div class="flex items-center justify-between py-3">
                <div class="flex-1">
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-3 bg-gray-100 rounded w-1/2 mt-2"></div>
                </div>
                <div class="h-4 bg-gray-200 rounded w-20"></div>
            </div>
            <div class="flex items-center justify-between py-3">
                <div class="flex-1">
                    <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                    <div class="h-3 bg-gray-100 rounded w-1/3 mt-2"></div>
                </div>
                <div class="h-4 bg-gray-200 rounded w-20"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateRecentActivity();
    // Auto refresh every 60 seconds
    setInterval(updateRecentActivity, 60000);
});

function updateRecentActivity() {
    const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
    const recentTasks = tasks
        .filter(t => t.completedTime || t.updatedAt)
        .sort((a, b) => {
            const dateA = new Date(b.completedTime || b.updatedAt);
            const dateB = new Date(a.completedTime || a.updatedAt);
            return dateA - dateB;
        })
        .slice(0, 5);

    const container = document.getElementById('recent-activity');
    
    if (!recentTasks.length) {
        container.innerHTML = `
            <div class="py-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>No recent activity</p>
                <a href="index.php?page=tasks" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                    Create your first task →
                </a>
            </div>
        `;
        return;
    }

    container.innerHTML = recentTasks.map(task => `
        <div class="flex items-center justify-between py-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center">
                    <span class="font-medium truncate">${task.name}</span>
                    ${task.completedTime ? `
                        <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span>
                    ` : `
                        <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Updated</span>
                    `}
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    ${task.description ? `${task.description.substring(0, 60)}${task.description.length > 60 ? '...' : ''}` : ''}
                </p>
            </div>
            <span class="text-sm text-gray-500 ml-4 whitespace-nowrap">
                ${formatTimeAgo(task.completedTime || task.updatedAt)}
            </span>
        </div>
    `).join('');
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (seconds < 60) return 'just now';
    if (minutes < 60) return `${minutes}m ago`;
    if (hours < 24) return `${hours}h ago`;
    if (days === 1) return 'yesterday';
    if (days < 7) return `${days}d ago`;
    
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric'
    });
}
</script>
<?php endif; ?>

<!-- Structured Data for SEO -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "SaaSApplication",
    "name": "ZenJourney",
    "description": "<?php echo htmlspecialchars($metaDescription); ?>",
    "applicationCategory": "Productivity Software",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>

<!-- Add scroll-triggered animations -->
<style>
    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    // Scroll animations
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in-up');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(element => observer.observe(element));
    });

    // Feature demo interaction
    const featureDemos = document.querySelectorAll('.feature-demo');
    const previewContainer = document.getElementById('featurePreview');

    featureDemos.forEach(demo => {
        demo.addEventListener('click', function() {
            featureDemos.forEach(d => d.classList.remove('border-blue-500', 'bg-white'));
            this.classList.add('border-blue-500', 'bg-white');
            
            // Update preview content based on selected feature
            updateFeaturePreview(this.querySelector('h3').textContent);
        });
    });

    function updateFeaturePreview(feature) {
        // Add dynamic preview content based on selected feature
        const previews = {
            'Task Management': `
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        <span>Complete project proposal</span>
                    </div>
                    <!-- Add more preview items -->
                </div>
            `,
            // Add more feature previews
        };

        previewContainer.innerHTML = previews[feature] || '';
    }
</script>

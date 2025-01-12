<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>

<?php if (!$isLoggedIn): ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 pt-20 pb-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-6xl font-bold text-gray-800 mb-8">
                Transform Your Productivity with <span class="text-blue-600">ZenJourney</span>
            </h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">
                Experience a smarter way to manage tasks, track progress, and achieve your goals with our intuitive task management platform.
            </p>
            <div class="space-x-4 mb-16">
                <a href="auth.php?action=register" 
                   class="inline-block bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                    Start Free Trial
                </a>
                <a href="auth.php?action=login" 
                   class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-50 transition-colors shadow-lg hover:shadow-xl border-2 border-blue-600">
                    Sign In
                </a>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto mb-20">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">2k+</div>
                    <div class="text-gray-600">Active Users</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">10k+</div>
                    <div class="text-gray-600">Tasks Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">99%</div>
                    <div class="text-gray-600">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose ZenJourney?</h2>
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Existing feature cards with enhanced styling -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Smart Task Management</h3>
                    <p class="text-gray-600">Organize tasks with priority levels, due dates, and custom categories.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Progress Analytics</h3>
                    <p class="text-gray-600">Track your productivity with visual charts and detailed statistics.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Time Tracking</h3>
                    <p class="text-gray-600">Monitor time spent on tasks and optimize your workflow.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
            <div class="grid md:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Sign Up</h3>
                    <p class="text-gray-600">Create your free account in seconds</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">Add Tasks</h3>
                    <p class="text-gray-600">Create and organize your tasks</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-yellow-600">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Track Progress</h3>
                    <p class="text-gray-600">Monitor your productivity</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Achieve Goals</h3>
                    <p class="text-gray-600">Complete tasks and reach milestones</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials with Avatars -->
    <div class="bg-white py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">What Our Users Say</h2>
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600">J</span>
                    </div>
                    <p class="text-gray-600 italic mb-4">"ZenJourney has transformed how I manage my daily tasks."</p>
                    <p class="font-semibold">John D.</p>
                </div>
                <!-- Add more testimonials as needed -->
            </div>
        </div>
    </div>

    <!-- Final CTA -->
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

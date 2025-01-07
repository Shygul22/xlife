<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- Header with Quick Stats -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Dashboard Overview</h2>
                <a href="index.php" class="text-blue-500 hover:text-blue-600 flex items-center">
                    <i class="fa fa-arrow-left mr-2"></i> Back to Tasks
                </a>
            </div>
            
            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-3 rounded-lg border-l-4 border-blue-500">
                    <p class="text-sm text-gray-600">Total Tasks</p>
                    <p id="total-tasks" class="text-2xl font-bold text-blue-600">0</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg border-l-4 border-green-500">
                    <p class="text-sm text-gray-600">Completed</p>
                    <p id="completed-tasks" class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-600">Avg Effort</p>
                    <p id="average-effort" class="text-2xl font-bold text-yellow-600">0h</p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg border-l-4 border-red-500">
                    <p class="text-sm text-gray-600">High Priority</p>
                    <p id="high-priority-tasks" class="text-2xl font-bold text-red-600">0</p>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-purple-50 p-3 rounded-lg border-l-4 border-purple-500">
                <p class="text-sm text-gray-600">Today's Tasks</p>
                <p id="today-tasks" class="text-2xl font-bold text-purple-600">0</p>
            </div>
            <div class="bg-indigo-50 p-3 rounded-lg border-l-4 border-indigo-500">
                <p class="text-sm text-gray-600">Completion Rate</p>
                <p id="completion-rate" class="text-2xl font-bold text-indigo-600">0%</p>
            </div>
            <div class="bg-pink-50 p-3 rounded-lg border-l-4 border-pink-500">
                <p class="text-sm text-gray-600">Peak Hours</p>
                <p id="peak-hours" class="text-2xl font-bold text-pink-600">--</p>
            </div>
            <div class="bg-cyan-50 p-3 rounded-lg border-l-4 border-cyan-500">
                <p class="text-sm text-gray-600">Productivity Score</p>
                <p id="productivity-score" class="text-2xl font-bold text-cyan-600">0</p>
            </div>
        </div>

        <!-- Task Insights Section -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h3 class="text-lg font-semibold mb-3">Task Insights</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-3">
                    <h4 class="font-medium text-gray-700 mb-2">Recent Completions</h4>
                    <div id="recent-completions" class="space-y-2">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
                <div class="border rounded-lg p-3">
                    <h4 class="font-medium text-red-700 mb-2">Critical Priority Tasks</h4>
                    <div id="critical-priority" class="space-y-2">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid with Loading States -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Status Chart -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Task Status</h3>
                <div class="h-48 relative">
                    <div id="status-chart-loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10 hidden">
                        <i class="fa fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    </div>
                    <canvas id="task-status-chart"></canvas>
                </div>
            </div>
            
            <!-- Priority Chart -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Priority Distribution</h3>
                <div class="h-48 relative">
                    <div id="priority-chart-loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10 hidden">
                        <i class="fa fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    </div>
                    <canvas id="task-priority-chart"></canvas>
                </div>
            </div>
            
            <!-- Effort Chart -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Effort Distribution</h3>
                <div class="h-48 relative">
                    <div id="effort-chart-loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10 hidden">
                        <i class="fa fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    </div>
                    <canvas id="task-effort-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Add Performance Timeline -->
        <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Performance Timeline</h3>
            <div class="h-48">
                <canvas id="performance-chart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Error handling utility
        const DashboardError = {
            container: null,
            init() {
                this.container = document.createElement('div');
                this.container.className = 'fixed top-4 right-4 z-50';
                document.body.appendChild(this.container);
            },
            show(message, type = 'error') {
                const alert = document.createElement('div');
                alert.className = `mb-4 p-4 rounded-lg ${type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white`;
                alert.textContent = message;
                this.container.appendChild(alert);
                setTimeout(() => alert.remove(), 3000);
            }
        };

        // Safe data fetching
        const DataFetcher = {
            getTasks() {
                try {
                    return JSON.parse(localStorage.getItem('tasks') || '[]');
                } catch (error) {
                    DashboardError.show('Failed to load tasks');
                    return [];
                }
            }
        };

        // Chart management
        const ChartManager = {
            instances: {},
            async create(id, config) {
                try {
                    if (this.instances[id]) {
                        this.instances[id].destroy();
                    }
                    const ctx = document.getElementById(id)?.getContext('2d');
                    if (!ctx) throw new Error(`Canvas context not found: ${id}`);
                    this.instances[id] = new Chart(ctx, config);
                    return this.instances[id];
                } catch (error) {
                    DashboardError.show(`Failed to create chart: ${id}`);
                    return null;
                }
            },
            destroyAll() {
                Object.values(this.instances).forEach(chart => chart?.destroy());
                this.instances = {};
            }
        };

        // Initialization
        document.addEventListener('DOMContentLoaded', async () => {
            DashboardError.init();
            await initializeDashboard();
        });

        async function initializeDashboard() {
            try {
                showLoading(true);
                const tasks = DataFetcher.getTasks();
                
                await Promise.all([
                    updateStats(tasks),
                    updateCharts(tasks),
                    updateInsights(tasks)
                ]);
            } catch (error) {
                DashboardError.show('Failed to initialize dashboard');
                console.error(error);
            } finally {
                showLoading(false);
            }
        }

        function showLoading(show) {
            document.querySelectorAll('[id$="-loading"]').forEach(loader => {
                loader.classList.toggle('hidden', !show);
            });
        }

        async function updateStats(tasks) {
            try {
                const stats = calculateStats(tasks);
                Object.entries(stats).forEach(([id, value]) => {
                    const element = document.getElementById(id);
                    if (element) element.textContent = value;
                });
            } catch (error) {
                DashboardError.show('Failed to update statistics');
            }
        }

        function calculateStats(tasks) {
            const completed = tasks.filter(t => t.completedTime);
            const highPriority = tasks.filter(t => !t.completedTime && parseFloat(calculatePriorityScore(t)) >= 6);
            
            return {
                'total-tasks': tasks.length,
                'completed-tasks': completed.length,
                'average-effort': `${calculateAverageEffort(tasks)}h`,
                'high-priority-tasks': highPriority.length,
                'today-tasks': calculateTodaysTasks(tasks),
                'completion-rate': `${calculateCompletionRate(tasks)}%`,
                'peak-hours': calculatePeakHours(tasks),
                'productivity-score': calculateProductivityScore(tasks)
            };
        }

        // Utility functions
        function calculatePriorityScore(task) {
            if (!task.urgency || !task.importance || !task.effort) return '0.00';
            
            const urgencyWeight = 0.45;
            const importanceWeight = 0.45;
            const effortWeight = 0.10;
            
            const normalizedEffort = Number(task.effort) <= 2 ? 1 :
                                   Number(task.effort) <= 4 ? 2 :
                                   Number(task.effort) <= 6 ? 3 :
                                   Number(task.effort) <= 8 ? 4 : 5;
            
            const baseScore = (
                (urgencyWeight * Number(task.urgency)) +
                (importanceWeight * Number(task.importance)) -
                (effortWeight * normalizedEffort)
            ) * 2;

            return Math.min(10, Math.max(0, baseScore)).toFixed(2);
        }

        function calculateAverageEffort(tasks) {
            return tasks.length > 0 
                ? (tasks.reduce((sum, t) => sum + (Number(t.effort) || 0), 0) / tasks.length).toFixed(1) 
                : '0.0';
        }

        function calculateTodaysTasks(tasks) {
            const today = new Date().toDateString();
            return tasks.filter(t => 
                new Date(t.scheduledTime?.split(' - ')[0]).toDateString() === today
            ).length;
        }

        function calculateCompletionRate(tasks) {
            const completedTasks = tasks.filter(t => t.completedTime).length;
            return tasks.length ? Math.round((completedTasks / tasks.length) * 100) : 0;
        }

        function calculatePeakHours(tasks) {
            const completed = tasks.filter(t => t.completedTime);
            if (!completed.length) return '--';

            const hours = completed.map(t => new Date(t.completedTime).getHours());
            const peakHour = mode(hours);
            return `${peakHour}:00`;
        }

        function calculateProductivityScore(tasks) {
            if (!tasks.length) return 0;
            
            const completedHighPriority = tasks.filter(t => 
                t.completedTime && parseFloat(calculatePriorityScore(t)) >= 6
            ).length;
            
            const totalHighPriority = tasks.filter(t => 
                parseFloat(calculatePriorityScore(t)) >= 6
            ).length;

            return Math.round((completedHighPriority / Math.max(totalHighPriority, 1)) * 100);
        }

        function mode(arr) {
            return arr.reduce((a, b) =>
                (arr.filter(v => v === a).length >= arr.filter(v => v === b).length ? a : b)
            );
        }

        async function updateCharts(tasks) {
            try {
                ChartManager.destroyAll();
                await Promise.all([
                    createTaskStatusChart(tasks),
                    createPriorityChart(tasks),
                    createEffortChart(tasks),
                    createPerformanceChart(tasks)
                ]);
            } catch (error) {
                DashboardError.show('Failed to update charts');
            }
        }

        function createTaskStatusChart(tasks) {
            const pending = tasks.filter(t => !t.completedTime).length;
            const completed = tasks.filter(t => t.completedTime).length;

            return ChartManager.create('task-status-chart', {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Completed'],
                    datasets: [{
                        data: [pending, completed],
                        backgroundColor: ['#3B82F6', '#10B981']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 15 }
                        }
                    }
                }
            });
        }

        function createPriorityChart(tasks) {
            const priorities = {
                Critical: tasks.filter(t => !t.completedTime && calculatePriorityScore(t) >= 8).length,
                High: tasks.filter(t => !t.completedTime && calculatePriorityScore(t) >= 6 && calculatePriorityScore(t) < 8).length,
                Medium: tasks.filter(t => !t.completedTime && calculatePriorityScore(t) >= 4 && calculatePriorityScore(t) < 6).length,
                Low: tasks.filter(t => !t.completedTime && calculatePriorityScore(t) < 4).length
            };

            return ChartManager.create('task-priority-chart', {
                type: 'bar',
                data: {
                    labels: Object.keys(priorities),
                    datasets: [{
                        data: Object.values(priorities),
                        backgroundColor: ['#EF4444', '#F97316', '#EAB308', '#22C55E']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        function createEffortChart(tasks) {
            const effortRanges = {
                '0-2h': tasks.filter(t => t.effort <= 2).length,
                '2-4h': tasks.filter(t => t.effort > 2 && t.effort <= 4).length,
                '4-8h': tasks.filter(t => t.effort > 4 && t.effort <= 8).length,
                '>8h': tasks.filter(t => t.effort > 8).length
            };

            return ChartManager.create('task-effort-chart', {
                type: 'pie',
                data: {
                    labels: Object.keys(effortRanges),
                    datasets: [{
                        data: Object.values(effortRanges),
                        backgroundColor: ['#22C55E', '#EAB308', '#F97316', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 15 }
                        }
                    }
                }
            });
        }

        async function createPerformanceChart(tasks) {
            const completedTasks = tasks
                .filter(t => t.completedTime)
                .sort((a, b) => new Date(a.completedTime) - new Date(b.completedTime));

            const data = {
                labels: completedTasks.map(t => formatDate(t.completedTime)),
                datasets: [{
                    label: 'Completion Time (hours)',
                    data: completedTasks.map(t => t.effort),
                    borderColor: '#3B82F6',
                    tension: 0.4
                }]
            };

            await ChartManager.create('performance-chart', {
                type: 'line',
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString(undefined, {
                month: 'short',
                day: 'numeric'
            });
        }

        function updateInsights(tasks) {
            // Update recent completions
            const recentCompletions = tasks
                .filter(t => t.completedTime)
                .sort((a, b) => new Date(b.completedTime) - new Date(a.completedTime))
                .slice(0, 3);

            const recentDiv = document.getElementById('recent-completions');
            recentDiv.innerHTML = recentCompletions.length ? 
                recentCompletions.map(task => `
                    <div class="flex items-center justify-between text-sm">
                        <span class="truncate">${task.name}</span>
                        <span class="text-gray-500">${formatTimeAgo(task.completedTime)}</span>
                    </div>
                `).join('') :
                '<p class="text-gray-500 text-sm">No recent completions</p>';

            // Update critical priority tasks
            const criticalTasks = tasks
                .filter(t => !t.completedTime && parseFloat(calculatePriorityScore(t)) >= 8)
                .sort((a, b) => calculatePriorityScore(b) - calculatePriorityScore(a))
                .slice(0, 3);

            const criticalDiv = document.getElementById('critical-priority');
            criticalDiv.innerHTML = criticalTasks.length ? 
                criticalTasks.map(task => `
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex-1">
                            <div class="font-medium truncate">${task.name}</div>
                            <div class="text-xs text-gray-500">
                                Score: ${calculatePriorityScore(task)} | ${task.scheduledTime || 'Not scheduled'}
                            </div>
                        </div>
                        <span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                            Critical
                        </span>
                    </div>
                `).join('') :
                '<p class="text-gray-500 text-sm">No critical tasks</p>';
        }

        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);

            if (seconds < 60) return 'just now';
            if (seconds < 3600) return `${Math.floor(seconds / 60)}m ago`;
            if (seconds < 86400) return `${Math.floor(seconds / 3600)}h ago`;
            return `${Math.floor(seconds / 86400)}d ago`;
        }

        // Auto-refresh dashboard
        setInterval(() => {
            initializeDashboard().catch(console.error);
        }, 300000); // Refresh every 5 minutes

        // Add window error handler
        window.addEventListener('error', function(e) {
            DashboardError.show('An unexpected error occurred');
            console.error(e.error);
        });
    </script>
</body>
</html>
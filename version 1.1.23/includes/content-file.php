<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <div class="container mx-auto p-2 sm:p-6">
        <!-- Navigation -->
       

        <!-- Main Content -->
        <div class="space-y-6 max-w-4xl mx-auto">
            <!-- Task Form -->
            <form id="task-form" class="bg-white p-6 rounded-lg shadow-lg w-full">
                <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-center">
                    <!-- Task Name -->
                    <div class="col-span-2">
                        <label for="task-name" class="block text-sm font-medium text-gray-700 mb-1">Task Name</label>
                        <input type="text" id="task-name" placeholder="Enter task name" required
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Urgency -->
                    <div class="col-span-1">
                        <label for="urgency" class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
                        <select id="urgency" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select</option>
                            <option value="1">1 - Low</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5 - High</option>
                        </select>
                    </div>
                    <!-- Importance -->
                    <div class="col-span-1">
                        <label for="importance" class="block text-sm font-medium text-gray-700 mb-1">Importance</label>
                        <select id="importance" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select</option>
                            <option value="1">1 - Low</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5 - High</option>
                        </select>
                    </div>
                    <!-- Effort -->
                    <div class="col-span-1">
                        <label for="effort" class="block text-sm font-medium text-gray-700 mb-1">Effort (hrs)</label>
                        <input type="number" id="effort" placeholder="0.5 - 24 hrs" min="0.0" max="24" step="0.5" required
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Submit Button -->
                    <div class="col-span-1">
                        <button type="submit" id="submit-button" class="mt-5 sm:mt-0 w-full bg-blue-500 text-white p-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Task
                        </button>
                    </div>
                </div>
            </form>

            <!-- Time Slot Form -->
            <div id="time-slot-definition" class="bg-white p-6 rounded-lg shadow-lg">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label for="start-time" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" id="start-time" value="09:00" required
                            class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="end-time" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" id="end-time" value="17:00" required
                            class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="break-time" class="block text-sm font-medium text-gray-700">Break (min)</label>
                        <input type="number" id="break-time" value="0" min="0"
                            class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="flex items-end">
                        <button onclick="allocateTimeSlots(tasks)" class="w-full bg-blue-500 text-white p-3 rounded-lg">
                            Schedule Tasks
                        </button>
                    </div>
                </div>
            </div>

            <!-- Task List -->
            <div id="task-list" class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Priority Analysis Summary -->
                <div id="priority-analysis" class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Priority Analysis</h3>
    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- Critical Priority -->
                        <div class="border-l-4 border-red-500 bg-red-50 rounded-r-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-red-700">Critical Priority</h4>
                                <span id="critical-count" class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full"></span>
                            </div>
                            <div id="critical-tasks" class="text-sm space-y-2"></div>
                        </div>

                        <!-- High Priority -->
                        <div class="border-l-4 border-orange-500 bg-orange-50 rounded-r-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-orange-700">High Priority</h4>
                                <span id="high-count" class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full"></span>
                            </div>
                            <div id="high-tasks" class="text-sm space-y-2"></div>
                        </div>

                        <!-- Medium Priority -->
                        <div class="border-l-4 border-yellow-500 bg-yellow-50 rounded-r-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-yellow-700">Medium Priority</h4>
                                <span id="medium-count" class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full"></span>
                            </div>
                            <div id="medium-tasks" class="text-sm space-y-2"></div>
                        </div>

                        <!-- Low Priority -->
                        <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-green-700">Low Priority</h4>
                                <span id="low-count" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"></span>
                            </div>
                            <div id="low-tasks" class="text-sm space-y-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Remove search and filters section and replace with just the task list -->
                <div id="task-list-content" class="mt-4">
                    <!-- Task list content will be populated by JavaScript -->
                </div>

                <button onclick="clearAllTasks()" class="w-full sm:w-auto bg-red-600 text-white py-3 px-4 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 transition duration-300 mt-6 text-lg">
                    <i class="fa fa-trash mr-2"></i> Clear All Tasks
                </button>
            </div>
        </div>

        <!-- Error message container -->
        <div id="error-message-container" class="fixed top-4 right-4 z-50"></div>
    </div>

    <script>
        // Core utilities
const ErrorHandler = {
    handle(error, context = '') {
        console.error(`${context}:`, error);
        this.showError(error.message || 'An error occurred');
    },

    showError(message) {
        const container = document.getElementById('error-message-container');
        if (!container) return;
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'bg-red-500 text-white p-4 rounded-lg shadow-lg mb-2';
        errorDiv.textContent = message;
        
        container.appendChild(errorDiv);

        // Safely remove after delay
        setTimeout(() => {
            if (container.contains(errorDiv)) {
                container.removeChild(errorDiv);
            }
        }, 3000);
    }
};

// Data management
const DataManager = {
    save(key, data) {
        try {
            localStorage.setItem(key, JSON.stringify(data));
            return true;
        } catch (error) {
            ErrorHandler.handle(error, 'Save operation failed');
            return false;
        }
    },

    load(key, defaultValue = null) {
        try {
            const data = localStorage.getItem(key);
            return data ? JSON.parse(data) : defaultValue;
        } catch (error) {
            ErrorHandler.handle(error, 'Load operation failed');
            return defaultValue;
        }
    }
};

// Task Management
let tasks = [];
let achievements = [];

// Add this after the task management variables (tasks and achievements)
function addTask(taskData) {
    try {
        // Validate task data
        if (!taskData.name?.trim()) {
            throw new Error('Task name is required');
        }
        if (!taskData.urgency || !taskData.importance) {
            throw new Error('Urgency and importance are required');
        }
        if (!taskData.effort || taskData.effort <= 0) {
            throw new Error('Valid effort value is required');
        }

        // Create new task object with generated ID
        const newTask = {
            ...taskData,
            id: Date.now().toString(),
            completedTime: null,
            scheduledTime: null
        };

        // Add to tasks array
        tasks.push(newTask);
        
        // Save to storage
        DataManager.save('tasks', tasks);

        // Schedule the task if time slots are set
        allocateTimeSlots(tasks);

        return true;
    } catch (error) {
        ErrorHandler.handle(error, 'Task addition failed');
        return false;
    }
}

// Core functions - keep only the most recent versions
function calculatePriorityScore(task) {
    if (!task.urgency || !task.importance || !task.effort) return 0;
            
    // Updated weights for better balance
    const urgencyWeight = 0.45;     // Increased weight for urgency
    const importanceWeight = 0.45;   // Increased weight for importance
    const effortWeight = 0.10;      // Reduced weight for effort to minimize its impact
    
    // Enhanced effort normalization (1-5 scale)
    const normalizedEffort = task.effort <= 2 ? 1 :
                            task.effort <= 4 ? 2 :
                            task.effort <= 6 ? 3 :
                            task.effort <= 8 ? 4 : 5;
    
    // Calculate base score (0-10 scale)
    const baseScore = (
        (urgencyWeight * task.urgency) +
        (importanceWeight * task.importance) - 
        (effortWeight * normalizedEffort)
    ) * 2;

    // Return score rounded to 2 decimal places
    return Math.min(10, Math.max(0, baseScore)).toFixed(2);
}

// Add helper function for date calculations
function getDaysUntilDue(dueDate) {
    const now = new Date();
    const due = new Date(dueDate);
    const diffTime = due - now;
    const diffDays = diffTime / (1000 * 60 * 60 * 24);
    return Math.max(0, diffDays);
}

// Update the priority class assignment in updateTaskList
function getPriorityClass(score) {
    const numScore = parseFloat(score);
    if (numScore >= 8) return 'text-red-600 font-bold';     // Critical
    if (numScore >= 6) return 'text-orange-500 font-bold';  // High
    if (numScore >= 4) return 'text-yellow-600';            // Medium
    return 'text-green-600';                                // Low
}

// Update the task element creation in updateTaskList function
function updateTaskList(filteredTasks = tasks) {
    try {
        updatePriorityAnalysis();
        const taskListContent = document.getElementById('task-list-content');
        taskListContent.innerHTML = '';

        // Add table header
        taskListContent.innerHTML = `
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metrics</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        `;

        const tbody = taskListContent.querySelector('tbody');

        filteredTasks.forEach(task => {
            const priorityScore = calculatePriorityScore(task);
            const priorityClass = getPriorityClass(priorityScore);
            const priorityLabel = getPriorityLabel(priorityScore);

            const tr = document.createElement('tr');
            tr.className = `${task.completedTime ? 'bg-gray-50' : 'hover:bg-gray-50'} transition-colors`;
            
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900 ${task.completedTime ? 'line-through' : ''}">
                            ${task.name}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="${priorityClass} text-sm">
                            ${priorityLabel} (${priorityScore})
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">
                        U:${task.urgency}/5 | I:${task.importance}/5 | E:${task.effort}h
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">
                        ${task.scheduledTime || 'Not scheduled'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex space-x-2">
                        ${!task.completedTime ? `
                            <button onclick="completeTask('${task.id}')"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors">
                                <i class="fa fa-check"></i>
                            </button>
                        ` : `
                            <span class="text-green-600">
                                <i class="fa fa-check-circle"></i>
                            </span>
                        `}
                        <button onclick="deleteTask('${task.id}')"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tbody.appendChild(tr);
        });

        // Show empty state if no tasks
        if (filteredTasks.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <i class="fa fa-tasks fa-2x mb-2"></i>
                        <p>No tasks found</p>
                    </td>
                </tr>
            `;
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to update task list');
    }
}

// Add helper function for priority labels
function getPriorityLabel(score) {
    const numScore = parseFloat(score);
    if (numScore >= 8) return 'Critical';
    if (numScore >= 6) return 'High';
    if (numScore >= 4) return 'Medium';
    return 'Low';
}

// Dashboard
const dashboard = {
    charts: {
        tasksStatus: null,
        priority: null,
        effort: null
    },
    
    init() {
        this.showLoading(true);
        try {
            this.destroyCharts();
            this.createCharts();
            this.showLoading(false);
        } catch (error) {
            console.error('Dashboard initialization error:', error);
            this.showError('Failed to initialize dashboard');
        }
    },

    showLoading(show) {
        document.getElementById('dashboard-loading').classList.toggle('hidden', !show);
        document.getElementById('dashboard-content').classList.toggle('hidden', show);
    },

    showError(message) {
        showErrorMessage(message);
        this.showLoading(false);
    },

    destroyCharts() {
        Object.values(this.charts).forEach(chart => {
            if (chart) chart.destroy();
        });
    },

    createCharts() {
        this.createTaskStatusChart();
        this.createPriorityChart();
        this.createEffortChart();
    },

    createTaskStatusChart() {
        try {
            const ctx = document.getElementById('task-status-chart')?.getContext('2d');
            if (!ctx) return;
            
            const pendingTasks = tasks.filter(t => !t.completedTime).length;
            const completedTasks = tasks.filter(t => t.completedTime).length;

            this.charts.tasksStatus = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Completed'],
                    datasets: [{
                        data: [pendingTasks, completedTasks],
                        backgroundColor: ['#4299E1', '#48BB78']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to create status chart');
        }
    },

    createPriorityChart() {
        try {
            const ctx = document.getElementById('task-priority-chart')?.getContext('2d');
            if (!ctx) return;
            
            const priorityData = tasks.reduce((acc, task) => {
                const priority = Math.round(calculatePriorityScore(task));
                acc[priority] = (acc[priority] || 0) + 1;
                return acc;
            }, {});

            this.charts.priority = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(priorityData),
                    datasets: [{
                        label: 'Tasks by Priority',
                        data: Object.values(priorityData),
                        backgroundColor: '#9F7AEA'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to create priority chart');
        }
    },

    createEffortChart() {
        try {
            const ctx = document.getElementById('task-effort-chart')?.getContext('2d');
            if (!ctx) return;
            
            const effortRanges = {
                'Low (0-2h)': tasks.filter(t => t.effort <= 2).length,
                'Medium (2-4h)': tasks.filter(t => t.effort > 2 && t.effort <= 4).length,
                'High (4-8h)': tasks.filter(t => t.effort > 4 && t.effort <= 8).length,
                'Very High (>8h)': tasks.filter(t => t.effort > 8).length
            };

            this.charts.effort = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(effortRanges),
                    datasets: [{
                        data: Object.values(effortRanges),
                        backgroundColor: ['#68D391', '#F6AD55', '#FC8181', '#F687B3']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        }
                    }
                }
            });
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to create effort chart');
        }
    }
};

// Time Slot Manager
const TimeSlotManager = {
    validate(startTime, endTime, breakTime) {
        const start = this.parseTime(startTime);
        const end = this.parseTime(endTime);
        
        if (!start || !end) throw new Error('Invalid time format');
        if (start >= end) throw new Error('Start time must be before end time');
        if (breakTime < 0) throw new Error('Break time cannot be negative');
        
        return { start, end, breakTime };
    },

    parseTime(timeString) {
        const [hours, minutes] = timeString.split(':').map(Number);
        return hours + minutes / 60;
    },

    formatTime(decimalTime) {
        const hours = Math.floor(decimalTime);
        const minutes = Math.round((decimalTime - hours) * 60);
        const period = hours >= 12 ? 'PM' : 'AM';
        const formattedHour = hours % 12 || 12;
        return `${formattedHour}:${minutes.toString().padStart(2, '0')} ${period}`;
    },

    calculateAvailableTime(start, end, breakTime) {
        return end - start - (breakTime / 60);
    },

    allocateTimeSlots(tasks, settings) {
        try {
            const { start, end, breakTime } = this.validate(
                settings.startTime,
                settings.endTime,
                settings.breakTime
            );

            let currentTime = start;
            const availableTime = this.calculateAvailableTime(start, end, breakTime);
            const scheduledTasks = [];
            const unscheduledTasks = [];

            // Sort tasks by priority
            const sortedTasks = [...tasks].sort((a, b) => {
                if (a.completedTime) return 1;
                if (b.completedTime) return -1;
                return calculatePriorityScore(b) - calculatePriorityScore(a);
            });

            sortedTasks.forEach(task => {
                if (task.completedTime) {
                    scheduledTasks.push(task);
                    return;
                }

                if (!task.effort || task.effort <= 0) {
                    unscheduledTasks.push({
                        ...task,
                        scheduledTime: "Invalid effort"
                    });
                    return;
                }

                const taskEndTime = currentTime + task.effort;
                if (taskEndTime <= end) {
                    scheduledTasks.push({
                        ...task,
                        scheduledTime: `${this.formatTime(currentTime)} - ${this.formatTime(taskEndTime)}`,
                        startTime: currentTime,
                        endTime: taskEndTime
                    });
                    currentTime = taskEndTime + (breakTime / 60);
                } else {
                    unscheduledTasks.push({
                        ...task,
                        scheduledTime: "Exceeds available time"
                    });
                }
            });

            return {
                scheduled: scheduledTasks,
                unscheduled: unscheduledTasks,
                availableTime,
                remainingTime: end - currentTime
            };
        } catch (error) {
            ErrorHandler.handle(error, 'Time slot allocation failed');
            return null;
        }
    }
};

// Auto Scheduler
const AutoScheduler = {
    strategies: {
        priority: (tasks) => [...tasks].sort((a, b) => calculatePriorityScore(b) - calculatePriorityScore(a)),
        deadline: (tasks) => [...tasks].sort((a, b) => {
            if (!a.dueDate) return 1;
            if (!b.dueDate) return -1;
            return new Date(a.dueDate) - new Date(b.dueDate);
        }),
        effort: (tasks) => [...tasks].sort((a, b) => a.effort - b.effort)
    },

    calculateOptimalTimeSlots(tasks, workingHours) {
        const totalEffort = tasks.reduce((sum, task) => sum + (task.effort || 0), 0);
        const dailyHours = workingHours.end - workingHours.start;
        const daysNeeded = Math.ceil(totalEffort / dailyHours);
        
        return {
            daysNeeded,
            dailyHours,
            totalEffort,
            suggestedBreaks: this.calculateBreaks(tasks.length, dailyHours)
        };
    },

    calculateBreaks(taskCount, dailyHours) {
        // Suggest breaks based on workload
        const baseBreak = 15; // 15 minutes base break
        const breakCount = Math.floor(dailyHours / 2); // Break every 2 hours
        return Math.min(taskCount - 1, breakCount) * baseBreak;
    },

    autoSchedule(tasks, strategy = 'priority') {
        try {
            // Get current working hours
            const start = TimeUtil.toDecimal(document.getElementById('start-time').value);
            const end = TimeUtil.toDecimal(document.getElementById('end-time').value);

            // Calculate optimal scheduling
            const optimal = this.calculateOptimalTimeSlots(tasks, { start, end });
            
            // Update break time with suggested value
            document.getElementById('break-time').value = optimal.suggestedBreaks;

            // Sort tasks according to selected strategy
            const sortedTasks = this.strategies[strategy](tasks.filter(t => !t.completedTime));
            
            // Show scheduling summary
            this.showSchedulingSummary(optimal);

            // Apply the schedule
            return TimeSlotManager.allocateTimeSlots(sortedTasks, {
                startTime: document.getElementById('start-time').value,
                endTime: document.getElementById('end-time').value,
                breakTime: optimal.suggestedBreaks
            });
        } catch (error) {
            ErrorHandler.handle(error, 'Auto-scheduling failed');
            return null;
        }
    },

    showSchedulingSummary(optimal) {
        const summary = `
            <div class="text-sm">
                <p>Total effort: ${optimal.totalEffort.toFixed(1)} hours</p>
                <p>Days needed: ${optimal.daysNeeded}</p>
                <p>Suggested breaks: ${optimal.suggestedBreaks} minutes</p>
            </div>
        `;

        const summaryDiv = document.createElement('div');
        summaryDiv.className = 'fixed bottom-4 right-4 bg-indigo-500 text-white p-4 rounded-lg shadow-lg z-50';
        summaryDiv.innerHTML = summary;
        document.body.appendChild(summaryDiv);
        setTimeout(() => summaryDiv.remove(), 5000);
    }
};

// Event Listeners
document.addEventListener('DOMContentLoaded', async function() {
    try {
        tasks = DataManager.load('tasks', []);
        setupAutoTimeSlotUpdate();  // Add this line
        initializeCharts();
        updateTaskList();
        if (tasks.length > 0) {
            allocateTimeSlots(tasks);  // Initial allocation
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to initialize application');
    }
});

// Form submissions
document.getElementById('task-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    try {
        // Get form elements directly
        const taskName = document.getElementById('task-name')?.value.trim();
        const urgency = Number(document.getElementById('urgency')?.value);
        const importance = Number(document.getElementById('importance')?.value);
        const effort = Number(document.getElementById('effort')?.value);
        
        // Validate required fields
        if (!taskName) throw new Error('Task name is required');
        if (!urgency) throw new Error('Urgency is required');
        if (!importance) throw new Error('Importance is required');
        if (!effort || effort <= 0) throw new Error('Valid effort value is required');

        const taskData = {
            name: taskName,
            urgency,
            importance,
            effort,
            id: Date.now().toString(),
            completedTime: null,
            scheduledTime: null
        };

        // Add task
        tasks.push(taskData);
        DataManager.save('tasks', tasks);
        
        // Update UI
        this.reset();
        updateTaskList();  // This will now include priority analysis
        updateDashboard();
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to add task');
    }
});

// Add these utility functions
function getElementValue(id, defaultValue = '') {
    const element = document.getElementById(id);
    return element ? element.value : defaultValue;
}

function showErrorMessage(message) {
    ErrorHandler.showError(message);
}

function showAllocationSummary(result) {
    const existingSummary = document.querySelector('.allocation-summary');
    if (existingSummary) {
        existingSummary.remove();
    }

    const summary = document.createElement('div');
    summary.className = 'allocation-summary fixed bottom-4 right-4 bg-white p-4 rounded-lg shadow-lg z-50';
    summary.innerHTML = `
        <h3 class="font-bold mb-2">Task Allocation Summary</h3>
        <p>Scheduled Tasks: ${result.scheduled.length}</p>
        <p>Unscheduled Tasks: ${result.unscheduled.length}</p>
        <p>Available Time: ${result.availableTime.toFixed(1)}h</p>
        <p>Remaining Time: ${result.remainingTime.toFixed(1)}h</p>
    `;
    document.body.appendChild(summary);
    setTimeout(() => {
        if (document.body.contains(summary)) {
            document.body.removeChild(summary);
        }
    }, 5000);
}

// Add task completion and deletion handlers
function completeTask(taskId) {
    const task = tasks.find(t => t.id === taskId);
    if (task) {
        task.completedTime = new Date().toISOString();
        DataManager.save('tasks', tasks);
        allocateTimeSlots(tasks);  // Reallocate after completion
        updateTaskList();
        updateDashboard();
    }
}

function deleteTask(taskId) {
    tasks = tasks.filter(t => t.id !== taskId);
    DataManager.save('tasks', tasks);
    allocateTimeSlots(tasks);  // Reallocate after deletion
    updateTaskList();
    updateDashboard();
}

function clearAllTasks() {
    if (confirm('Are you sure you want to clear all tasks?')) {
        tasks = [];
        DataManager.save('tasks', tasks);
        updateTaskList();
        updateDashboard();
    }
}

// Fix chart initialization
function initializeCharts() {
    try {
        // First check if elements exist
        const statusChart = document.getElementById('task-status-chart');
        const priorityChart = document.getElementById('task-priority-chart');
        const effortChart = document.getElementById('task-effort-chart');

        if (!statusChart || !priorityChart || !effortChart) {
            throw new Error('Chart elements not found');
        }

        // Get contexts
        const ctx1 = statusChart.getContext('2d');
        const ctx2 = priorityChart.getContext('2d');
        const ctx3 = effortChart.getContext('2d');

        // Destroy existing charts
        if (dashboard.charts.tasksStatus) dashboard.charts.tasksStatus.destroy();
        if (dashboard.charts.priority) dashboard.charts.priority.destroy();
        if (dashboard.charts.effort) dashboard.charts.effort.destroy();

        // Create new charts
        dashboard.createTaskStatusChart();
        dashboard.createPriorityChart();
        dashboard.createEffortChart();
    } catch (error) {
        ErrorHandler.handle(error, 'Chart initialization failed');
    }
}

function updateDashboard() {
    dashboard.init();
}

// Add this new function to analyze and display priority distribution
function updatePriorityAnalysis() {
    try {
        const priorityGroups = {
            critical: { tasks: [], element: 'critical-tasks', countElement: 'critical-count', threshold: 8 },
            high: { tasks: [], element: 'high-tasks', countElement: 'high-count', threshold: 6 },
            medium: { tasks: [], element: 'medium-tasks', countElement: 'medium-count', threshold: 4 },
            low: { tasks: [], element: 'low-tasks', countElement: 'low-count', threshold: 0 }
        };

        // Group tasks by priority
        tasks.forEach(task => {
            if (task.completedTime) return; // Skip completed tasks
            const score = parseFloat(calculatePriorityScore(task));
            
            if (score >= priorityGroups.critical.threshold) {
                priorityGroups.critical.tasks.push(task);
            } else if (score >= priorityGroups.high.threshold) {
                priorityGroups.high.tasks.push(task);
            } else if (score >= priorityGroups.medium.threshold) {
                priorityGroups.medium.tasks.push(task);
            } else {
                priorityGroups.low.tasks.push(task);
            }
        });

        // Update the UI for each priority group
        Object.entries(priorityGroups).forEach(([level, group]) => {
            const element = document.getElementById(group.element);
            const countElement = document.getElementById(group.countElement);
            
            if (!element || !countElement) return;

            // Update count badge
            countElement.textContent = group.tasks.length;

            if (group.tasks.length === 0) {
                element.innerHTML = '<div class="py-3 text-gray-500 text-sm">No tasks</div>';
                return;
            }

            element.innerHTML = group.tasks
                .sort((a, b) => calculatePriorityScore(b) - calculatePriorityScore(a))
                .slice(0, 2)
                .map(task => `
                    <div class="flex items-center justify-between py-1">
                        <div class="flex-1 truncate">
                            <div class="font-medium truncate">${task.name}</div>
                            <div class="text-xs text-gray-500">
                                Score: ${calculatePriorityScore(task)} | ${task.scheduledTime || 'Not scheduled'}
                            </div>
                        </div>
                    </div>
                `).join('');

            if (group.tasks.length > 2) {
                element.innerHTML += `
                    <div class="text-xs text-gray-500 text-right">
                        +${group.tasks.length - 2} more
                    </div>
                `;
            }
        });
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to update priority analysis');
    }
}

// Add this new function for auto-updating time slots
function setupAutoTimeSlotUpdate() {
    const inputs = ['start-time', 'end-time', 'break-time'];
    inputs.forEach(id => {
        document.getElementById(id)?.addEventListener('change', () => {
            if (tasks.length > 0) {
                allocateTimeSlots(tasks);
                updateTaskList();
            }
        });
    });
}

// Modify the allocateTimeSlots function
function allocateTimeSlots(tasks) {
    if (!tasks?.length) return tasks;

    try {
        const settings = {
            startTime: getElementValue('start-time', '09:00'),
            endTime: getElementValue('end-time', '17:00'),
            breakTime: parseInt(getElementValue('break-time', '0'))
        };

        const result = TimeSlotManager.allocateTimeSlots(tasks, settings);
        if (!result) return tasks;

        // Update tasks with new scheduling
        tasks = [...result.scheduled, ...result.unscheduled];
        DataManager.save('tasks', tasks);

        // Show allocation summary
        showAllocationSummary(result);
        
        // Update dashboard if it exists
        updateDashboard();
        
        return tasks;
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to allocate time slots');
        return tasks;
    }
}

// Modify the addTask function
function addTask(taskData) {
    try {
        // ... existing validation code ...

        const newTask = {
            ...taskData,
            id: Date.now().toString(),
            completedTime: null,
            scheduledTime: null
        };

        // Add to tasks array
        tasks.push(newTask);
        
        // Save to storage
        DataManager.save('tasks', tasks);

        // Automatically allocate time slots
        allocateTimeSlots(tasks);

        return true;
    } catch (error) {
        ErrorHandler.handle(error, 'Task addition failed');
        return false;
    }
}

// Update the completeTask and deleteTask functions
function completeTask(taskId) {
    const task = tasks.find(t => t.id === taskId);
    if (task) {
        task.completedTime = new Date().toISOString();
        DataManager.save('tasks', tasks);
        allocateTimeSlots(tasks);  // Reallocate after completion
        updateTaskList();
        updateDashboard();
    }
}

function deleteTask(taskId) {
    tasks = tasks.filter(t => t.id !== taskId);
    DataManager.save('tasks', tasks);
    allocateTimeSlots(tasks);  // Reallocate after deletion
    updateTaskList();
    updateDashboard();
}
    </script>
</body>
</html>


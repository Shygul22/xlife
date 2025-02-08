<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenJourney.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
      <!-- Welcome Modal -->
      <div id="welcome-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white max-w-2xl mx-auto mt-20 rounded-lg shadow-xl">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Welcome to ZenJourney.in</h2>
                <div class="space-y-4">
                    
                    <p class="text-gray-600">This tool helps you organize your tasks efficiently by:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li>Automatically scheduling tasks based on priority and effort</li>
                        <li>Managing your daily work hours and breaks</li>
                        <li>Optimizing task order for maximum productivity</li>
                        <li>Keeping track of completed and pending tasks</li>
                    </ul>
                    
                    <div class="mt-6">
                        <h3 class="font-semibold mb-2">Quick Start Guide:</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600">
                            <li>Set your working hours in Time Settings</li>
                            <li>Add tasks with priority levels and effort estimates</li>
                            <li>Click "Schedule Tasks" to organize your day</li>
                            <li>Mark tasks as complete as you finish them</li>
                        </ol>
                    </div>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" id="dont-show-again" class="mr-2">
                        Don't show this again
                    </label>
                    <button onclick="closeWelcomeModal()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Get Started
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen">
        <!-- Header with Time Settings Button -->
        <header class="bg-white shadow-sm">
            <div class="max-w-4xl mx-auto py-4 px-4 sm:px-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">ZenJourney.in</h1>
                        <p class="mt-1 text-sm text-gray-600">Balance Your Time, Elevate Your Life</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleTimeSettings()" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center space-x-2">
                            <i class="fa fa-clock-o"></i>
                            <span>Time Settings</span>
                        </button>
                        <button onclick="showGuide()" 
                            class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200 transition duration-200 flex items-center space-x-2">
                            <i class="fa fa-question-circle"></i>
                            <span>How to Use</span>
                        </button>
                    </div>
                </div>
                
                <!-- Collapsible Time Settings Section -->
                <div id="time-settings-panel" class="mt-4 hidden transition-all duration-300 ease-in-out">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fa fa-clock-o mr-2 text-blue-500"></i>Time Settings
                            </h2>
                            <button onclick="rescheduleAllTasks()"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center space-x-2 text-sm">
                                <i class="fa fa-refresh"></i>
                                <span>Schedule Tasks</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="start-time" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fa fa-sun-o mr-1"></i>Start Time
                                </label>
                                <input type="time" id="start-time" required
                                    class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="saveTimeSlotSettings()">
                            </div>
                            <div>
                                <label for="end-time" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fa fa-moon-o mr-1"></i>End Time
                                </label>
                                <input type="time" id="end-time" required
                                    class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="saveTimeSlotSettings()">
                            </div>
                            <div>
                                <label for="break-time" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fa fa-coffee mr-1"></i>Break (min)
                                </label>
                                <input type="number" id="break-time" min="0"
                                    class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="saveTimeSlotSettings()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="container mx-auto p-4 sm:p-6">
            <div class="space-y-6 max-w-4xl mx-auto">
                <!-- Task Form Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class="fa fa-plus-circle mr-2 text-green-500"></i>Add New Task
                        </h2>
                    </div>
                    <form id="task-form" class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                            <div class="sm:col-span-2">
                                <label for="task-name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fa fa-tasks mr-1"></i>Task Name
                                </label>
                                <input type="text" id="task-name" placeholder="Enter task name" required
                                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fa fa-flag mr-1"></i>Priority
                                </label>
                                <select id="priority" required 
                                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="" disabled selected>Select Level</option>
                                    <option value="1">1 - Very Low</option>
                                    <option value="2">2 - Low</option>
                                    <option value="3">3 - Medium</option>
                                    <option value="4">4 - High</option>
                                    <option value="5">5 - Very High</option>
                                </select>
                            </div>
                            <div>
                                <label for="effort" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fa fa-clock-o mr-1"></i>Effort (hrs)
                                </label>
                                <input type="number" id="effort" placeholder="0.5 - 24 hrs" min="0.0" max="24" step="0.5" required
                                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-200 flex items-center space-x-2 ml-auto">
                                <i class="fa fa-plus"></i>
                                <span>Add Task</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Task List Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class="fa fa-list mr-2 text-gray-500"></i>Task List
                        </h2>
                        <button onclick="clearAllTasks()" 
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200 flex items-center space-x-2">
                            <i class="fa fa-trash"></i>
                            <span>Clear All</span>
                        </button>
                    </div>
                    <div id="task-list-content" class="p-6">
                        <!-- Task list will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </main>
    </div>
<div class="version">
version 2.1.30 
</div>
    <!-- Error message container with improved styling -->
    <div id="error-message-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script>
        // Core utilities - Keep only essential error handling
const ErrorHandler = {
    handle(error, context = '') {
        console.error(`${context}:`, error);
        this.showMessage(error.message || 'An error occurred', 'error');
    },

    showMessage(message, type = 'error') {
        const container = document.getElementById('error-message-container');
        if (!container) return;
        
        const messageDiv = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 
                       type === 'warning' ? 'bg-yellow-500' : 'bg-red-500';
        
        messageDiv.className = `${bgColor} text-white p-4 rounded-lg shadow-lg mb-2 flex items-center space-x-2`;
        messageDiv.innerHTML = `
            <i class="fa fa-${type === 'success' ? 'check-circle' : 
                          type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        container.appendChild(messageDiv);
        setTimeout(() => {
            if (container.contains(messageDiv)) {
                container.removeChild(messageDiv);
            }
        }, 3000);
    }
};

// Data management - Simplified
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

// Task Management - Simplified
let tasks = [];

// Core functions - Essential only
function addTask(taskData) {
    try {
        const newTask = {
            ...taskData,
            id: Date.now().toString(),
            completedTime: null,
            scheduledTime: null
        };

        tasks.push(newTask);
        const result = TimeSlotManager.allocateTimeSlots(tasks, {
            startTime: getElementValue('start-time', '09:00'),
            endTime: getElementValue('end-time', '17:00'),
            breakTime: parseInt(getElementValue('break-time', '0'))
        });

        if (result) {
            tasks = [...result.scheduled, ...result.unscheduled];
            DataManager.save('tasks', tasks);
        }
        
        updateTaskList();
        return true;
    } catch (error) {
        ErrorHandler.handle(error, 'Task addition failed');
        return false;
    }
}

// Time management - Essential functionality
const TimeUtil = {
    toDecimal(timeString) {
        try {
            if (!timeString || typeof timeString !== 'string') return null;
            const [hours, minutes] = timeString.split(':').map(Number);
            if (isNaN(hours) || isNaN(minutes)) return null;
            return hours + (minutes / 60);
        } catch (error) {
            return null;
        }
    },

    fromDecimal(decimal) {
        try {
            if (typeof decimal !== 'number' || isNaN(decimal)) return null;
            const hours = Math.floor(decimal);
            const minutes = Math.round((decimal - hours) * 60);
            return {
                hours: Math.max(0, Math.min(23, hours)),
                minutes: Math.max(0, Math.min(59, minutes)),
                formatted: `${String(Math.max(0, Math.min(23, hours))).padStart(2, '0')}:${String(Math.max(0, Math.min(59, minutes))).padStart(2, '0')}`
            };
        } catch (error) {
            return null;
        }
    },

    formatTimeRange(start, end) {
        const startTime = this.fromDecimal(start);
        const endTime = this.fromDecimal(end);
        if (!startTime || !endTime) return 'Invalid time';
        return `${this.to12Hour(startTime.formatted)} - ${this.to12Hour(endTime.formatted)}`;
    },

    to12Hour(time24) {
        try {
            const [hours, minutes] = time24.split(':');
            const hour = parseInt(hours);
            const period = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${period}`;
        } catch (error) {
            return time24;
        }
    }
};

// Add missing calculatePriorityScore function
function calculatePriorityScore(task) {
    try {
        if (!task?.urgency || !task?.importance || !task?.effort) return 0;
        
        const urgencyWeight = 0.45;
        const importanceWeight = 0.45;
        const effortWeight = 0.10;
        
        const normalizedEffort = task.effort <= 2 ? 1 :
                               task.effort <= 4 ? 2 :
                               task.effort <= 6 ? 3 :
                               task.effort <= 8 ? 4 : 5;
        
        const score = (
            (urgencyWeight * task.urgency) +
            (importanceWeight * task.importance) - 
            (effortWeight * normalizedEffort)
        ) * 2;
        
        return Math.min(10, Math.max(0, score)).toFixed(2);
    } catch (error) {
        return 0;
    }
}

// Update TimeSlotManager with validation
const TimeSlotManager = {
    validate(settings) {
        try {
            if (!settings?.startTime || !settings?.endTime) return false;
            const start = TimeUtil.toDecimal(settings.startTime);
            const end = TimeUtil.toDecimal(settings.endTime);
            
            if (start === null || end === null) {
                ErrorHandler.showMessage('Invalid time format', 'warning');
                return false;
            }
            
            if (start >= end) {
                ErrorHandler.showMessage('End time must be after start time', 'warning');
                return false;
            }
            
            if (end - start > 24) {
                ErrorHandler.showMessage('Time range cannot exceed 24 hours', 'warning');
                return false;
            }
            
            return true;
        } catch (error) {
            ErrorHandler.handle(error, 'Time validation failed');
            return false;
        }
    },

    allocateTimeSlots(tasks, settings) {
        try {
            if (!Array.isArray(tasks) || !this.validate(settings)) {
                return null;
            }

            const start = TimeUtil.toDecimal(settings.startTime);
            const end = TimeUtil.toDecimal(settings.endTime);
            const breakInHours = Math.max(0, (settings.breakTime || 0)) / 60;
            let currentTime = start;
            
            const scheduledTasks = [];
            const unscheduledTasks = [];

            // Sort by priority (remove completed task handling since we're removing them)
            const sortedTasks = [...tasks].sort((a, b) => 
                calculatePriorityScore(b) - calculatePriorityScore(a)
            );

            for (const task of sortedTasks) {
                if (!task.effort || task.effort <= 0) {
                    unscheduledTasks.push({ ...task, scheduledTime: "Invalid effort" });
                    continue;
                }

                const taskEndTime = currentTime + task.effort;
                if (taskEndTime <= end) {
                    scheduledTasks.push({
                        ...task,
                        scheduledTime: TimeUtil.formatTimeRange(currentTime, taskEndTime),
                        startTime: currentTime,
                        endTime: taskEndTime
                    });
                    currentTime = taskEndTime + breakInHours;
                } else {
                    unscheduledTasks.push({ ...task, scheduledTime: "Exceeds available time" });
                }
            }

            return { scheduled: scheduledTasks, unscheduled: unscheduledTasks };
        } catch (error) {
            ErrorHandler.handle(error, 'Scheduling failed');
            return null;
        }
    }
};

// Update form submission handler with validation
document.getElementById('task-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    try {
        const taskName = document.getElementById('task-name')?.value?.trim();
        const priority = Number(document.getElementById('priority')?.value);
        const effort = Number(document.getElementById('effort')?.value);
        
        if (!taskName) throw new Error('Task name is required');
        if (priority < 1 || priority > 5) throw new Error('Invalid priority value');
        if (effort <= 0 || effort > 24) throw new Error('Effort must be between 0 and 24 hours');

        const taskData = { 
            name: taskName, 
            urgency: priority, // Use priority for both
            importance: priority, 
            effort 
        };
        
        if (addTask(taskData)) {
            this.reset();
            updateTaskList();
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to add task');
    }
});

// Add these functions before the DOMContentLoaded event listener
function saveTimeSlotSettings() {
    const startTime = document.getElementById('start-time').value;
    const endTime = document.getElementById('end-time').value;
    const breakTime = parseInt(document.getElementById('break-time').value) || 0;
    
    if (breakTime < 0 || breakTime > 120) {
        ErrorHandler.showMessage('Break time must be between 0 and 120 minutes', 'warning');
        document.getElementById('break-time').value = Math.min(120, Math.max(0, breakTime));
        return;
    }
    
    const settings = { startTime, endTime, breakTime };
    
    if (TimeSlotManager.validate(settings)) {
        DataManager.save('timeSlotSettings', settings);
        
        const result = TimeSlotManager.allocateTimeSlots(tasks, {
            startTime: startTime,
            endTime: endTime,
            breakTime: breakTime
        });
        
        if (result) {
            tasks = [...result.scheduled, ...result.unscheduled];
            DataManager.save('tasks', tasks);
            updateTaskList();
            ErrorHandler.showMessage('Time settings updated', 'success');
        }
    }
}

function loadTimeSlotSettings() {
    const defaultSettings = {
        startTime: '09:00',
        endTime: '17:00',
        breakTime: '0'
    };
    
    const settings = DataManager.load('timeSlotSettings', defaultSettings);
    
    document.getElementById('start-time').value = settings.startTime;
    document.getElementById('end-time').value = settings.endTime;
    document.getElementById('break-time').value = settings.breakTime;
}

// Modify the DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // Load saved states
    loadTimeSlotSettings();
    tasks = DataManager.load('tasks', []);
    
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize time settings panel state
    const timeSettingsState = DataManager.load('timeSettingsVisible', false);
    const panel = document.getElementById('time-settings-panel');
    if (timeSettingsState) {
        panel.classList.remove('hidden');
        panel.classList.add('opacity-100');
    }
    
    // Initial task list update
    updateTaskList();
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    tasks = DataManager.load('tasks', []);
    updateTaskList();
});

// Helper functions - Keep only essentials
function getElementValue(id, defaultValue = '') {
    return document.getElementById(id)?.value || defaultValue;
}

// Add the missing updateTaskList implementation
function updateTaskList() {
    try {
        const taskListContent = document.getElementById('task-list-content');
        if (!taskListContent) return;

        taskListContent.innerHTML = `
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metrics</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        ${tasks.length ? '' : `
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    <i class="fa fa-tasks fa-2x mb-2"></i>
                                    <p>No tasks found</p>
                                </td>
                            </tr>
                        `}
                    </tbody>
                </table>
            </div>
        `;

        const tbody = taskListContent.querySelector('tbody');
        tasks.forEach(task => {
            const priorityScore = calculatePriorityScore(task);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        ${task.name}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm ${getPriorityClass(priorityScore)}">
                        ${getPriorityLabel(priorityScore)}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">
                        Priority: ${task.urgency}/5 | Effort: ${task.effort}h
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">
                        ${task.scheduledTime || 'Not scheduled'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                        <button onclick="completeTask('${task.id}')"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 flex items-center space-x-1">
                            <i class="fa fa-check"></i>
                            <span>Complete</span>
                        </button>
                        <button onclick="deleteTask('${task.id}')"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 flex items-center space-x-1">
                            <i class="fa fa-trash"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to update task list');
    }
}

// Add missing utility functions
function getPriorityClass(score) {
    const numScore = parseFloat(score);
    if (numScore >= 8) return 'text-red-600 font-bold';
    if (numScore >= 6) return 'text-orange-500 font-bold';
    if (numScore >= 4) return 'text-yellow-600';
    return 'text-green-600';
}

function getPriorityLabel(score) {
    const numScore = parseFloat(score);
    if (numScore >= 8) return 'Critical';
    if (numScore >= 6) return 'High';
    if (numScore >= 4) return 'Medium';
    return 'Low';
}

function rescheduleTasksAfterTime(startingTime) {
    // Filter uncompleted tasks that are scheduled after the given time
    const remainingTasks = tasks.filter(t => 
        !t.completedTime && 
        t.startTime >= startingTime
    );

    // Get the end of day time
    const endTime = TimeUtil.toDecimal(getElementValue('end-time', '17:00'));
    const breakTime = parseInt(getElementValue('break-time', '0')) / 60;

    let currentTime = startingTime;
    
    // Reschedule remaining tasks
    remainingTasks.forEach(task => {
        const taskEndTime = currentTime + task.effort;
        if (taskEndTime <= endTime) {
            task.startTime = currentTime;
            task.endTime = taskEndTime;
            task.scheduledTime = TimeUtil.formatTimeRange(currentTime, taskEndTime);
            currentTime = taskEndTime + breakTime;
        } else {
            task.scheduledTime = "Exceeds available time";
            task.startTime = null;
            task.endTime = null;
        }
    });

    // Update tasks array
    tasks = tasks.map(t => {
        const updatedTask = remainingTasks.find(rt => rt.id === t.id);
        return updatedTask || t;
    });

    DataManager.save('tasks', tasks);
    updateTaskList();
}

function completeTask(taskId) {
    try {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            if (confirm(`Mark "${task.name}" as complete?`)) {
                const taskEndTime = task.endTime;
                tasks = tasks.filter(t => t.id !== taskId);
                
                if (taskEndTime) {
                    const remainingTasks = tasks.filter(t => t.startTime >= taskEndTime);
                    if (remainingTasks.length > 0) {
                        rescheduleTasksAfterTime(taskEndTime);
                    } else {
                        DataManager.save('tasks', tasks);
                        updateTaskList();
                    }
                } else {
                    DataManager.save('tasks', tasks);
                    updateTaskList();
                }
                
                ErrorHandler.showMessage(`Task "${task.name}" completed!`, 'success');
            }
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to complete task');
    }
}

function deleteTask(taskId) {
    try {
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;

        if (confirm(`Are you sure you want to delete task "${task.name}"?`)) {
            tasks = tasks.filter(t => t.id !== taskId);
            DataManager.save('tasks', tasks);
            const result = TimeSlotManager.allocateTimeSlots(tasks, {
                startTime: getElementValue('start-time', '09:00'),
                endTime: getElementValue('end-time', '17:00'),
                breakTime: parseInt(getElementValue('break-time', '0'))
            });
            if (result) {
                tasks = [...result.scheduled, ...result.unscheduled];
                DataManager.save('tasks', tasks);
            }
            updateTaskList();
            ErrorHandler.showMessage('Task deleted successfully', 'success');
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to delete task');
    }
}

function clearAllTasks() {
    if (tasks.length === 0) {
        ErrorHandler.showMessage('No tasks to clear', 'warning');
        return;
    }
    
    if (confirm('Are you sure you want to clear all tasks? This action cannot be undone.')) {
        tasks = [];
        DataManager.save('tasks', tasks);
        updateTaskList();
        ErrorHandler.showMessage('All tasks cleared successfully', 'success');
    }
}

function rescheduleAllTasks() {
    try {
        const result = TimeSlotManager.allocateTimeSlots(tasks, {
            startTime: getElementValue('start-time', '09:00'),
            endTime: getElementValue('end-time', '17:00'),
            breakTime: parseInt(getElementValue('break-time', '0'))
        });
        
        if (result) {
            tasks = [...result.scheduled, ...result.unscheduled];
            DataManager.save('tasks', tasks);
            updateTaskList();
            // Show success message
            ErrorHandler.showMessage('Tasks rescheduled successfully', 'success');
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to reschedule tasks');
    }
}

// ...rest of essential utility functions...
    // Add before other JavaScript code
    function initializeTooltips() {
        // Time Settings tooltips
        tippy('#start-time', { content: 'Set when your work day begins' });
        tippy('#end-time', { content: 'Set when your work day ends' });
        tippy('#break-time', { content: 'Add break time between tasks' });
        
        // Task Form tooltips
        tippy('#task-name', { content: 'Enter a clear, specific task name' });
        tippy('#priority', { content: 'Set task importance (1=lowest, 5=highest)' });
        tippy('#effort', { content: 'Estimate how many hours needed' });
    }

    function showGuide() {
        const guideContent = `
            <div class="space-y-6 p-4">
                <section>
                    <h3 class="font-bold text-lg mb-2">Time Settings</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>Set your working hours using Start Time and End Time</li>
                        <li>Add break time between tasks if needed</li>
                        <li>Click "Schedule Tasks" to reorganize your task list</li>
                    </ul>
                </section>
                
                <section>
                    <h3 class="font-bold text-lg mb-2">Adding Tasks</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>Enter a clear task name</li>
                        <li>Select priority level (affects scheduling order)</li>
                        <li>Estimate effort in hours (0.5 - 24 hours)</li>
                    </ul>
                </section>
                
                <section>
                    <h3 class="font-bold text-lg mb-2">Managing Tasks</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>Tasks are automatically scheduled based on priority</li>
                        <li>Click Complete when a task is finished</li>
                        <li>Delete removes tasks without rescheduling</li>
                        <li>Clear All removes all tasks</li>
                    </ul>
                </section>
            </div>
        `;
        
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white max-w-2xl mx-4 rounded-lg shadow-xl">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-bold">How to Use ZenJourney.in</h2>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                ${guideContent}
                <div class="border-t p-4 text-right">
                    <button onclick="this.closest('.fixed').remove()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Got it!
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Add to DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        // ... existing initialization code ...
        
        // Initialize tooltips
        initializeTooltips();
    });

    // Add this function after other utility functions
    function toggleTimeSettings() {
        const panel = document.getElementById('time-settings-panel');
        const isHidden = panel.classList.contains('hidden');
        
        // Cancel any ongoing animation
        clearTimeout(panel.dataset.timeoutId);
        
        if (isHidden) {
            panel.classList.remove('hidden');
            // Force reflow
            panel.offsetHeight;
            panel.classList.add('opacity-100');
            DataManager.save('timeSettingsVisible', true);
        } else {
            panel.classList.remove('opacity-100');
            panel.dataset.timeoutId = setTimeout(() => {
                panel.classList.add('hidden');
            }, 300);
            DataManager.save('timeSettingsVisible', false);
        }
    }
    
    // Add error handling for time input changes
    document.getElementById('start-time')?.addEventListener('change', validateTimeInput);
    document.getElementById('end-time')?.addEventListener('change', validateTimeInput);

    function validateTimeInput(e) {
        const startTime = document.getElementById('start-time').value;
        const endTime = document.getElementById('end-time').value;
        
        if (startTime && endTime) {
            const start = TimeUtil.toDecimal(startTime);
            const end = TimeUtil.toDecimal(endTime);
            
            if (start >= end) {
                ErrorHandler.showMessage('End time must be after start time', 'warning');
                e.target.value = e.target.defaultValue;
                return;
            }
        }
        
        saveTimeSlotSettings();
    }
    
    // ... rest of existing JavaScript code ...
    </script>
</body>
</html>


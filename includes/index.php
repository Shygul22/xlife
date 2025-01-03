<?php
require_once 'auth_check.php';
$pageTitle = 'Task Manager';
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zen Journey</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans">
    <div class="container mx-auto p-2 sm:p-6">
        <h1 class="text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6">Task Prioritization Tool</h1>

        <div class="flex flex-col lg:flex-row lg:space-x-6 space-y-6 lg:space-y-0">
            <!-- Left Column -->
            <div class="flex flex-col space-y-6 w-full lg:w-1/3">
                <!-- Task Form -->
                <form id="task-form" class="space-y-4 bg-white p-4 sm:p-6 rounded-lg shadow-lg">
                    <div class="space-y-2">
                        <input type="text" id="task-name" placeholder="Task Name" required
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-2">
                        <label for="urgency" class="block text-sm font-medium">Urgency:</label>
                        <select id="urgency" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Urgency</option>
                            <option value="1">1 - Low</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5 - High</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="importance" class="block text-sm font-medium">Importance:</label>
                        <select id="importance" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Importance</option>
                            <option value="1">1 - Low</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5 - High</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="effort" class="block text-sm font-medium">Effort (hours):</label>
                        <input type="number" id="effort" min="0.0" max="24" step="0.5" required
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-2">
                        <label for="task-due-date" class="block text-sm font-medium">Due Date:</label>
                        <input type="date" id="task-due-date" 
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-2">
                        <label for="task-description" class="block text-sm font-medium">Description:</label>
                        <textarea id="task-description" rows="3" 
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label for="task-category" class="block text-sm font-medium">Category:</label>
                        <select id="task-category" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="work">Work</option>
                            <option value="personal">Personal</option>
                            <option value="study">Study</option>
                            <option value="health">Health</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="task-progress" class="block text-sm font-medium">Progress (%):</label>
                        <input type="number" id="task-progress" min="0" max="100" value="0"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" id="submit-button" class="w-full bg-blue-500 text-white p-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Add Task
                    </button>
                </form>

                <!-- Time Slot Definition Section -->
                <div id="time-slot-definition" class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">
                    <h2 class="text-3xl font-semibold text-gray-900 mb-4">Define Time Slots</h2>
                    <form id="time-slot-form" class="space-y-4">
                        <div class="space-y-2">
                            <label for="start-time" class="block text-sm font-medium">Start Time:</label>
                            <input type="time" id="start-time" value="09:00" required
                                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2">
                            <label for="end-time" class="block text-sm font-medium">End Time:</label>
                            <input type="time" id="end-time" value="17:00" required
                                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2">
                            <label for="break-time" class="block text-sm font-medium">Break Time (minutes):</label>
                            <input type="number" id="break-time" value="0" min="0" required
                                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" id="time-slot-submit-button"
                            class="w-full bg-blue-500 text-white p-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Set Time Slots
                        </button>
                        <button type="button" id="reset-time-slots-button"
                            class="w-full bg-gray-500 text-white p-3 rounded-lg shadow-md hover:bg-gray-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 mt-4">
                            Reset Time Slots
                        </button>
                    </form>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium mb-2">Auto Schedule</h3>
                        <div class="flex space-x-2">
                            <button id="auto-schedule-button" 
                                class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition-colors">
                                <i class="fa fa-magic mr-2"></i>Auto Schedule Tasks
                            </button>
                            <select id="schedule-strategy" class="border rounded-lg px-3 py-2">
                                <option value="priority">By Priority</option>
                                <option value="deadline">By Deadline</option>
                                <option value="effort">By Effort</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col space-y-6 w-full lg:w-2/3">
                <!-- Task Lists -->
                <div id="task-list" class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-4">Tasks</h2>
                    <!-- Search Input Field -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <input type="text" id="task-search" placeholder="Search tasks..." onkeyup="filterTasks()"
                            class="w-full sm:w-1/3 p-2 border rounded-lg">
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <select id="filter-category" onchange="filterTasks()" class="w-full sm:w-auto p-2 border rounded-lg">
                            <option value="">All Categories</option>
                            <option value="work">Work</option>
                            <option value="personal">Personal</option>
                            <option value="study">Study</option>
                            <option value="health">Health</option>
                            <option value="other">Other</option>
                        </select>

                        <select id="filter-status" onchange="filterTasks()" class="w-full sm:w-auto p-2 border rounded-lg">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>

                        <select id="sort-tasks" onchange="sortAndUpdateTasks()" class="w-full sm:w-auto p-2 border rounded-lg">
                            <option value="priority">Sort by Priority</option>
                            <option value="dueDate">Sort by Due Date</option>
                            <option value="progress">Sort by Progress</option>
                            <option value="effort">Sort by Effort</option>
                        </select>
                    </div>
                    <div id="task-list-content" class="mt-4 list-view">
                        <!-- Tasks will be injected here -->
                    </div>
                    <button onclick="clearAllTasks()" class="w-full sm:w-auto bg-red-600 text-white py-3 px-4 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 transition duration-300 mt-6 text-lg">
                        <i class="fa fa-trash mr-2"></i> Clear All Tasks
                    </button>
                </div>

                <!-- Dashboard Section -->
                <div id="dashboard-section" class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-4">Dashboard</h2>
                    <div id="dashboard-loading" class="hidden">
                        <p class="text-center text-gray-600">Loading dashboard...</p>
                    </div>
                    <div id="dashboard-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-gray-800">Task Status</h3>
                            <div class="h-64">
                                <canvas id="tasks-status-chart"></canvas>
                            </div>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-gray-800">Priority Distribution</h3>
                            <div class="h-64">
                                <canvas id="priority-chart"></canvas>
                            </div>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-gray-800">Effort Analysis</h3>
                            <div class="h-64">
                                <canvas id="effort-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Removed Completed Tasks Section -->
         
    </div>

    <script>
        // Initialize variables with proper error handling
        let tasks = [];
        let achievements = [];
        let tasksStatusChart = null;
        let averagePriorityChart = null;
        let effortDistributionChart = null;

        // Improved error handling for localStorage
        function safeLocalStorageOperation(operation, key, data = null) {
            try {
                if (operation === 'set') {
                    localStorage.setItem(key, JSON.stringify(data));
                    return true;
                } else if (operation === 'get') {
                    const item = localStorage.getItem(key);
                    return item ? JSON.parse(item) : null;
                }
            } catch (e) {
                console.error(`LocalStorage ${operation} error:`, e);
                return operation === 'get' ? null : false;
            }
        }

        // Improved task prioritization calculation
        function calculatePriorityScore(task) {
            if (!task.urgency || !task.importance || !task.effort) return 0;
            
            const urgencyWeight = 0.4;
            const importanceWeight = 0.4;
            const effortWeight = 0.2;
            
            // Normalize effort to 1-5 scale
            const normalizedEffort = Math.min(5, Math.max(1, task.effort / 2));
            
            return (
                (urgencyWeight * task.urgency) +
                (importanceWeight * task.importance) -
                (effortWeight * normalizedEffort)
            ).toFixed(2);
        }

        // Improved time slot allocation
        function allocateTimeSlots(tasks, startTimeDecimal = null) {
            if (!tasks.length) return;

            const startTime = document.getElementById('start-time').value;
            const endTime = document.getElementById('end-time').value;
            const breakTime = Math.max(0, parseInt(document.getElementById('break-time').value) / 60);

            let currentTime = startTimeDecimal || convertTimeToDecimal(startTime);
            const endDecimalTime = convertTimeToDecimal(endTime);

            if (currentTime >= endDecimalTime) {
                alert("Invalid time range: Start time must be before end time");
                return;
            }

            tasks.forEach(task => {
                if (task.completedTime) return;

                if (!task.effort || task.effort <= 0) {
                    task.scheduledTime = "Invalid effort";
                    return;
                }

                if (currentTime + task.effort + breakTime <= endDecimalTime) {
                    task.scheduledTime = `${formatTime(currentTime)} - ${formatTime(currentTime + task.effort)}`;
                    scheduleNotification(task, currentTime);
                    currentTime += task.effort + breakTime;
                } else {
                    task.scheduledTime = "Exceeds available time";
                }
            });

            safeLocalStorageOperation('set', 'tasks', tasks);
        }

        // Improved notification system
        function scheduleNotification(task, startTime) {
            if (!("Notification" in window)) {
                console.log("This browser does not support notifications");
                return;
            }

            if (Notification.permission === "granted") {
                scheduleTaskNotifications(task, startTime);
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        scheduleTaskNotifications(task, startTime);
                    }
                });
            }
        }

        function scheduleTaskNotifications(task, startTime) {
            const now = new Date();
            const taskStart = new Date(now.toDateString() + ' ' + formatTime24(startTime));
            
            if (taskStart > now) {
                setTimeout(() => {
                    new Notification(`Task Starting: ${task.name}`, {
                        body: `Time to start: ${task.name}`,
                        icon: '/favicon.ico'
                    });
                }, taskStart - now);
            }
        }

        // Improved dashboard update with error handling
        function updateDashboard() {
            try {
                if (tasksStatusChart) tasksStatusChart.destroy();
                if (averagePriorityChart) averagePriorityChart.destroy();
                if (effortDistributionChart) effortDistributionChart.destroy();

                const pendingTasks = tasks.filter(task => !task.completedTime).length;
                const averagePriority = tasks.length ? 
                    tasks.reduce((sum, task) => sum + parseFloat(calculatePriorityScore(task)), 0) / tasks.length : 0;

                // Create new charts with error handling
                createTasksStatusChart(pendingTasks);
                createAveragePriorityChart(averagePriority);
                createEffortDistributionChart();
            } catch (e) {
                console.error("Dashboard update error:", e);
            }
        }

        function createTasksStatusChart(pendingTasks) {
            const ctx = document.getElementById('tasks-status-chart').getContext('2d');
            tasksStatusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending'],
                    datasets: [{
                        data: [pendingTasks],
                        backgroundColor: ['#4299E1']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function createAveragePriorityChart(averagePriority) {
            const ctx = document.getElementById('average-priority-chart').getContext('2d');
            averagePriorityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Average Priority'],
                    datasets: [{
                        data: [averagePriority],
                        backgroundColor: ['#48BB78']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5
                        }
                    }
                }
            });
        }

        function createEffortDistributionChart() {
            const effortGroups = tasks.reduce((acc, task) => {
                const effort = Math.ceil(task.effort);
                acc[effort] = (acc[effort] || 0) + 1;
                return acc;
            }, {});

            const ctx = document.getElementById('effort-distribution-chart').getContext('2d');
            effortDistributionChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(effortGroups),
                    datasets: [{
                        data: Object.values(effortGroups),
                        backgroundColor: ['#F6AD55', '#FC8181', '#90CDF4', '#9F7AEA', '#68D391']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function formatTime(decimalTime) {
            const hours = Math.floor(decimalTime);
            const minutes = Math.round((decimalTime - hours) * 60);
            const period = hours >= 12 ? 'PM' : 'AM';
            const formattedHour = hours % 12 || 12;
            return `${formattedHour}:${minutes.toString().padStart(2, '0')} ${period}`;
        }

        function formatTime24(decimalTime) {
            const hours = Math.floor(decimalTime);
            const minutes = Math.round((decimalTime - hours) * 60);
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }

        function convertTimeToDecimal(time) {
            const [hours, minutes] = time.split(':').map(Number);
            return hours + minutes / 60;
        }

        function updateTaskList(filteredTasks = tasks) {
            try {
                const taskListContent = document.getElementById('task-list-content');
                taskListContent.innerHTML = '';

                filteredTasks.forEach(task => {
                    const taskElement = document.createElement('div');
                    taskElement.className = `p-4 bg-gray-100 rounded-lg shadow-md mb-4 ${
                        task.completedTime ? 'opacity-50' : ''
                    }`;
                    
                    const priorityScore = calculatePriorityScore(task);
                    const priorityClass = priorityScore >= 4 ? 'text-red-600' : 
                                        priorityScore >= 3 ? 'text-orange-500' : 
                                        'text-green-600';

                    taskElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold">${task.name}</h3>
                                <p class="${priorityClass}">Priority Score: ${priorityScore}</p>
                                <p>Scheduled Time: ${task.scheduledTime || 'Not scheduled'}</p>
                                <p>Due Date: ${task.dueDate || 'No due date'}</p>
                                <p class="text-gray-600">${task.description || 'No description'}</p>
                            </div>
                            <div class="flex flex-col space-y-2 ml-4">
                                ${!task.completedTime ? `
                                    <button onclick="completeTask('${task.id}')"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-200 flex items-center">
                                        <i class="fa fa-check mr-2"></i>Complete
                                    </button>
                                ` : `
                                    <span class="text-green-600 font-medium">
                                        <i class="fa fa-check-circle mr-1"></i>Completed
                                    </span>
                                `}
                                <button onclick="deleteTask('${task.id}')"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-200 flex items-center">
                                    <i class="fa fa-trash mr-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    `;
                    taskListContent.appendChild(taskElement);
                });

                // Show empty state if no tasks
                if (filteredTasks.length === 0) {
                    taskListContent.innerHTML = `
                        <div class="text-center text-gray-500 py-8">
                            <i class="fa fa-tasks fa-3x mb-4"></i>
                            <p>No tasks found</p>
                        </div>
                    `;
                }
            } catch (error) {
                ErrorHandler.handle(error, 'Failed to update task list');
            }
        }

        function completeTask(taskId) {
            try {
                const taskIndex = tasks.findIndex(t => t.id === taskId);
                if (taskIndex === -1) {
                    throw new Error('Task not found');
                }

                tasks[taskIndex] = {
                    ...tasks[taskIndex],
                    completedTime: new Date().toISOString()
                };

                // Clear any scheduled notifications for this task
                NotificationSystem.clearExistingNotifications();
                
                // Save updated tasks
                DataManager.save('tasks', tasks);
                updateTaskList();
                updateDashboard();

                // Show success message
                showSuccessMessage('Task completed successfully!');
            } catch (error) {
                ErrorHandler.handle(error, 'Failed to complete task');
            }
        }

        function deleteTask(taskId) {
            try {
                if (!confirm('Are you sure you want to delete this task?')) {
                    return;
                }

                const taskIndex = tasks.findIndex(t => t.id === taskId);
                if (taskIndex === -1) {
                    throw new Error('Task not found');
                }

                // Remove task
                tasks.splice(taskIndex, 1);
                
                // Clear notifications for this task
                NotificationSystem.clearExistingNotifications();
                
                // Save updated tasks
                DataManager.save('tasks', tasks);
                updateTaskList();
                updateDashboard();

                // Show success message
                showSuccessMessage('Task deleted successfully!');
            } catch (error) {
                ErrorHandler.handle(error, 'Failed to delete task');
            }
        }

        function showSuccessMessage(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50';
            successDiv.textContent = message;
            document.body.appendChild(successDiv);
            setTimeout(() => successDiv.remove(), 3000);
        }

        function completeTask(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (task) {
                task.completedTime = new Date().toISOString();
                safeLocalStorageOperation('set', 'tasks', tasks);
                updateTaskList();
                updateDashboard();
            }
        }

        function deleteTask(taskId) {
            tasks = tasks.filter(t => t.id !== taskId);
            safeLocalStorageOperation('set', 'tasks', tasks);
            updateTaskList();
            updateDashboard();
        }

        function clearAllTasks() {
            tasks = [];
            safeLocalStorageOperation('set', 'tasks', tasks);
            updateTaskList();
            updateDashboard();
        }

        function clearAchievements() {
            achievements = [];
            safeLocalStorageOperation('set', 'achievements', achievements);
            updateAchievementsList();
        }

        function updateAchievementsList() {
            const achievementsList = document.getElementById('achievements-list');
            achievementsList.innerHTML = '';

            achievements.forEach(achievement => {
                const achievementElement = document.createElement('div');
                achievementElement.className = 'p-4 bg-gray-100 rounded-lg shadow-md mb-4';
                achievementElement.innerHTML = `
                    <h3 class="text-xl font-semibold">${achievement.name}</h3>
                    <p>${achievement.description}</p>
                `;
                achievementsList.appendChild(achievementElement);
            });
        }

        // Add input validation to task form
        document.getElementById('task-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const taskName = document.getElementById('task-name').value.trim();
            const effort = parseFloat(document.getElementById('effort').value);

            if (!taskName) {
                alert("Task name is required");
                return;
            }

            if (isNaN(effort) || effort <= 0) {
                alert("Please enter a valid effort value");
                return;
            }

            const task = {
                id: Date.now().toString(),
                name: taskName,
                urgency: parseInt(document.getElementById('urgency').value),
                importance: parseInt(document.getElementById('importance').value),
                effort: effort,
                dueDate: document.getElementById('task-due-date').value,
                description: document.getElementById('task-description').value,
                category: document.getElementById('task-category').value,
                progress: parseInt(document.getElementById('task-progress').value) || 0,
                completedTime: null
            };

            tasks.push(task);
            safeLocalStorageOperation('set', 'tasks', tasks);
            updateTaskList();
            updateDashboard();
            document.getElementById('task-form').reset();
        });

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            tasks = safeLocalStorageOperation('get', 'tasks') || [];
            achievements = safeLocalStorageOperation('get', 'achievements') || [];
            
            loadTimeSlotsFromLocalStorage();
            updateTaskList();
            updateDashboard();
            
            // Request notification permission on load
            if ("Notification" in window) {
                Notification.requestPermission();
            }
        });

        function loadTimeSlotsFromLocalStorage() {
            try {
                const startTime = safeLocalStorageOperation('get', 'startTime') || "09:00";
                const endTime = safeLocalStorageOperation('get', 'endTime') || "17:00";
                const breakTime = safeLocalStorageOperation('get', 'breakTime') || "0";

                document.getElementById('start-time').value = startTime;
                document.getElementById('end-time').value = endTime;
                document.getElementById('break-time').value = breakTime;
            } catch (e) {
                console.error("Error loading time slots:", e);
                showErrorMessage("Failed to load time slots");
            }
        }

        function saveTimeSlotsToLocalStorage() {
            const startTime = document.getElementById('start-time').value;
            const endTime = document.getElementById('end-time').value;
            const breakTime = document.getElementById('break-time').value;

            safeLocalStorageOperation('set', 'startTime', startTime);
            safeLocalStorageOperation('set', 'endTime', endTime);
            safeLocalStorageOperation('set', 'breakTime', breakTime);
        }

        function filterTasks() {
            const searchTerm = document.getElementById('task-search').value.toLowerCase();
            const categoryFilter = document.getElementById('filter-category').value;
            const statusFilter = document.getElementById('filter-status').value;

            const filteredTasks = tasks.filter(task => {
                const matchesSearch = task.name.toLowerCase().includes(searchTerm) ||
                                    task.description.toLowerCase().includes(searchTerm);
                const matchesCategory = !categoryFilter || task.category === categoryFilter;
                const matchesStatus = !statusFilter || 
                                    (statusFilter === 'completed' && task.completedTime) ||
                                    (statusFilter === 'pending' && !task.completedTime);

                return matchesSearch && matchesCategory && matchesStatus;
            });

            updateTaskList(filteredTasks);
        }

        function sortTasks(tasks) {
            return tasks.sort((a, b) => {
                // Sort by priority score
                const priorityA = parseFloat(calculatePriorityScore(a));
                const priorityB = parseFloat(calculatePriorityScore(b));
                
                if (priorityB !== priorityA) {
                    return priorityB - priorityA;
                }
                
                // If priority is equal, sort by due date
                if (a.dueDate && b.dueDate) {
                    return new Date(a.dueDate) - new Date(b.dueDate);
                }
                
                return 0;
            });
        }

        function showErrorMessage(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg';
            errorDiv.textContent = message;
            document.body.appendChild(errorDiv);
            setTimeout(() => errorDiv.remove(), 3000);
        }

        // Update task form submission
        document.getElementById('task-form').addEventListener('submit', function(e) {
            e.preventDefault();
            try {
                const formData = {
                    id: Date.now().toString(),
                    name: document.getElementById('task-name').value.trim(),
                    urgency: parseInt(document.getElementById('urgency').value),
                    importance: parseInt(document.getElementById('importance').value),
                    effort: parseFloat(document.getElementById('effort').value),
                    dueDate: document.getElementById('task-due-date').value,
                    description: document.getElementById('task-description').value.trim(),
                    category: document.getElementById('task-category').value,
                    progress: parseInt(document.getElementById('task-progress').value) || 0,
                    completedTime: null
                };

                // Validation
                if (!formData.name) throw new Error("Task name is required");
                if (isNaN(formData.effort) || formData.effort <= 0) throw new Error("Invalid effort value");
                if (!formData.urgency) throw new Error("Urgency is required");
                if (!formData.importance) throw new Error("Importance is required");

                tasks.push(formData);
                safeLocalStorageOperation('set', 'tasks', tasks);
                allocateTimeSlots(tasks);
                updateTaskList();
                updateDashboard();
                this.reset();
            } catch (error) {
                showErrorMessage(error.message);
            }
        });

        // Update time slot form submission
        document.getElementById('time-slot-form').addEventListener('submit', function(e) {
            e.preventDefault();
            try {
                saveTimeSlotsToLocalStorage();
                allocateTimeSlots(tasks);
                updateTaskList();
                showErrorMessage("Time slots updated successfully!");
            } catch (error) {
                showErrorMessage("Failed to update time slots");
            }
        });

        // Update initialization
        document.addEventListener('DOMContentLoaded', function() {
            try {
                tasks = safeLocalStorageOperation('get', 'tasks') || [];
                achievements = safeLocalStorageOperation('get', 'achievements') || [];
                
                loadTimeSlotsFromLocalStorage();
                tasks = sortTasks(tasks);
                updateTaskList();
                updateDashboard();
                
                if ("Notification" in window) {
                    Notification.requestPermission();
                }
            } catch (error) {
                showErrorMessage("Failed to initialize application");
                console.error("Initialization error:", error);
            }
        });
    </script>
    <script>
    // Improved error handling wrapper
    function tryCatch(fn, errorMessage = 'Operation failed') {
        try {
            return fn();
        } catch (error) {
            console.error(error);
            showErrorMessage(errorMessage);
            return null;
        }
    }

    // Improved localStorage wrapper
    const storage = {
        get(key, defaultValue = null) {
            try {
                const item = localStorage.getItem(key);
                return item ? JSON.parse(item) : defaultValue;
            } catch {
                return defaultValue;
            }
        },
        set(key, data) {
            try {
                localStorage.setItem(key, JSON.stringify(data));
                return true;
            } catch {
                return false;
            }
        }
    };

    // Fixed time slot allocation
    function allocateTimeSlots(tasks, startTimeDecimal = null) {
        if (!tasks?.length) return;

        const startTime = document.getElementById('start-time')?.value || '09:00';
        const endTime = document.getElementById('end-time')?.value || '17:00';
        const breakTime = Math.max(0, parseInt(document.getElementById('break-time')?.value || '0') / 60);

        let currentTime = startTimeDecimal || convertTimeToDecimal(startTime);
        const endDecimalTime = convertTimeToDecimal(endTime);

        if (currentTime >= endDecimalTime) {
            showErrorMessage("Invalid time range: Start time must be before end time");
            return;
        }

        const scheduledTasks = tasks.map(task => {
            if (task.completedTime) return task;

            if (!task.effort || task.effort <= 0) {
                return { ...task, scheduledTime: "Invalid effort" };
            }

            if (currentTime + task.effort + breakTime <= endDecimalTime) {
                const scheduledTime = `${formatTime(currentTime)} - ${formatTime(currentTime + task.effort)}`;
                scheduleNotification(task, currentTime);
                currentTime += task.effort + breakTime;
                return { ...task, scheduledTime };
            }

            return { ...task, scheduledTime: "Exceeds available time" };
        });

        storage.set('tasks', scheduledTasks);
        return scheduledTasks;
    }

    // Improved chart creation with cleanup
    function createCharts() {
        if (tasksStatusChart) tasksStatusChart.destroy();
        if (averagePriorityChart) averagePriorityChart.destroy();
        if (effortDistributionChart) effortDistributionChart.destroy();

        const pendingTasks = tasks.filter(task => !task.completedTime);
        const averagePriority = tasks.length ? 
            tasks.reduce((sum, task) => sum + Number(calculatePriorityScore(task)), 0) / tasks.length : 0;

        createTasksStatusChart(pendingTasks.length);
        createAveragePriorityChart(averagePriority);
        createEffortDistributionChart();
    }

    // Improved task form submission
    document.getElementById('task-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const task = {
            id: Date.now().toString(),
            name: formData.get('task-name')?.trim(),
            urgency: Number(formData.get('urgency')),
            importance: Number(formData.get('importance')),
            effort: Number(formData.get('effort')),
            dueDate: formData.get('task-due-date'),
            description: formData.get('task-description')?.trim(),
            category: document.getElementById('task-category').value,
            progress: parseInt(document.getElementById('task-progress').value) || 0,
            completedTime: null
        };

        if (!validateTask(task)) return;

        tasks = [...tasks, task];
        storage.set('tasks', tasks);
        tasks = allocateTimeSlots(tasks) || tasks;
        updateTaskList();
        updateDashboard();
        this.reset();
    });

    // New task validation function
    function validateTask(task) {
        const errors = [];
        if (!task.name) errors.push("Task name is required");
        if (isNaN(task.effort) || task.effort <= 0) errors.push("Invalid effort value");
        if (!task.urgency) errors.push("Urgency is required");
        if (!task.importance) errors.push("Importance is required");

        if (errors.length) {
            showErrorMessage(errors.join('. '));
            return false;
        }
        return true;
    }

    // Improved initialization
    function initializeApp() {
        tasks = storage.get('tasks', []);
        achievements = storage.get('achievements', []);
        
        loadTimeSlotsFromLocalStorage();
        tasks = sortTasks(tasks);
        allocateTimeSlots(tasks);
        updateTaskList();
        updateDashboard();
        
        if ("Notification" in window) {
            Notification.requestPermission();
        }
    }

    // Error message display
    function showErrorMessage(message, duration = 3000) {
        const existingError = document.querySelector('.error-message');
        if (existingError) existingError.remove();

        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50';
        errorDiv.textContent = message;
        document.body.appendChild(errorDiv);
        setTimeout(() => errorDiv.remove(), duration);
    }

    document.addEventListener('DOMContentLoaded', () => tryCatch(initializeApp, 'Failed to initialize application'));
</script>
<script>
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
        const ctx = document.getElementById('tasks-status-chart').getContext('2d');
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
    },

    createPriorityChart() {
        const ctx = document.getElementById('priority-chart').getContext('2d');
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
    },

    createEffortChart() {
        const ctx = document.getElementById('effort-chart').getContext('2d');
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
    }
};

// Update the existing updateDashboard function
function updateDashboard() {
    tryCatch(() => dashboard.init(), 'Failed to update dashboard');
}

// Update the existing DOMContentLoaded event listener to include dashboard initialization
document.addEventListener('DOMContentLoaded', () => {
    tryCatch(() => {
        initializeApp();
        dashboard.init();
    }, 'Failed to initialize application');
});
</script>
<script>
// Add this new notification manager object before other scripts
const notificationManager = {
    init() {
        if (!("Notification" in window)) {
            console.log("This browser does not support notifications");
            return false;
        }
        return Notification.requestPermission();
    },

    scheduleTaskNotification(task, startTime) {
        if (Notification.permission !== "granted") return;

        const now = new Date();
        const taskStart = this.calculateTaskStartTime(startTime);
        
        // Schedule start notification
        this.scheduleNotification(taskStart - 5 * 60000, {
            title: `Task Starting Soon: ${task.name}`,
            body: `Your task starts in 5 minutes at ${formatTime(startTime)}`,
            icon: '/favicon.ico',
            tag: `task-start-${task.id}`
        });

        // Schedule end notification
        const taskEnd = new Date(taskStart.getTime() + task.effort * 3600000);
        this.scheduleNotification(taskEnd, {
            title: `Task Due: ${task.name}`,
            body: `Time allocated for this task has ended`,
            icon: '/favicon.ico',
            tag: `task-end-${task.id}`
        });

        // Store notification info in localStorage
        this.saveNotificationSchedule(task.id, {
            startTime: taskStart.getTime(),
            endTime: taskEnd.getTime()
        });
    },

    calculateTaskStartTime(startTime) {
        const now = new Date();
        const [hours, minutes] = formatTime24(startTime).split(':').map(Number);
        const taskStart = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hours, minutes);
        
        if (taskStart < now) {
            taskStart.setDate(taskStart.getDate() + 1);
        }
        return taskStart;
    },

    scheduleNotification(time, options) {
        const delay = time - Date.now();
        if (delay <= 0) return;

        setTimeout(() => {
            new Notification(options.title, {
                body: options.body,
                icon: options.icon,
                tag: options.tag
            });
        }, delay);
    },

    saveNotificationSchedule(taskId, schedule) {
        const schedules = storage.get('notificationSchedules', {});
        schedules[taskId] = schedule;
        storage.set('notificationSchedules', schedules);
    },

    checkScheduledNotifications() {
        const schedules = storage.get('notificationSchedules', {});
        const now = Date.now();

        Object.entries(schedules).forEach(([taskId, schedule]) => {
            if (schedule.endTime < now) {
                // Clean up expired notifications
                delete schedules[taskId];
            }
        });

        storage.set('notificationSchedules', schedules);
    }
};

// Replace the existing scheduleNotification function with this updated version
function scheduleNotification(task, startTime) {
    notificationManager.scheduleTaskNotification(task, startTime);
}

// Update the existing allocateTimeSlots function to include the new notification logic
const originalAllocateTimeSlots = allocateTimeSlots;
function allocateTimeSlots(tasks, startTimeDecimal = null) {
    const scheduledTasks = originalAllocateTimeSlots(tasks, startTimeDecimal);
    
    if (scheduledTasks) {
        scheduledTasks.forEach(task => {
            if (!task.completedTime && task.scheduledTime && task.scheduledTime !== "Invalid effort" && task.scheduledTime !== "Exceeds available time") {
                const startTime = task.scheduledTime.split(' - ')[0];
                scheduleNotification(task, convertTimeToDecimal(startTime));
            }
        });
    }
    
    return scheduledTasks;
}

// Add this to your DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // ...existing initialization code...
    
    // Initialize notifications
    notificationManager.init().then(() => {
        notificationManager.checkScheduledNotifications();
    });
});
</script>
<script>
// Error handling utilities
const ErrorHandler = {
    handle(error, context = '') {
        console.error(`${context}:`, error);
        this.showError(error.message || 'An error occurred');
    },

    showError(message) {
        const existingError = document.querySelector('.error-message');
        if (existingError) existingError.remove();

        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50';
        errorDiv.textContent = message;
        document.body.appendChild(errorDiv);
        setTimeout(() => errorDiv.remove(), 3000);
    },

    validateTask(task) {
        if (!task.name?.trim()) throw new Error('Task name is required');
        if (!task.urgency) throw new Error('Urgency is required');
        if (!task.importance) throw new Error('Importance is required');
        if (!task.effort || task.effort <= 0) throw new Error('Valid effort is required');
        return true;
    }
};

// Safer data management
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

// Notification manager with error handling
const NotificationManager = {
    init() {
        if (!("Notification" in window)) {
            ErrorHandler.showError("This browser does not support notifications");
            return Promise.resolve(false);
        }
        return Notification.requestPermission();
    },

    scheduleNotification(task, options) {
        try {
            if (Notification.permission !== "granted") return;
            
            const notification = new Notification(options.title, {
                body: options.body,
                icon: options.icon || '/favicon.ico',
                tag: options.tag
            });

            notification.onclick = () => {
                window.focus();
                notification.close();
            };
        } catch (error) {
            ErrorHandler.handle(error, 'Notification scheduling failed');
        }
    }
};

// Fixed time conversion utilities
const TimeUtil = {
    toDecimal(timeString) {
        try {
            const [hours, minutes] = timeString.split(':').map(Number);
            if (isNaN(hours) || isNaN(minutes)) throw new Error('Invalid time format');
            return hours + minutes / 60;
        } catch (error) {
            ErrorHandler.handle(error, 'Time conversion failed');
            return 0;
        }
    },

    format24Hour(decimalTime) {
        try {
            const hours = Math.floor(decimalTime);
            const minutes = Math.round((decimalTime - hours) * 60);
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        } catch (error) {
            ErrorHandler.handle(error, 'Time formatting failed');
            return '00:00';
        }
    }
};

// Task management with improved error handling
function addTask(taskData) {
    try {
        ErrorHandler.validateTask(taskData);
        const task = {
            ...taskData,
            id: Date.now().toString(),
            completedTime: null
        };
        tasks.push(task);
        DataManager.save('tasks', tasks);
        return true;
    } catch (error) {
        ErrorHandler.handle(error, 'Task addition failed');
        return false;
    }
}

// Update your event listeners to use the new utilities
document.getElementById('task-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    try {
        const formData = new FormData(this);
        const taskData = {
            name: formData.get('task-name')?.trim(),
            urgency: Number(formData.get('urgency')),
            importance: Number(formData.get('importance')),
            effort: Number(formData.get('effort')),
            dueDate: formData.get('task-due-date'),
            description: formData.get('task-description')?.trim(),
            category: document.getElementById('task-category').value,
            progress: parseInt(document.getElementById('task-progress').value) || 0
        };

        if (addTask(taskData)) {
            this.reset();
            updateTaskList();
            updateDashboard();
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Form submission failed');
    }
});

// Initialize application with error handling
function initializeApp() {
    try {
        tasks = DataManager.load('tasks', []);
        NotificationManager.init()
            .then(() => {
                updateTaskList();
                updateDashboard();
            })
            .catch(error => ErrorHandler.handle(error, 'Notification initialization failed'));
    } catch (error) {
        ErrorHandler.handle(error, 'Application initialization failed');
    }
}

// Update your DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', initializeApp);
</script>
<script>
// Add this new TimeSlotManager before other scripts
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
                    const scheduledTask = {
                        ...task,
                        scheduledTime: `${this.formatTime(currentTime)} - ${this.formatTime(taskEndTime)}`,
                        startTime: currentTime,
                        endTime: taskEndTime
                    };
                    scheduledTasks.push(scheduledTask);
                    currentTime = taskEndTime + (breakTime / 60);

                    // Schedule notification
                    notificationManager.scheduleTaskNotification(scheduledTask, currentTime);
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

// Update the existing allocateTimeSlots function
function allocateTimeSlots(tasks) {
    const settings = {
        startTime: document.getElementById('start-time').value,
        endTime: document.getElementById('end-time').value,
        breakTime: parseInt(document.getElementById('break-time').value)
    };

    const result = TimeSlotManager.allocateTimeSlots(tasks, settings);
    if (!result) return;

    // Update tasks with new scheduling
    tasks = [...result.scheduled, ...result.unscheduled];
    DataManager.save('tasks', tasks);

    // Show allocation summary
    showAllocationSummary(result);
    return tasks;
}

// Add new function to show allocation summary
function showAllocationSummary(result) {
    const message = `
        Tasks scheduled: ${result.scheduled.length}
        Tasks unscheduled: ${result.unscheduled.length}
        Available time: ${result.availableTime.toFixed(2)} hours
        Remaining time: ${result.remainingTime.toFixed(2)} hours
    `;
    
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'fixed bottom-4 right-4 bg-blue-500 text-white p-4 rounded-lg shadow-lg z-50';
    summaryDiv.style.maxWidth = '300px';
    summaryDiv.innerHTML = message.split('\n').join('<br>');
    
    document.body.appendChild(summaryDiv);
    setTimeout(() => summaryDiv.remove(), 5000);
}

// Update time slot form submission
document.getElementById('time-slot-form').addEventListener('submit', function(e) {
    e.preventDefault();
    try {
        saveTimeSlotsToLocalStorage();
        const updatedTasks = allocateTimeSlots(tasks);
        if (updatedTasks) {
            tasks = updatedTasks;
            updateTaskList();
            updateDashboard();
        }
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to update time slots');
    }
});

// Add reset functionality
document.getElementById('reset-time-slots-button').addEventListener('click', function() {
    try {
        document.getElementById('start-time').value = '09:00';
        document.getElementById('end-time').value = '17:00';
        document.getElementById('break-time').value = '0';
        saveTimeSlotsToLocalStorage();
        const updatedTasks = allocateTimeSlots(tasks);
        if (updatedTasks) {
            tasks = updatedTasks;
            updateTaskList();
            updateDashboard();
        }
        showErrorMessage('Time slots reset successfully');
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to reset time slots');
    }
});
</script>
<script>
// Replace existing notification manager with this improved version
const NotificationSystem = {
    init() {
        return new Promise((resolve) => {
            if (!("Notification" in window)) {
                ErrorHandler.showError("Browser doesn't support notifications");
                resolve(false);
                return;
            }

            if (Notification.permission === "granted") {
                resolve(true);
                return;
            }

            Notification.requestPermission()
                .then(permission => {
                    resolve(permission === "granted");
                })
                .catch(error => {
                    ErrorHandler.handle(error, 'Notification permission request failed');
                    resolve(false);
                });
        });
    },

    scheduleTaskNotification(task) {
        if (Notification.permission !== "granted") return;

        try {
            const startTime = this.parseScheduledTime(task.scheduledTime);
            if (!startTime) return;

            // Schedule 5-minute warning
            const warningTime = new Date(startTime.getTime() - 5 * 60000);
            if (warningTime > new Date()) {
                this.createScheduledNotification(warningTime, {
                    title: `⏰ Task Starting Soon: ${task.name}`,
                    body: `Your task "${task.name}" starts in 5 minutes\nScheduled: ${task.scheduledTime}`,
                    tag: `warning-${task.id}`,
                    requireInteraction: true
                });
            }

            // Schedule start notification
            if (startTime > new Date()) {
                this.createScheduledNotification(startTime, {
                    title: `🎯 Task Start: ${task.name}`,
                    body: `Time to start: "${task.name}"\nDuration: ${task.effort} hours`,
                    tag: `start-${task.id}`,
                    requireInteraction: true
                });
            }

            // Save notification schedule
            this.saveNotificationSchedule(task.id, {
                warningTime: warningTime.getTime(),
                startTime: startTime.getTime(),
                taskName: task.name
            });

        } catch (error) {
            ErrorHandler.handle(error, 'Failed to schedule notification');
        }
    },

    parseScheduledTime(scheduledTime) {
        if (!scheduledTime || scheduledTime === "Invalid effort" || scheduledTime === "Exceeds available time") {
            return null;
        }

        try {
            const [timeStr] = scheduledTime.split(' - ');
            const [time, period] = timeStr.split(' ');
            const [hours, minutes] = time.split(':').map(Number);
            
            const now = new Date();
            const scheduledDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            let adjustedHours = hours;
            if (period === 'PM' && hours !== 12) adjustedHours += 12;
            if (period === 'AM' && hours === 12) adjustedHours = 0;
            
            scheduledDate.setHours(adjustedHours, minutes, 0, 0);

            // If the time has passed for today, schedule for tomorrow
            if (scheduledDate < now) {
                scheduledDate.setDate(scheduledDate.getDate() + 1);
            }

            return scheduledDate;
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to parse scheduled time');
            return null;
        }
    },

    createScheduledNotification(scheduledTime, options) {
        const delay = scheduledTime.getTime() - Date.now();
        if (delay <= 0) return;

        const timeoutId = setTimeout(() => {
            try {
                const notification = new Notification(options.title, {
                    body: options.body,
                    icon: '/favicon.ico',
                    tag: options.tag,
                    requireInteraction: options.requireInteraction || false
                });

                notification.onclick = () => {
                    window.focus();
                    notification.close();
                };
            } catch (error) {
                ErrorHandler.handle(error, 'Failed to create notification');
            }
        }, delay);

        // Store timeout ID for cleanup
        this.storeTimeout(options.tag, timeoutId);
    },

    storeTimeout(tag, timeoutId) {
        const timeouts = JSON.parse(localStorage.getItem('notificationTimeouts') || '{}');
        timeouts[tag] = timeoutId;
        localStorage.setItem('notificationTimeouts', JSON.stringify(timeouts));
    },

    clearExistingNotifications() {
        try {
            // Clear any existing timeouts
            const timeouts = JSON.parse(localStorage.getItem('notificationTimeouts') || '{}');
            Object.values(timeouts).forEach(timeoutId => clearTimeout(timeoutId));
            localStorage.removeItem('notificationTimeouts');

            // Clear any existing notifications
            if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                navigator.serviceWorker.ready.then(registration => {
                    registration.getNotifications().then(notifications => {
                        notifications.forEach(notification => notification.close());
                    });
                });
            }
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to clear notifications');
        }
    },

    saveNotificationSchedule(taskId, schedule) {
        try {
            const schedules = JSON.parse(localStorage.getItem('notificationSchedules') || '{}');
            schedules[taskId] = schedule;
            localStorage.setItem('notificationSchedules', JSON.stringify(schedules));
        } catch (error) {
            ErrorHandler.handle(error, 'Failed to save notification schedule');
        }
    }
};

// Update the time slot allocation to use the new notification system
function allocateTimeSlots(tasks) {
    const settings = {
        startTime: document.getElementById('start-time').value,
        endTime: document.getElementById('end-time').value,
        breakTime: parseInt(document.getElementById('break-time').value)
    };

    const result = TimeSlotManager.allocateTimeSlots(tasks, settings);
    if (!result) return;

    // Clear existing notifications before scheduling new ones
    NotificationSystem.clearExistingNotifications();

    // Schedule notifications for all tasks
    result.scheduled.forEach(task => {
        if (!task.completedTime) {
            NotificationSystem.scheduleTaskNotification(task);
        }
    });

    // Update tasks with new scheduling
    tasks = [...result.scheduled, ...result.unscheduled];
    DataManager.save('tasks', tasks);

    showAllocationSummary(result);
    return tasks;
}

// Update initialization to include notification system
document.addEventListener('DOMContentLoaded', async function() {
    try {
        await NotificationSystem.init();
        NotificationSystem.clearExistingNotifications();
        initializeApp();
    } catch (error) {
        ErrorHandler.handle(error, 'Failed to initialize notification system');
    }
});
</script>
<script>
// Add this inside the time-slot-definition div, after the existing form
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

// Add event listener for auto-schedule button
document.getElementById('auto-schedule-button')?.addEventListener('click', function() {
    const strategy = document.getElementById('schedule-strategy').value;
    const result = AutoScheduler.autoSchedule(tasks, strategy);
    
    if (result) {
        tasks = [...result.scheduled, ...result.unscheduled];
        DataManager.save('tasks', tasks);
        updateTaskList();
        updateDashboard();
    }
});
</script>
<script>
// Update the task object creation in the form submission handler
const task = {
    // ...existing task properties...
    category: document.getElementById('task-category').value,
    progress: parseInt(document.getElementById('task-progress').value) || 0,
    // ...existing task properties...
};

// Enhanced filter function
function filterTasks() {
    const searchTerm = document.getElementById('task-search').value.toLowerCase();
    const categoryFilter = document.getElementById('filter-category').value;
    const statusFilter = document.getElementById('filter-status').value;

    const filteredTasks = tasks.filter(task => {
        const matchesSearch = task.name.toLowerCase().includes(searchTerm) ||
                            task.description.toLowerCase().includes(searchTerm);
        const matchesCategory = !categoryFilter || task.category === categoryFilter;
        const matchesStatus = !statusFilter || 
                            (statusFilter === 'completed' && task.completedTime) ||
                            (statusFilter === 'pending' && !task.completedTime);

        return matchesSearch && matchesCategory && matchesStatus;
    });

    updateTaskList(filteredTasks);
}

// Enhanced sort function
function sortAndUpdateTasks() {
    const sortBy = document.getElementById('sort-tasks').value;
    
    const sortedTasks = [...tasks].sort((a, b) => {
        switch(sortBy) {
            case 'priority':
                return calculatePriorityScore(b) - calculatePriorityScore(a);
            case 'dueDate':
                if (!a.dueDate) return 1;
                if (!b.dueDate) return -1;
                return new Date(a.dueDate) - new Date(b.dueDate);
            case 'progress':
                return b.progress - a.progress;
            case 'effort':
                return a.effort - b.effort;
            default:
                return 0;
        }
    });

    updateTaskList(sortedTasks);
}

// Update the task rendering to include new features
function renderTaskElement(task) {
    const priorityScore = calculatePriorityScore(task);
    const priorityClass = priorityScore >= 4 ? 'bg-red-100' : 
                         priorityScore >= 3 ? 'bg-yellow-100' : 
                         'bg-green-100';

    return `
        <div class="flex justify-between items-start p-4 ${priorityClass} rounded-lg shadow-md mb-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-xl font-semibold">${task.name}</h3>
                    <span class="px-2 py-1 text-sm rounded-full bg-gray-200">${task.category}</span>
                </div>
                <p class="text-gray-600 mb-2">${task.description || 'No description'}</p>
                <div class="flex items-center gap-4 text-sm">
                    <span>Priority: ${priorityScore}</span>
                    <span>Effort: ${task.effort}h</span>
                    <span>Due: ${task.dueDate || 'No due date'}</span>
                </div>
                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: ${task.progress}%"></div>
                </div>
            </div>
            <!-- ...existing buttons... -->
        </div>
    `;
}

// Update task progress
function updateProgress(taskId, progress) {
    const taskIndex = tasks.findIndex(t => t.id === taskId);
    if (taskIndex !== -1) {
        tasks[taskIndex].progress = Math.min(100, Math.max(0, progress));
        DataManager.save('tasks', tasks);
        updateTaskList();
        updateDashboard();
    }
}
</script>
</body>

</html>
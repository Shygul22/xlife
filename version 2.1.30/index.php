<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="script.js" defer type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-xl p-6 space-y-6">
            <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">
                <i class="fas fa-check-circle mr-2"></i>Smart Todo List
            </h1>
            
            <div class="flex gap-4 mb-6">
                <input type="text" id="taskInput" 
                    class="flex-1 px-4 py-3 rounded-lg border-2 border-indigo-100 focus:border-indigo-300 
                    focus:outline-none transition-colors" 
                    placeholder="Add a new task...">
                <input type="number" id="taskDuration" 
                    class="w-32 px-4 py-3 rounded-lg border-2 border-indigo-100 focus:border-indigo-300" 
                    placeholder="Minutes" min="1" max="480">
                <select id="timeSlot" 
                    class="w-48 px-4 py-3 rounded-lg border-2 border-indigo-100 focus:border-indigo-300">
                    <option value="">Select Time</option>
                    <option value="morning">Morning (9-12)</option>
                    <option value="afternoon">Afternoon (1-5)</option>
                    <option value="evening">Evening (6-9)</option>
                </select>
                <button id="addTaskBtn" 
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg
                    transform hover:scale-105 transition-all duration-200">
                    Add Task
                </button>
            </div>

            <div class="flex gap-4 mb-6">
                <button id="filterAll" class="flex-1 py-2 rounded-lg bg-indigo-100 hover:bg-indigo-200 transition-colors">All</button>
                <button id="filterActive" class="flex-1 py-2 rounded-lg bg-indigo-100 hover:bg-indigo-200 transition-colors">Active</button>
                <button id="filterCompleted" class="flex-1 py-2 rounded-lg bg-indigo-100 hover:bg-indigo-200 transition-colors">Completed</button>
            </div>

            <ul id="taskList" class="space-y-3">
                <!-- Tasks will be added here dynamically -->
            </ul>

            <div class="flex justify-between items-center mt-6 text-sm text-gray-500">
                <span id="taskCount">0 tasks</span>
                <button id="clearCompleted" 
                    class="text-indigo-500 hover:text-indigo-600 transition-colors">
                    Clear Completed
                </button>
            </div>

            <!-- Time Allocation Summary -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Time Allocation</h3>
                <canvas id="timeChart" height="100"></canvas>
                <div id="timeSlotSummary" class="mt-3 text-sm text-gray-600"></div>
            </div>
        </div>
    </div>
</body>
</html>
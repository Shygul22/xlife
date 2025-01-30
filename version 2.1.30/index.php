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
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.min.css" />
    <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-sky-50 to-indigo-100 min-h-screen p-6">
    <!-- Help Button -->
    <button id="helpButton" 
        class="fixed top-4 right-4 bg-primary-500 text-white p-3 rounded-full shadow-lg hover:bg-primary-600"
        data-tooltip-target="helpTooltip">
        <i class="fas fa-question"></i>
    </button>
    <div id="helpTooltip" role="tooltip" class="tooltip invisible opacity-0 bg-gray-900 text-sm text-white rounded-lg p-4 absolute z-10">
        Click for help and instructions
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Quick Guide Card -->
        <div class="bg-primary-50 rounded-2xl p-4 border border-primary-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-primary-700">Quick Guide</h2>
                <button id="toggleGuide" class="text-primary-600 hover:text-primary-700">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div id="guideContent" class="hidden mt-4 space-y-3 text-sm text-primary-600">
                <p><i class="fas fa-info-circle mr-2"></i>Add tasks with duration and priority</p>
                <p><i class="fas fa-clock mr-2"></i>Use time slots to organize your day</p>
                <p><i class="fas fa-chart-pie mr-2"></i>Track progress with charts and matrices</p>
                <p><i class="fas fa-hourglass-half mr-2"></i>Use Pomodoro timer for focused work</p>
            </div>
        </div>

        <!-- Main Task Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 backdrop-blur-sm bg-white/90">
            <h1 class="text-4xl font-bold text-center text-primary-600 mb-8 flex items-center justify-center">
                <i class="fas fa-check-circle mr-3"></i>Smart Todo List
            </h1>
            
            <!-- Task Form -->
            <form id="taskForm" class="mb-8">
                <div class="flex flex-col gap-6">
                    <!-- Input Fields -->
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="col-span-3 md:col-span-1">
                            <label for="taskInput" class="block text-sm font-medium text-gray-700 mb-1">
                                Task Description
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="taskInput" name="taskInput" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-primary-100" 
                                placeholder="What needs to be done?"
                                data-tooltip-target="taskInputHelp">
                            <div id="taskInputHelp" role="tooltip" class="tooltip invisible opacity-0 bg-gray-900 text-sm text-white rounded-lg p-2">
                                Enter a clear and specific task description
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        
                        <div class="flex gap-4 col-span-3 md:col-span-2">
                            <input type="number" id="taskDuration" name="taskDuration" required
                                class="w-32 px-4 py-3 rounded-xl border-2 border-primary-100 
                                focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" 
                                placeholder="Minutes" min="1" max="480">
                                
                            <select id="timeSlot" name="timeSlot" required
                                class="flex-1 px-4 py-3 rounded-xl border-2 border-primary-100 
                                focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                                <option value="">Select Time</option>
                                <option value="morning">Morning (9-12)</option>
                                <option value="afternoon">Afternoon (1-5)</option>
                                <option value="evening">Evening (6-9)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Time Slot Info -->
                    <div id="timeSlotSuggestion" class="text-sm text-primary-600 font-medium"></div>
                    <div id="timeSlotAvailability" 
                        class="grid grid-cols-3 gap-4 p-4 bg-sky-50 rounded-xl border border-sky-100">
                        <div class="relative group">
                            <div class="text-sm">
                                <span class="font-medium">Morning:</span>
                                <span id="morningAvailable" class="ml-1"></span>
                                <div class="absolute hidden group-hover:block bg-white p-2 rounded shadow-lg text-xs">
                                    Best for high-priority tasks (9 AM - 12 PM)
                                </div>
                            </div>
                        </div>
                        <div class="text-sm">
                            <span class="font-medium">Afternoon:</span>
                            <span id="afternoonAvailable" class="ml-1"></span>
                        </div>
                        <div class="text-sm">
                            <span class="font-medium">Evening:</span>
                            <span id="eveningAvailable" class="ml-1"></span>
                        </div>
                    </div>
                    
                    <!-- Priority and Date -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <select id="taskPriority" name="taskPriority" required
                            class="px-4 py-3 rounded-xl border-2 border-primary-100 
                            focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                            <option value="">Select Priority</option>
                            <option value="High">High Priority</option>
                            <option value="Medium">Medium Priority</option>
                            <option value="Low">Low Priority</option>
                        </select>
                        
                        <input type="date" id="taskDueDate" name="taskDueDate" required
                            class="px-4 py-3 rounded-xl border-2 border-primary-100 
                            focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
                    </div>
                    
                    <button type="submit" id="addTaskBtn" 
                        class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 
                        hover:to-primary-700 text-white px-8 py-4 rounded-xl
                        transform hover:scale-[1.02] transition-all duration-200 shadow-lg 
                        hover:shadow-primary-500/25">
                        Add Task
                    </button>
                </div>
            </form>

            <!-- Task Filters -->
            <div class="flex gap-4 mb-6">
                <button id="filterAll" 
                    class="flex-1 py-3 rounded-xl bg-primary-50 hover:bg-primary-100 
                    text-primary-700 font-medium transition-colors">All</button>
                <button id="filterActive" 
                    class="flex-1 py-3 rounded-xl bg-primary-50 hover:bg-primary-100 
                    text-primary-700 font-medium transition-colors">Active</button>
                <button id="filterCompleted" 
                    class="flex-1 py-3 rounded-xl bg-primary-50 hover:bg-primary-100 
                    text-primary-700 font-medium transition-colors">Completed</button>
            </div>

            <!-- Task List -->
            <ul id="taskList" class="space-y-4">
                <!-- Tasks will be added here dynamically -->
            </ul>

            <!-- Task Stats -->
            <div class="flex justify-between items-center mt-8 text-sm">
                <span id="taskCount" class="text-gray-600 font-medium">0 tasks</span>
                <button id="clearCompleted" 
                    class="text-primary-600 hover:text-primary-700 font-medium transition-colors">
                    Clear Completed
                </button>
            </div>
        </div>

        <!-- Charts and Tools Section -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Time Allocation -->
            <div class="bg-white rounded-2xl shadow-xl p-6 backdrop-blur-sm bg-white/90">
                <h3 class="text-xl font-bold text-primary-600 mb-4">Time Allocation</h3>
                <canvas id="timeChart" height="200"></canvas>
                <div id="timeSlotSummary" class="mt-4 text-sm text-gray-600 text-center"></div>
            </div>

            <!-- Productivity Tools -->
            <div class="bg-white rounded-2xl shadow-xl p-6 backdrop-blur-sm bg-white/90">
                <h3 class="text-xl font-bold text-primary-600 mb-4">
                    <i class="fas fa-chart-line mr-2"></i>Productivity Tools
                </h3>
                
                <div class="grid gap-6">
                    <div id="eisenhowerMatrix" class="p-4 bg-sky-50 rounded-xl border border-sky-100">
                        <h3 class="text-lg font-semibold mb-3">Eisenhower Matrix</h3>
                        <!-- Matrix will be populated by JS -->
                    </div>

                    <div id="pomodoroTimer" class="text-center p-6 bg-primary-50 rounded-xl">
                        <div id="timerDisplay" class="text-4xl font-bold text-primary-700 mb-4">25:00</div>
                        <button id="startPomodoro" 
                            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 
                            rounded-xl transition-colors">
                            Start Pomodoro
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Blocks Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 backdrop-blur-sm bg-white/90">
            <h2 class="text-xl font-bold text-primary-600 mb-4">
                <i class="fas fa-calendar-alt mr-2"></i>Time Blocks
            </h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div id="timeBlockView" class="md:col-span-3 bg-sky-50 rounded-xl p-6 min-h-[300px]">
                    <!-- Time blocks will be rendered here -->
                </div>
                <div id="taskCategories" class="bg-sky-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-primary-600">Categories</h3>
                    <div id="categoryList" class="space-y-3">
                        <!-- Categories will be listed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" tabindex="-1" aria-hidden="true" 
        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">How to Use</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="text-sm text-gray-500 text-left space-y-4">
                        <p><strong>1. Adding Tasks:</strong> Enter task details in the form including duration and priority</p>
                        <p><strong>2. Time Slots:</strong> Choose morning, afternoon, or evening based on availability</p>
                        <p><strong>3. Priority:</strong> Set task priority to help organize your day</p>
                        <p><strong>4. Tracking:</strong> Use the charts and matrix to monitor your progress</p>
                        <p><strong>5. Focus Mode:</strong> Use the Pomodoro timer for concentrated work sessions</p>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeHelp" class="px-4 py-2 bg-primary-500 text-white rounded-md">
                        Got it!
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
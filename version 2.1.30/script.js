class TodoStorage {
    constructor(secretKey = 'your-secret-key') {
        this.secretKey = secretKey;
    }

    encrypt(data) {
        return CryptoJS.AES.encrypt(JSON.stringify(data), this.secretKey).toString();
    }

    decrypt(encryptedData) {
        try {
            const bytes = CryptoJS.AES.decrypt(encryptedData, this.secretKey);
            return JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
        } catch (e) {
            return [];
        }
    }

    saveTasks(tasks) {
        try {
            localStorage.setItem('tasks', this.encrypt(tasks));
        } catch (e) {
            console.error('Failed to save tasks:', e);
        }
    }

    getTasks() {
        const tasks = localStorage.getItem('tasks');
        return tasks ? this.decrypt(tasks) : [];
    }

    // Add productivity methods to TodoStorage
    categorizeTasks(tasks) {
        const matrix = {
            urgentImportant: [],
            notUrgentImportant: [],
            urgentNotImportant: [],
            notUrgentNotImportant: []
        };

        tasks.forEach(task => {
            if (!task.dueDate || !task.priority) return;

            const now = new Date();
            const dueDate = new Date(task.dueDate);
            const dueInTime = dueDate - now;
            const urgent = dueInTime <= 24 * 60 * 60 * 1000;

            if (urgent && task.priority === 'High') {
                matrix.urgentImportant.push(task);
            } else if (!urgent && task.priority === 'Medium') {
                matrix.notUrgentImportant.push(task);
            } else if (urgent && task.priority === 'Low') {
                matrix.urgentNotImportant.push(task);
            } else {
                matrix.notUrgentNotImportant.push(task);
            }
        });

        return matrix;
    }
}

class TimeAllocator {
    static suggestDuration() {
        return 30; // Default duration in minutes
    }

    static validateTimeSlot(duration, timeSlot) {
        const slots = {
            morning: { start: 9, end: 12, available: 180 },
            afternoon: { start: 13, end: 17, available: 240 },
            evening: { start: 18, end: 21, available: 180 }
        };
        
        return slots[timeSlot]?.available >= duration;
    }

    static getAvailableTime(timeSlot, tasks) {
        const slots = {
            morning: { start: 9, end: 12, available: 180 },
            afternoon: { start: 13, end: 17, available: 240 },
            evening: { start: 18, end: 21, available: 180 }
        };

        const used = tasks.reduce((acc, task) => {
            if (task.timeSlot === timeSlot) {
                acc += task.duration;
            }
            return acc;
        }, 0);

        return slots[timeSlot].available - used;
    }

    static suggestBestTimeSlot(duration, tasks) {
        const availability = {
            morning: this.getAvailableTime('morning', tasks),
            afternoon: this.getAvailableTime('afternoon', tasks),
            evening: this.getAvailableTime('evening', tasks)
        };

        // Find slot with most available time
        const bestSlot = Object.entries(availability)
            .filter(([_, available]) => available >= duration)
            .sort(([_, a], [__, b]) => b - a)[0];

        return bestSlot ? bestSlot[0] : null;
    }

    static getTaskCategories(tasks) {
        const categories = {
            focus: [],    // High priority & complex tasks
            routine: [],  // Medium priority & repetitive tasks
            quick: [],    // Tasks under 30 minutes
            flexible: []  // Low priority & can be moved
        };

        tasks.forEach(task => {
            if (task.duration <= 30) {
                categories.quick.push(task);
            } else if (task.priority === 'High') {
                categories.focus.push(task);
            } else if (task.priority === 'Medium') {
                categories.routine.push(task);
            } else {
                categories.flexible.push(task);
            }
        });

        return categories;
    }

    static createTimeBlocks(tasks) {
        const timeBlocks = {
            morning: [],
            afternoon: [],
            evening: []
        };

        // Sort tasks by priority and duration
        const sortedTasks = [...tasks].sort((a, b) => {
            if (a.priority === 'High' && b.priority !== 'High') return -1;
            if (b.priority === 'High' && a.priority !== 'High') return 1;
            return b.duration - a.duration;
        });

        sortedTasks.forEach(task => {
            if (task.timeSlot) {
                timeBlocks[task.timeSlot].push(task);
            }
        });

        return timeBlocks;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const elements = {
        taskForm: document.getElementById('taskForm'),
        taskInput: document.getElementById('taskInput'),
        addTaskBtn: document.getElementById('addTaskBtn'),
        taskList: document.getElementById('taskList'),
        taskCount: document.getElementById('taskCount'),
        filterAll: document.getElementById('filterAll'),
        filterActive: document.getElementById('filterActive'),
        filterCompleted: document.getElementById('filterCompleted'),
        clearCompleted: document.getElementById('clearCompleted'),
        taskDuration: document.getElementById('taskDuration'),
        timeSlot: document.getElementById('timeSlot'),
        timeChart: document.getElementById('timeChart'),
        timeSlotSummary: document.getElementById('timeSlotSummary'),
        taskPriority: document.getElementById('taskPriority'),
        taskDueDate: document.getElementById('taskDueDate'),
        eisenhowerMatrix: document.getElementById('eisenhowerMatrix'),
        startPomodoro: document.getElementById('startPomodoro'),
        timerDisplay: document.getElementById('timerDisplay'),
        timeSlotSuggestion: document.getElementById('timeSlotSuggestion'),
        morningAvailable: document.getElementById('morningAvailable'),
        afternoonAvailable: document.getElementById('afternoonAvailable'),
        eveningAvailable: document.getElementById('eveningAvailable'),
        timeBlockView: document.getElementById('timeBlockView'),
        categoryList: document.getElementById('categoryList'),
        helpButton: document.getElementById('helpButton'),
        helpModal: document.getElementById('helpModal'),
        closeHelp: document.getElementById('closeHelp'),
        toggleGuide: document.getElementById('toggleGuide'),
        guideContent: document.getElementById('guideContent')
    };

    // Validate all required elements exist
    for (const [key, element] of Object.entries(elements)) {
        if (!element) {
            console.error(`Required element '${key}' not found`);
            return;
        }
    }

    const storage = new TodoStorage();
    let tasks = [];

    try {
        tasks = storage.getTasks();
    } catch (e) {
        console.error('Failed to load tasks:', e);
        tasks = [];
    }

    let timeChart = null;

    function updateTimeChart() {
        const timeData = {
            morning: 0,
            afternoon: 0,
            evening: 0
        };

        tasks.forEach(task => {
            if (task.timeSlot && task.duration) {
                timeData[task.timeSlot] += task.duration;
            }
        });

        if (timeChart) {
            timeChart.destroy();
        }

        timeChart = new Chart(elements.timeChart, {
            type: 'bar',
            data: {
                labels: ['Morning', 'Afternoon', 'Evening'],
                datasets: [{
                    label: 'Minutes Allocated',
                    data: Object.values(timeData),
                    backgroundColor: ['#93c5fd', '#818cf8', '#4f46e5']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 240
                    }
                }
            }
        });

        elements.timeSlotSummary.innerHTML = Object.entries(timeData)
            .map(([slot, mins]) => `${slot}: ${mins}min`)
            .join(' | ');
    }

    function updateEisenhowerMatrix() {
        const matrix = storage.categorizeTasks(tasks);
        elements.eisenhowerMatrix.innerHTML = `
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="bg-red-100 p-2 rounded">
                    <strong>Urgent & Important (${matrix.urgentImportant.length})</strong>
                    ${matrix.urgentImportant.map(t => `<div>${t.text}</div>`).join('')}
                </div>
                <div class="bg-yellow-100 p-2 rounded">
                    <strong>Important (${matrix.notUrgentImportant.length})</strong>
                    ${matrix.notUrgentImportant.map(t => `<div>${t.text}</div>`).join('')}
                </div>
                <div class="bg-blue-100 p-2 rounded">
                    <strong>Urgent (${matrix.urgentNotImportant.length})</strong>
                    ${matrix.urgentNotImportant.map(t => `<div>${t.text}</div>`).join('')}
                </div>
                <div class="bg-green-100 p-2 rounded">
                    <strong>Neither (${matrix.notUrgentNotImportant.length})</strong>
                    ${matrix.notUrgentNotImportant.map(t => `<div>${t.text}</div>`).join('')}
                </div>
            </div>
        `;
    }

    function updateTaskList(filteredTasks = tasks) {
        try {
            taskList.innerHTML = '';
            filteredTasks.forEach((task, index) => {
                const li = document.createElement('li');
                li.className = `group flex items-center p-4 bg-white rounded-lg shadow-sm 
                              border-2 ${task.completed ? 'border-green-100' : 'border-indigo-50'} 
                              hover:border-indigo-200 transition-all duration-200`;

                li.innerHTML = `
                    <input type="checkbox" ${task.completed ? 'checked' : ''} 
                        class="w-5 h-5 mr-4 rounded border-gray-300 text-indigo-600 
                        focus:ring-indigo-500 cursor-pointer">
                    <span class="${task.completed ? 'line-through text-gray-400' : ''} flex-1">
                        ${task.text}
                    </span>
                    <span class="px-2 py-1 mx-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${task.duration}min - ${task.timeSlot}
                    </span>
                    <span class="px-2 py-1 mx-2 rounded-full text-xs font-medium 
                        ${task.priority === 'High' ? 'bg-red-100 text-red-800' : 
                          task.priority === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 
                          'bg-green-100 text-green-800'}">
                        ${task.priority}
                    </span>
                    <button class="delete-btn opacity-0 group-hover:opacity-100 transition-opacity 
                        text-red-500 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                `;

                const checkbox = li.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', () => toggleTask(index));

                const deleteBtn = li.querySelector('.delete-btn');
                deleteBtn.addEventListener('click', () => deleteTask(index));

                taskList.appendChild(li);
            });

            taskCount.textContent = `${tasks.length} tasks`;
            storage.saveTasks(tasks);
            updateTimeChart();
            updateEisenhowerMatrix();
            updateTimeSlotAvailability();
            updateTimeBlocks();
            updateCategories();
        } catch (e) {
            console.error('Error updating task list:', e);
        }
    }

    function getFormData() {
        const formData = new FormData(elements.taskForm);
        const data = {
            text: formData.get('taskInput')?.trim() || '',
            duration: parseInt(formData.get('taskDuration')) || TimeAllocator.suggestDuration(),
            timeSlot: formData.get('timeSlot') || '',
            priority: formData.get('taskPriority') || '',
            dueDate: formData.get('taskDueDate') || ''
        };
        
        // Convert dueDate to proper Date object if exists
        if (data.dueDate) {
            data.dueDate = new Date(data.dueDate + 'T00:00:00');
        }

        return data;
    }

    function validateFormData(data) {
        const errors = [];
        const warnings = [];
        
        if (!data.text) errors.push('Task description is required');
        if (!data.timeSlot) errors.push('Time slot is required');
        if (!data.priority) errors.push('Priority is required');
        if (!data.dueDate) errors.push('Due date is required');
        if (!TimeAllocator.validateTimeSlot(data.duration, data.timeSlot)) {
            errors.push('Invalid time slot or duration');
        }

        // Additional user guidance
        if (data.duration > 120) {
            warnings.push('Consider breaking this task into smaller chunks');
        }
        if (data.priority === 'High' && data.duration < 30) {
            warnings.push('High priority tasks typically need more time');
        }

        return { errors, warnings };
    }

    function addTask(e) {
        e.preventDefault();
        
        const formData = getFormData();
        const { errors, warnings } = validateFormData(formData);

        if (errors.length > 0) {
            alert('Please fix the following errors:\n' + errors.join('\n'));
            return;
        }

        if (warnings.length > 0) {
            if (!confirm(warnings.join('\n') + '\n\nDo you want to continue?')) {
                return;
            }
        }

        try {
            const task = {
                id: Date.now(),
                ...formData,
                completed: false,
                created: new Date().toISOString()
            };

            tasks.push(task);
            elements.taskForm.reset();
            updateTaskList();
            return task;
        } catch (e) {
            console.error('Error adding task:', e);
            alert('Failed to add task. Please try again.');
            return null;
        }
    }

    function toggleTask(index) {
        tasks[index].completed = !tasks[index].completed;
        updateTaskList();
    }

    function deleteTask(index) {
        tasks.splice(index, 1);
        updateTaskList();
    }

    // Add Pomodoro Timer state
    let pomodoroInterval = null;
    let timeLeft = 25 * 60;

    // Add Pomodoro Timer functionality
    elements.startPomodoro?.addEventListener('click', () => {
        if (pomodoroInterval) {
            clearInterval(pomodoroInterval);
            pomodoroInterval = null;
            elements.startPomodoro.textContent = 'Start Pomodoro';
            elements.timerDisplay.textContent = '25:00';
            timeLeft = 25 * 60;
        } else {
            startPomodoro();
        }
    });

    function startPomodoro() {
        pomodoroInterval = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();
            
            if (timeLeft <= 0) {
                clearInterval(pomodoroInterval);
                pomodoroInterval = null;
                timeLeft = 25 * 60;
                elements.startPomodoro.textContent = 'Start Pomodoro';
                alert('Pomodoro completed! Take a break.');
            }
        }, 1000);
        elements.startPomodoro.textContent = 'Stop Pomodoro';
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        elements.timerDisplay.textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function updateTimeSlotAvailability() {
        const morning = TimeAllocator.getAvailableTime('morning', tasks);
        const afternoon = TimeAllocator.getAvailableTime('afternoon', tasks);
        const evening = TimeAllocator.getAvailableTime('evening', tasks);

        elements.morningAvailable.textContent = `${morning}min available`;
        elements.afternoonAvailable.textContent = `${afternoon}min available`;
        elements.eveningAvailable.textContent = `${evening}min available`;

        elements.morningAvailable.className = morning < 30 ? 'text-red-500' : 'text-green-600';
        elements.afternoonAvailable.className = afternoon < 30 ? 'text-red-500' : 'text-green-600';
        elements.eveningAvailable.className = evening < 30 ? 'text-red-500' : 'text-green-600';
    }

    // Add event listener for duration input
    elements.taskDuration.addEventListener('input', (e) => {
        const duration = parseInt(e.target.value);
        if (duration) {
            const suggestion = TimeAllocator.suggestBestTimeSlot(duration, tasks);
            if (suggestion) {
                elements.timeSlotSuggestion.textContent = 
                    `Suggestion: ${suggestion} has the most available time`;
                elements.timeSlot.value = suggestion;
            } else {
                elements.timeSlotSuggestion.textContent = 
                    'No time slot has enough available time';
            }
        }
    });

    function updateTimeBlocks() {
        const timeBlocks = TimeAllocator.createTimeBlocks(tasks);
        elements.timeBlockView.innerHTML = `
            <div class="grid grid-cols-3 gap-4">
                ${Object.entries(timeBlocks).map(([slot, slotTasks]) => `
                    <div class="bg-white p-3 rounded shadow-sm">
                        <h4 class="font-semibold capitalize mb-2">${slot}</h4>
                        ${slotTasks.map(task => `
                            <div class="bg-${task.priority === 'High' ? 'red' : 
                                         task.priority === 'Medium' ? 'yellow' : 'green'}-50 
                                 p-2 mb-2 rounded text-sm">
                                <div class="font-medium">${task.text}</div>
                                <div class="text-xs text-gray-500">${task.duration}min</div>
                            </div>
                        `).join('')}
                    </div>
                `).join('')}
            </div>
        `;
    }

    function updateCategories() {
        const categories = TimeAllocator.getTaskCategories(tasks);
        elements.categoryList.innerHTML = `
            ${Object.entries(categories).map(([category, categoryTasks]) => `
                <div class="mb-3">
                    <h4 class="font-medium capitalize text-indigo-600">${category} (${categoryTasks.length})</h4>
                    <div class="text-sm text-gray-600">
                        ${categoryTasks.map(task => `
                            <div class="py-1">${task.text}</div>
                        `).join('')}
                    </div>
                </div>
            `).join('')}
        `;
    }

    // Event Listeners with error handling
    elements.taskForm.addEventListener('submit', addTask);
    
    // Remove old event listeners
    elements.addTaskBtn.removeEventListener('click', addTask);
    elements.taskInput.removeEventListener('keypress', (e) => {
        if (e.key === 'Enter') addTask(e);
    });

    elements.filterAll.addEventListener('click', () => {
        try {
            updateTaskList();
        } catch (e) {
            console.error('Error filtering all tasks:', e);
        }
    });

    elements.filterActive.addEventListener('click', () => 
        updateTaskList(tasks.filter(task => !task.completed))
    );

    elements.filterCompleted.addEventListener('click', () => 
        updateTaskList(tasks.filter(task => task.completed))
    );

    elements.clearCompleted.addEventListener('click', () => {
        tasks = tasks.filter(task => !task.completed);
        updateTaskList();
    });

    // Help system handlers
    elements.helpButton?.addEventListener('click', () => {
        elements.helpModal.classList.remove('hidden');
    });

    elements.closeHelp?.addEventListener('click', () => {
        elements.helpModal.classList.add('hidden');
    });

    elements.toggleGuide?.addEventListener('click', () => {
        elements.guideContent.classList.toggle('hidden');
        const icon = elements.toggleGuide.querySelector('i');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
    });

    // Show quick guide on first visit
    if (!localStorage.getItem('hasSeenGuide')) {
        elements.guideContent.classList.remove('hidden');
        localStorage.setItem('hasSeenGuide', 'true');
    }

    // Initial render
    updateTaskList();
    updateTimeChart();
    updateEisenhowerMatrix();
    updateTimeSlotAvailability();
    updateTimeBlocks();
    updateCategories();
});

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
}

document.addEventListener('DOMContentLoaded', () => {
    const elements = {
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
        timeSlotSummary: document.getElementById('timeSlotSummary')
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
        } catch (e) {
            console.error('Error updating task list:', e);
        }
    }

    function addTask() {
        const text = elements.taskInput.value.trim();
        const duration = parseInt(elements.taskDuration.value) || TimeAllocator.suggestDuration();
        const timeSlot = elements.timeSlot.value;

        if (!text || !TimeAllocator.validateTimeSlot(duration, timeSlot)) {
            alert('Invalid task details or time slot unavailable');
            return;
        }

        try {
            tasks.push({
                id: Date.now(), // Add unique ID for each task
                text,
                completed: false,
                duration,
                timeSlot,
                created: new Date().toISOString()
            });

            elements.taskInput.value = '';
            elements.taskDuration.value = '';
            elements.timeSlot.value = '';
            updateTaskList();
            updateTimeChart();
        } catch (e) {
            console.error('Error adding task:', e);
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

    // Event Listeners with error handling
    elements.addTaskBtn.addEventListener('click', (e) => {
        e.preventDefault();
        addTask();
    });

    elements.taskInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTask();
        }
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

    // Initial render
    updateTaskList();
    updateTimeChart();
});

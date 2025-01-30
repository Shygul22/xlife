// Task class to represent each task with priority, estimated time, and due date
class Task {
    constructor(name, priority, estimatedTime, dueDate) {
        this.name = name;
        this.priority = priority;
        this.estimatedTime = estimatedTime; // in minutes
        this.dueDate = new Date(dueDate); // Date object
    }
}

// Function to gather task information from the user
const getUserTaskInput = () => {
    const name = prompt("Enter the task name:");
    const priority = prompt("Enter the priority (High, Medium, Low):");
    const estimatedTime = parseInt(prompt("Enter the estimated time in minutes:"), 10);
    const dueDate = prompt("Enter the due date (YYYY-MM-DD):");

    return new Task(name, priority, estimatedTime, dueDate);
}

// Eisenhower Matrix categorization
const categorizeTasks = (tasks) => {
    const urgentImportant = [];
    const notUrgentImportant = [];
    const urgentNotImportant = [];
    const notUrgentNotImportant = [];

    tasks.forEach(task => {
        const now = new Date();
        const dueInTime = task.dueDate - now; // in milliseconds
        const urgent = dueInTime <= 24 * 60 * 60 * 1000; // Due in the next 24 hours

        if (urgent && task.priority === 'High') {
            urgentImportant.push(task);
        } else if (!urgent && task.priority === 'Medium') {
            notUrgentImportant.push(task);
        } else if (urgent && task.priority === 'Low') {
            urgentNotImportant.push(task);
        } else {
            notUrgentNotImportant.push(task);
        }
    });

    return { urgentImportant, notUrgentImportant, urgentNotImportant, notUrgentNotImportant };
};

// Pomodoro Technique: Break the tasks into Pomodoro intervals
const applyPomodoro = (task) => {
    const pomodoros = Math.ceil(task.estimatedTime / 25); // 1 Pomodoro = 25 minutes
    let pomodoroSchedule = [];
    
    for (let i = 1; i <= pomodoros; i++) {
        pomodoroSchedule.push(`Pomodoro ${i}: Work for 25 minutes`);
        if (i !== pomodoros) {
            pomodoroSchedule.push('Take a 5-minute break');
        }
    }
    
    return pomodoroSchedule;
};

// Time Blocking: Allocate time blocks based on task priority and time required
const timeBlocking = (tasks) => {
    let timeBlockSchedule = [];
    let currentTime = new Date();
    
    tasks.forEach(task => {
        const taskBlock = {
            task: task.name,
            startTime: currentTime.toLocaleString(),
            endTime: new Date(currentTime.getTime() + task.estimatedTime * 60000).toLocaleString()
        };
        
        timeBlockSchedule.push(taskBlock);
        currentTime = new Date(currentTime.getTime() + task.estimatedTime * 60000);
    });
    
    return timeBlockSchedule;
};

// 2-Minute Rule: If the task can be done in 2 minutes, do it immediately
const twoMinuteRule = (tasks) => {
    return tasks.filter(task => task.estimatedTime <= 2);
};

// Task Scheduling Module
const taskScheduler = (tasks) => {
    // Step 1: Categorize tasks based on Eisenhower Matrix
    const { urgentImportant, notUrgentImportant, urgentNotImportant, notUrgentNotImportant } = categorizeTasks(tasks);

    // Step 2: Apply Pomodoro Technique to High-Priority tasks (Urgent & Important)
    const urgentImportantSchedule = urgentImportant.map(task => {
        return {
            task: task.name,
            pomodoros: applyPomodoro(task)
        };
    });

    // Step 3: Apply Time Blocking to all tasks
    const allTimeBlocks = timeBlocking(tasks);

    // Step 4: Apply 2-Minute Rule to Low-Priority tasks
    const quickTasks = twoMinuteRule(tasks);

    return {
        urgentImportantSchedule,
        allTimeBlocks,
        quickTasks,
        notUrgentImportant,
        notUrgentNotImportant
    };
};

// Example: Collect user tasks using the prompt and store in an array
let userTasks = [];
const numTasks = parseInt(prompt("How many tasks would you like to input?"));

for (let i = 0; i < numTasks; i++) {
    const task = getUserTaskInput();
    userTasks.push(task);
}

// Execute task scheduling
const schedule = taskScheduler(userTasks);

// Display results
console.log('Urgent & Important Tasks:', schedule.urgentImportantSchedule);
console.log('Time Blocks for All Tasks:', schedule.allTimeBlocks);
console.log('Quick Tasks to Do Immediately:', schedule.quickTasks);
console.log('Not Urgent & Important Tasks:', schedule.notUrgentImportant);
console.log('Not Urgent & Not Important Tasks:', schedule.notUrgentNotImportant);

// DOM Integration
document.addEventListener('DOMContentLoaded', () => {
    const elements = {
        taskPriority: document.getElementById('taskPriority'),
        taskDueDate: document.getElementById('taskDueDate'),
        eisenhowerMatrix: document.getElementById('eisenhowerMatrix'),
        startPomodoro: document.getElementById('startPomodoro'),
        timerDisplay: document.getElementById('timerDisplay')
    };

    // Initialize Pomodoro Timer
    let pomodoroInterval = null;
    let timeLeft = 25 * 60; // 25 minutes in seconds

    elements.startPomodoro.addEventListener('click', () => {
        if (pomodoroInterval) {
            clearInterval(pomodoroInterval);
            pomodoroInterval = null;
            elements.startPomodoro.textContent = 'Start Pomodoro';
            timeLeft = 25 * 60;
        } else {
            pomodoroInterval = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                elements.timerDisplay.textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(pomodoroInterval);
                    alert('Pomodoro completed! Take a break.');
                }
            }, 1000);
            elements.startPomodoro.textContent = 'Stop Pomodoro';
        }
    });

    // Update Eisenhower Matrix display
    function updateEisenhowerMatrix(tasks) {
        const matrix = categorizeTasks(tasks);
        elements.eisenhowerMatrix.innerHTML = `
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="bg-red-100 p-2 rounded">
                    <strong>Urgent & Important (${matrix.urgentImportant.length})</strong>
                </div>
                <div class="bg-yellow-100 p-2 rounded">
                    <strong>Important (${matrix.notUrgentImportant.length})</strong>
                </div>
                <div class="bg-blue-100 p-2 rounded">
                    <strong>Urgent (${matrix.urgentNotImportant.length})</strong>
                </div>
                <div class="bg-green-100 p-2 rounded">
                    <strong>Neither (${matrix.notUrgentNotImportant.length})</strong>
                </div>
            </div>
        `;
    }

    // Hook into the existing task system
    const originalAddTask = window.addTask;
    window.addTask = function() {
        const priority = elements.taskPriority.value;
        const dueDate = elements.taskDueDate.value;
        
        // Call original addTask with additional data
        const task = originalAddTask();
        if (task) {
            task.priority = priority;
            task.dueDate = new Date(dueDate);
            updateEisenhowerMatrix(window.tasks);
        }
    };
});

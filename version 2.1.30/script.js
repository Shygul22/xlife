// ...existing code...

function closeWelcomeModal() {
    const modal = document.getElementById('welcome-modal');
    const dontShowAgain = document.getElementById('dont-show-again').checked;
    
    if (dontShowAgain) {
        localStorage.setItem('hideWelcomeModal', 'true');
    }
    
    modal.classList.add('hidden');
    ErrorHandler.showMessage('Welcome to ZenJourney!', 'success');
}

// Update the DOMContentLoaded event listener
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
    
    // Show welcome modal if first visit
    if (!localStorage.getItem('hideWelcomeModal')) {
        document.getElementById('welcome-modal').classList.remove('hidden');
    }
    
    // Initial task list update
    updateTaskList();
});

// ...rest of existing code...


function manageEditIncTab() {
    // Get all tab buttons
    const tabButtons = document.querySelectorAll('#edit-inc-tab button');
    const tabContent = document.querySelectorAll('.tab-pane');

    // Get the active tab from local storage
    const activeTab = localStorage.getItem('editIncidentActiveTab');

    // If there is an active tab in local storage, set it as active
    if (activeTab) {
        tabButtons.forEach(button => {
            if (button.id === activeTab) {
                button.classList.add('active');
                document.querySelector(button.getAttribute('data-bs-target')).classList.add('show', 'active');
            } else {
                button.classList.remove('active');
            }
        });
    } else {
        // Default to the first tab
        tabButtons[0].classList.add('active');
        tabContent[0].classList.add('show', 'active');
    }

    // Add click event listeners to each tab button
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to the clicked button
            button.classList.add('active');

            // Hide all tab content
            tabContent.forEach(content => content.classList.remove('show', 'active'));
            // Show the clicked tab content
            document.querySelector(button.getAttribute('data-bs-target')).classList.add('show', 'active');

            // Save the active tab to local storage
            localStorage.setItem('editIncidentActiveTab', button.id);
        });
    });
}
document.addEventListener('DOMContentLoaded', manageEditIncTab);



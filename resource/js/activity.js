// Function to initialize tab navigation
function activityPageInitializeTabNavigation() {
    const navContainer = document.querySelector('#activityPage-nav-tab');
    if (!navContainer) {
        console.warn('Nav container not found, skipping activityPageInitializeTabNavigation.');
        return;
    }
    const navLinks = navContainer.querySelectorAll('.activityPage-nav-link');
    if (navLinks.length === 0) {
        console.warn('No nav links found, skipping activityPageInitializeTabNavigation.');
        return;
    }
    const tabContent = document.querySelectorAll('.tab-pane');

    function activityPageSetActiveTab(tabId) {
        navLinks.forEach(link => {
            const isSelected = (link.id === tabId);
            link.classList.toggle('active', isSelected);
            link.setAttribute('aria-selected', isSelected);
            const targetId = link.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            if (target) {
                target.classList.toggle('show', isSelected);
                target.classList.toggle('active', isSelected);
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            localStorage.setItem('activityPageActiveTab', this.id);
            activityPageSetActiveTab(this.id);
        });
    });

    const activeTabId = localStorage.getItem('activityPageActiveTab');
    if (activeTabId) {
        activityPageSetActiveTab(activeTabId);
    } else if (navLinks.length > 0) {
        activityPageSetActiveTab(navLinks[0].id); // Default to the first tab if none is stored
    }
}

document.addEventListener('DOMContentLoaded', activityPageInitializeTabNavigation);

// Sub Activity Tabs
function subActivityPageInitializeTabNavigation() {
    const navContainers = document.querySelectorAll('.subActivityPage-nav-tab');
    if (navContainers.length === 0) {
        console.warn('Sub nav containers not found, skipping subActivityPageInitializeTabNavigation.');
        return;
    }
    navContainers.forEach(container => {
        const navLinks = container.querySelectorAll('.subActivityPage-nav-link');
        if (navLinks.length === 0) {
            console.warn('No sub nav links found in container, skipping subActivityPageInitializeTabNavigation for this container.');
            return;
        }
        const tabContent = container.querySelectorAll('.tab-pane');

        function subActivityPageSetActiveTab(tabId) {
            navLinks.forEach(link => {
                const isSelected = (link.id === tabId);
                link.classList.toggle('active', isSelected);
                link.setAttribute('aria-selected', isSelected);
                const targetId = link.getAttribute('data-bs-target');
                const target = document.querySelector(targetId);
                if (target) {
                    target.classList.toggle('show', isSelected);
                    target.classList.toggle('active', isSelected);
                }
            });
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                localStorage.setItem('subActivityPageActiveTab', this.id);
                subActivityPageSetActiveTab(this.id);
            });
        });

        const activeTabId = localStorage.getItem('subActivityPageActiveTab');
        if (activeTabId) {
            subActivityPageSetActiveTab(activeTabId);
        } else if (navLinks.length > 0) {
            subActivityPageSetActiveTab(navLinks[0].id); // Default to the first tab if none is stored
        }
    });
}

document.addEventListener('DOMContentLoaded', subActivityPageInitializeTabNavigation);

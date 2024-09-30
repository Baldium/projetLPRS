document.addEventListener('DOMContentLoaded', (event) => {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.querySelector('.search-button');
    const contactTable = document.querySelector('.contact-table tbody');
    const sidebarMenuItems = document.querySelectorAll('.sidebar-menu li');

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = contactTable.querySelectorAll('tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keyup', (event) => {
        if (event.key === 'Enter') {
            performSearch();
        }
    });

    sidebarMenuItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarMenuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            console.log('Selected:', item.textContent);
        });
    });

    console.log('Search functionality and sidebar menu initialized');
});
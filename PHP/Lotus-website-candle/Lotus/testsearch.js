document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.getElementById('search-icon');
    const searchBar = document.getElementById('search-bar');

    searchIcon.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        if (searchBar.getAttribute('data-seeable') == 'true') {
            searchBar.style.display = 'none';
            searchBar.setAttribute('data-seeable', 'false');
        } 
        else {
            searchBar.removeAttribute('style');
            searchBar.setAttribute('data-seeable', 'true');
        }
    });

    // Close the search bar if clicked outside of it
    document.addEventListener('click', function(event) {
        if (!searchBar.contains(event.target) && !searchIcon.contains(event.target)) {
            searchBar.style.display = 'none';
        }
    });
});

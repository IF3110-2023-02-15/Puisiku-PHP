document.addEventListener('DOMContentLoaded', function() {
    const clickableRows = document.querySelectorAll('.clickable-row');

    clickableRows.forEach(function(row) {
        row.addEventListener('click', function() {
            window.location.href = row.getAttribute('data-href');
        });
    });
});
const searchInput = document.getElementById('search-input');
const searchForm = document.getElementById('search-form');

const filterDropdown = document.getElementById('filter-dropdown');
const filterButton = document.getElementById('filter-button');
const filterDropdownOkButton = document.getElementById('filter-dropdown-ok-button');

function fetchData(url, callback) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.log('Error: ', response.error);
            } else {
                callback(response);
            }
        }
    }
    xhr.send();
}

function updateUI(response) {
    let poems = response.poems;
    let pagination = response.pagination;

    let poemsContainer = document.getElementById("poems-container");
    poemsContainer.innerHTML = poems;

    let paginationContainer = document.getElementById("pagination-container")
    paginationContainer.innerHTML = pagination;

    // Add event listeners to the pagination buttons
    addPaginationEventListeners();
}

function addPaginationEventListeners() {
    let prevPage = document.getElementById('prev-page');
    let nextPage = document.getElementById('next-page');
    let pageInfo = document.getElementById('page-info');

    if (prevPage) {
        prevPage.addEventListener('click', function (event) {
            event.preventDefault();

            let currentPage = parseInt(pageInfo.getAttribute('data-current-page'));
            let prevPageNum = currentPage - 1;

            let data = getData(prevPageNum);
            let params = new URLSearchParams(data).toString();

            fetchData('/poems/search?' + params, updateUI);
        });
    }

    if (nextPage) {
        nextPage.addEventListener('click', function(event) {
            event.preventDefault();

            let currentPage = parseInt(pageInfo.getAttribute('data-current-page'));
            let nextPageNum = currentPage + 1;

            let data = getData(nextPageNum);
            let params = new URLSearchParams(data).toString();

            fetchData('/poems/search?' + params, updateUI);
        });
    }
}

// Get data function
function getData(page = 1) {
    let search_query = searchInput.value;

    let allGenres = document.querySelectorAll('#genre-dropdown input[type="checkbox"]');
    let checkedGenres = document.querySelectorAll('#genre-dropdown input[type="checkbox"]:checked');
    let checkedGenresValue = Array.from(checkedGenres).map(cb => cb.value);

    let sortBy = document.getElementById('sort-by').value;
    let yearQuery = document.getElementById('year-query').value;

    let data = {};

    if (search_query !== '') {
        data.search_query = search_query;
    }
    if (checkedGenres.length < allGenres.length) {
        data.genre = JSON.stringify(checkedGenresValue);
    }
    if (page !== 1) {
        data.page = page;
    }
    if (sortBy !== '') {
        data.sort_by = sortBy;
    }
    if (yearQuery !== '') {
        data.year_query = yearQuery;
    }

    console.log(data);
    return data;
}

// Debounce function
function debounce(func, delay) {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
}

// Fetch data function with debounce
let fetchDataDebounced = debounce(function(event) {
    let data = getData();
    let params = new URLSearchParams(data).toString();

    fetchData('/poems/search?' + params, updateUI);
}, 1000); // 1000ms delay

// Add event listener
searchInput.addEventListener('input', fetchDataDebounced);

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    let data = getData();
    let params = new URLSearchParams(data).toString();

    fetchData('/poems/search?' + params, updateUI);

    searchInput.addEventListener('input', fetchDataDebounced);

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();

        let data = getData();
        let params = new URLSearchParams(data).toString();

        fetchData('/poems/search?' + params, updateUI);
    })

    filterButton.addEventListener('click', function() {
        filterDropdown.classList.toggle('hidden');
    });

    filterDropdownOkButton.addEventListener('click', function() {
        filterDropdown.classList.add('hidden');

        let data = getData();
        let params = new URLSearchParams(data).toString();

        fetchData('/poems/search?' + params, updateUI);
    });
});





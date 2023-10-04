<form id="search-form" class="search-bar">
    <input type="text" id="search-input" name="query" placeholder="Search..." class="search-input">

    <!-- Search button -->
    <button id="submit-button" class="submit-button" type="submit">
        <img src="/assets/icons/search.svg" alt="Search">
    </button>

    <!-- Dropdown for genre selection -->
    <div id="genre-select">
        <button type="button" id="genre-button" class="genre-button">
            <img src="/assets/icons/filter.svg" alt="Filter">
        </button>
        <div id="genre-dropdown" class="genre-dropdown hidden">
            <label><input type="checkbox" name="genre" value="Romantic" checked> Romantic</label>
            <label><input type="checkbox" name="genre" value="Sad" checked> Sad</label>
            <label><input type="checkbox" name="genre" value="National" checked> National</label>
            <label><input type="checkbox" name="genre" value="Epic" checked> Epic</label>
            <label><input type="checkbox" name="genre" value="Haiku" checked> Haiku</label>
            <button type="button" id="genre-select-ok-button">OK</button>
        </div>
    </div>


</form>

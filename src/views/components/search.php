<?php
$genres = GENRES;
$yearOptions = array(
    "2020 - 2023" => [2023, 2020],
    "2016-2019" => [2019, 2016],
    "Older than 2016" => [2016]
);
$sortOptions = array(
    "Title A-Z" => "Poems.title ASC",
    "Title Z-A" => "Poems.title DESC",
    "Newest Poem" => "Poems.year DESC",
    "Oldest Poem" => "Poems.year ASC",
    "Newest Uploaded" => "Poems.created_at DESC",
    "Oldest Uploaded" => "Poems.created_at ASC",
);
?>

<form id="search-form" class="search-bar">
    <input type="text" id="search-input" name="query" placeholder="Search..." class="search-input">

    <!-- Search button -->
    <button id="submit-button" class="submit-button" type="submit">
        <img src="/assets/icons/search.svg" alt="Search">
    </button>

    <!-- Dropdown for genre selection -->
    <div id="filter-select">
        <button type="button" id="filter-button" class="filter-button">
            <img src="/assets/icons/filter.svg" alt="Filter">
        </button>

        <div id="filter-dropdown" class="filter-dropdown hidden">
            <div id="genre-dropdown" class="genre-dropdown">
                <h3>Genre</h3>
                <?php foreach($genres as $genre) { ?>
                    <label><input type="checkbox" name="genre" value="<?php echo $genre; ?>" checked> <?php echo $genre; ?></label>
                <?php } ?>
            </div>

            <div class="year-dropdown" id="year-dropdown">
                <h3>Year</h3>
                <select name="year-query" id="year-query">
                    <option value="" selected>None</option>
                    <?php foreach($yearOptions as $option => $value) { ?>
                        <option value="<?php echo json_encode($value); ?>"><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="sort-by-dropdown" id="sort-by-dropdown">
                <h3>Sort By</h3>
                <select name="sort-by" id="sort-by">
                    <option value="" selected>None</option>
                    <?php foreach($sortOptions as $option => $value) { ?>
                        <option value="<?php echo $value; ?>"><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="button" id="filter-dropdown-ok-button">OK</button>
        </div>
    </div>


</form>

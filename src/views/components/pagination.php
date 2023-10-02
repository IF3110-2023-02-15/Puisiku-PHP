<?php

function pagination($currentPage, $pages) {
    $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
    $nextDisabled = $currentPage >= $pages ? 'disabled' : '';

    return '
        <button id="prev-page" ' . $prevDisabled . '><img src="/assets/icons/left-arrow.svg" alt="Previous"></button>
        <span id="page-info" class="page-info" data-current-page="' . $currentPage . '">' . $currentPage . ' of ' . $pages . '</span>
        <button id="next-page" ' . $nextDisabled . '><img src="/assets/icons/right-arrow.svg" alt="Next"></button>
    ';
}


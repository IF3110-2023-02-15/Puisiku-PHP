<?php

function createTable($headers, $data) {
    $table = "<table><thead><tr>";

    // Add table headers
    foreach ($headers as $header) {
        $table .= "<td>{$header}</td>";
    }

    $table .= "</tr></thead><tbody>";

    // Add table data
    foreach ($data as $index => $item) {
        $displayIndex = $index + 1;
        $table .= "
            <tr class='clickable-row' data-href='/poem/{$item['id']}'>
                <td>{$displayIndex}</td>
                <td>{$item['title']}</td>
                <td>{$item['creator_name']}</td>
                <td>{$item['genre']}</td>
                <td>{$item['year']}</td>
            </tr>
        ";
    }

    $table .= "</tbody></table>";

    return $table;
}
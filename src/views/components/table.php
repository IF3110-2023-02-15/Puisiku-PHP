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
            <tr class='clickable-row'>
                <td>{$displayIndex}</td>
                <td>
                    <a href='/poem/{$item['id']}'>
                        {$item['title']}
                    </a>
                </td>
                <td>{$item['creator_name']}</td>
                <td>{$item['genre']}</td>
                <td>{$item['year']}</td>
                <td>
                    <button onclick='deletePlaylistItem({$item['id']})'>
                        Delete
                    </button>
                </td>
            </tr>
        ";
    }

    $table .= "</tbody></table>";

    return $table;
}
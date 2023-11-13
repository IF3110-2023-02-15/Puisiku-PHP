<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium">
    <title>Premium</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/premium/premium.css">
    <link rel="stylesheet" href="/css/premium/creator_avatar.css">
    <link rel="stylesheet" href="/css/premium/subscribe_modal.css">
</head>
<body>
<?php
require_once VIEWS_DIR . 'layouts/layout.php';

ob_start();
include 'view.php';
$content = ob_get_clean();

layout($current_page, $playlists, $role, $display_search, $profile_url, $content);
?>
<script defer src="/js/premium/premium.js"></script>
</body>
</html>
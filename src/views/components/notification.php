<?php
class Notification {
    public static function show($message) {
        $html = '
        <link rel="stylesheet" href="/css/notification.css">
        <div id="notification">
            ' . $message . '
        </div>
        <script src="/js/notification.js"></script>
        ';
        return $html;
    }   
}

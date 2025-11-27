<?php
function debug_log($message) {
    $debug_file = __DIR__ . '/../debug_session.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($debug_file, "[$timestamp] $message\n", FILE_APPEND);
}

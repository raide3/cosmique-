<?php
$request_uri = $_SERVER['REQUEST_URI'];
if (preg_match('/\.txt$/', $request_uri)) {
    header('HTTP/1.0 403 Forbidden');
    exit('Access forbidden.');
}
?>


<?php
    header('Access-Control-Allow-Methods: GET, POST');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');
    session_start();
    require "../vendor/autoload.php";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    new \App\Core\Fetch();
?>
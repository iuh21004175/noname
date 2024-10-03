<?php
    header('Access-Control-Allow-Methods: GET, POST');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');
    session_start();
    require "../vendor/autoload.php";

    new \App\Core\Fetch();
?>
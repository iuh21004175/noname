<?php
    session_start();
    require "./vendor/autoload.php";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    new \App\Core\Web();
?>
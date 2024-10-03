<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
class Database
{
    public function __construct()
    {
        $capsule = new Capsule;

        // Cấu hình kết nối cơ sở dữ liệu
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'cp',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_0900_ai_ci',
            'prefix'    => '',
        ]);

        // Thiết lập Eloquent ORM
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
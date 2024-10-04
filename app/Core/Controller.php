<?php

namespace App\Core;

use eftec\bladeone\BladeOne;
use Illuminate\Database\Capsule\Manager as Capsule;

class Controller
{
    protected $capsule;

    public function __construct()
    {
        // Khởi tạo Capsule (Eloquent ORM)
        $this->capsule = new Capsule;

        // Cấu hình kết nối cơ sở dữ liệu
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'chipheo',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_0900_ai_ci',
            'prefix'    => '',
        ]);

        // Thiết lập Eloquent ORM
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    protected function view($page, $data = [])
    {
        $dirView = "./app/Views";
        $dirCache = "./app/Cache";
        $blade = new BladeOne($dirView, $dirCache, BladeOne::MODE_AUTO);
        return $blade->run($page, $data);
    }
}

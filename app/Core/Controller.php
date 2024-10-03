<?php

namespace App\Core;

use eftec\bladeone\BladeOne;


class Controller
{
    protected function view($page, $data = [])
    {
        $dirView = "./app/Views";
        $dirCache = "./app/Cache";
        $blade = new BladeOne($dirView, $dirCache, BladeOne::MODE_AUTO);
        return $blade->run($page, $data);
    }
}
<?php

namespace App\Controllers;

use App\Core\Controller;

class CtrlTrangChu extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->kiemTraToken();
    }

    public function index()
    {
        return $this->view('Pages.TrangChu');
    }
}
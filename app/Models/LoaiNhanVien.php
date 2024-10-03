<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiNhanVien extends Model
{
    protected $table = 'loainhanvien';
    protected $primaryKey = 'MaLoaiNhanVien';
    public $timestamps = false;
}
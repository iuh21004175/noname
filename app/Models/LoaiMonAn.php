<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiMonAn extends Model
{
    protected $table = 'loaimonan';
    protected $primaryKey = 'MaLoaiMonAn';
    public $timestamps = false;
}
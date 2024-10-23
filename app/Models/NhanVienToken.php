<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVienToken extends Model
{
    protected $table = 'nhanvien_token';
    protected $primaryKey = 'MaNhanVien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MaNhanVien',
        'Token',
        'HoatDongCuoi'
    ];
    public $timestamps = false;
}
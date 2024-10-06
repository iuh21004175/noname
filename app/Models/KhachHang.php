<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khachhang';
    protected $primaryKey = 'MaKhachHang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'TenKhachHang',
        'GioiTinh',
        'DiaChi',
        'SoDienThoai',
        'TichDiem',
        'MaNhanVien',
        'TrangThai'
    ];
    public $timestamps = false;
}
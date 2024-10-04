<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien';
    protected $primaryKey = 'MaNhanVien';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'TenNhanVien',
        'NgaySinh',
        'DiaChi',
        'SoDienThoai',
        'Email',
        'MatKhau',
        'GhiChu',
        'HinhAnh',
        'MaLoaiNhanVien',
        'TrangThai',
        'TrangThaiHoatDong'
    ];
    public $timestamps = false;
}
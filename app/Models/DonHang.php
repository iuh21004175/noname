<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'donhang';
    protected $primaryKey = 'MaDonHang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'NgayLap',
        'MaKhachHang',
        'TichDiemSuDung',
        'MaNhanVien',
        'MaKhuyenMai',
        'TongTien',
        'TrangThai'
    ];
    public $timestamps = false;
}
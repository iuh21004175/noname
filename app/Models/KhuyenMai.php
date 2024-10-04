<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyenmai';
    protected $primaryKey = 'MaKhuyenMai';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['ChuDe', 'MoTa', 'PhanTram', 'DieuKien', 'BatDau', 'KetThuc', 'MaNhanVien', 'TrangThai'];
    public $timestamps = false;
}
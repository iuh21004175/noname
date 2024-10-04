<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoAnUong extends Model
{
    protected $table = 'doanuong';
    protected $primaryKey = 'MaDoAnUong';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'Ten',
        'Gia',
        'DonVi',
        'MoTa',
        'Loai',
        'TrangThai'
    ];
    public $timestamps = false;
}
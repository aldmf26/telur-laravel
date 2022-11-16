<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telur extends Model
{
    use HasFactory;
    protected $table = 'tb_penjualan_telur';
    protected $guarded = [];
}

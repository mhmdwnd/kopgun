<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    use HasFactory;

    protected $fillable =[
    	'nama_produk',
    	'harga',
    	'detail_spesifik',
    	'foto',
    ];
}

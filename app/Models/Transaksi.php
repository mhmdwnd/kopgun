<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['nama_pelanggan', 'nomor_meja', 'total_pembayaran', 'metode_pembayaran', 'items'];

    protected $casts =['items' => 'array',];
}

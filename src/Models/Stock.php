<?php

namespace Uiaciel\Corporation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kode_saham',
        'harga',
        'perubahan',
        'waktu_perubahan',
        'pembukaan',
        'penutupan_sebelumnya',
        'offer',
        'bid',
        'harga_terendah',
        'harga_tertinggi',
        'volume',
        'nilai_transaksi',
        'frekuensi',
        'eps',
        'pe_ratio',
        'market_cap',
        'peringkat_industri',
        'perungkat_semua_perusahaan'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table="pengembalians";
    protected $fillable = [
        'peminjaman_id',
        'jumlah_dikembalikan',
        'tanggal_kembali',
    ];
    public $timestamps = true;

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
    
}

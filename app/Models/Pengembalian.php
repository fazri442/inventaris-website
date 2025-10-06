<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table="pengembalians";
    protected $fillable = [
        'id',
        'kode_barang',
        'jumlah',
        'tanggal_kembali',
        'nama_peminjam',
        'status',
        'id_pinjam',
        'id_barang',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_barang');
    }
    public function peminjam(){
        return $this->belongsTo(Peminjaman::class, 'id_barang');
    }
}

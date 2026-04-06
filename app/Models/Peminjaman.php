<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table="peminjamans";
    protected $fillable = [
        'id',
        'kode_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'id_tim',
        'id_tool',
        'jumlah',
        'status',
    ];
    public $timestamps = true;

    public function datapusat(){
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }
    public function tim(){
        return $this->belongsTo(Tim::class, 'id_tim');
    }
    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjam');
    }
}

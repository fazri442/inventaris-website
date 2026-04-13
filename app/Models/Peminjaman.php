<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table="peminjamans";
    protected $fillable = [
         'kode_pinjam',
        'id_tim',
        'id_tool',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'status',
    ];
    public $timestamps = true;

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim');
    }

    public function datapusat()
    {
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}

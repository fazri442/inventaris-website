<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table="barangmasuks";
    protected $fillable = [
        'id',
        'kode_barang',
        'jumlah',
        'tanggal_masuk',
        'keterangan',
        'id_barang',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_barang');
    }
}

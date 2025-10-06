<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangkeluar extends Model
{
    use HasFactory;
    protected $table="barangkeluars";
    protected $fillable = [
        'id',
        'kode_barang',
        'jumlah',
        'tanggal_keluar',
        'keterangan',
        'id_barang',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_barang');
    }
}

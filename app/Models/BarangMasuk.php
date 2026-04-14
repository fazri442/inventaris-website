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
        'kode_tool',
        'nama_tim',
        'jumlah',
        'tanggal_masuk',
        'keterangan',
        'lokasi',
        'id_tool',
    ];
    protected $casts = [
        'tanggal_masuk' => 'date',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }
    public function tim(){
        return $this->belongsTo(Tim::class, 'nama_tim');
    }
}

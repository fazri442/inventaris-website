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
        'kode_tool',
        'nama_tim',
        'jumlah',
        'tanggal_keluar',
        'keterangan',
        'lokasi',
        'id_tool',
    ];
    protected $casts = [
        'tanggal_keluar' => 'date',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }

    public function tim(){
        return $this->belongsTo(Tim::class, 'nama_tim');
    }
}

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
        'kode_tool',
        'jumlah',
        'tanggal_kembali',
        'status',
        'id_tim',
        'id_tool',
    ];
    public $timestamps = true;

    public function pusat(){
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }
    public function tim(){
        return $this->belongsTo(Tim::class, 'id_tim');
    }
}

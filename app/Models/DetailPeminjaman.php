<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table="detail_peminjamans";
    protected $guarded = [];

    public $timestamps = true;

    public function tool(){
        return $this->belongsTo(Datapusat::class, 'id_tool');
    }

    public function peminjaman(){
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}

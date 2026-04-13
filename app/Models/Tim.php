<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    protected $table="tims";
    protected $fillable = [
        'kode_tim',
        'nama_anggota_tim',
        'lokasi_tim',
        'pemimpin_tim',
        'kontak_tim',
    ];
    public $timestamps = true;

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_tim');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangMasuk;
use App\Models\Peminjaman;
use App\Models\Barangkeluar;
use App\Models\Pengembalian;

class Datapusat extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'kode_barang', 'nama', 'merk', 'foto', 'stok'];
    public $timestamp = true;

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'id');  
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_barang', 'id');
    }

    public function pengembalians()
    {
        return $this->hasMany(Pengembalian::class);
    }

    public function deleteImage(){
        if($this->foto && file_exists(public_path('image/dp_foto'. $this->foto))){
            return unlink(public_path('image/dp_foto'. $this->foto));
        }
    }
}

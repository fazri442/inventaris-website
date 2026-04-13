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
    protected $fillable = ['id', 'kode_tool', 'nama_tool', 'foto', 'stok', 'deskripsi', 'lokasi'];
    public $timestamp = true;

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'id_tool', 'id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'id_tool', 'id');  
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_tool');
    }

    public function pengembalians()
    {
        return $this->hasMany(Pengembalian::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_tool', 'id');
    }

    public function deleteImage(){
        if($this->foto && file_exists(public_path('image/dp_foto'. $this->foto))){
            return unlink(public_path('image/dp_foto'. $this->foto));
        }
    }
}

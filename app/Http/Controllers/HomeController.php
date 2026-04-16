<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $barang = \App\Models\Datapusat::latest()->take(5)->get();
    $datapusat = \App\Models\Datapusat::all();
    $totalPeminjamanGlobal = \App\Models\Peminjaman::count();
    
    // Ambil semua tim dengan hitungan relasi
    $timStats = \App\Models\Tim::withCount([
        'peminjaman',
        'peminjaman as pengembalian_count' => function ($query) {
            $query->where('status', 'dikembalikan');
        }
    ])
    ->get()
    ->map(function($tim) use ($totalPeminjamanGlobal) {

        // ✅ ambil value yang benar
        $totalPinjam = $tim->peminjamans_count;
        $totalKembali = $tim->pengembalian_count;

        // 📊 Persentase terhadap global
        $persenPinjam = $totalPeminjamanGlobal > 0 
            ? ($totalPinjam / $totalPeminjamanGlobal) * 100 
            : 0;

        // 📊 Rasio pengembalian per tim
        $rasioKembali = $totalPinjam > 0 
            ? ($totalKembali / $totalPinjam) * 100 
            : 0;

        return [
            'nama' => $tim->nama_anggota_tim,
            'total_pinjam' => $totalPinjam,
            'total_kembali' => $totalKembali,
            'persen_pinjam' => round($persenPinjam, 1),
            'persen_kembali' => round($rasioKembali, 1),
        ];
    })
    ->sortByDesc('total_pinjam')
    ->take(5)
    ->values(); // biar index rapi

    return view('home', compact('barang', 'timStats', 'datapusat'));
}
}

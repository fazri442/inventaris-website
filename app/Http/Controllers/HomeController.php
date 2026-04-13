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
    $totalPeminjamanGlobal = \App\Models\Peminjaman::count();
    
    // Ambil semua tim dengan hitungan relasi
    $timStats = \App\Models\Tim::withCount(['peminjaman', 'pengembalian'])
                ->get()
                ->map(function($tim) use ($totalPeminjamanGlobal) {
                    // Persentase peminjaman tim terhadap total peminjaman global
                    $persenPinjam = $totalPeminjamanGlobal > 0 ? ($tim->peminjaman_count / $totalPeminjamanGlobal) * 100 : 0;
                    
                    // Rasio pengembalian tim itu sendiri (berapa yang sudah balik dari yang mereka pinjam)
                    // Jika pinjam 10, balik 10, maka 100%
                    $rasioKembali = $tim->peminjaman_count > 0 ? ($tim->pengembalian_count / $tim->peminjaman_count) * 100 : 0;

                    return [
                        'nama' => $tim->nama_anggota_tim,
                        'total_pinjam' => $tim->peminjaman_count,
                        'total_kembali' => $tim->pengembalian_count,
                        'persen_pinjam' => round($persenPinjam, 1),
                        'persen_kembali' => round($rasioKembali, 1),
                    ];
                })->sortByDesc('total_pinjam')->take(5);

    return view('home', compact('barang', 'timStats'));
}
}

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="relative bg-blue-600 rounded-[2.5rem] p-10 overflow-hidden shadow-2xl shadow-blue-200">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Halo, Selamat Datang! 👋</h1>
            <p class="text-blue-100 max-w-md">Sistem inventaris siap digunakan. Anda memiliki {{ \App\Models\Peminjaman::whereDate('created_at', today())->count() }} laporan peminjaman baru hari ini.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Stok Barang Masuk</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\BarangMasuk::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-hand-holding-dots"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Peminjaman</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\Peminjaman::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Belum Kembali</p>
                    {{-- Asumsi: kamu punya kolom 'status' di tabel peminjaman --}}
                    <h3 class="text-2xl font-bold">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h3>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
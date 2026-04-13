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
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
    
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 flex items-center justify-between border-b border-slate-50">
            <h3 class="text-xl font-bold text-slate-800">Inventaris Terbaru</h3>
            <a href="{{ route('datapusat.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Barang</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($barang as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" class="w-10 h-10 rounded-xl object-cover">
                                @else
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-image text-xs"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $item->nama_tool }}</p>
                                    <p class="text-[11px] text-slate-400 tracking-tight">{{ $item->kode_tool }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 {{ $item->stok > 5 ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' }} rounded-lg text-xs font-bold">
                                {{ $item->stok }} Unit
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2 text-slate-500">
                                <i class="fa-solid fa-location-dot text-[10px]"></i>
                                <span class="text-xs font-medium">{{ $item->lokasi }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-800">Aktivitas Tim</h3>
        <div class="flex gap-3">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Pinjam</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Kembali</span>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        @foreach($timStats as $stat)
        <div class="space-y-3">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-sm font-bold text-slate-700">{{ $stat['nama'] }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">
                        {{ $stat['total_pinjam'] }} Pinjam • {{ $stat['total_kembali'] }} Kembali
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-black {{ $stat['persen_kembali'] < 100 ? 'text-amber-500' : 'text-emerald-600' }}">
                        {{ $stat['persen_kembali'] }}% Teratasi
                    </span>
                </div>
            </div>

            <div class="space-y-1.5">
                <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: {{ $stat['persen_pinjam'] }}%"></div>
                </div>
                <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $stat['persen_kembali'] }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 p-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
        <p class="text-[11px] text-slate-500 text-center leading-relaxed">
            Indikator <span class="text-emerald-600 font-bold">Teratasi</span> menunjukkan persentase barang yang sudah dikembalikan oleh tim dibandingkan dengan jumlah yang dipinjam.
        </p>
    </div>
</div>

</div>
@endsection
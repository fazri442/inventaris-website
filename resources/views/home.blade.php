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
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Informasi Tool</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($datapusat as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        {{-- KOLOM 1: INFO TOOL (FOTO + NAMA) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200/50">
                                    @if($item->foto && file_exists(public_path('images/dp_foto/' . $item->foto)))
                                        <img src="{{ asset('images/dp_foto/' . $item->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-toolbox text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 leading-tight">{{ $item->nama_tool }}</h3>
                                    <p class="text-[10px] font-mono text-slate-400 uppercase tracking-tighter">{{ $item->kode_tool }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- KOLOM 2: LOKASI --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-slate-600">
                                <i class="fa-solid fa-location-dot text-[10px] text-blue-500"></i>
                                <span class="text-sm font-medium">{{ $item->lokasi }}</span>
                            </div>
                        </td>

                        {{-- KOLOM 3: AKSI --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('datapusat.edit', $item->id) }}" class="p-2 text-slate-400 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>
                                <form action="{{ route('datapusat.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus data ini?')" class="p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-all">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 font-medium">
                            <i class="fa-solid fa-box-open block text-3xl mb-3 opacity-20"></i>
                            Data barang masih kosong.
                        </td>
                    </tr>
                    @endforelse
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
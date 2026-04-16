@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Master Data Barang</h1>
            <p class="text-sm text-slate-500">Kelola informasi alat, stok pusat, dan lokasi penyimpanan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('barang.export') }}" class="flex items-center gap-2 px-5 py-2.5 bg-rose-50 text-rose-600 rounded-2xl font-semibold hover:bg-rose-100 transition-all border border-rose-100 text-sm">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('datapusat.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all text-sm">
                <i class="fa-solid fa-plus"></i> Tambah Barang
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Informasi Tool</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Stok</th>
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

                        {{-- KOLOM 3: STOK --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold">{{ $item->stok }} Unit</span>
                        </td>

                        {{-- KOLOM 4: AKSI --}}
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
</div>
@endsection
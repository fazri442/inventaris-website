@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Barang Keluar</h1>
            <p class="text-sm text-slate-500">Pantau pengeluaran inventaris dan distribusi barang secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('barangkeluar.export') }}" target="_blank" 
               class="flex items-center gap-2 px-5 py-2.5 bg-rose-50 text-rose-600 rounded-2xl font-semibold hover:bg-rose-100 transition-all border border-rose-100">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Cetak Laporan</span>
            </a>
            <a href="{{ route('barangkeluar.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                <i class="fa-solid fa-minus text-sm"></i>
                <span>Catat Barang Keluar</span>
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Tool</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tujuan/Tim</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Keluar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Keluar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php $no = 1; @endphp
                    @forelse ($keluar as $data)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $no++ }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900">{{ $data->pusat->nama_tool }}</span>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <i class="fa-solid fa-tag text-[10px] text-slate-300"></i>
                                    <span class="text-[11px] text-slate-400 leading-none">{{ $data->keterangan ?? 'Tanpa alasan/catatan' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold">
                                <i class="fa-solid fa-truck-fast mr-1 text-[10px]"></i>
                                {{ $data->tim->nama_anggota_tim }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-rose-600">-{{ $data->jumlah }}</span>
                                <span class="text-xs text-slate-400 italic font-medium">Unit</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar text-slate-300"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_keluar)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('barangkeluar.edit', $data->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-500 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all"
                                   title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>
                                
                                <form action="{{ route('barangkeluar.destroy', $data->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Hapus catatan barang keluar ini?')"
                                            class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-500 rounded-xl hover:bg-rose-50 hover:text-rose-600 transition-all"
                                            title="Hapus Data">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-truck-ramp-box text-3xl text-slate-200"></i>
                                </div>
                                <p class="text-slate-900 font-bold">Belum Ada Barang Keluar</p>
                                <p class="text-slate-400 text-sm mt-1">Semua aktivitas pengeluaran barang akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
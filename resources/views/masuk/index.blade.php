@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Barang Masuk</h1>
            <p class="text-sm text-slate-500 text-sm">Kelola dan pantau seluruh riwayat barang yang masuk ke inventaris.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('barangmasuk.export') }}" target="_blank" 
               class="flex items-center gap-2 px-5 py-2.5 bg-rose-50 text-rose-600 rounded-2xl font-semibold hover:bg-rose-100 transition-all border border-rose-100">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Buat PDF</span>
            </a>
            <a href="{{ route('barangmasuk.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Tambah Data</span>
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
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Tool</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Tim</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Masuk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php $no = 1; @endphp
                    @forelse ($masuk as $data)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $no++ }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900">{{ $data->pusat->nama_tool }}</span>
                                <span class="text-[11px] text-slate-400 italic">{{ $data->keterangan ?? 'Tanpa keterangan' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                {{ $data->nama_tim }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-700">
                            {{ $data->jumlah }} <span class="text-xs font-normal text-slate-400 ml-1 italic">Unit</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($data->tanggal_masuk)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i class="fa-solid fa-location-dot text-slate-300"></i>
                                {{ $data->lokasi }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('barangmasuk.edit', $data->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-all"
                                   title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>
                                
                                <form action="{{ route('barangmasuk.destroy', $data->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                            class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-all"
                                            title="Hapus Data">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-box-open text-4xl text-slate-200 mb-3"></i>
                                <p class="text-slate-400 text-sm">Belum ada data barang masuk.</p>
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
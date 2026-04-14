@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Riwayat Pengembalian</h1>
        <p class="text-sm text-slate-500">Daftar barang yang telah dikembalikan ke gudang/inventaris.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-emerald-500 p-6 rounded-[2rem] text-white flex items-center justify-between shadow-lg shadow-emerald-100">
            <div>
                <p class="text-emerald-100 text-xs font-medium uppercase tracking-widest">Total Selesai</p>
                <h3 class="text-3xl font-bold">{{ $pengembalian->count() }}</h3>
            </div>
            <i class="fa-solid fa-circle-check text-4xl opacity-20"></i>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-widest">Terakhir Kembali</p>
                <h3 class="text-xl font-bold text-slate-700">
                    {{ $pengembalian->last()->nama_tool ?? '-' }}
                </h3>
            </div>
            <i class="fa-solid fa-clock-rotate-left text-4xl text-slate-100"></i>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Detail Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php $no = 1; @endphp
                    @forelse ($pengembalian as $data)
                    <tr class="group transition-colors hover:bg-slate-50/50">
                        <td class="px-6 py-4 text-sm text-slate-400">{{ $no++ }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $data->peminjaman->datapusat->nama_tool }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $data->peminjaman->tim->nama_anggota_tim ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 italic">{{ $data->keterangan ?? 'Baik' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100 shadow-sm shadow-emerald-50">
                                    <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                                    <span class="text-[10px] font-bold uppercase tracking-tighter">Verified</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <i class="fa-solid fa-clipboard-check text-4xl text-slate-100 mb-3 block"></i>
                            <p class="text-slate-400 text-sm italic">Belum ada riwayat pengembalian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
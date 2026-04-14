@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Peminjaman Tool</h1>
            <p class="text-sm text-slate-500">Kelola peminjaman barang dan pantau tenggat waktu pengembalian.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('peminjaman.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                <i class="fa-solid fa-hand-holding-hand text-sm"></i>
                <span>Tambah Peminjaman</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Peminjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Barang & Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php $no = 1; @endphp
                    @forelse ($peminjaman as $data)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $no++ }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900">{{ $data->tim->nama_anggota_tim }}</span>
                                <span class="text-[11px] text-slate-400">{{ $data->kode_pinjam }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-slate-700 font-medium">{{ $data->datapusat->nama_tool }}</span>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $data->jumlah }}x</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($data->status == 'dipinjam')
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[11px] font-bold border border-amber-100 uppercase tracking-tighter">
                                Dipinjam
                            </span>
                            @else
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-bold border border-emerald-100 uppercase tracking-tighter">
                                Kembali
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">

                            {{-- ✅ Tombol Kembalikan --}}
                            @if($data->status == 'dipinjam')
                            <form action="{{ route('pengembalian.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="peminjaman_id" value="{{ $data->id }}">
                                <button type="submit"
                                    onclick="return confirm('Kembalikan barang ini?')"
                                    class="w-32 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all">
                                    Kembalikan<i class="fa-solid fa-rotate-left text-[12px]"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('peminjaman.edit', $data->id) }}"
                            class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fa-solid fa-pen-to-square text-[12px]"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('peminjaman.destroy', $data->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus data?')"
                                    class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 rounded-lg hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash text-[12px]"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic text-sm">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
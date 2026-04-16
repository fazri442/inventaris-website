@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10 px-4 pt-6 space-y-8">
    
    <div class="flex items-center gap-5 p-3 bg-white border border-slate-100 rounded-full shadow-sm">
        <a href="{{ route('barangkeluar.index') }}" class="w-12 h-12 flex items-center justify-center bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-full transition-all border border-slate-200 hover:border-rose-100 shadow-inner">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-950">Perbarui Catatan Keluar</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold ml-0.5">
                Logistik ID: <span class="font-bold text-rose-600">BK-{{ $barangkeluar->id }}</span>
            </p>
        </div>
        @if (session('error'))
            <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/30 overflow-hidden">
            <div class="p-8 md:p-10">
                <form action="{{ route('barangkeluar.update', $barangkeluar->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="p-4 mb-6 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm">
                            <div class="flex items-center gap-2.5 font-bold mb-1.5">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Terjadi Kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside text-rose-500 opacity-90 space-y-0.5 ml-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Barang yang Keluar</label>
                            <div class="relative">
                                <select name="id_tool" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                    <option value="" disabled>-- Pilih Barang --</option>
                                    @foreach ($pusat as $data)
                                        <option value="{{ $data->id }}" {{ old('id_tool', $barangkeluar->id_tool) == $data->id ? 'selected' : '' }}>
                                            {{ $data->nama_tool }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tujuan / Nama Tim</label>
                            <div class="relative">
                                <select name="nama_tim" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                    <option value="" disabled>-- Pilih Tim --</option>
                                    @foreach ($tim as $data)
                                        <option value="{{ $data->id }}" {{ old('nama_tim', $barangkeluar->nama_tim) == $data->id ? 'selected' : '' }}>
                                            {{ $data->nama_anggota_tim }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Jumlah Keluar</label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', $barangkeluar->jumlah) }}" placeholder="0" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none font-bold text-lg text-slate-950">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tanggal Keluar</label>
                                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', \Carbon\Carbon::parse($barangkeluar->tanggal_keluar)->format('Y-m-d')) }}" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none font-medium text-slate-900">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Lokasi Penempatan</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $barangkeluar->lokasi) }}" placeholder="Contoh: Area Proyek A" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none font-medium text-slate-900">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Catatan/Keterangan</label>
                            <textarea name="keterangan" rows="3" placeholder="Tambahkan alasan pengeluaran barang..." class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-rose-500 transition-all outline-none font-medium text-slate-900 resize-none">{{ old('keterangan', $barangkeluar->keterangan) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-end">
                        <button type="submit" class="px-10 py-3.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-extrabold shadow-lg shadow-rose-200 transition-all flex items-center gap-2 active:scale-95">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-5 lg:mt-0 mt-2">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="fa-solid fa-history text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900">Data Sebelumnya</h3>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl border border-slate-100/50">
                    <span class="text-slate-400 font-medium text-xs">Item:</span>
                    <span class="font-semibold text-slate-900 truncate max-w-[140px] text-right">{{ $barangkeluar->tool->nama_tool ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl border border-slate-100/50">
                    <span class="text-slate-400 font-medium text-xs">Tim Asli:</span>
                    <span class="font-semibold text-slate-900 text-right">{{ $barangkeluar->tim->nama_anggota_tim ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl border border-slate-100/50">
                    <span class="text-slate-400 font-medium text-xs">Jumlah Keluar:</span>
                    <span class="font-bold text-slate-950">{{ $barangkeluar->jumlah }} <span class="text-[10px] text-slate-400 font-normal">UNIT</span></span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl border border-slate-100/50">
                    <span class="text-slate-400 font-medium text-xs">Tgl Keluar:</span>
                    <span class="font-semibold text-slate-900 text-right">{{ \Carbon\Carbon::parse($barangkeluar->tanggal_keluar)->format('d/m/Y') }}</span>
                </div>
            </div>
            
            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
                <div class="flex gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                    <p class="text-[11px] text-amber-700 leading-relaxed font-medium">
                        Pastikan tim penerima sudah sesuai dengan surat jalan logistik untuk menghindari selisih stok.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
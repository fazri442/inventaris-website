@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10 space-y-8">
    
    <div class="flex items-center gap-5 p-3 bg-white border border-slate-100 rounded-full shadow-sm">
        <a href="{{ route('peminjaman.index') }}" class="w-12 h-12 flex items-center justify-center bg-slate-100 hover:bg-amber-50 text-slate-400 hover:text-amber-600 rounded-full transition-all border border-slate-200 hover:border-amber-100 shadow-inner">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-950">Edit Data Pinjaman</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold ml-0.5">ID Pinjam: <span class="font-bold text-amber-600">#TRX-{{ $peminjaman->id }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/30 overflow-hidden">
            <div class="p-8 md:p-10">
                <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if(session('error'))
    <div class="p-4 mb-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm">
        {{ session('error') }}
    </div>
@endif


                    @if ($errors->any())
                        <div class="p-4 mb-6 bg-amber-50 border border-amber-100 rounded-2xl text-amber-700 text-sm">
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tim Peminjam</label>
                            <select name="id_tim" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                @foreach ($tim as $data)
                                    <option value="{{ $data->id }}" {{ old('id_tim', $peminjaman->id_tim) == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_anggota_tim }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Barang yang Dipinjam</label>
                            <select name="id_tool" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                @foreach ($datapusat as $data)
                                    <option value="{{ $data->id }}" {{ old('id_tool', $peminjaman->id_tool) == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_tool }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Jumlah</label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', $peminjaman->jumlah) }}" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none font-bold text-lg text-slate-950">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Rencana Kembali</label>
                                <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali', \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('Y-m-d')) }}" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none font-medium text-slate-900">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-end">
                        <button type="submit" class="px-10 py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-extrabold shadow-lg shadow-amber-200 transition-all flex items-center gap-2 active:scale-95">
                            <i class="fa-solid fa-check-double text-xs"></i>
                            Update Data Pinjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-5">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900">Riwayat Pinjam</h3>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="p-3 bg-slate-50 rounded-xl">
                    <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Tanggal Pinjam:</p>
                    <p class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl">
                    <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Status Saat Ini:</p>
                    <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold">SEDANG DIPINJAM</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
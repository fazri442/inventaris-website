@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white/50 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-100">
                <i class="fa-solid fa-hand-holding-box text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800">Form Peminjaman</h1>
                <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Pustakawan / Inventaris</p>
            </div>
        </div>
        @if (session('error'))
            <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif
        <a href="{{ route('peminjaman.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <i class="fa-solid fa-arrow-rotate-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
                @csrf

                @if ($errors->any())
                    <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-xl text-amber-700 text-sm">
                        <p class="font-bold mb-1">Periksa kembali data pinjaman:</p>
                        <ul class="list-disc list-inside opacity-80">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Siapa yang Pinjam? (Tim)</label>
                            <select name="id_tim" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none appearance-none font-medium text-slate-700">
                                <option disabled selected>-- Pilih Tim --</option>
                                @foreach ($tim as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_anggota_tim }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Barang yang Dipinjam</label>
                            <select name="id_tool" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none appearance-none font-medium text-slate-700">
                                <option disabled selected>-- Pilih Barang --</option>
                                @foreach ($datapusat as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_tool }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Kuantitas Pinjam</label>
                            <input type="number" name="jumlah" placeholder="0" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none font-bold text-lg text-amber-600">
                        </div>
                        <div class="space-y-2 opacity-60">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tanggal Pinjam (Hari Ini)</label>
                            <input type="text" value="{{ now()->format('d F Y') }}" class="w-full px-5 py-4 bg-slate-100 border-2 border-slate-100 rounded-2xl cursor-not-allowed font-medium text-slate-500" readonly>
                            <input type="hidden" name="tanggal_pinjam" value="{{ now() }}">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Kapan Rencana Dikembalikan?</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-calendar-check"></i></span>
                            <input type="date" name="tanggal_rencana_kembali" class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-amber-500 transition-all outline-none font-medium text-slate-700">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 ml-2">*Mohon kembalikan tepat waktu agar bisa digunakan tim lain.</p>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-amber-500 hover:bg-amber-600 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-amber-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <i class="fa-solid fa-key text-sm"></i> Berikan Izin Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
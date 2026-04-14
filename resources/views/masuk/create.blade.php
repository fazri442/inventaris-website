@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white/50 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                <i class="fa-solid fa-box-open text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800">Tambah Barang Masuk</h1>
                <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Logistik & Inventaris</p>
            </div>
        </div>
        <a href="{{ route('barangmasuk.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            <i class="fa-solid fa-arrow-rotate-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm">
                        <p class="font-bold mb-1">Mohon periksa kembali:</p>
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
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Pilih Item Barang</label>
                            <select name="id_tool" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none appearance-none font-medium text-slate-700">
                                <option disabled selected>-- Cari Item --</option>
                                @foreach ($datapusat as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_tool }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tim Penerima</label>
                            <select name="nama_tim" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none appearance-none font-medium text-slate-700">
                                <option disabled selected>-- Pilih Tim --</option>
                                @foreach ($tim as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_anggota_tim }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Jumlah (Qty)</label>
                            <input type="number" name="jumlah" placeholder="0" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-lg">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Lokasi Penyimpanan</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-location-dot"></i></span>
                            <input type="text" name="lokasi" placeholder="Contoh: Gudang A, Rak 02" class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" placeholder="Tulis catatan di sini..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-indigo-500 transition-all outline-none font-medium"></textarea>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-indigo-200 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <i class="fa-solid fa-paper-plane"></i> Simpan Data Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
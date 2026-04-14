@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10 space-y-8">
    
    <div class="flex items-center gap-5 p-3 bg-white border border-slate-100 rounded-full shadow-sm">
        <a href="{{ route('barangmasuk.index') }}" class="w-12 h-12 flex items-center justify-center bg-slate-100 hover:bg-blue-50 text-slate-400 hover:text-blue-600 rounded-full transition-all border border-slate-200 hover:border-blue-100 shadow-inner">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-950">Perbarui Catatan Masuk</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold ml-0.5">Logistik ID: <span class="font-bold text-blue-600">BM-{{ $barangmasuk->id }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/30 overflow-hidden">
            <div class="p-8 md:p-10">
                <form action="{{ route('barangmasuk.update', $barangmasuk->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="p-4 mb-6 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm">
                            <div class="flex items-center gap-2.5 font-bold mb-1.5">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Perhatian:</span>
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
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Barang yang Masuk</label>
                            <select name="id_tool" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                @foreach ($datapusat as $data)
                                    <option value="{{ $data->id }}" {{ old('id_tool', $barangmasuk->id_tool) == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_tool }}
                                    </a>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tim Penerima</label>
                            <select name="nama_tim" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none font-semibold text-slate-900">
                                @foreach ($tim as $data)
                                    <option value="{{ $data->id }}" {{ old('nama_tim', $barangmasuk->nama_tim) == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_anggota_tim }}
                                    </a>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Jumlah</label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', $barangmasuk->jumlah) }}" placeholder="0" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-lg text-slate-950">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($barangmasuk->tanggal_masuk)->format('Y-m-d')) }}" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-medium text-slate-900">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Lokasi Gudang/Rak</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $barangmasuk->lokasi) }}" placeholder="Contoh: Rak B-01" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-medium text-slate-900">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase ml-2">Catatan/Keterangan</label>
                            <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan khusus..." class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-medium text-slate-900 resize-none">{{ old('keterangan', $barangmasuk->keterangan) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-end gap-3">
                        <button type="submit" class="px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-extrabold shadow-lg shadow-blue-200 transition-all flex items-center gap-2 active:scale-95">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            Terapkan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-5 lg:mt-0 mt-8">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                    <i class="fa-solid fa-info-circle text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900">Ringkasan Data Lama</h3>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl">
                    <span class="text-slate-400 font-medium">Item Sebelumnya:</span>
                    <span class="font-semibold text-slate-900 truncate max-w-[150px]">{{ $barangmasuk->pusat->nama_tool }}</span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl">
                    <span class="text-slate-400 font-medium">Tim Penerima:</span>
                    <span class="font-semibold text-slate-900 truncate max-w-[150px]">{{ $barangmasuk->tim->nama_anggota_tim }}</span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl">
                    <span class="text-slate-400 font-medium">Jumlah Awal:</span>
                    <span class="font-bold text-lg text-slate-950">{{ $barangmasuk->jumlah }} <span class="text-xs text-slate-400 font-normal">Unit</span></span>
                </div>
                <div class="flex items-center justify-between gap-2 p-3 bg-slate-50 rounded-xl">
                    <span class="text-slate-400 font-medium">Tanggal Input:</span>
                    <span class="font-semibold text-slate-900">{{ $barangmasuk->tanggal_masuk->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-400 font-medium">
                Data di atas adalah data asli sebelum diubah.
            </div>
        </div>
    </div>
</div>
@endsection
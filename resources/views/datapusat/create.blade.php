@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Tambah Data Barang</h1>
            <p class="text-sm text-slate-500">Daftarkan alat atau stok baru ke dalam sistem InvenTool.</p>
        </div>
        <div>
            <a href="{{ route('datapusat.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-600 rounded-2xl font-semibold hover:bg-slate-200 transition-all text-sm border border-slate-200">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden p-8">
        <form action="{{ route('datapusat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm">
                    <ul class="list-disc list-inside font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Nama Tool / Barang</label>
                        <input type="text" name="nama_tool" placeholder="Contoh: Bor Listrik Makita" required
                               class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="5" placeholder="Tuliskan spesifikasi atau kondisi barang..."
                                  class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Foto Barang</label>
                        <div class="relative group">
                            <input type="file" name="foto" 
                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-2 group-hover:border-blue-300 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Jumlah Stok</label>
                            <input type="number" name="stok" placeholder="0"
                                   class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Lokasi Penyimpanan</label>
                            <input type="text" name="lokasi" placeholder="Contoh: Rak B-1"
                                   class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-50 flex items-center justify-end gap-3">
                <button type="reset" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                    Reset Data Form
                </button>
                <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95">
                    <i class="fa-solid fa-check"></i> Simpan Data Form
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
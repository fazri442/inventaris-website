@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tim.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-100 transition-all">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Data Tim</h1>
            <p class="text-sm text-slate-500">Perbarui informasi untuk: <span class="font-bold text-blue-600">{{ $tim->nama_anggota_tim }}</span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="{{ route('tim.update', $tim->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="p-4 mb-6 bg-rose-50 border border-rose-100 rounded-2xl">
                        <div class="flex items-center gap-3 mb-2 text-rose-600">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span class="font-bold text-sm">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs text-rose-500 space-y-1 ml-7">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Anggota/Tim</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-users text-sm"></i>
                            </div>
                            <input type="text" name="nama_anggota_tim" value="{{ old('nama_anggota_tim', $tim->nama_anggota_tim) }}" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-blue-400 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Pemimpin Tim</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-user-tie text-sm"></i>
                            </div>
                            <input type="text" name="pemimpin_tim" value="{{ old('pemimpin_tim', $tim->pemimpin_tim) }}" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-blue-400 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Lokasi Kerja</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-map-location-dot text-sm"></i>
                            </div>
                            <input type="text" name="lokasi_tim" value="{{ old('lokasi_tim', $tim->lokasi_tim) }}" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-blue-400 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kontak / WhatsApp</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-phone text-sm"></i>
                            </div>
                            <input type="text" name="kontak_tim" value="{{ old('kontak_tim', $tim->kontak_tim) }}" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-blue-400 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 flex items-center justify-end gap-3">
                    <a href="{{ route('tim.index') }}" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3.5 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center gap-2 active:scale-95">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
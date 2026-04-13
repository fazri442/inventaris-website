@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Tim / Anggota</h1>
            <p class="text-sm text-slate-500">Manajemen tim kerja dan lokasi operasional mereka.</p>
        </div>
        <a href="{{ route('tim.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all text-sm">
            <i class="fa-solid fa-user-plus"></i> Registrasi Tim
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tim as $t)
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="flex gap-2 text-slate-300">
                    <a href="{{ route('tim.edit', $t->id) }}" class="hover:text-blue-500"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('tim.destroy', $t->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="hover:text-rose-500"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <h3 class="font-bold text-slate-900 mb-1">{{ $t->nama_anggota_tim }}</h3>
            <p class="text-[11px] font-semibold text-indigo-500 uppercase tracking-widest mb-4">{{ $t->kode_tim }}</p>
            
            <div class="space-y-3 pt-4 border-t border-slate-50">
                <div class="flex items-center gap-3 text-slate-500">
                    <i class="fa-solid fa-user-tie text-xs w-4"></i>
                    <span class="text-xs">{{ $t->pemimpin_tim }}</span>
                </div>
                <div class="flex items-center gap-3 text-slate-500">
                    <i class="fa-solid fa-map-location-dot text-xs w-4"></i>
                    <span class="text-xs">{{ $t->lokasi_tim }}</span>
                </div>
                <div class="flex items-center gap-3 text-slate-500">
                    <i class="fa-solid fa-phone text-xs w-4"></i>
                    <span class="text-xs font-mono">{{ $t->kontak_tim }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full p-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200 text-slate-400">
            Belum ada tim terdaftar.
        </div>
        @endforelse
    </div>
</div>
@endsection
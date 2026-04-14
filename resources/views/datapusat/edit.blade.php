@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Data Barang</h1>
            <p class="text-sm text-slate-500">Perbarui informasi untuk alat: <span class="font-bold text-blue-600">{{ $datapusat->nama_tool }}</span></p>
        </div>
        <div>
            <a href="{{ route('datapusat.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-600 rounded-2xl font-semibold hover:bg-slate-200 transition-all text-sm border border-slate-200">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden p-8">
        <form action="{{ route('datapusat.update', $datapusat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') @if ($errors->any())
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
                        <input type="text" name="nama_tool" value="{{ old('nama_tool', $datapusat->nama_tool) }}" required
                               class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="5"
                                  class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none resize-none">{{ old('deskripsi', $datapusat->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Foto Barang</label>
                        
                        <div id="image-preview-wrapper" class="mb-4 relative w-full h-48 rounded-2xl overflow-hidden border-2 border-slate-100 bg-slate-50 flex items-center justify-center">
                            @if($datapusat->foto)
                                <img id="image-preview" src="{{ asset('storage/' . $datapusat->foto) }}" class="w-full h-full object-cover">
                            @else
                                <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                                <div id="placeholder-icon" class="text-slate-300 text-4xl">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                            
                            <button type="button" id="remove-btn" onclick="removePreview()" class="hidden absolute top-2 right-2 w-8 h-8 bg-rose-500 text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-rose-600 transition-all">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="relative group">
                            <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewImage(this)"
                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-2 group-hover:border-blue-300 transition-all">
                        </div>
                        <p class="mt-2 text-[11px] text-slate-400 ml-1 italic">*Biarkan kosong jika tidak ingin mengubah foto.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Jumlah Stok</label>
                            <input type="number" name="stok" value="{{ old('stok', $datapusat->stok) }}"
                                   class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Lokasi Penyimpanan</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $datapusat->lokasi) }}"
                                   class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm font-semibold text-slate-900 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-50 flex items-center justify-end gap-3">
                <a href="{{ route('datapusat.index') }}" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const initialImage = "{{ $datapusat->foto ? asset('storage/' . $datapusat->foto) : '#' }}";

    function previewImage(input) {
        const previewImage = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-btn');
        const placeholder = document.getElementById('placeholder-icon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden'); // Tampilkan tombol X saat pilih file baru
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview() {
        const input = document.getElementById('foto-input');
        const previewImage = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-btn');
        const placeholder = document.getElementById('placeholder-icon');
        
        input.value = ""; // Reset input file
        
        if (initialImage !== '#') {
            previewImage.src = initialImage; // Balikkan ke foto lama
            removeBtn.classList.add('hidden');
        } else {
            previewImage.src = "#";
            previewImage.classList.add('hidden');
            if(placeholder) placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        }
    }
</script>
@endsection
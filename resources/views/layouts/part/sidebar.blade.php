<aside class="w-64 bg-white border-r border-slate-200 flex flex-col hidden md:flex h-screen sticky top-0">
    <div class="p-6">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
            InvenTool
        </h2>
    </div>
    
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Main Menu</p>
        
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all">
            <i class="fa-solid fa-house text-sm"></i>
            <span class="text-sm">Halaman Utama</span>
        </a>

        <div class="pt-4">
            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Data Master</p>
            <a href="{{ route('datapusat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('datapusat.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all">
                <i class="fa-solid fa-layer-group text-sm"></i>
                <span class="text-sm">Data Barang</span>
            </a>

            <a href="{{ route('tim.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('tim.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all mt-1">
                <i class="fa-solid fa-users-gear text-sm"></i>
                <span class="text-sm">Data Tim</span>
            </a>
        </div>

        <div class="pt-4">
            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Inventaris</p>
            <a href="{{ route('barangmasuk.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('barangmasuk.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all">
                <i class="fa-solid fa-box-archive text-sm"></i>
                <span class="text-sm">Barang Masuk</span>
            </a>

            <a href="{{ route('barangkeluar.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('barangkeluar.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all mt-1">
                <i class="fa-solid fa-truck-ramp-box text-sm"></i>
                <span class="text-sm">Barang Keluar</span>
            </a>
        </div>

        <div class="pt-4">
            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Transaksi</p>
            <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('peminjam.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all">
                <i class="fa-solid fa-hand-holding-heart text-sm"></i>
                <span class="text-sm">Peminjaman</span>
            </a>

            <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengembalian.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50' }} transition-all mt-1">
                <i class="fa-solid fa-rotate-left text-sm"></i>
                <span class="text-sm">Pengembalian</span>
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-rose-500 hover:bg-rose-50 transition-all">
                <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                <span class="text-sm font-medium">Keluar</span>
            </button>
        </form>
    </div>
</aside>
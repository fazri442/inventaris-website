<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-10" x-data="{ open: false }">
    <button class="text-slate-500 hover:text-slate-900 md:hidden">
        <i class="fa-solid fa-bars-staggered text-xl"></i>
    </button>
    
    <div class="hidden md:flex items-center bg-slate-100 px-4 py-2 rounded-2xl w-96 border border-transparent focus-within:border-blue-300 focus-within:bg-white transition-all">
        <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
        <input type="text" placeholder="Cari data barang..." class="bg-transparent border-none outline-none ml-3 text-sm w-full text-slate-600">
    </div>

    <div class="flex items-center gap-3">
        {{-- <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 transition-all relative">
            <i class="fa-regular fa-bell"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
        </button> --}}
        
        <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
        
        <div class="relative">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-2 cursor-pointer group focus:outline-none">
                <div class="text-right hidden sm:block transition-all group-hover:mr-1">
                    <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-slate-500 mt-1 uppercase tracking-tighter">Super Admin</p>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" class="w-10 h-10 rounded-2xl border-2 border-white shadow-sm ring-1 ring-slate-100 transition-transform group-hover:scale-105" alt="Avatar">
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 shadow-blue-100/50"
                 style="display: none;">
                
                <div class="px-4 py-3 border-b border-slate-50 mb-1 md:hidden">
                    <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500">Super Admin</p>
                </div>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                    <i class="fa-solid fa-user-gear opacity-50"></i>
                    <span>Pengaturan Profile</span>
                </a>

                <div class="h-[1px] bg-slate-100 my-1 mx-4"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 transition-colors">
                        <i class="fa-solid fa-power-off opacity-50"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
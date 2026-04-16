<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - InvenTool</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Roboto', sans-serif; }
    </style>
</head>
<body class="bg-[#E8F1F9] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-[50px] shadow-sm w-full max-w-[500px] p-10 md:p-12 text-center">
        
        <div class="inline-flex items-center justify-center p-3 border border-[#F1F5F9] rounded-[15px] mb-5">
            <i data-lucide="user-plus" class="w-6 h-6 text-[#1A1C1E]"></i>
        </div>

        <h2 class="text-[32px] font-bold text-[#1A1C1E] mb-10">Daftar</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            
            <div class="relative">
                <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                    <i data-lucide="user" class="w-5 h-5 text-[#94A3B8]"></i>
                </div>
                <input type="text" name="name" 
                    class="w-full bg-[#F8FAFC] text-[#1A1C1E] text-[15px] rounded-[15px] py-5 pl-14 pr-5 focus:outline-none placeholder-[#94A3B8] @error('name') border-red-500 @enderror" 
                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 text-left ml-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-5 h-5 text-[#94A3B8]"></i>
                </div>
                <input type="email" name="email" 
                    class="w-full bg-[#F8FAFC] text-[#1A1C1E] text-[15px] rounded-[15px] py-5 pl-14 pr-5 focus:outline-none placeholder-[#94A3B8] @error('email') border-red-500 @enderror" 
                    placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 text-left ml-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-[#94A3B8]"></i>
                </div>
                <input type="password" name="password" 
                    class="w-full bg-[#F8FAFC] text-[#1A1C1E] text-[15px] rounded-[15px] py-5 pl-14 pr-5 focus:outline-none placeholder-[#94A3B8] @error('password') border-red-500 @enderror" 
                    placeholder="Password" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 text-left ml-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                class="w-full bg-[#1A1A1C] hover:bg-black text-white font-bold py-5 rounded-[15px] transition-all duration-300 shadow-lg shadow-black/5 mt-4">
                Daftar Sekarang
            </button>
        </form>

        {{-- <div class="flex items-center my-8">
            <div class="flex-grow border-t border-[#E2E8F0]"></div>
            <span class="mx-4 text-[11px] text-[#CBD5E1] uppercase tracking-widest font-medium">Atau Daftar Dengan</span>
            <div class="flex-grow border-t border-[#E2E8F0]"></div>
        </div> --}}

        {{-- <a href="#" 
            class="w-full flex items-center justify-center gap-3 bg-white border border-[#F1F5F9] rounded-[15px] py-4 text-[#1A1C1E] font-semibold hover:bg-gray-50 transition-all">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/1200px-Google_%22G%22_logo.svg.png" 
                class="w-5 h-5" alt="Google">
            <span>Daftar dengan Google</span>
        </a> --}}

        <p class="mt-10 text-sm text-[#64748B]">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-[#1A1C1E] font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
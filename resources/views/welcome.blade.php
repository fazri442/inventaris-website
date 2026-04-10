<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(180deg, #e0f2fe 0%, #ffffff 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-sm rounded-[2.5rem] shadow-2xl p-8 border border-white">
        <div class="flex justify-center mb-6">
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-zinc-800">
                <i class="fa-solid fa-right-to-bracket text-2xl"></i>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-center text-gray-900 mb-2">Masuk</h1>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="email" name="email" placeholder="Email" 
                    class="w-full pl-12 pr-4 py-4 bg-gray-100/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-400 transition-all outline-none" required>
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="password" placeholder="Password" 
                    class="w-full pl-12 pr-12 py-4 bg-gray-100/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-400 transition-all outline-none" required>
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>

            <div class="text-right">
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Lupa password?</a>
            </div>

            <button type="submit" 
                class="w-full py-4 bg-zinc-900 text-white font-semibold rounded-2xl hover:bg-zinc-800 transition-all shadow-lg active:scale-[0.98]">
                Masuk Sekarang
            </button>
        </form>

        <div class="relative my-8 text-center">
            <hr class="border-t border-dotted border-gray-300">
            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-xs text-gray-400 uppercase tracking-widest">
                Atau masuk dengan
            </span>
        </div>

        <div class="flex justify-center">
            <a href="{{ url('auth/google') }}" class="flex items-center justify-center gap-3 w-full py-3 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all shadow-sm font-medium text-gray-700">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-6 w-6" alt="Google">
                <span>Lanjutkan dengan Google</span>
            </a>
        </div>

        <p class="text-center mt-8 text-gray-500 text-sm">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-zinc-900 font-bold hover:underline ml-1">Daftar di sini</a>
        </p>
    </div>

</body>
</html>
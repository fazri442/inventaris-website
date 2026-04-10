<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pustakawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="flex min-h-screen">
        @include('layouts.part.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.part.navbar')

            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIAGA Adminduk') - Dindukcapil Brebes</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">

            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-700 text-white font-bold text-lg">
                    S
                </div>
                <div>
                    <h1 class="text-lg font-bold text-green-800">SIAGA Adminduk</h1>
                    <p class="text-xs text-slate-500">Dindukcapil Kabupaten Brebes</p>
                </div>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium md:flex">
                <a href="{{ route('home') }}" class="text-green-700">Beranda</a>
                <a href="#layanan" class="hover:text-green-700">Layanan</a>
                <a href="#tentang" class="hover:text-green-700">Tentang</a>
                <a href="{{ route('admin.login') }}" class="rounded-lg border border-green-700 px-4 py-2 text-green-700 hover:bg-green-50">
                    Login Admin
                </a>
            </nav>

            <button id="menuButton" class="rounded-lg border border-slate-200 p-2 md:hidden" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden border-t border-slate-200 bg-white px-5 py-4 md:hidden">
            <div class="flex flex-col gap-4 text-sm font-medium">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="#layanan">Layanan</a>
                <a href="#tentang">Tentang</a>
                <a href="{{ route('admin.login') }}">Login Admin</a>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 bg-green-950 text-green-50">
        <div class="mx-auto max-w-7xl px-5 py-10">
            <h2 class="text-xl font-bold">SIAGA Adminduk</h2>
            <p class="mt-2 max-w-xl text-sm text-green-100/80">
                Sistem Informasi Asistensi dan Pengaduan Administrasi Kependudukan
                Dinas Kependudukan dan Pencatatan Sipil Kabupaten Brebes.
            </p>
            <div class="mt-8 border-t border-green-800 pt-5 text-xs text-green-100/70">
                © {{ date('Y') }} Dindukcapil Kabupaten Brebes.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('menuButton')?.addEventListener('click', function () {
            document.getElementById('mobileMenu')?.classList.toggle('hidden');
        });
    </script>

</body>
</html>

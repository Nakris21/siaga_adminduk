
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIAGA Adminduk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen">

    <!-- OVERLAY MOBILE -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-green-900 text-white flex flex-col
        transform -translate-x-full transition-transform duration-300
        lg:translate-x-0">

        <!-- Logo -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-green-800">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white text-green-800 rounded-lg flex items-center justify-center font-bold">
                    SA
                </div>

                <div class="ml-3">
                    <h1 class="font-bold text-base">SIAGA Adminduk</h1>
                    <p class="text-xs text-green-200">Admin Panel</p>
                </div>
            </div>

            <button id="closeSidebar"
                class="lg:hidden text-green-200 hover:text-white text-2xl">
                &times;
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <p class="text-xs uppercase tracking-wider text-green-300 px-3 mb-3">
                Menu Utama
            </p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-3 rounded-lg transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white font-semibold' : 'text-green-100 hover:bg-green-800' }}">
                <span>▦</span>
                Dashboard
            </a>

            <a href="{{ route('admin.complaints.index') }}"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-green-100 hover:bg-green-800"
               {{ request()->routeIs('admin.complaints.*')
                ? 'bg-green-800 text-white'
                : 'text-green-100 hover:bg-green-800 hover:text-white' }}>
                <span>▤</span>
                Data Pengaduan
            </a>

            <a href="#"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-green-100 hover:bg-green-800">
                <span>◷</span>
                Analisis Pengaduan
            </a>

            <p class="text-xs uppercase tracking-wider text-green-300 px-3 pt-6 pb-2">
                Pengaturan
            </p>

            <a href="#"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-green-100 hover:bg-green-800">
                <span>▧</span>
                Referensi Regulasi
            </a>

            <a href="#"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-green-100 hover:bg-green-800">
                <span>♙</span>
                Manajemen Admin
            </a>

            <a href="#"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-green-100 hover:bg-green-800">
                <span>▤</span>
                Laporan
            </a>

        </nav>

        <!-- Pengguna -->
        <div class="p-4 border-t border-green-800">
            <p class="text-sm font-semibold">
                {{ auth()->user()->name }}
            </p>

            <p class="text-xs text-green-300 mb-4">
                Administrator
            </p>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg text-sm text-green-100 hover:bg-red-700 transition">
                    Keluar dari Sistem
                </button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <div class="min-h-screen flex flex-col lg:ml-64">

        <!-- HEADER -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-8">

            <div class="flex items-center gap-3">

                <button id="openSidebar"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-700 text-xl">
                    ☰
                </button>

                <h2 class="font-semibold text-gray-800">
                    @yield('page-heading', 'Dashboard')
                </h2>

            </div>

            <div class="hidden sm:block text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>

        </header>

        <!-- ISI HALAMAN -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="px-4 sm:px-8 py-4 border-t border-gray-200 bg-white">
            <p class="text-xs text-gray-500 text-center">
                SIAGA Adminduk &copy; {{ date('Y') }} ·
                Dinas Kependudukan dan Pencatatan Sipil Kabupaten Brebes
            </p>
        </footer>

    </div>

</div>

<!-- JAVASCRIPT SIDEBAR -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openButton = document.getElementById('openSidebar');
    const closeButton = document.getElementById('closeSidebar');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    openButton.addEventListener('click', openSidebar);
    closeButton.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
</script>

</body>
</html>

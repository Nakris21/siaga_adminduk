
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="bg-gradient-to-br from-green-800 to-green-600 text-white">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 py-20 md:grid-cols-2 md:py-28">

        <div>
            <span class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-medium">
                Layanan Digital Dindukcapil Brebes
            </span>

            <h2 class="mt-7 text-4xl font-bold leading-tight md:text-5xl">
                Ada Pertanyaan atau Pengaduan Adminduk?
            </h2>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-green-50">
                SIAGA Adminduk hadir untuk membantu masyarakat mendapatkan
                informasi, konsultasi, serta menyampaikan pengaduan terkait
                administrasi kependudukan secara lebih mudah.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#layanan" class="rounded-lg bg-white px-6 py-3 font-semibold text-green-800 hover:bg-green-50">
                    Mulai Layanan
                </a>

                <a href="#tentang" class="rounded-lg border border-white/50 px-6 py-3 font-semibold text-white hover:bg-white/10">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-white/20 bg-white/10 p-8 backdrop-blur">
            <div class="text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-white text-3xl font-bold text-green-700">
                    S
                </div>

                <h3 class="mt-6 text-2xl font-bold">SIAGA Adminduk</h3>

                <p class="mt-3 text-sm leading-relaxed text-green-50">
                    Satu pintu untuk konsultasi dan pengaduan
                    administrasi kependudukan.
                </p>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-3 text-center text-sm">
                <div class="rounded-xl bg-white/10 p-4">
                    <p class="font-semibold">Konsultasi</p>
                    <p class="mt-1 text-xs text-green-100">Informasi Adminduk</p>
                </div>

                <div class="rounded-xl bg-white/10 p-4">
                    <p class="font-semibold">Pengaduan</p>
                    <p class="mt-1 text-xs text-green-100">Sampaikan Keluhan</p>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="layanan" class="mx-auto max-w-7xl px-5 py-20">

    <div class="mx-auto mb-12 max-w-2xl text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-green-700">
            Layanan SIAGA
        </span>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            Apa yang Bisa Kami Bantu?
        </h2>

        <p class="mt-4 text-slate-600">
            Pilih layanan sesuai kebutuhan administrasi kependudukan Anda.
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700 text-xl">
                ?
            </div>

            <h3 class="mt-5 text-xl font-bold">Konsultasi Adminduk</h3>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Temukan informasi persyaratan, prosedur, dan pelayanan
                administrasi kependudukan.
            </p>

            <a href="#" class="mt-6 inline-block font-semibold text-green-700 hover:text-green-900">
                Mulai Konsultasi →
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-700 text-xl">
                !
            </div>

            <h3 class="mt-5 text-xl font-bold">Sampaikan Pengaduan</h3>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Sampaikan kendala atau keluhan terkait pelayanan
                administrasi kependudukan.
            </p>

            <a href="/pengaduan" class="mt-6 inline-block font-semibold text-green-700 hover:text-green-900">
                Buat Pengaduan →
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700 text-xl">
                ✓
            </div>

            <h3 class="mt-5 text-xl font-bold">Cek Status Pengaduan</h3>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Pantau perkembangan pengaduan menggunakan nomor tiket
                dan kode akses.
            </p>

            <a href="#" class="mt-6 inline-block font-semibold text-green-700 hover:text-green-900">
                Periksa Pengaduan →
            </a>
        </div>

    </div>
</section>

<section id="tentang" class="bg-white py-16">
    <div class="mx-auto max-w-4xl px-5 text-center">
        <h2 class="text-2xl font-bold text-slate-900">
            Pelayanan yang Lebih Mudah dan Transparan
        </h2>

        <p class="mt-5 leading-relaxed text-slate-600">
            SIAGA Adminduk merupakan sarana digital untuk mendukung
            peningkatan kualitas pelayanan publik melalui kemudahan
            akses informasi, konsultasi, dan pengelolaan pengaduan
            masyarakat.
        </p>
    </div>
</section>

@endsection

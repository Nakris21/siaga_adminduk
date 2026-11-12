
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-12">
    <div class="mx-auto max-w-xl">

        <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                <svg class="h-8 w-8 text-green-700"
                     fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="mt-5 text-2xl font-bold text-gray-900">
                Pengaduan Berhasil Dikirim!
            </h1>

            <p class="mt-3 text-sm leading-relaxed text-gray-600">
                Terima kasih. Pengaduan Anda telah berhasil kami terima.
                Simpan nomor tiket dan kode akses berikut untuk memantau
                tindak lanjut pengaduan.
            </p>

            <div class="mt-8 rounded-xl bg-gray-50 p-5 text-left">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Nomor Tiket
                </p>

                <p class="mt-2 text-xl font-bold tracking-wide text-green-700">
                    {{ session('complaint_ticket') }}
                </p>

                <div class="my-5 border-t border-gray-200"></div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Kode Akses Rahasia
                </p>

                <p class="mt-2 text-xl font-bold tracking-widest text-gray-900">
                    {{ session('complaint_access_code') }}
                </p>
            </div>

            <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-left">
                <p class="text-sm leading-relaxed text-amber-800">
                    <strong>Penting!</strong> Simpan atau catat kedua informasi
                    tersebut. Kode akses hanya ditampilkan satu kali dan
                    diperlukan untuk melihat perkembangan pengaduan.
                    Jangan bagikan kepada orang lain.
                </p>
            </div>

            <button onclick="window.print()"
                    class="mt-6 w-full rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Cetak Bukti Pengaduan
            </button>

            <a href="{{ route('home') }}"
               class="mt-3 inline-flex w-full justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">
                Kembali ke Beranda
            </a>

        </div>

        <p class="mt-6 text-center text-xs text-gray-500">
            Dinas Kependudukan dan Pencatatan Sipil Kabupaten Brebes
        </p>

    </div>
</div>
@endsection

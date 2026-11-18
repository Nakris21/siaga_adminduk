
@extends('layouts.app')

@section('content')
<div class="min-h-[75vh] bg-gray-50 px-4 py-12">
    <div class="mx-auto max-w-lg">

        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-2xl">
                🔎
            </div>

            <h1 class="text-2xl font-bold text-gray-800">
                Cek Status Pengaduan
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Pantau perkembangan pengaduan administrasi kependudukan Anda.
            </p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            @if($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('public.complaints.check.submit') }}"
                  class="space-y-5">
                @csrf

                <div>
                    <label for="ticket_number"
                           class="mb-2 block text-sm font-medium text-gray-700">
                        Nomor Tiket
                    </label>

                    <input
                        type="text"
                        id="ticket_number"
                        name="ticket_number"
                        value="{{ old('ticket_number') }}"
                        placeholder="Contoh: ADK-20261118-ABC123"
                        required
                        autocomplete="off"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm uppercase focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-100"
                    >
                </div>

                <div>
                    <label for="access_code"
                           class="mb-2 block text-sm font-medium text-gray-700">
                        Kode Akses
                    </label>

                    <input
                        type="password"
                        id="access_code"
                        name="access_code"
                        placeholder="Masukkan kode akses rahasia"
                        required
                        autocomplete="off"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        Kode akses diperoleh saat pengaduan berhasil dikirim.
                    </p>
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-green-700 px-5 py-3 font-semibold text-white transition hover:bg-green-800">
                    Cek Status Pengaduan
                </button>
            </form>
        </div>

        <div class="mt-5 rounded-lg bg-blue-50 p-4 text-sm text-blue-800">
            <strong>Informasi:</strong>
            Simpan nomor tiket dan kode akses Anda. Keduanya diperlukan untuk melihat perkembangan pengaduan.
        </div>

        <div class="mt-6 text-center">
            <a href="{{ url('/') }}"
               class="text-sm font-medium text-green-700 hover:underline">
                &larr; Kembali ke Beranda
            </a>
        </div>

    </div>
</div>
@endsection

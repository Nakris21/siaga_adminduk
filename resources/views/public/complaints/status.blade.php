
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-10">
    <div class="mx-auto max-w-3xl space-y-6">

        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Detail Pengaduan
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Informasi perkembangan pengaduan Anda.
                </p>
            </div>

            <a href="{{ route('public.complaints.check') }}"
               class="text-sm font-medium text-green-700 hover:underline">
                Cek Tiket Lain
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Nomor Tiket</p>

            <h2 class="mt-1 text-xl font-bold text-green-700">
                {{ $complaint->ticket_number }}
            </h2>

            @php
                $statusClass = match($complaint->status) {
                    'Baru' => 'bg-blue-100 text-blue-700',
                    'Diproses' => 'bg-yellow-100 text-yellow-700',
                    'Menunggu Balasan' => 'bg-orange-100 text-orange-700',
                    'Selesai' => 'bg-green-100 text-green-700',
                    'Dicabut' => 'bg-gray-100 text-gray-700',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp

            <div class="mt-4">
                <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $statusClass }}">
                    {{ $complaint->status }}
                </span>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 font-semibold text-gray-800">
                Informasi Pengaduan
            </h3>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500">Nama Pelapor</p>
                    <p class="font-medium text-gray-800">{{ $complaint->name }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tanggal Pengaduan</p>
                    <p class="font-medium text-gray-800">
                        {{ $complaint->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Lokasi Layanan</p>
                    <p class="font-medium text-gray-800">
                        {{ $complaint->service_location }}
                        {{ $complaint->other_location ? ' - '.$complaint->other_location : '' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Kategori</p>
                    <p class="font-medium text-gray-800">{{ $complaint->category }}</p>
                </div>
            </div>

            <div class="mt-5 border-t border-gray-100 pt-5">
                <p class="mb-2 text-xs text-gray-500">Uraian Pengaduan</p>
                <div class="whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $complaint->description }}</div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-semibold text-gray-800">
                Status Penanganan
            </h3>

            <div class="space-y-4">
                @foreach([
                    'Baru' => 'Pengaduan telah diterima.',
                    'Diproses' => 'Pengaduan sedang ditindaklanjuti.',
                    'Menunggu Balasan' => 'Petugas menunggu informasi atau balasan.',
                    'Selesai' => 'Pengaduan telah diselesaikan.',
                    'Dicabut' => 'Pengaduan telah dicabut.',
                ] as $status => $description)
                    <div class="flex gap-3">
                        <div class="mt-1 h-3 w-3 shrink-0 rounded-full
                            {{ $complaint->status === $status ? 'bg-green-600' : 'bg-gray-300' }}">
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $status }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- NOTIFIKASI --}}
@if(session('success'))
    <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
        {{ $errors->first() }}
    </div>
@endif

{{-- RIWAYAT PERCAKAPAN --}}
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-200 p-5 ">
        <h3 class="font-semibold text-gray-800">
            Percakapan Pengaduan
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Komunikasi antara Anda dan petugas Dindukcapil Brebes.
        </p>
    </div>

    <div class="min-h-screen space-y-4 overflow-y-auto bg-gray-50 p-4">

        {{-- Pesan awal pengaduan --}}
        <div class="flex justify-start">
            <div class="max-w-[85%] rounded-xl rounded-tl-none border border-gray-200 bg-white p-4 shadow-sm">

                <p class="mb-2 text-xs font-semibold text-gray-500">
                    Anda · Pengaduan Awal
                </p>

                <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $complaint->description }}</p>

                <p class="mt-2 text-right text-xs text-gray-400">
                    {{ $complaint->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        {{-- Riwayat pesan --}}
        @foreach($complaint->messages as $message)

            <div class="flex {{ $message->sender_type === 'admin' ? 'justify-start' : 'justify-end' }}">

                <div class="max-w-[85%] rounded-xl p-4 shadow-sm
                    {{ $message->sender_type === 'admin'
                        ? 'rounded-tl-none border border-gray-200 bg-white'
                        : 'rounded-tr-none bg-green-700 text-white' }}">

                    <p class="mb-2 text-xs font-semibold
                        {{ $message->sender_type === 'admin'
                            ? 'text-green-700'
                            : 'text-green-100' }}">

                        {{ $message->sender_type === 'admin'
                            ? 'Petugas Dindukcapil'
                            : 'Anda' }}
                    </p>

                    <p class="whitespace-pre-line text-sm leading-relaxed">
                        {{ $message->message }}
                    </p>

                    <p class="mt-2 text-right text-xs
                        {{ $message->sender_type === 'admin'
                            ? 'text-gray-400'
                            : 'text-green-100' }}">
                        {{ $message->created_at->format('d/m/Y H:i') }}
                    </p>

                </div>
            </div>

        @endforeach

    </div>

    {{-- FORM BALASAN MASYARAKAT --}}
    @if(!in_array($complaint->status, ['Selesai', 'Dicabut']))

        <div class="border-t border-gray-200 p-5">

            <form method="POST"
                  action="{{ route('public.complaints.reply') }}"
                  class="space-y-3">

                @csrf

                <label for="message"
                       class="block text-sm font-semibold text-gray-700">
                    Balas Pesan Petugas
                </label>

                <textarea
                    name="message"
                    id="message"
                    rows="3"
                    maxlength="5000"
                    required
                    placeholder="Tuliskan balasan atau informasi tambahan..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-100"
                >{{ old('message') }}</textarea>

                <div class="flex justify-end">
                    <button type="submit"
                            class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800">
                        Kirim Balasan
                    </button>
                </div>

            </form>
        </div>

    @else

        <div class="border-t border-gray-200 bg-gray-100 p-5">
            <div class="flex items-start gap-3">
                <span class="text-xl">🔒</span>

                <div>
                    <p class="text-sm font-semibold text-gray-700">
                        Percakapan Ditutup
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        Pengaduan ini berstatus {{ $complaint->status }}.
                        Anda masih dapat membaca riwayat percakapan,
                        tetapi tidak dapat mengirim pesan baru.
                    </p>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection



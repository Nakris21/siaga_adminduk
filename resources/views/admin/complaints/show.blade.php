
@extends('layouts.admin')

@section('page-heading', 'Detail Pengaduan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $complaint->ticket_number }}
            </h2>
            <p class="text-sm text-gray-500">
                Diterima pada {{ $complaint->created_at->format('d F Y, H:i') }}
            </p>
        </div>

        <a href="{{ route('admin.complaints.index') }}"
           class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
            &larr; Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- INFORMASI PENGADUAN --}}
        <div class="space-y-6 lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold text-gray-800">
                    Informasi Pelapor
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs text-gray-500">Nama Pelapor</p>
                        <p class="font-medium text-gray-800">{{ $complaint->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">NIK</p>
                        <p class="font-medium text-gray-800">{{ $complaint->nik }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Nomor Telepon</p>
                        <p class="font-medium text-gray-800">{{ $complaint->phone }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">{{ $complaint->email ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold text-gray-800">
                    Isi Pengaduan
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs text-gray-500">Lokasi Layanan</p>
                        <p class="font-medium text-gray-800">
                            {{ $complaint->service_location }}
                            @if($complaint->other_location)
                                - {{ $complaint->other_location }}
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Kategori</p>
                        <p class="font-medium text-gray-800">{{ $complaint->category }}</p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="mb-2 text-xs text-gray-500">Uraian Pengaduan</p>
                    <div class="whitespace-pre-line rounded-lg bg-gray-50 p-4 text-sm leading-relaxed text-gray-700">{{ $complaint->description }}</div>
                </div>
            </div>

            {{-- LAMPIRAN --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold text-gray-800">
                    Lampiran Bukti
                </h3>

                @if($complaint->attachments->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($complaint->attachments as $attachment)
                            <a href="{{ route('admin.complaints.attachments.show', [$complaint, $attachment]) }}"
                               target="_blank"
                               rel="noopener"
                               class="group overflow-hidden rounded-lg border border-gray-200 hover:border-green-500">

                                @if(in_array($attachment->mime_type, ['image/jpeg', 'image/png']))
                                    <img
                                        src="{{ route('admin.complaints.attachments.show', [$complaint, $attachment]) }}"
                                        alt="Lampiran pengaduan"
                                        class="h-48 w-full bg-gray-100 object-contain"
                                    >
                                @endif

                                <div class="p-3">
                                    <p class="truncate text-sm font-medium text-gray-700">
                                        {{ $attachment->original_name }}
                                    </p>
                                    <p class="mt-1 text-xs text-green-700">
                                        Buka lampiran
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">
                        Tidak ada lampiran yang disertakan.
                    </p>
                @endif
            </div>
        </div>

        {{-- STATUS --}}
        <div class="space-y-6">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold text-gray-800">
                    Status Pengaduan
                </h3>

                <p class="mb-4 text-sm text-gray-600">
                    Status saat ini:
                    <strong>{{ $complaint->status }}</strong>
                </p>

                <form method="POST"
                      action="{{ route('admin.complaints.status', $complaint) }}"
                      class="space-y-3">
                    @csrf
                    @method('PATCH')

                    <label class="block text-sm font-medium text-gray-700">
                        Ubah Status
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach(['Baru', 'Diproses', 'Menunggu Balasan', 'Selesai', 'Dicabut'] as $status)
                            <option value="{{ $status }}"
                                @selected($complaint->status === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="w-full rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-800">
                        Simpan Status
                    </button>
                </form>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-3 font-semibold text-gray-800">
                    Informasi Tiket
                </h3>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-500">Nomor Tiket</p>
                        <p class="font-medium">{{ $complaint->ticket_number }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Tanggal Pengaduan</p>
                        <p>{{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Terakhir Diperbarui</p>
                        <p>{{ $complaint->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIWAYAT PERCAKAPAN --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h3 class="font-semibold text-gray-800">
                Percakapan Pengaduan
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Riwayat komunikasi antara pelapor dan petugas.
            </p>
        </div>

        <div class="max-h-[500px] space-y-4 overflow-y-auto rounded-lg bg-gray-50 p-4">
            {{-- Pesan awal dari pelapor --}}
            <div class="flex justify-start">
                <div class="max-w-[85%] rounded-xl rounded-tl-none border bg-white p-3 shadow-sm sm:max-w-[70%]">
                    <p class="mb-1 text-xs font-semibold text-gray-500">
                        {{ $complaint->name }} · Pengaduan awal
                    </p>
                    <p class="whitespace-pre-line text-sm text-gray-700">{{ $complaint->description }}</p>
                    <p class="mt-2 text-right text-xs text-gray-400">
                        {{ $complaint->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            @foreach($complaint->messages as $message)
                <div class="flex {{ $message->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] rounded-xl p-3 shadow-sm sm:max-w-[70%]
                        {{ $message->sender_type === 'admin'
                            ? 'rounded-tr-none bg-green-700 text-white'
                            : 'rounded-tl-none border bg-white text-gray-700' }}">

                        <p class="mb-1 text-xs font-semibold
                            {{ $message->sender_type === 'admin' ? 'text-green-100' : 'text-gray-500' }}">
                            {{ $message->sender_type === 'admin' ? 'Petugas Dindukcapil' : $complaint->name }}
                        </p>

                        <p class="whitespace-pre-line text-sm">{{ $message->message }}</p>

                        <p class="mt-2 text-right text-xs
                            {{ $message->sender_type === 'admin' ? 'text-green-100' : 'text-gray-400' }}">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if(!in_array($complaint->status, ['Selesai', 'Dicabut']))
            <form method="POST"
                  action="{{ route('admin.complaints.reply', $complaint) }}"
                  class="mt-5 space-y-3">
                @csrf

                <label for="message" class="block text-sm font-medium text-gray-700">
                    Tulis Balasan
                </label>

                <textarea
                    name="message"
                    id="message"
                    rows="4"
                    maxlength="5000"
                    required
                    placeholder="Tuliskan tanggapan atau informasi kepada pelapor..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-green-600 focus:outline-none"
                >{{ old('message') }}</textarea>

                <div class="flex justify-end">
                    <button type="submit"
                            class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-800">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        @else
            <div class="mt-5 rounded-lg bg-gray-100 p-4 text-sm text-gray-600">
                Pengaduan ini sudah {{ strtolower($complaint->status) }}.
                Untuk mengirim balasan, ubah statusnya menjadi aktif terlebih dahulu.
            </div>
        @endif
    </div>
</div>
@endsection

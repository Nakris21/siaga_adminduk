
@extends('layouts.admin')

@section('page-heading', 'Data Pengaduan')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-800">
                Daftar Pengaduan Masyarakat
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola dan tindak lanjuti pengaduan administrasi kependudukan.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.complaints.index') }}"
              class="mb-5 flex flex-col gap-3 sm:flex-row">

            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nomor tiket, nama, atau kategori..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-green-600 focus:outline-none"
            >

            <select name="status"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm">
                <option value="">Semua Status</option>
                @foreach(['Baru', 'Diproses', 'Menunggu Balasan', 'Selesai', 'Dicabut'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="rounded-lg bg-green-700 px-5 py-2 text-sm font-medium text-white hover:bg-green-800">
                Cari
            </button>

            <a href="{{ route('admin.complaints.index') }}"
               class="rounded-lg border border-gray-300 px-5 py-2 text-center text-sm text-gray-600 hover:bg-gray-50">
                Reset
            </a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm">
                <thead class="border-b bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Nomor Tiket</th>
                        <th class="px-4 py-3">Pelapor</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-green-700">
                                {{ $complaint->ticket_number }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">
                                    {{ $complaint->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $complaint->phone }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                {{ $complaint->category }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-4 py-3">
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

                                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">
                                    {{ $complaint->status }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                   class="inline-block rounded-lg bg-green-700 px-3 py-2 text-xs font-medium text-white hover:bg-green-800">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                Belum ada data pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection

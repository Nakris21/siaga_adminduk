
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard')
@section('content')

    <!-- Judul halaman -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            Dashboard
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Ringkasan dan pemantauan pengaduan administrasi kependudukan.
        </p>
    </div>

    <!-- Kartu statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

        @php
            $cards = [
                [
                    'label' => 'Total Pengaduan',
                    'value' => $statistics['total'],
                    'color' => 'border-gray-400',
                    'description' => 'Seluruh pengaduan',
                ],
                [
                    'label' => 'Pengaduan Baru',
                    'value' => $statistics['baru'],
                    'color' => 'border-blue-500',
                    'description' => 'Belum ditangani',
                ],
                [
                    'label' => 'Sedang Diproses',
                    'value' => $statistics['diproses'],
                    'color' => 'border-yellow-500',
                    'description' => 'Dalam penanganan',
                ],
                [
                    'label' => 'Menunggu Balasan',
                    'value' => $statistics['menunggu_balasan'],
                    'color' => 'border-orange-500',
                    'description' => 'Menunggu respons pelapor',
                ],
                [
                    'label' => 'Selesai',
                    'value' => $statistics['selesai'],
                    'color' => 'border-green-500',
                    'description' => 'Pengaduan telah selesai',
                ],
                [
                    'label' => 'Dicabut',
                    'value' => $statistics['dicabut'],
                    'color' => 'border-red-500',
                    'description' => 'Pengaduan dicabut pelapor',
                ],
            ];

        @endphp

        @foreach ($cards as $card)
            <div class="bg-white rounded-xl border border-gray-200 border-l-4 {{ $card['color'] }} p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">
                    {{ $card['label'] }}
                </p>

                <p class="text-3xl font-bold text-gray-900 mt-3">
                    {{ number_format($card['value']) }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    {{ $card['description'] }}
                </p>
            </div>
        @endforeach

    </div>

    <!-- Tabel pengaduan terbaru -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">
                Pengaduan Terbaru
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Lima pengaduan yang terakhir masuk ke sistem.
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No. Tiket</th>
                        <th class="px-6 py-4 font-semibold">Nama Pelapor</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($recentComplaints as $complaint)
                        @php
                            $statusColors = [
                                'Baru' => 'bg-blue-100 text-blue-700',
                                'Diproses' => 'bg-yellow-100 text-yellow-700',
                                'Menunggu Balasan' => 'bg-orange-100 text-orange-700',
                                'Selesai' => 'bg-green-100 text-green-700',
                                'Dicabut' => 'bg-red-100 text-red-700',
                            ];

                            $statusClass = $statusColors[$complaint->status]
                                ?? 'bg-gray-100 text-gray-700';
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $complaint->ticket_number }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $complaint->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $complaint->category }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                {{ $complaint->created_at->format('d-m-Y H:i') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p class="font-medium">Belum ada pengaduan.</p>
                                <p class="text-xs mt-1">
                                    Pengaduan yang masuk akan ditampilkan di sini.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-gray-400">
                Menampilkan maksimal lima pengaduan terbaru.
            </p>
        </div>

    </div>

@endsection

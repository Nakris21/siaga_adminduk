
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                SIAGA ADMINDUK
            </span>

            <h1 class="mt-4 text-3xl font-bold text-gray-900">
                Formulir Pengaduan
            </h1>

            <p class="mt-3 text-gray-600">
                Sampaikan kendala atau pengaduan terkait pelayanan administrasi kependudukan.
            </p>
        </div>

        {{-- Informasi --}}
        <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-4">
            <p class="text-sm leading-relaxed text-blue-800">
                <strong>Informasi:</strong> Layanan pengaduan ini tidak dipungut biaya.
                Pastikan data yang Anda masukkan benar. Setelah pengaduan berhasil
                dikirim, Anda akan memperoleh nomor tiket dan kode akses untuk
                memantau tindak lanjut pengaduan.
            </p>
        </div>

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="font-semibold text-red-800">
                    Mohon periksa kembali data Anda:
                </p>

                <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:p-8">

            @csrf

            {{-- Identitas Pelapor --}}
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    A. Identitas Pelapor
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Lengkapi identitas untuk keperluan tindak lanjut.
                </p>
            </div>

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" required
                       autocomplete="name"
                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100"
                       placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label for="nik" class="mb-2 block text-sm font-medium text-gray-700">
                    NIK <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nik" name="nik"
                       value="{{ old('nik') }}" required
                       inputmode="numeric" maxlength="16"
                       pattern="[0-9]{16}" autocomplete="off"
                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100"
                       placeholder="Masukkan 16 digit NIK">
                <p class="mt-1 text-xs text-gray-500">
                    NIK digunakan untuk verifikasi internal dan tidak ditampilkan kepada publik.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                        Nomor WhatsApp/HP <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone"
                           value="{{ old('phone') }}" required
                           autocomplete="tel"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100"
                           placeholder="Contoh: 081234567890">
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           autocomplete="email"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100"
                           placeholder="nama@email.com">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h2 class="text-lg font-bold text-gray-900">
                    B. Informasi Pelayanan
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Berikan informasi lokasi dan jenis pelayanan yang berkaitan dengan pengaduan.
                </p>
            </div>

            <div>
                <label for="service_location" class="mb-2 block text-sm font-medium text-gray-700">
                    Lokasi Pelayanan <span class="text-red-500">*</span>
                </label>

                <select id="service_location" name="service_location" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100">
                    <option value="">-- Pilih lokasi pelayanan --</option>
                    @foreach ([
                        'Kantor Dindukcapil',
                        'Mal Pelayanan Publik (MPP)',
                        'Kecamatan',
                        'Kios Adminduk Desa/Kelurahan',
                        'Lainnya'
                    ] as $location)
                        <option value="{{ $location }}"
                            @selected(old('service_location') === $location)>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="other-location-wrapper"
                 class="{{ old('service_location') === 'Lainnya' ? '' : 'hidden' }}">
                <label for="other_location" class="mb-2 block text-sm font-medium text-gray-700">
                    Sebutkan Lokasi Lainnya <span class="text-red-500">*</span>
                </label>
                <input type="text" id="other_location" name="other_location"
                       value="{{ old('other_location') }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100"
                       placeholder="Tuliskan nama lokasi">
            </div>

            <div>
                <label for="category" class="mb-2 block text-sm font-medium text-gray-700">
                    Kategori Pengaduan <span class="text-red-500">*</span>
                </label>

                <select id="category" name="category" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100">
                    <option value="">-- Pilih kategori --</option>
                    @foreach ([
                        'Persyaratan dan Prosedur',
                        'Waktu Penyelesaian',
                        'Kendala Sistem/Aplikasi',
                        'Petugas Pelayanan',
                        'Sarana dan Prasarana',
                        'Biaya atau Pungutan',
                        'Data Administrasi Kependudukan',
                        'Lainnya'
                    ] as $category)
                        <option value="{{ $category }}"
                            @selected(old('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">
                    Uraian Pengaduan <span class="text-red-500">*</span>
                </label>

                <textarea id="description" name="description" rows="5" required
                          minlength="10"
                          class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100"
                          placeholder="Jelaskan permasalahan yang Anda alami secara jelas...">{{ old('description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">
                    Tuliskan kronologi, jenis layanan, dan kendala yang dialami.
                </p>
            </div>

            
                {{-- Dokumen Pendukung --}}
                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-lg font-bold text-gray-900">
                        C. Dokumen Pendukung
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Unggah foto atau dokumen yang dapat membantu proses penanganan pengaduan.
                    </p>
                </div>

                <div>
                    <label for="attachments" class="mb-2 block text-sm font-medium text-gray-700">
                        Pilih Dokumen atau Foto Pendukung
                    </label>

                    <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 text-center transition hover:border-green-500">
                        <input
                            type="file"
                            id="attachments"
                            name="attachments[]"
                            multiple
                            accept=".jpg,.jpeg,.png"
                            class="block w-full cursor-pointer text-sm text-gray-600
                                file:mr-4 file:rounded-lg file:border-0
                                file:bg-green-100 file:px-4 file:py-2
                                file:font-semibold file:text-green-700
                                hover:file:bg-green-200"
                        >

                        <p class="mt-3 text-xs text-gray-500">
                            Format: JPG, JPEG, PNG. Maksimal 1 MB per file. Maksimal 5 file. File yang diunggah akan bersifat rahasia dan hanya dapat diakses oleh petugas terkait.
                        </p>
                    </div>

                    <div id="selected-files" class="mt-3 space-y-2"></div>

                    @error('attachments')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @foreach ($errors->get('attachments.*') as $messages)
                        @foreach ($messages as $message)
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @endforeach
                    @endforeach
                </div>

            {{-- Persetujuan --}}
            <div class="rounded-xl bg-gray-50 p-4">
                <label class="flex items-start gap-3">
                    <input type="checkbox" name="agreement" value="1" required
                           class="mt-1 h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="text-sm leading-relaxed text-gray-600">
                        Saya menyatakan bahwa data dan informasi yang disampaikan
                        adalah benar serta bersedia dihubungi untuk keperluan
                        tindak lanjut pengaduan.
                    </span>
                </label>
            </div>
            {{-- Tombol --}}
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-between">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Kembali
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-green-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-200">
                    Kirim Pengaduan
                </button>
            </div>

        </form>

        <p class="mt-6 text-center text-xs text-gray-500">
            Dinas Kependudukan dan Pencatatan Sipil Kabupaten Brebes
        </p>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const locationSelect = document.getElementById('service_location');
        const otherWrapper = document.getElementById('other-location-wrapper');
        const otherInput = document.getElementById('other_location');

        function toggleOtherLocation() {
            const isOther = locationSelect.value === 'Lainnya';

            otherWrapper.classList.toggle('hidden', !isOther);
            otherInput.required = isOther;

            if (!isOther) {
                otherInput.value = '';
            }
        }

        locationSelect.addEventListener('change', toggleOtherLocation);
        toggleOtherLocation();
    });

const attachmentInput = document.getElementById('attachments');
const selectedFiles = document.getElementById('selected-files');

attachmentInput.addEventListener('change', function () {
    selectedFiles.innerHTML = '';

    Array.from(this.files).forEach(function (file) {
        const item = document.createElement('div');

        item.className = 'rounded-lg bg-green-50 px-4 py-3 text-sm text-gray-700';

        item.textContent = file.name + ' (' +
            (file.size / 1024 / 1024).toFixed(2) + ' MB)';

        selectedFiles.appendChild(item);
    });
});
</script>
@endsection

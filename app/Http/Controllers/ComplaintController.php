<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ComplaintController extends Controller
{
    /**
     * Menampilkan formulir pengaduan.
     */
    public function create()
    {
        return view('public.complaints.create');
    }

    /**
     * Menyimpan pengaduan beserta dokumen pendukung.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],

            'service_location' => [
                'required',
                'in:Kantor Dindukcapil,Mal Pelayanan Publik (MPP),Kecamatan,Kios Adminduk Desa/Kelurahan,Lainnya'
            ],

            'other_location' => [
                'required_if:service_location,Lainnya',
                'nullable',
                'string',
                'max:255'
            ],

            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:10'],

            // Persetujuan pelapor
            'agreement' => ['required', 'accepted'],

            // Validasi dokumen pendukung
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png',
                'max:1024'
            ],
        ], [
            'name.required' => 'Nama pelapor wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari tepat 16 digit.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'service_location.required' => 'Lokasi pelayanan wajib dipilih.',
            'service_location.in' => 'Pilihan lokasi pelayanan tidak valid.',
            'other_location.required_if' => 'Mohon isi lokasi pelayanan lainnya.',
            'category.required' => 'Kategori pengaduan wajib dipilih.',
            'description.required' => 'Isi pengaduan wajib ditulis.',
            'description.min' => 'Isi pengaduan minimal 10 karakter.',
            'agreement.accepted' => 'Anda harus menyetujui pernyataan terlebih dahulu.',
            'attachments.array' => 'Format lampiran tidak valid.',
            'attachments.max' => 'Maksimal 5 file yang dapat diunggah.',
            'attachments.*.file' => 'Lampiran harus berupa file.',
            'attachments.*.mimes' => 'Lampiran hanya boleh berupa JPG, JPEG, atau PNG.',
            'attachments.*.max' => 'Ukuran setiap lampiran maksimal 1 MB.',
        ]);

        // Pisahkan data lampiran dan persetujuan dari data pengaduan.
        $attachments = $validated['attachments'] ?? [];

        unset(
            $validated['attachments'],
            $validated['agreement']
        );

        // Kosongkan lokasi lainnya jika tidak memilih Lainnya.
        if ($validated['service_location'] !== 'Lainnya') {
            $validated['other_location'] = null;
        }

        // Membuat nomor tiket unik.
        do {
            $ticketNumber = 'ADK-' . now()->format('Ymd') . '-' .
                Str::upper(Str::random(3));
        } while (Complaint::where('ticket_number', $ticketNumber)->exists());

        // Membuat kode akses rahasia.
        $accessCode = Str::upper(Str::random(4));

        // Menampung lokasi file untuk keperluan pembersihan jika gagal.
        $storedPaths = [];

        try {
            DB::transaction(function () use (
                $validated,
                $attachments,
                $ticketNumber,
                $accessCode,
                &$storedPaths
            ) {
                // Simpan data pengaduan.
                $complaint = Complaint::create([
                    ...$validated,
                    'ticket_number' => $ticketNumber,
                    'access_code_hash' => Hash::make($accessCode),
                    'status' => 'Baru',
                ]);

                // Simpan setiap lampiran ke disk privat.
                foreach ($attachments as $file) {
                    $path = $file->store('', 'complaint_private');

                    $storedPaths[] = $path;

                    // Simpan informasi lampiran ke database.
                    $complaint->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'stored_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            });

        } catch (Throwable $exception) {
            // Hapus file jika proses database gagal.
            if (!empty($storedPaths)) {
                Storage::disk('complaint_private')->delete($storedPaths);
            }

            throw $exception;
        }

        // Tampilkan kode akses hanya sekali setelah berhasil.
        session()->flash('complaint_ticket', $ticketNumber);
        session()->flash('complaint_access_code', $accessCode);

        return redirect()->route('complaints.success');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicComplaintStatusController extends Controller
{
    public function index()
    {
        return view('public.complaints.check');
    }

    // Memeriksa nomor tiket dan kode akses
    public function check(Request $request)
    {
        $validated = $request->validate([
            'ticket_number' => ['required', 'string', 'max:50'],
            'access_code' => ['required', 'string', 'max:50'],
        ], [
            'ticket_number.required' => 'Nomor tiket wajib diisi.',
            'access_code.required' => 'Kode akses wajib diisi.',
        ]);

        $complaint = Complaint::where(
            'ticket_number',
            strtoupper(trim($validated['ticket_number']))
        )->first();

        if (
            !$complaint ||
            !Hash::check(
                strtoupper(trim($validated['access_code'])),
                $complaint->access_code_hash
            )
        ) {
            return back()
                ->withErrors([
                    'access_code' => 'Nomor tiket atau kode akses tidak sesuai.',
                ])
                ->withInput($request->only('ticket_number'));
        }

        // Regenerasi session setelah verifikasi berhasil
        $request->session()->regenerate();

        // Simpan identitas pengaduan yang sudah diverifikasi
        $request->session()->put(
            'public_complaint_id',
            $complaint->id
        );

        return redirect()->route('public.complaints.status');
    }

    // Menampilkan detail dan percakapan
    public function detail(Request $request)
    {
        $complaintId = $request->session()->get('public_complaint_id');

        if (!$complaintId) {
            return redirect()
                ->route('public.complaints.check')
                ->withErrors([
                    'access_code' => 'Silakan verifikasi nomor tiket dan kode akses terlebih dahulu.',
                ]);
        }

        $complaint = Complaint::with([
            'messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
        ])->find($complaintId);

        if (!$complaint) {
            $request->session()->forget('public_complaint_id');

            return redirect()->route('public.complaints.check');
        }

        return view('public.complaints.status', compact('complaint'));
    }

    // Menerima balasan dari masyarakat
    public function reply(Request $request)
    {
        $complaintId = $request->session()->get('public_complaint_id');

        if (!$complaintId) {
            return redirect()->route('public.complaints.check');
        }

        $complaint = Complaint::find($complaintId);

        if (!$complaint) {
            $request->session()->forget('public_complaint_id');

            return redirect()->route('public.complaints.check');
        }

        // Pengaduan yang sudah ditutup tidak dapat dibalas
        if (in_array($complaint->status, ['Selesai', 'Dicabut'])) {
            return back()->withErrors([
                'message' => 'Pengaduan sudah ditutup dan tidak dapat menerima balasan.',
            ]);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:5000'],
        ], [
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 2 karakter.',
            'message.max' => 'Pesan maksimal 5.000 karakter.',
        ]);

        $complaint->messages()->create([
            'sender_type' => 'complainant',
            'message' => $validated['message'],
        ]);

        // Jika sebelumnya menunggu balasan masyarakat,
        // ubah kembali menjadi Diproses.
        if ($complaint->status === 'Menunggu Balasan') {
            $complaint->update([
                'status' => 'Diproses',
            ]);
        }

        return redirect()
            ->route('public.complaints.status')
            ->with('success', 'Balasan Anda berhasil dikirim.');
    }
}

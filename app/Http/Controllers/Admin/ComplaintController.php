<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::query();

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load([
            'attachments',
            'messages',
        ]);

        return view('admin.complaints.show', compact('complaint'));
    }

    public function reply(Request $request, Complaint $complaint)
    {
        if (in_array($complaint->status, ['Selesai', 'Dicabut'])) {
            return back()->withErrors([
                'message' => 'Pengaduan sudah ditutup. Ubah status menjadi aktif terlebih dahulu untuk membalas.',
            ]);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:5000'],
        ], [
            'message.required' => 'Pesan balasan wajib diisi.',
            'message.min' => 'Pesan minimal 2 karakter.',
            'message.max' => 'Pesan maksimal 5.000 karakter.',
        ]);

        $complaint->messages()->create([
            'sender_type' => 'admin',
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'Baru',
                    'Diproses',
                    'Menunggu Balasan',
                    'Selesai',
                    'Dicabut',
                ]),
            ],
        ]);

        $complaint->update([
            'status' => $validated['status'],
            'completed_at' => $validated['status'] === 'Selesai'
                ? ($complaint->completed_at ?? now())
                : null,
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function showAttachment(
        Complaint $complaint,
        ComplaintAttachment $attachment
    ) {
        abort_unless(
            $attachment->complaint_id === $complaint->id,
            404
        );

        $disk = Storage::disk('complaint_private');

        abort_unless($disk->exists($attachment->stored_path), 404);

        $path = $disk->path($attachment->stored_path);

        $mime = $attachment->mime_type;

        abort_unless(
            in_array($mime, ['image/jpeg', 'image/png']),
            404
        );

        return response()->file($path, [
            'Content-Type' => $mime,
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline',
        ]);
    }
}

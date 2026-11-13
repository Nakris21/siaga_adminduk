<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
    $statistics = [
        'total' => Complaint::count(),
        'baru' => Complaint::where('status', 'Baru')->count(),
        'diproses' => Complaint::where('status', 'Diproses')->count(),
        'menunggu_balasan' => Complaint::where('status', 'Menunggu Balasan')->count(),
        'selesai' => Complaint::where('status', 'Selesai')->count(),
        'dicabut' => Complaint::where('status', 'Dicabut')->count(),
    ];

    $recentComplaints = Complaint::latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'statistics',
        'recentComplaints'
    ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DetailProfileController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user();
        
        // Get total active loans
        $totalPeminjaman = $pengguna->peminjaman()
            ->whereIn('status', ['diajukan', 'diproses', 'disetujui'])
            ->count();
            
        // Get recent activities
        $aktivitasTerbaru = $pengguna->peminjaman()
            ->with(['ruangan', 'sarana'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get join year
        $tahunBergabung = $pengguna->created_at->format('Y');

        return view('profile', compact('pengguna', 'totalPeminjaman', 'aktivitasTerbaru', 'tahunBergabung'));
    }
}
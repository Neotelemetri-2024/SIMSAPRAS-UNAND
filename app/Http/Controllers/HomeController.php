<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;


class HomeController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user(); 
        $pengumuman = Pengumuman::latest()->get();

        return view('home', compact('pengguna', 'pengumuman'));
    }
}
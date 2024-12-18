<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Sarana;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
        $kategori = KategoriSarana::all();
        $sarana = Sarana::all();

        return view('admin.dashboard', compact('kategori', 'sarana'));
    }
}

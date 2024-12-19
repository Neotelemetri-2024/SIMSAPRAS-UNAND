<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanAdminController extends Controller
{
    public function PeminjamanMasuk() {
        return view('admin.pmasuk');
    }

    public function PeminjamanKeluar() {
        return view('admin.pkeluar');
    }
}
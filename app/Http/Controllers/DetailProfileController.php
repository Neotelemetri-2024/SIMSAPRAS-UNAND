<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DetailProfileController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user(); 
        return view('profile', compact('pengguna'));
    }
}
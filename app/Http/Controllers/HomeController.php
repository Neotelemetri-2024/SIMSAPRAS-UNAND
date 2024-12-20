<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user(); 
        return view('home', compact('pengguna'));
    }
}
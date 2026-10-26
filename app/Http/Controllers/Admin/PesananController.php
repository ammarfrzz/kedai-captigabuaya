<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PesananController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.pesanan.dine_in');
    }

    public function dineIn()
    {
        return view('admin.pesanan.dine_in', ['tipe' => 'dine_in']);
    }

    public function takeAway()
    {
        return view('admin.pesanan.take_away', ['tipe' => 'take_away']);
    }

    public function create()
    {
        return redirect()->route('admin.pesanan.dine_in');
    }

    public function show($id)
    {
        return view('admin.pesanan.show', compact('id'));
    }
}

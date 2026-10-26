<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AkunController extends Controller
{
    public function index()
    {
        return view('admin.akun.index');
    }

    public function update()
    {
        // TODO: update profil admin
        return redirect()->route('admin.akun')->with('success', 'Pengaturan akun berhasil disimpan.');
    }
}

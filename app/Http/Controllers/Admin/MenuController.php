<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    public function terlaris()
    {
        $allMenus = collect(Menu::all());
        $terlarisMenus = $allMenus->where('terlaris', true)->values();
        return view('admin.menu.terlaris', compact('terlarisMenus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store()
    {
        // TODO: simpan menu ke database
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $allMenus = collect(Menu::all());
        $menu = $allMenus->firstWhere('id', (int) $id) ?? $allMenus->first();
        return view('admin.menu.edit', compact('id', 'menu'));
    }

    public function update($id)
    {
        // TODO: update menu di database
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // TODO: hapus menu dari database
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}

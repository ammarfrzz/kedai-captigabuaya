<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function terlaris()
    {
        $terlarisMenus = Menu::where('terlaris', true)->orderBy('rating', 'desc')->get();
        return view('admin.menu.terlaris', compact('terlarisMenus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $gambarPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama_menu']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menus', $filename, 'public');
            $gambarPath = asset('storage/' . $path);
        }

        // Cari atau hubungkan kategori
        $category = Category::where('slug', $validated['kategori'])->first();

        Menu::create([
            'category_id' => $category?->id,
            'kategori'    => $validated['kategori'],
            'nama'        => $validated['nama_menu'],
            'slug'        => Str::slug($validated['nama_menu']),
            'harga'       => $validated['harga'],
            'deskripsi'   => $validated['deskripsi'] ?? null,
            'gambar'      => $gambarPath ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80',
            'is_available'=> true,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('admin.menu.edit', compact('id', 'menu', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama_menu' => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $category = Category::where('slug', $validated['kategori'])->first();

        $menuData = [
            'category_id' => $category?->id,
            'kategori'    => $validated['kategori'],
            'nama'        => $validated['nama_menu'],
            'slug'        => Str::slug($validated['nama_menu']),
            'harga'       => $validated['harga'],
            'deskripsi'   => $validated['deskripsi'],
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama_menu']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menus', $filename, 'public');
            $menuData['gambar'] = asset('storage/' . $path);
        }

        $menu->update($menuData);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus dari sistem.');
    }
}

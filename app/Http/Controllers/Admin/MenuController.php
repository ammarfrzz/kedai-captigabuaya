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
        $menus = Menu::orderByDesc('terlaris')->orderBy('id', 'desc')->get();
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
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'terlaris'  => ['nullable', 'boolean'],
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'harga.required' => 'Harga menu wajib diisi.',
            'harga.numeric' => 'Harga menu harus berupa angka.',
            'foto.image' => 'File foto harus berupa gambar valid.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal adalah 10 MB.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama_menu']) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            
            $targetDir = public_path('images/menus');
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;

            $realPath = $file->getRealPath();
            $saved = false;
            if ($realPath && file_exists($realPath)) {
                $saved = @copy($realPath, $targetPath);
            }
            if (!$saved && method_exists($file, 'getContent')) {
                $saved = (file_put_contents($targetPath, $file->getContent()) !== false);
            }

            if ($saved) {
                $gambarPath = asset('images/menus/' . $filename);
            }
        }

        // Cari atau hubungkan kategori
        $category = Category::where('slug', $validated['kategori'])->first();

        Menu::create([
            'category_id' => $category?->id,
            'kategori'    => $validated['kategori'],
            'nama'        => $validated['nama_menu'],
            'slug'        => Str::slug($validated['nama_menu']),
            'harga'       => $validated['harga'],
            'terlaris'    => $request->boolean('terlaris'),
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
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'terlaris'  => ['nullable', 'boolean'],
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'harga.required' => 'Harga menu wajib diisi.',
            'harga.numeric' => 'Harga menu harus berupa angka.',
            'foto.image' => 'File foto harus berupa gambar valid.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal adalah 10 MB.',
        ]);

        $category = Category::where('slug', $validated['kategori'])->first();

        $menuData = [
            'category_id' => $category?->id,
            'kategori'    => $validated['kategori'],
            'nama'        => $validated['nama_menu'],
            'slug'        => Str::slug($validated['nama_menu']),
            'harga'       => $validated['harga'],
            'terlaris'    => $request->boolean('terlaris'),
            'deskripsi'   => $validated['deskripsi'],
        ];

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama_menu']) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            
            $targetDir = public_path('images/menus');
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;

            // Hapus gambar lama jika ada di images/menus
            if (!empty($menu->gambar) && str_contains($menu->gambar, 'images/menus/')) {
                $oldFilename = basename(parse_url($menu->gambar, PHP_URL_PATH));
                $oldPath = public_path('images/menus/' . $oldFilename);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $realPath = $file->getRealPath();
            $saved = false;
            if ($realPath && file_exists($realPath)) {
                $saved = @copy($realPath, $targetPath);
            }
            if (!$saved && method_exists($file, 'getContent')) {
                $saved = (file_put_contents($targetPath, $file->getContent()) !== false);
            }

            if ($saved) {
                $menuData['gambar'] = asset('images/menus/' . $filename);
            }
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

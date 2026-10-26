<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LandingMedia;

class BannerController extends Controller
{
    /**
     * Tampilkan halaman kelola banner & semua gambar landing page
     */
    public function index(Request $request)
    {
        $allMedia = collect(LandingMedia::all());
        $sectionFilter = $request->get('section', 'semua');

        if ($sectionFilter && $sectionFilter !== 'semua') {
            $filteredMedia = $allMedia->where('section', $sectionFilter)->values();
        } else {
            $filteredMedia = $allMedia;
        }

        $stats = [
            'total' => $allMedia->count(),
            'customized' => $allMedia->whereNotNull('custom_url')->count(),
            'default' => $allMedia->whereNull('custom_url')->count(),
            'sections' => $allMedia->pluck('section')->unique()->count(),
        ];

        return view('admin.banner.index', compact('filteredMedia', 'stats', 'sectionFilter'));
    }

    /**
     * Update gambar untuk slot tertentu (bisa upload file atau URL eksternal)
     */
    public function update(Request $request)
    {
        $request->validate([
            'media_id' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'custom_url' => 'nullable|url|max:1000',
        ]);

        $mediaId = $request->input('media_id');
        $customUrl = $request->input('custom_url');
        $uploadedFile = $request->file('image_file');

        if (!$uploadedFile && empty($customUrl)) {
            return redirect()->back()->with('error', 'Silakan pilih file gambar baru untuk diunggah atau masukkan URL gambar valid.');
        }

        $success = LandingMedia::updateMedia($mediaId, $customUrl, $uploadedFile);

        if ($success) {
            return redirect()->back()->with('success', 'Gambar website landing page berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui gambar. Periksa format file Anda.');
    }

    /**
     * Reset gambar ke foto default bawaan sistem
     */
    public function reset(Request $request)
    {
        $request->validate([
            'media_id' => 'required|string',
        ]);

        $mediaId = $request->input('media_id');
        LandingMedia::resetToDefault($mediaId);

        return redirect()->back()->with('success', 'Gambar berhasil dikembalikan ke tampilan default awal.');
    }
}

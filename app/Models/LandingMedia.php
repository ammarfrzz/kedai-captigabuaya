<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class LandingMedia
{
    protected static string $storageFile = 'landing_media.json';

    /**
     * Definisi default slot media / gambar di website landing page
     */
    public static function defaults(): array
    {
        return [
            // ================= BERANDA / HERO =================
            [
                'id' => 'hero_bg',
                'section' => 'beranda',
                'section_label' => 'Beranda (Hero)',
                'label' => 'Background Banner Utama',
                'deskripsi' => 'Gambar latar belakang utama di bagian atas website (Hero Banner).',
                'default_path' => 'images/hero-bg.jpg',
                'custom_url' => null,
                'aspek_rasio' => '16:9 / Landscape Lebar',
                'dimensi_anjuran' => '1920 x 1080 px',
            ],

            // ================= TENTANG KAMI =================
            [
                'id' => 'about_main',
                'section' => 'tentang',
                'section_label' => 'Tentang Kami',
                'label' => 'Foto Cerita / Sejarah Kedai',
                'deskripsi' => 'Foto dokumentasi suasana atau cerita tiga sahabat di bagian Tentang Kami.',
                'default_path' => 'images/bgabout1.jpg',
                'custom_url' => null,
                'aspek_rasio' => '4:3 atau 3:2',
                'dimensi_anjuran' => '800 x 600 px',
            ],

            // ================= KENAPA PILIH KAMI =================
            [
                'id' => 'why_bento_wide',
                'section' => 'kenapa-kami',
                'section_label' => 'Kenapa Pilih Kami',
                'label' => 'Foto Suasana Kedai Santai (Bento Card)',
                'deskripsi' => 'Gambar kartu lebar suasana nongkrong santai di bagian Kenapa Pilih Kami.',
                'default_path' => 'images/whychooseus.JPG',
                'custom_url' => null,
                'aspek_rasio' => '16:9',
                'dimensi_anjuran' => '900 x 500 px',
            ],

            // ================= GALERI =================
            [
                'id' => 'gallery_1',
                'section' => 'galeri',
                'section_label' => 'Galeri Foto',
                'label' => 'Galeri 1 - Suasana Kedai',
                'deskripsi' => 'Foto pertama galeri yang menampilkan suasana dan kehangatan ruang kedai.',
                'default_path' => 'images/bggaleri1.jpg',
                'custom_url' => null,
                'aspek_rasio' => '4:3',
                'dimensi_anjuran' => '800 x 600 px',
            ],
            [
                'id' => 'gallery_2',
                'section' => 'galeri',
                'section_label' => 'Galeri Foto',
                'label' => 'Galeri 2 - Hidangan Spesial',
                'deskripsi' => 'Foto kedua galeri yang menampilkan sajian otentik kopitiam & kuliner.',
                'default_path' => 'images/Gallery2.jpg',
                'custom_url' => null,
                'aspek_rasio' => '4:3',
                'dimensi_anjuran' => '800 x 600 px',
            ],
            [
                'id' => 'gallery_3',
                'section' => 'galeri',
                'section_label' => 'Galeri Foto',
                'label' => 'Galeri 3 - Estetika & Detail',
                'deskripsi' => 'Foto ketiga galeri yang menampilkan sudut estetika kopitiam.',
                'default_path' => 'images/Gallery3.jpg',
                'custom_url' => null,
                'aspek_rasio' => '4:3',
                'dimensi_anjuran' => '800 x 600 px',
            ],
            [
                'id' => 'gallery_4',
                'section' => 'galeri',
                'section_label' => 'Galeri Foto',
                'label' => 'Galeri 4 - Minuman Segar',
                'deskripsi' => 'Foto keempat galeri yang menampilkan kesegaran kopi, soda, atau teh.',
                'default_path' => 'images/Gallery4.jpg',
                'custom_url' => null,
                'aspek_rasio' => '4:3',
                'dimensi_anjuran' => '800 x 600 px',
            ],
            [
                'id' => 'gallery_5',
                'section' => 'galeri',
                'section_label' => 'Galeri Foto',
                'label' => 'Galeri 5 - Momen Hangat',
                'deskripsi' => 'Foto kelima galeri menampilkan momen kebersamaan pelanggan di kedai.',
                'default_path' => 'images/Gallery5.png',
                'custom_url' => null,
                'aspek_rasio' => '4:3',
                'dimensi_anjuran' => '800 x 600 px',
            ],


            // ================= BANNER AJAKAN / FOOTER =================
            [
                'id' => 'cta_bg',
                'section' => 'cta',
                'section_label' => 'Banner Ajakan Kunjungan',
                'label' => 'Background Banner Ajakan Kunjungan',
                'deskripsi' => 'Banner penutup di atas footer untuk mengajak berkunjung ke kedai.',
                'default_path' => 'images/bgfooter.jpeg',
                'custom_url' => null,
                'aspek_rasio' => '16:9 / Landscape',
                'dimensi_anjuran' => '1920 x 800 px',
            ],
        ];
    }

    /**
     * Mengambil semua data slot media (termasuk kustomisasi yang tersimpan)
     */
    public static function all(): array
    {
        $defaults = self::defaults();
        $stored = self::getStoredCustomizations();

        return array_map(function ($item) use ($stored) {
            $id = $item['id'];
            if (isset($stored[$id])) {
                $item['custom_url'] = $stored[$id]['custom_url'] ?? $item['custom_url'];
                if (isset($stored[$id]['updated_at'])) {
                    $item['updated_at'] = $stored[$id]['updated_at'];
                }
            }
            $item['url'] = self::resolveUrl($item);
            return $item;
        }, $defaults);
    }

    /**
     * Ambil URL gambar yang aktif untuk ID slot tertentu
     */
    public static function get(string $id, ?string $fallback = null): string
    {
        $all = self::all();
        foreach ($all as $item) {
            if ($item['id'] === $id) {
                return $item['url'];
            }
        }

        if ($fallback) {
            return str_starts_with($fallback, 'http') ? $fallback : asset($fallback);
        }

        return asset('images/hero-bg.jpg');
    }

    /**
     * Perbarui gambar slot (bisa upload file atau URL eksternal)
     */
    public static function updateMedia(string $id, ?string $customUrl = null, $uploadedFile = null): bool
    {
        $stored = self::getStoredCustomizations();

        if ($uploadedFile && $uploadedFile->isValid()) {
            $filename = 'landing_' . $id . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storeAs('media', $filename, 'public');
            $customUrl = asset('storage/' . $path);
        }

        if ($customUrl !== null) {
            $stored[$id] = [
                'custom_url' => $customUrl,
                'updated_at' => date('d M Y, H:i') . ' WIB',
            ];
            self::saveStoredCustomizations($stored);
            return true;
        }

        return false;
    }

    /**
     * Reset gambar ke foto default bawaan
     */
    public static function resetToDefault(string $id): bool
    {
        $stored = self::getStoredCustomizations();
        if (isset($stored[$id])) {
            unset($stored[$id]);
            self::saveStoredCustomizations($stored);
            return true;
        }
        return false;
    }

    /**
     * Helper URL resolving
     */
    protected static function resolveUrl(array $item): string
    {
        if (!empty($item['custom_url'])) {
            $url = $item['custom_url'];
            // Tambahkan timestamp anti-cache jika asset lokal
            if (str_contains($url, asset('storage/'))) {
                return $url . '?v=' . time();
            }
            return $url;
        }

        if (!empty($item['default_path'])) {
            $fullPath = public_path($item['default_path']);
            $v = file_exists($fullPath) ? filemtime($fullPath) : time();
            return asset($item['default_path']) . '?v=' . $v;
        }

        return asset('images/hero-bg.jpg');
    }

    protected static function getStoredCustomizations(): array
    {
        if (Storage::disk('local')->exists(self::$storageFile)) {
            $json = Storage::disk('local')->get(self::$storageFile);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        return [];
    }

    protected static function saveStoredCustomizations(array $data): void
    {
        Storage::disk('local')->put(self::$storageFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}

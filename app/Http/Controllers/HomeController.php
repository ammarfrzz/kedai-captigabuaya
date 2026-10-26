<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama kedai.
     */
    public function index()
    {
        $menus = Menu::all();

        $galeri = [
            [
                'gambar' => \App\Models\LandingMedia::get('gallery_1', 'images/bggaleri1.jpg'),
                'judul'  => 'Suasana Kedai',
            ],
            [
                'gambar' => \App\Models\LandingMedia::get('gallery_2', 'images/Gallery2.jpg'),
                'judul'  => 'Hidangan Spesial',
            ],
            [
                'gambar' => \App\Models\LandingMedia::get('gallery_3', 'images/Gallery3.jpg'),
                'judul'  => 'Estetika',
            ],
        ];

        $testimoni = [
            [
                'nama'    => 'Budi Pratama',
                'role'    => 'Sahabat Ngopi Jemursari',
                'rating'  => 5,
                'pesan'   => 'Kopi butter-nya juara, gurihnya dapet dan nggak bikin enek! Paling pas dipadu sama Nasi Lemak Ayam CTB-nya. Tempatnya pewe banget buat nongkrong sore bareng circle sehabis ngampus',
                'avatar'  => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face&auto=format&q=80',
            ],
            [
                'nama'    => 'Siti Rahma',
                'role'    => 'Penikmat Teh Tarik',
                'rating'  => 5,
                'pesan'   => 'Teh tariknya beneran legit dan mantap khas kopitiam Melayu! Ropang srikayanya juga renyah manisnya pas. Seneng akhirnya di Surabaya nemu tempat kopitiam yang suasananya se-homey ini',
                'avatar'  => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face&auto=format&q=80',
            ],
            [
                'nama'    => 'Dinda Kirana',
                'role'    => 'Arek Suroboyo',
                'rating'  => 5,
                'pesan'   => 'Konsepnya asik pol, berasa nongkrong di rumah kawan sendiri! Nasi Telur Barendo plus Kopi Tubruk Susu udah jadi kombo wajib tiap kali mampir ke sini. Harganya juga ramah banget di kantong',
                'avatar'  => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop&crop=face&auto=format&q=80',
            ],
            [
                'nama'    => 'Fajar Maulana',
                'role'    => 'Langganan WFC',
                'rating'  => 5,
                'pesan'   => 'Cocok banget buat rehat sambil nugas santai. Pesen Mie Nyemek sama Soda Gembira, suasananya tenang dan pelayanannya beneran ramah!',
                'avatar'  => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face&auto=format&q=80',
            ],
        ];

        return view('home.index', compact('menus', 'galeri', 'testimoni'));
    }
}

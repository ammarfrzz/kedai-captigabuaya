<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman pembayaran & kasir pelanggan.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('payment.index', compact('menus'));
    }

    /**
     * Tampilkan halaman konfirmasi pembayaran & instruksi / struk pesanan.
     */
    public function confirmation()
    {
        return view('payment.confirmation');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PesananController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.pesanan.dine_in');
    }

    public function dineIn(Request $request)
    {
        $orders = Order::with('items')
            ->where('order_type', 'dine_in')
            ->latest()
            ->get();

        return view('admin.pesanan.dine_in', compact('orders'));
    }

    public function takeAway(Request $request)
    {
        $orders = Order::with('items')
            ->where('order_type', 'take_away')
            ->latest()
            ->get();

        return view('admin.pesanan.take_away', compact('orders'));
    }

    public function show($id)
    {
        // Cari berdasarkan id atau order_number
        $order = is_numeric($id) 
            ? Order::with(['items.menu'])->findOrFail($id)
            : Order::with(['items.menu'])->where('order_number', $id)->firstOrFail();

        return view('admin.pesanan.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_status'   => ['nullable', 'in:pending,processing,completed,cancelled'],
            'payment_status' => ['nullable', 'in:unpaid,paid'],
        ]);

        $order->update(array_filter($validated));

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Hapus pesanan (hanya untuk pesanan dengan status 'cancelled').
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Hanya pesanan dengan status 'cancelled' yang boleh dihapus
        if ($order->order_status !== 'cancelled') {
            return back()->with('error', 'Hanya pesanan dengan status "Dibatalkan" yang dapat dihapus dari sistem.');
        }

        $orderNumber = $order->order_number;
        $orderType = $order->order_type;

        $order->delete();

        // Jika dipanggil dari halaman detail pesanan, arahkan kembali ke daftar pesanan
        if ($request->input('from_show') || url()->previous() === route('admin.pesanan.show', $id)) {
            $redirectRoute = ($orderType === 'take_away') 
                ? route('admin.pesanan.take_away') 
                : route('admin.pesanan.dine_in');
            return redirect($redirectRoute)->with('success', "Pesanan #{$orderNumber} yang dibatalkan telah berhasil dihapus dari sistem.");
        }

        return back()->with('success', "Pesanan #{$orderNumber} yang dibatalkan telah berhasil dihapus dari sistem.");
    }
}

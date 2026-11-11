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
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        $order->update(array_filter($validated));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui.',
                'order'   => [
                    'id'             => $order->id,
                    'payment_status' => $order->payment_status,
                    'order_status'   => $order->order_status,
                    'payment_method' => $order->payment_method,
                ]
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Konfirmasi penerimaan pembayaran tunai langsung dari kasir (1-klik).
     */
    public function markAsPaid(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $updateData = [
            'payment_status' => 'paid',
        ];

        // Jika status pesanan masih pending, naikkan ke processing (sedang diproses dapur)
        if ($order->order_status === 'pending') {
            $updateData['order_status'] = 'processing';
        }

        // Jika metode bayar belum ada atau kasir, pastikan tersimpan rapi
        if (empty($order->payment_method) || str_contains(strtolower($order->payment_method), 'kasir')) {
            $updateData['payment_method'] = 'Tunai (Kasir)';
        }

        $order->update($updateData);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Pembayaran pesanan #{$order->order_number} berhasil dikonfirmasi LUNAS.",
                'order'   => [
                    'id'             => $order->id,
                    'payment_status' => $order->payment_status,
                    'order_status'   => $order->order_status,
                    'payment_method' => $order->payment_method,
                ]
            ]);
        }

        return back()->with('success', "Pembayaran pesanan #{$order->order_number} berhasil dikonfirmasi LUNAS.");
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

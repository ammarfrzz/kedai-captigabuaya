<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman pembayaran & kasir pelanggan.
     */
    public function index()
    {
        $menus = Menu::where('is_available', true)->get();
        return view('payment.index', compact('menus'));
    }

    /**
     * API / Endpoint Simpan Pesanan Pelanggan ke Database
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:150'],
            'order_type'     => ['required', 'in:dine_in,take_away,dine-in,take-away,takeaway'],
            'table_number'   => ['nullable', 'regex:/^[0-9]+$/', 'max:10'],
            'notes'          => ['nullable', 'string'],
            'payment_method' => ['required', 'string'],
            'items'          => ['required', 'array', 'min:1'],
            'items.*.id'     => ['nullable'],
            'items.*.name'   => ['required', 'string'],
            'items.*.price'  => ['required', 'numeric', 'min:0'],
            'items.*.qty'    => ['required', 'integer', 'min:1'],
        ]);

        $orderType = str_contains($validated['order_type'], 'dine') ? 'dine_in' : 'take_away';

        return DB::transaction(function () use ($validated, $orderType) {
            // Hitung total dan subtotal
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }
            $total = $subtotal;

            // Generate nomor nota pesanan: CTB-YYYYMMDD-XXXX
            $today = date('Ymd');
            $randomCode = strtoupper(substr(uniqid(), -4));
            $orderNumber = "CTB-{$today}-{$randomCode}";

            // Simpan Order Master
            $order = Order::create([
                'order_number'   => $orderNumber,
                'order_type'     => $orderType,
                'customer_name'  => $validated['customer_name'],
                'table_number'   => $orderType === 'dine_in' ? ($validated['table_number'] ?? '-') : null,
                'subtotal'       => $subtotal,
                'tax'            => 0,
                'total'          => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'order_status'   => 'pending',
                'notes'          => $validated['notes'] ?? null,
            ]);

            // Simpan Rincian Item Pesanan
            foreach ($validated['items'] as $item) {
                $itemSubtotal = $item['price'] * $item['qty'];
                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => is_numeric($item['id'] ?? null) ? $item['id'] : null,
                    'menu_name'  => $item['name'],
                    'price'      => $item['price'],
                    'quantity'   => $item['qty'],
                    'subtotal'   => $itemSubtotal,
                    'notes'      => $item['notes'] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'order'   => [
                    'id'           => $order->order_number,
                    'order_id'     => $order->id,
                    'total'        => $order->total,
                    'customer_name'=> $order->customer_name,
                    'order_type'   => $order->order_type,
                    'table_number' => $order->table_number,
                    'status'       => $order->order_status,
                ],
            ]);
        });
    }

    /**
     * Tampilkan halaman konfirmasi pembayaran & instruksi / struk pesanan.
     */
    public function confirmation()
    {
        return view('payment.confirmation');
    }

    /**
     * Batalkan pesanan pelanggan dan hapus dari database (khusus pembayaran QRIS belum bayar).
     */
    public function cancelOrder(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $orderId = $request->input('order_id');

        $query = Order::query();
        if ($orderId) {
            $query->where('id', $orderId);
        } elseif ($orderNumber) {
            $query->where('order_number', $orderNumber);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Parameter order_number atau order_id tidak ditemukan.'
            ], 400);
        }

        $order = $query->first();

        if ($order) {
            $isQris = str_contains(strtolower($order->payment_method ?? ''), 'qris');
            // Hapus dari database jika metode QRIS dan belum dibayar (unpaid)
            if ($isQris && $order->payment_status === 'unpaid') {
                $order->delete();
                return response()->json([
                    'success' => true,
                    'deleted' => true,
                    'message' => 'Pesanan QRIS berhasil dibatalkan dan dihapus dari database.'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'deleted' => false,
            'message' => 'Pesanan tidak ditemukan atau bukan pesanan QRIS belum bayar.'
        ]);
    }
}

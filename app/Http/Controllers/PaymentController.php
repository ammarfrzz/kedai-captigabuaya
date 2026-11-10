<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

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

            // Generate Snap Token jika metode pembayaran QRIS / Online
            $snapToken = null;
            $isOnlinePay = str_contains(strtolower($validated['payment_method']), 'qris') || 
                           str_contains(strtolower($validated['payment_method']), 'midtrans');

            if ($isOnlinePay) {
                try {
                    $midtransService = new MidtransService();
                    $snapToken = $midtransService->createSnapToken($order);
                } catch (\Throwable $e) {
                    Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                        'order_id' => $order->id,
                        'trace'    => $e->getTraceAsString(),
                    ]);
                }
            }

            return response()->json([
                'success'    => true,
                'message'    => 'Pesanan berhasil dibuat.',
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
                'order'      => [
                    'id'           => $order->order_number,
                    'order_id'     => $order->id,
                    'total'        => $order->total,
                    'customer_name'=> $order->customer_name,
                    'order_type'   => $order->order_type,
                    'table_number' => $order->table_number,
                    'status'       => $order->order_status,
                    'snap_token'   => $snapToken,
                ],
            ]);
        });
    }

    /**
     * Tampilkan halaman konfirmasi pembayaran & instruksi / struk pesanan.
     */
    public function confirmation()
    {
        $clientKey = config('midtrans.client_key');
        $isProduction = config('midtrans.is_production', false);
        $snapUrl = $isProduction 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';

        return view('payment.confirmation', compact('clientKey', 'snapUrl'));
    }

    /**
     * Endpoint untuk pengecekan status pesanan secara berkala (polling) dari frontend.
     * Otomatis menanyakan langsung ke API Server Midtrans tanpa memerlukan Ngrok / Webhook!
     */
    public function checkStatus(Request $request)
    {
        $orderNumber = $request->query('order_number');
        if (!$orderNumber) {
            return response()->json(['error' => 'Order number required'], 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Jika saat ini masih unpaid dan memiliki snap_token, tembak langsung API Midtrans
        if ($order->payment_status === 'unpaid') {
            try {
                $midtransService = new MidtransService();
                $statusResponse = $midtransService->getTransactionStatus($order->order_number);

                if ($statusResponse) {
                    $transactionStatus = $statusResponse->transaction_status ?? null;
                    $fraudStatus       = $statusResponse->fraud_status ?? null;

                    if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                        $order->update([
                            'payment_status' => 'paid',
                            'order_status'   => 'processing',
                        ]);
                    } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                        $order->update([
                            'order_status' => 'cancelled',
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Abaikan jika belum ada transaksi di Midtrans
            }
        }

        return response()->json([
            'order_number'   => $order->order_number,
            'payment_status' => $order->payment_status,
            'order_status'   => $order->order_status,
            'snap_token'     => $order->snap_token,
        ]);
    }

    /**
     * Webhook / HTTP Notification Handler dari Midtrans
     */
    public function notification(Request $request)
    {
        try {
            $midtransService = new MidtransService();
            $data = $midtransService->handleNotification();

            $orderNumber = $data['order_id'];
            $transactionStatus = $data['status'];
            $fraudStatus = $data['fraud'];
            $paymentType = $data['type'];

            // Log untuk audit notifikasi yang masuk
            Log::info('Midtrans Notification Received:', [
                'order_number' => $orderNumber,
                'status'       => $transactionStatus,
                'payment_type' => $paymentType
            ]);

            // Jika Midtrans melakukan ping test (order_id dummy / tidak ada di database), return 200 OK
            if (!$orderNumber) {
                return response()->json(['status' => 'success', 'message' => 'Empty order id handled']);
            }

            $order = Order::where('order_number', $orderNumber)->first();
            if (!$order) {
                // Return 200 agar Midtrans menganggap URL valid saat initial verification
                return response()->json(['status' => 'success', 'message' => 'Order not found, verification passed']);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->update(['payment_status' => 'unpaid']);
                } else if ($fraudStatus == 'accept') {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status'   => 'processing',
                    ]);
                }
            } else if ($transactionStatus == 'settlement') {
                // Pembayaran sukses (QRIS, GoPay, VA, dsb.)
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'processing',
                ]);
            } else if ($transactionStatus == 'pending') {
                $order->update([
                    'payment_status' => 'unpaid',
                ]);
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'payment_status' => 'unpaid',
                    'order_status'   => 'cancelled',
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Notification handled']);
        } catch (\Throwable $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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

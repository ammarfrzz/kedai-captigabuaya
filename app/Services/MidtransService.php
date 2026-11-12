<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use App\Models\Order;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('midtrans.is_3ds', true);
        Config::$curlOptions = [
            10023 => [], // CURLOPT_HTTPHEADER
            64 => false, // CURLOPT_SSL_VERIFYPEER
            81 => 0,     // CURLOPT_SSL_VERIFYHOST
        ];
    }

    /**
     * Dapatkan Snap Token untuk Order
     */
    public function createSnapToken(Order $order): string
    {
        if (!empty($order->snap_token)) {
            return $order->snap_token;
        }

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id'       => (string) ($item->menu_id ?? 'ITEM-' . $item->id),
                'price'    => (int) round($item->price),
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->menu_name, 0, 50),
            ];
        }

        // Jika subtotal item tidak sama persis dengan total order karena pembulatan, sesuaikan
        $calculatedSum = array_sum(array_map(fn($it) => $it['price'] * $it['quantity'], $items));
        $grossAmount = (int) round($order->total);

        if ($calculatedSum !== $grossAmount) {
            $items = [
                [
                    'id'       => $order->order_number,
                    'price'    => $grossAmount,
                    'quantity' => 1,
                    'name'     => 'Pesanan Kedai Cap Tiga Buaya #' . $order->order_number,
                ]
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone'      => $order->customer_phone ?? '081234567890',
            ],
            'item_details' => $items,
        ];

        // Filter / Custom Payment Channels (Opsi B)
        $enabledPayments = config('midtrans.enabled_payments');
        if (!empty($enabledPayments) && is_array($enabledPayments)) {
            $params['enabled_payments'] = array_values($enabledPayments);
        }

        $snapToken = Snap::getSnapToken($params);

        $order->update([
            'snap_token' => $snapToken,
        ]);

        return $snapToken;
    }

    /**
     * Dapatkan status transaksi langsung dari server API Midtrans
     */
    public function getTransactionStatus(string $orderNumber)
    {
        try {
            return Transaction::status($orderNumber);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Parse Notifikasi Webhook dari Midtrans
     */
    public function handleNotification(): array
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        // Jika dipanggil via HTTP POST payload JSON
        if (is_array($payload) && !empty($payload)) {
            $transaction = $payload['transaction_status'] ?? null;
            $type        = $payload['payment_type'] ?? null;
            $orderId     = $payload['order_id'] ?? null;
            $fraud       = $payload['fraud_status'] ?? null;

            return [
                'status'      => $transaction,
                'type'        => $type,
                'order_id'    => $orderId,
                'fraud'       => $fraud,
                'raw'         => $payload,
            ];
        }

        // Fallback ke class resmi Notification Midtrans jika perlu
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status ?? null;

        return [
            'status'      => $transaction,
            'type'        => $type,
            'order_id'    => $orderId,
            'fraud'       => $fraud,
            'raw'         => $notif,
        ];
    }
}


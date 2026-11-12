<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | Enabled Payments (Metode Pembayaran yang Aktif di Popup Snap)
    |--------------------------------------------------------------------------
    | Daftar payment channel yang diizinkan muncul pada popup Midtrans Snap.
    | Pembayaran yang tidak stabil/error pada sandbox simulator (misal: seabank,
    | bsi, danamon, bank saqu, indomaret, akulaku, kredivo, dsb) dihide dengan
    | cara tidak menyertakannya di dalam list ini.
    | Bisa dikonfigurasi lewat .env dengan key MIDTRANS_ENABLED_PAYMENTS (koma).
    */
    'enabled_payments' => env('MIDTRANS_ENABLED_PAYMENTS') 
        ? array_filter(array_map('trim', explode(',', env('MIDTRANS_ENABLED_PAYMENTS'))))
        : [
            'qris',
            'bca_va',
            'bni_va',
            'bri_va',
            'permata_va',
            'cimb_va',
            'echannel', // Mandiri Bill Payment
            'other_va',
            'gopay',
            'shopeepay',
        ],
];



<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        // Pakai config() bukan env() — best practice Laravel
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Fix CURL SSL error di Laragon (development only)
        // Hapus baris ini saat deploy ke production!
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [], // Fix bug dari Midtrans SDK "Undefined array key 10023"
        ];
    }

    public function createSnapToken($orderId, $grossAmount, $customerDetails, $itemDetails)
    {
        // Parameter dinamis yang dilempar dari Controller
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $grossAmount,
            ],
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        return Snap::getSnapToken($params);
    }

    public function getTransactionStatus($orderId)
    {
        // Constructor service ini udah otomatis nyiapin Config::$serverKey dll
        return \Midtrans\Transaction::status($orderId);
    }
}
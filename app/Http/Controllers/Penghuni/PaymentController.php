<?php

namespace App\Http\Controllers\Penghuni;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use App\Models\Transaksi;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
  protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function halamanPembayaran(Request $request)
    {
        $grossAmount = 1200000; 
        $modalData = null;
        $orderId = $request->query('order_id');
        
        // TANGKEP DUA-DUANYA! Dari JS lu (status) atau dari Midtrans (transaction_status)
        $rawStatus = $request->query('status') ?? $request->query('transaction_status');
        $modalStatus = null;

        if ($orderId && $rawStatus) {
            // Terjemahin bahasa Midtrans biar JS lu ngerti
            if (in_array($rawStatus, ['success', 'settlement', 'capture'])) {
                $modalStatus = 'success';
            } elseif (in_array($rawStatus, ['pending'])) {
                $modalStatus = 'pending';
            } elseif (in_array($rawStatus, ['failed', 'deny', 'cancel', 'expire'])) {
                $modalStatus = 'failed';
            }

            $transaksi = Transaksi::with('tagihan')->where('order_id', $orderId)->first();
            
            if ($transaksi) {
                $modalData = $transaksi;
            }
        }

        return view('penghuni.pembayaran_penghuni', compact('grossAmount', 'modalData', 'modalStatus'));
    }

    public function prosesBayar(Request $request)
    {
        $user = Auth::user();

        // 1. Cari tagihan milik user ini yang statusnya MASIH BELUM LUNAS
        // Asumsi: id_penghuni di tabel tagihan itu nyambung ke tabel users. 
        $tagihan = Tagihan::where('id_penghuni', $user->id)
                          ->where('status_tagihan', 'Belum Lunas') 
                          ->first(); 

        // 2. Kalau tagihannya nggak ada (alias udah lunas semua), stop prosesnya!
        if (!$tagihan) {
            return response()->json([
                'status' => 'error',
                'message' => 'UDAH LUNAS, NGAPAIN BAYAR LAGI'
            ], 404);
        }

        // 3. Ambil nominal ASLI dari database, jangan di-hardcode!
        $grossAmount = $tagihan->nominal_tagihan; 
        
        $orderId = 'TRX-' . time() . '-' . $user->id; 

        $customerDetails = [
            'first_name' => $user->username ?? $user->name, // Jaga-jaga kalau username kosong
            'email' => $user->email,
        ];

        $itemDetails = [
            [
                // 4. Panggil ->id karena $tagihan itu objek
                'id'       => 'TAGIHAN-' . $tagihan->id, 
                'price'    => $grossAmount,
                'quantity' => 1,
                // Nama tagihannya kita bikin keren pake periode bulan dari database
                'name'     => 'Tagihan Kost ' . $tagihan->periode_bulan 
            ]
        ];

        $snapToken = $this->midtransService->createSnapToken(
            $orderId, 
            $grossAmount, 
            $customerDetails, 
            $itemDetails
        );

        Transaksi::create([
            'order_id'         => $orderId,
            'id_tagihan'       => $tagihan->id, // Panggil ->id lagi
            'snap_token'       => $snapToken,
            'status_transaksi' => 'menunggu', 
            'tipe_pembayaran'  => null, 
        ]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken
        ]);
    }
    // =========================================================
    // METHOD 2: WEBHOOK / NOTIFICATION HANDLER (WAJIB ADA!)
    // =========================================================
    public function webhook(Request $request)
    {
        try {
            $transaction = $request->transaction_status;
            $type = $request->payment_type;
            $orderId = $request->order_id;
            $fraud = $request->fraud_status;

            // Tambahin Log ini sementara buat mata-mata (Cek di laravel.log nanti)
            Log::info('Webhook Midtrans Masuk! Nyari Order ID: ' . $orderId);

            $transaksi = Transaksi::where('order_id', $orderId)->first();
            
            if(!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan bro. ID yang dicari: ' . $orderId], 404);
            }

            // 2. Cari tagihannya lewat id_tagihan yang udah disimpen di tabel transaksi
            $tagihan = Tagihan::where('id', $transaksi->id_tagihan)->first();

            // LOGIKA PENGECEKAN STATUS DARI MIDTRANS
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaksi->update(['status_transaksi' => 'menunggu']);
                    } else {
                        $transaksi->update(['status_transaksi' => 'berhasil']);
                        if($tagihan) $tagihan->update(['status_tagihan' => 'Lunas']);
                    }
                }
            } else if ($transaction == 'settlement') {
                // INI STATUS KALO PAKE GOPAY/QRIS/VA
                // Perhatiin nama kolomnya: status_transaksi (bukan status)
                $transaksi->update([
                    'status_transaksi' => 'berhasil',
                    'tipe_pembayaran' => $type
                ]);
                
                // Update tabel tagihannya jadi Lunas (Pake L gede biar sama kayak seeder lu)
                if($tagihan) {
                    $tagihan->update([
                        'status_tagihan' => 'Lunas',
                        'tanggal_bayar' => now() // Sekalian catet tanggal lunasnya
                    ]);
                }
                
            } else if ($transaction == 'pending') {
                $transaksi->update(['status_transaksi' => 'menunggu']);
                
            } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $transaksi->update(['status_transaksi' => 'gagal']);
            }

            return response()->json(['message' => 'Webhook berhasil diproses']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error dari server'], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Penghuni;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Tagihan;
use App\Models\Penghuni;
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
        $user = Auth::user();
        $modalData = null;
        $orderId = $request->query('order_id');

        $rawStatus = $request->query('status') ?? $request->query('transaction_status');
        $modalStatus = null;

        if ($orderId && $rawStatus) {
            if (in_array($rawStatus, ['success', 'settlement', 'capture'])) {
                $modalStatus = 'success';
            } elseif (in_array($rawStatus, ['pending'])) {
                $modalStatus = 'pending';
            } elseif (in_array($rawStatus, ['failed', 'deny', 'cancel', 'expire'])) {
                $modalStatus = 'failed';
            }

            $penghuni = Penghuni::where('id_user', $user->id)->first();
            
            $transaksi = Transaksi::with('tagihan')->where('order_id', $orderId)
                ->whereHas('tagihan', function($query) use ($penghuni) {
                    $query->where('id_penghuni', $penghuni->id);
                })
                ->first();

            if ($transaksi && $transaksi->status_transaksi === 'menunggu') {
                try {
                    $status = $this->midtransService->getTransactionStatus($orderId);
                    $transactionStatus = $status->transaction_status;
                    $type = $status->payment_type ?? null;
                    $fraud = $status->fraud_status ?? null;
                    $tagihan = $transaksi->tagihan;

                    if ($transactionStatus == 'capture') {
                        if ($type == 'credit_card') {
                            if ($fraud == 'challenge') {
                                $transaksi->update(['status_transaksi' => 'menunggu']);
                            } else {
                                $transaksi->update(['status_transaksi' => 'berhasil']);
                                if ($tagihan)
                                    $tagihan->update(['status_tagihan' => 'Lunas', 'tanggal_bayar' => now()]);
                            }
                        }
                    } else if ($transactionStatus == 'settlement') {
                        $transaksi->update([
                            'status_transaksi' => 'berhasil',
                            'tipe_pembayaran' => $type
                        ]);
                        if ($tagihan) {
                            $tagihan->update([
                                'status_tagihan' => 'Lunas',
                                'tanggal_bayar' => now()
                            ]);
                        }
                    } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                        $transaksi->update(['status_transaksi' => 'gagal']);
                    }
                    $transaksi->refresh();
                } catch (\Exception $e) {
                    Log::error('Midtrans Sync Error: ' . $e->getMessage());
                }
            }

            if ($transaksi) {
                $modalData = $transaksi;
            }
        }
        if (!isset($penghuni)) {
            $penghuni = Penghuni::where('id_user', $user->id)->first();
        }
        $tagihanSaatIni = null;
        $riwayatTagihan = collect();

        if ($penghuni) {
            $daftarBelumLunas = Tagihan::where('id_penghuni', $penghuni->id)
                ->where('status_tagihan', 'Belum Lunas')
                ->orderBy('jatuh_tempo', 'asc')
                ->get();

            $daftarMenunggu = Tagihan::where('id_penghuni', $penghuni->id)
                ->where('status_tagihan', 'Menunggu Konfirmasi')
                ->orderBy('jatuh_tempo', 'asc')
                ->get();

            if ($daftarBelumLunas->isNotEmpty()) {
                $tagihanSaatIni = (object) [
                    'status_tagihan'  => 'Belum Lunas',
                    'periode_bulan'   => $daftarBelumLunas->pluck('periode_bulan')->join(', '), 
                    'jatuh_tempo'     => $daftarBelumLunas->first()->jatuh_tempo, 
                    'nominal_tagihan' => $daftarBelumLunas->sum('nominal_tagihan'),
                ];
            } elseif ($daftarMenunggu->isNotEmpty()) {
                $tagihanSaatIni = (object) [
                    'status_tagihan'  => 'Menunggu Konfirmasi',
                    'periode_bulan'   => $daftarMenunggu->pluck('periode_bulan')->join(', '), 
                    'jatuh_tempo'     => $daftarMenunggu->first()->jatuh_tempo, 
                    'nominal_tagihan' => $daftarMenunggu->sum('nominal_tagihan'),
                ];
            } else {
                $tagihanSaatIni = null;
            }

            $riwayatTagihan = Tagihan::where('id_penghuni', $penghuni->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('penghuni.pembayaran_penghuni', compact('modalData', 'modalStatus', 'tagihanSaatIni', 'riwayatTagihan'));
    }

    public function prosesBayar(Request $request)
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        $tagihans = Tagihan::where('id_penghuni', $penghuni->id)
            ->where('status_tagihan', 'Belum Lunas')
            ->orderBy('jatuh_tempo', 'asc')
            ->get();

        if ($tagihans->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'UDAH LUNAS, NGAPAIN BAYAR LAGI'
            ], 404);
        }

        $tagihanUtama = $tagihans->first();

        $transaksiPending = Transaksi::where('id_tagihan', $tagihanUtama->id)->where('status_transaksi', 'menunggu')->first();
        if ($transaksiPending && $transaksiPending->snap_token){
            return response()->json([
                'status' => 'success',
                'snap_token' => $transaksiPending->snap_token,
                'pesan' => 'melanjutkan pembayaran'
        ]);
        }
        $grossAmount = $tagihans->sum('nominal_tagihan');
        $periodeGabungan = $tagihans->pluck('periode_bulan')->join(', ');

        $orderId = 'TRX-' . time() . '-' . $user->id;

        $customerDetails = [
            'first_name' => $user->username ?? $user->name, // Jaga-jaga kalau username kosong
            'email' => $user->email,
        ];

        $itemDetails = [
            [
                'id' => 'TAGIHAN-' . $tagihans->first()->id,
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Tagihan Kost ' . $periodeGabungan
            ]
        ];

        $snapToken = $this->midtransService->createSnapToken(
            $orderId,
            $grossAmount,
            $customerDetails,
            $itemDetails
        );

        Transaksi::create([
            'order_id' => $orderId,
            'id_tagihan' => $tagihans->first()->id,
            'snap_token' => $snapToken,
            'status_transaksi' => 'menunggu',
            'tipe_pembayaran'  => null,
            'nominal' => $grossAmount, 
            'nama' => $periodeGabungan,
        ]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken
        ]);
    }
    public function webhook(Request $request)
    {
        try {
            $transaction = $request->transaction_status;
            $type = $request->payment_type;
            $orderId = $request->order_id;

            Log::info('Webhook Midtrans Masuk! Nyari Order ID: ' . $orderId);

            $transaksi = Transaksi::where('order_id', $orderId)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan bro. ID: ' . $orderId], 404);
            }

            $tagihanPerwakilan = Tagihan::where('id', $transaksi->id_tagihan)->first();

            if (!$tagihanPerwakilan) {
                return response()->json(['message' => 'Tagihan tidak ditemukan bro.'], 404);
            }
            $idPenghuni = $tagihanPerwakilan->id_penghuni;

            if ($transaction == 'settlement') {
                
                $transaksi->update([
                    'status_transaksi' => 'berhasil',
                    'tipe_pembayaran' => $type
                ]);

                Tagihan::where('id_penghuni', $idPenghuni)
                    ->where('status_tagihan', 'Belum Lunas')
                    ->update([
                        'status_tagihan' => 'Lunas',
                        'tanggal_bayar' => now() 
                    ]);

                $this->bukaKunciPenghuni($idPenghuni);

            } else if ($transaction == 'pending') {
                $transaksi->update(['status_transaksi' => 'menunggu']);

            } else if (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $transaksi->update(['status_transaksi' => 'gagal']);
            }

            return response()->json(['message' => 'Webhook berhasil diproses']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error dari server'], 500);
        }
    }

    public function halamanManual(Request $request)
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();
        $tagihanSaatIni = null;

        if ($penghuni) {
            $tagihanSaatIni = Tagihan::where('id_penghuni', $penghuni->id)
                ->where('status_tagihan', 'Belum Lunas')
                ->latest()
                ->first();
        }

        return view('penghuni.pembayaran_manual', compact('tagihanSaatIni'));
    }

    public function prosesBayarManual(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $user = Auth::user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        if (!$penghuni) {
            return redirect()->back()->with('error', 'Data penghuni tidak ditemukan.');
        }

    $tagihan = Tagihan::where('id_penghuni', $penghuni->id)
        ->where('status_tagihan', 'Belum Lunas')
        ->get(); 

    if ($tagihan->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada tagihan yang harus dibayar.');
    }

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $path = $file->store('bukti', 'public');

            foreach($tagihan as $t){
                $t->update([
                    'status_tagihan' => 'Menunggu Konfirmasi',
                    'bukti_transfer' => 'storage/' . $path,
                ]);
            }

            return redirect()->route('penghuni.pembayaran')->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    private function bukaKunciPenghuni($id){
        $penghuni = Penghuni::find($id);
        if($penghuni){
            $user = User::where('id', $penghuni->id_user)->first();
            if($user->is_locked){
                $user->update([
                    'is_locked' => false,
                ]);
            }
        }
    }
}
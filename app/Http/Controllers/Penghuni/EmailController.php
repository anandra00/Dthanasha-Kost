<?php

namespace App\Http\Controllers\Penghuni;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Mail\SendOtpMail; 
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function submitEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.unique' => 'Email ini sudah terdaftar!'
        ]);

        $user = auth()->user();
        $otpCode = rand(100000, 999999);

        $user->update([
            'email' => $request->email,
            'otp_code' => Hash::make($otpCode),
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        try {
            Mail::to($request->email)->send(new SendOtpMail($otpCode, $user->name));
        } catch (\Exception $e) {
            $user->update(['email' => null, 'otp_code' => null, 'otp_expires_at' => null]);
            return back()->withErrors(['email' => 'Gagal mengirim email OTP, periksa koneksi.']);
        }

        return back()->with('success', 'Kode OTP berhasil dikirim!');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ], [
            'otp.required' => 'Kode OTP wajib diisi!',
            'otp.digits' => 'Kode OTP harus 6 angka!'
        ]);

        $user = auth()->user();

        if (is_null($user->otp_expires_at) || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa atau belum pernah diminta! Silakan kirim ulang email.']);
        }

        if (!Hash::check($request->otp, $user->otp_code)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai!']);
        }

        $user->update([
            'email_verified_at' => Carbon::now(),
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        return back()->with('success', 'Email berhasil diverifikasi!');
    }
    public function resetEmail(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'email' => null,
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        return back();
    }
}
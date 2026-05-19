<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Verifikasi Email</title>
</head>
<body style="background-color: #f4f4f5; font-family: Arial, sans-serif; padding: 40px 20px; margin: 0;">
    <div style="max-width: 440px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; padding: 40px; border: 1px solid #e4e4e7; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);">
        
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="font-size: 14px; font-weight: 900; color: #18181b; text-transform: uppercase; letter-spacing: 0.15em; margin: 0;">Dthanasha Kost</h2>
        </div>

        <p style="font-size: 14px; color: #18181b; font-weight: bold; margin-bottom: 16px;">
            Halo {{ $nama }},
        </p>
        <p style="font-size: 13px; color: #52525b; line-height: 1.6; margin-bottom: 32px;">
            Akun lu baru aja didaftarin di sistem dasbor penghuni. Untuk keamanan data dan sinkronisasi notifikasi tagihan bulanan, silakan gunakan kode OTP di bawah ini untuk memverifikasi alamat email lu:
        </p>

        <div style="text-align: center; background-color: #f4f4f5; padding: 20px; border-radius: 16px; letter-spacing: 8px; font-size: 32px; font-weight: 900; color: #18181b; margin-bottom: 32px; border: 1px solid #e4e4e7;">
            {{ $otpCode }}
        </div>

        <p style="font-size: 12px; color: #71717a; line-height: 1.6; margin-bottom: 32px;">
            *Kode ini cuma berlaku selama <strong>10 menit</strong> sejak email ini dikirim. Jangan bagikan kode ini ke siapapun termasuk ke pemilik kos.
        </p>

        <div style="border-top: 1px solid #e4e4e7; pt: 24px; text-align: center;">
            <p style="font-size: 11px; color: #a1a1aa; margin-top: 20px; margin-bottom: 0;">
                Email ini dikirim otomatis oleh sistem Dthanasha Kost.
            </p>
        </div>
    </div>
</body>
</html>
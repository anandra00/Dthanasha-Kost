<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Pembayaran</title>
</head>
<body style="font-family: sans-serif; color: #18181b; background-color: #fafafa; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; bg-color: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e4e4e7;">
        <h2 style="font-weight: 900; text-transform: uppercase;">Halo, {{ $tagihan->penghuni->nama_penghuni }} 👋</h2>
        <p style="font-size: 14px; color: #71717a;">
            Ini adalah pengingat otomatis dari sistem <strong>Dthanasha Kost</strong>. Tagihan sewa kos lu untuk periode <strong>{{ $tagihan->periode_bulan }}</strong> akan jatuh tempo dalam <strong>{{ $sisaHari }} hari lagi</strong>.
        </p>
        
        <div style="background-color: #f4f4f5; padding: 15px; border-radius: 12px; margin: 20px 0;">
            <table width="100%" style="font-size: 14px;">
                <tr>
                    <td style="font-weight: bold; padding: 5px 0;">Nominal Tagihan:</td>
                    <td style="text-align: right; font-weight: 900;">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 5px 0;">Jatuh Tempo:</td>
                    <td style="text-align: right; color: #ef4444; font-weight: bold;">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</td>
                </tr>
            </table>
        </div>

        <p style="font-size: 13px; color: #71717a; margin-bottom: 25px;">
            Silakan login ke dashboard penghuni untuk melakukan pembayaran via QRIS secara instan guna menghindari penangguhan akun otomatis.
        </p>
        
        <p style="font-size: 11px; color: #a1a1aa; text-align: center;">
            E-mail ini dibuat otomatis oleh sistem, mohon untuk tidak membalas email ini.
        </p>
    </div>
</body>
</html>
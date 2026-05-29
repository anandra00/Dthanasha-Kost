# Dthanasha Kost - Sistem Manajemen Rumah Kost Modern

Dthanasha Kost adalah sistem manajemen kost berbasis web yang dibangun menggunakan **Laravel 11** dan **Tailwind CSS**. Sistem ini memfasilitasi pemilik kost (Admin) dan penghuni kost dalam mengelola tagihan bulanan, pencatatan transaksi, manajemen kamar, serta integrasi pembayaran otomatis menggunakan **Midtrans Payment Gateway**.

---

## 🎯 Fitur Utama

### Sisi Pemilik Kost (Admin / Owner)
- **Dashboard Analitik:** Ringkasan total pendapatan, pengeluaran, daftar tagihan tertunggak, dan grafik keuangan tahunan.
- **Manajemen Kamar:** Pembuatan kamar lengkap dengan tipe, harga, dan status (Kosong/Terisi).
- **Data Penghuni:** Registrasi akun penghuni, alokasi kamar, manajemen profil, hingga *import* data dari Waiting List.
- **Waiting List:** Pencatatan antrean calon penghuni kost.
- **Manajemen Pembayaran:** Validasi pembayaran manual (cash/transfer) dan rekap transaksi dari Midtrans.
- **Riwayat Transaksi:** Pencatatan pemasukan otomatis dari tagihan, serta pencatatan **pengeluaran manual** (seperti biaya listrik, kebersihan, atau perbaikan infrastruktur).
- **Pengaturan Global:** Pengaturan nomor WhatsApp pemilik (untuk penerimaan keluhan) dan *setting* tanggal jatuh tempo tagihan setiap bulannya.

### Sisi Penghuni
- **Dashboard:** Pengecekan status kamar dan status tagihan bulan berjalan.
- **Pembayaran Tagihan:**
  - **Otomatis:** Integrasi *pop-up* Snap Midtrans untuk pembayaran menggunakan e-Wallet (Gopay, ShopeePay, dll), Virtual Account, atau QRIS.
  - **Manual:** Upload bukti transfer jika penghuni tidak menggunakan metode Midtrans.
- **Lapor Keluhan:** Tombol *shortcut* untuk mengirim pesan keluhan langsung ke WhatsApp pemilik (otomatis **terkunci/disable** jika penghuni belum melunasi tagihan aktif).
- **Profil:** Mengubah data pribadi seperti Kontak, Nomor Orang Tua, Email, dan Password.

---

## 💻 Tech Stack
- **Framework:** Laravel (PHP)
- **Frontend / Styling:** Tailwind CSS, Alpine.js, Blade Components
- **Authentication:** Laravel Breeze (dimodifikasi untuk sistem *Role-Based Access Control* : `owner` & `penghuni`)
- **Database:** MySQL
- **Integrasi Pihak Ketiga:** Midtrans API (Payment Gateway)
- **Ikon & Font:** Phosphor Icons, FontAwesome, Google Fonts (Plus Jakarta Sans & Inter)

---

## 🚀 Panduan Instalasi (Development)

Berikut adalah langkah-langkah untuk melakukan konfigurasi proyek di *local environment* Anda (menggunakan XAMPP, Laragon, dll).

### 1. Prasyarat
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL / MariaDB

### 2. Clone Repositori
```bash
git clone https://github.com/username/dthanasha-kost.git
cd dthanasha-kost
```

### 3. Install Dependensi PHP & Node
```bash
composer install
npm install
```

### 4. Konfigurasi Environment (`.env`)
Salin file environment dan atur koneksi database:
```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan pastikan konfigurasi berikut sudah sesuai:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dthanasha
DB_USERNAME=root
DB_PASSWORD=

# KONFIGURASI MIDTRANS
MIDTRANS_MERCHANT_ID=isi_merchant_id_anda
MIDTRANS_CLIENT_KEY=isi_client_key_anda
MIDTRANS_SERVER_KEY=isi_server_key_anda
MIDTRANS_IS_PRODUCTION=false
```

### 5. Migrasi & Seeding Database
Jalankan migrasi untuk membuat tabel, lalu lakukan *seeding* untuk membuat akun Admin dan Pengaturan awal.
```bash
php artisan migrate --seed
```
*(Catatan: Akun login bawaan bisa dicek di dalam file `DatabaseSeeder.php`)*

### 6. Build Frontend Asset & Jalankan Server
Buka 2 tab terminal terpisah:
```bash
# Terminal 1: Build dan watch Tailwind CSS
npm run dev

# Terminal 2: Jalankan web server Laravel
php artisan serve
```

Aplikasi sekarang dapat diakses melalui `http://127.0.0.1:8000`.

---

## ⚙️ Cron Job & Robot Tagihan Otomatis

Sistem Dthanasha menggunakan **Laravel Scheduler** untuk membuat tagihan secara otomatis untuk seluruh penghuni aktif pada **tanggal 1 setiap bulannya**.

Di *local development*, Anda bisa menjalankannya secara manual dengan:
```bash
php artisan schedule:work
```

### Setup di Server Produksi (cPanel / VPS)
Agar robot tagihan berjalan otomatis di latar belakang, tambahkan *Cron Job* berikut di server Anda (berjalan setiap 1 menit):
```bash
* * * * * cd /path-to-project/dthanasha && php artisan schedule:run >> /dev/null 2>&1
```

*(Tagihan pertengahan bulan: Jika penghuni masuk di tanggal 15, tagihannya tidak akan otomatis dibuat bulan tersebut. Pembayaran bulan pertama harus dimasukkan ke dalam menu **Riwayat -> Tambah Catatan Pemasukan**).*

---

## 🛠️ Konfigurasi Email Lupa Password

Sistem ini mendukung fitur *Forgot Password*. Namun secara default, pengiriman email pada environment *local* diarahkan ke file log (`MAIL_MAILER=log`). 

Untuk mengaktifkannya:
1. Daftar layanan SMTP seperti **Mailtrap** atau **Gmail App Password**.
2. Ubah `.env` Anda:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@dthanasha.com"
MAIL_FROM_NAME="Dthanasha Kost"
```

---

## 🪲 Troubleshooting / Masalah Umum

- **Gambar/Aset tidak muncul?** Pastikan Anda sudah menjalankan perintah `php artisan storage:link`.
- **Notifikasi Midtrans (Webhook) tidak masuk di Localhost?** Saat Anda mengetes Midtrans di local, API Midtrans tidak bisa mengirimkan notifikasi balik (*webhook*) ke `localhost`. Gunakan **Ngrok** atau letakkan aplikasi di server *live*.

---

*Dikembangkan dengan ❤️ untuk kemudahan manajemen rumah kost.*

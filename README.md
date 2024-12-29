<p align="center">
    <a href="https://unand.ac.id">
        <img src="https://github.com/user-attachments/assets/39661e44-107f-423e-a43c-7d7683b91317" width="200" alt="Logo Unand">
    </a>
    <a href="https://www.neotelemetri.com/">
        <img src="https://github.com/user-attachments/assets/572659ac-6f6f-4b61-81ed-a7c16562e3c6" width="250" alt="Logo UKM Neo Telemetri">
    </a>
</p>

<h1 align="center">SIMSAPRAS UNAND</h1>
<h3 align="center">Sistem Informasi Peminjaman Sarana dan Prasarana Universitas Andalas</h3>

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="150" alt="Laravel Logo">&nbsp;&nbsp;&nbsp;
    <img src="https://raw.githubusercontent.com/tailwindlabs/tailwindcss/master/.github/logo-dark.svg" width="150" alt="Tailwind CSS Logo">&nbsp;&nbsp;&nbsp;
    <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" width="100" alt="MySQL Logo">
</p>

## 🌟 Tentang SIMSAPRAS UNAND

SIMSAPRAS UNAND adalah sistem informasi manajemen yang dirancang khusus untuk mengelola peminjaman sarana dan prasarana di lingkungan Universitas Andalas. Sistem ini memudahkan proses peminjaman fasilitas universitas dengan cara yang efisien dan terorganisir.

## ✨ Fitur Utama

- Manajemen peminjaman sarana dan prasarana
- Sistem booking dengan kalender interaktif
- Pengelolaan pengumuman
- Dashboard admin yang komprehensif
- Sistem tracking status peminjaman
- Manajemen ruangan dan fasilitas
- Notifikasi status peminjaman

## 🚀 Teknologi

Sistem ini dibangun menggunakan teknologi-teknologi modern:

- **[Laravel](https://laravel.com/)** - Framework PHP
- **[Tailwind CSS](https://tailwindcss.com/)** - Framework CSS
- **[Alpine.js](https://alpinejs.dev/)** - Framework JavaScript
- **[MySQL](https://www.mysql.com/)** - Database Management System
- **[SweetAlert2](https://sweetalert2.github.io/)** - Beautiful Alert Messages
- **[FullCalendar](https://fullcalendar.io/)** - Calendar Interface

## 💻 Instalasi

1. Clone repository
```bash
git clone https://github.com/Neotelemetri-2024/SIMSAPRAS-UNAND.git
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simsapras_unand
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrate database
```bash
php artisan migrate
php artisan db:seed
```

6. Jalankan aplikasi
```bash
php artisan serve
npm run dev
```

## 📱 Penggunaan

1. **Autentikasi**
   - Akses halaman login
   - Masukkan kredensial yang sesuai

2. **Peminjaman Sarana**
   - Pilih sarana yang akan dipinjam
   - Isi form peminjaman
   - Pilih tanggal dan waktu
   - Submit permintaan peminjaman

3. **Monitoring Status**
   - Cek status peminjaman
   - Lihat riwayat peminjaman
   - Terima notifikasi update status

## 👥 Tim Pengembang

- Project Manager: Muhammad Nouval Habibie
- Developer: Khalied Nauly Maturino

## 📞 Kontak

Untuk informasi lebih lanjut, silakan hubungi:
- Email: neotelemetri@gmail.com
- Website: neotelemetri.com

## 🙏 Terima Kasih

Terima kasih kepada seluruh pihak yang telah berkontribusi dalam pengembangan SIMSAPRAS UNAND:
- Universitas Andalas
- Tim Pengembang
- Dan semua pihak yang telah membantu

---
<p align="center">© 2024 Neo Telemetri. All rights reserved.</p>
```

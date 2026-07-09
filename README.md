# 📦 Inventaris App

Aplikasi manajemen inventaris berbasis web yang dibangun menggunakan Laravel. Digunakan untuk mengelola data barang, peminjaman, laporan, dan monitoring stok.

---

## 🚀 Fitur Utama

### 🔐 Authentication & Role
- Login & Register
- Role: Admin, Staff, Manager, User
- Middleware proteksi akses

### 📦 Manajemen Barang
- CRUD Barang
- Kategori Barang (Relasi)
- Upload Gambar
- Detail Barang
- Search & Pagination

### 🔄 Peminjaman Barang
- Multi-item borrowing (1 transaksi banyak barang)
- Quantity per item
- Status: pending, approved, returned
- History peminjaman

### 📊 Dashboard
- Total barang
- Barang tersedia & dipinjam
- Low stock alert
- Grafik bulanan (Line Chart)
- Top borrowed (Bar Chart)
- Recent activity

### 📤 Report
- Export PDF
- Export Excel
- Filter tanggal

### 📜 Activity Log
- Log CRUD
- Log Peminjaman
- Pagination & Filter

---

## 🧱 Database

Tabel utama:
- users
- roles
- products
- categories
- borrowings
- borrowing_details

---

## ⚙️ Cara Instalasi

1. Clone repository

    git clone https://github.com/riskyhelen05/inventaris-app.git


2. Masuk ke folder project

    cd inventaris-app


3. Install dependency

    composer install
    npm install


4. Copy file env

    cp .env.example .env


5. Generate key

    php artisan key:generate


6. Setup database di `.env`

    DB_DATABASE=inventaris_db
    DB_USERNAME=root
    DB_PASSWORD=


7. Import database
    - Buka phpMyAdmin
    - Import file `database.sql`

8. Jalankan migration (optional jika tidak pakai import)

    php artisan migrate


9. Jalankan server

    php artisan serve


10. Jalankan frontend

    npm run dev


---

## 🔑 Akun Testing

| Role   | Email              | Password    |
|--------|--------------------|-------------|
| Admin  | admin@gmail.com    | password123 |
| Staff  | staff@gmail.com    | password123 |
| Manager| manager@gmail.com  | password123 |
| User   | user@gmail.com     | password123 |

---

## 📁 Repository

https://github.com/riskyhelen05/inventaris-app

---

## 📝 Catatan

- Dashboard digunakan sama untuk semua role
- Fokus utama pada sistem peminjaman dan manajemen stok
- Menggunakan Laravel Breeze untuk authentication

---

## 👨‍💻 Developer
Helen Risky Dwi Wahyuni
Sistem Informasi - UPN “Veteran” Jawa Timur

Dibuat untuk challenge magang Sistem Informasi

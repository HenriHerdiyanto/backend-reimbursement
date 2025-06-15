<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 💼 Reimbursement System API (Laravel)

Sistem API untuk manajemen reimburse menggunakan Laravel, cocok untuk digunakan oleh **Employee**, **Manager**, dan **Admin**.

---

## ⚙️ Teknologi yang Digunakan

| No | Teknologi                        | Deskripsi                                                                 |
|----|----------------------------------|---------------------------------------------------------------------------|
| ✅ 1 | **Laravel (v11 atau terbaru)**     | Framework utama untuk backend API. Mengatur routing, controller, model, middleware, dll. |
| ✅ 2 | **Laravel Sanctum**               | Autentikasi token-based untuk login dan akses API (via Postman). Menyediakan endpoint `/login`, `/me`, `/logout` dan middleware `auth:sanctum`. |
| ✅ 3 | **Eloquent ORM**                 | Interaksi database menggunakan model (`User`, `Reimbursement`, `Category`). Menangani relasi seperti `user()->reimbursements()`. |
| ✅ 4 | **File Upload (Laravel Storage)** | Menyimpan bukti reimburse (pdf/jpg/dll) di direktori `storage/app/public`. |
| ✅ 5 | **Form Request Validation**       | Validasi input secara otomatis (title, amount, submitted_at, dll). |
| ✅ 6 | **Spatie Laravel Permission** *(Opsional)* | Manajemen role: admin, manager, user. Proteksi route dengan `middleware('role:admin')`. |
| ✅ 7 | **Carbon**                        | Library untuk manipulasi dan pengecekan tanggal (misalnya membatasi limit bulanan reimburse). |
| ✅ 8 | **Laravel Soft Deletes**          | Data tidak langsung dihapus, tapi bisa di-*restore*. Digunakan pada tabel `reimbursements`. |
| ✅ 9 | **Migration & Seeder**            | Pengelolaan struktur database (`reimbursements`, `categories`, `activity_logs`, dll). |
| ✅ 10 | **Activity Logging (Custom)**      | Logging manual untuk create, update, delete, status change ke tabel `activity_logs`. |

---

## 🔐 Autentikasi & Endpoint

### 🔸 `GET /api/me`
Lihat data user yang sedang login.  
🔐 **Butuh Token**

---

## 📥 Auth API

### 🔹 `POST /api/login`
Login user.  
🔑 **Email & Password**

### 🔹 `POST /api/register`
Registrasi user baru.

---

## 📂 Category API

### 🔹 `GET /api/categories`
Lihat semua kategori.  
📌 **Public**

### 🔹 `GET /api/categoryAdminShow/{id}`
Lihat detail kategori berdasarkan ID.  
🔐 **Admin**

### 🔹 `POST /api/categoryAdmin`
Tambah kategori baru.  
🔐 **Admin**

### 🔹 `GET /api/categoryAdmin`
Lihat semua kategori (versi Admin).  
🔐 **Admin**

### 🔹 `PUT /api/categories/{id}`
Update kategori.  
🔐 **Admin**

---

## 🧾 Reimbursement API

### 🔹 `GET /api/manager/reimbursementsManager`
Lihat semua data reimbursement.  
🔐 **Manager**

### 🔹 `PUT /api/reimbursements/{id}`
Update status reimbursement.  
🔐 **Manager**

### 🔹 `DELETE /api/reimbursements/{id}`
Soft delete reimbursement.  
🔐 **Admin**

### 🔹 `GET /api/reimbursementsAdmin`
Lihat semua reimbursements (versi Admin).  
🔐 **Admin**

### 🔹 `GET|POST|PUT|DELETE /api/reimbursements`
CRUD reimbursements (berdasarkan method yang digunakan).  
🔐 **Employee**

---

## 📎 Catatan

- Gunakan tools seperti **Postman** untuk mengakses dan menguji endpoint API.
- Pastikan menambahkan `Authorization: Bearer {token}` di header untuk endpoint yang butuh autentikasi.
- File bukti reimburse disimpan di `storage/app/public` dan dapat diakses melalui `php artisan storage:link`.

---

## 📣 Kontribusi & Lisensi

Feel free untuk mengembangkan lebih lanjut project ini!  
Lisensi mengikuti [MIT License](LICENSE) *(jika ada)*.

---



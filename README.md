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

## 🔐 Autentikasi

### 🔸 Lihat Data User yang Login
`GET http://localhost:8000/api/me`  
🔐 *Butuh token*

### 🔸 Login
`POST http://localhost:8000/api/login`

### 🔸 Register
`POST http://localhost:8000/api/register`

---

## 📂 Endpoint Category (Kategori)

### 🔹 Lihat Semua Kategori  
`GET http://localhost:8000/api/categories`  
📌 *Public*

### 🔹 Tambah Kategori (Admin)  
`POST http://localhost:8000/api/categoryAdmin`  
🔐 *Admin*

### 🔹 Lihat Semua Kategori (Admin)  
`GET http://localhost:8000/api/categoryAdmin`  
🔐 *Admin*

### 🔹 Lihat Detail Kategori (Admin)  
`GET http://localhost:8000/api/categoryAdminShow/{id}`  
🔐 *Admin*

### 🔹 Update Kategori (Admin)  
`PUT http://localhost:8000/api/categories/{id}`  
🔐 *Admin*

---

## 🧾 Endpoint Reimbursement

### 🔹 CRUD Reimbursements (Employee)
`GET|POST|PUT|DELETE http://localhost:8000/api/reimbursements`  
🔐 *Employee*

### 🔹 Lihat Semua Reimbursement (Manager)  
`GET http://localhost:8000/api/manager/reimbursementsManager`  
🔐 *Manager*

### 🔹 Update Status Reimbursement (Manager)  
`PUT http://localhost:8000/api/reimbursements/{id}`  
🔐 *Manager*

### 🔹 Soft Delete Reimbursement (Admin)  
`DELETE http://localhost:8000/api/reimbursements/{id}`  
🔐 *Admin*

### 🔹 Lihat Semua Reimbursement (Admin)  
`GET http://localhost:8000/api/reimbursementsAdmin`  
🔐 *Admin*

---

## 📎 Catatan

- Gunakan tools seperti **Postman** untuk mengakses dan menguji endpoint API.
- Tambahkan header:  
  `Authorization: Bearer {token}` untuk endpoint yang membutuhkan autentikasi.
- File bukti reimburse disimpan di direktori:  
  `storage/app/public` dan dapat diakses menggunakan `php artisan storage:link`.

---

## 📣 Kontribusi & Lisensi

Feel free untuk mengembangkan lebih lanjut project ini!  
Lisensi mengikuti [MIT License](LICENSE) *(jika ada)*.

---


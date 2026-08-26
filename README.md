## 🚀 TaskHub - Aplikasi Manajemen Proyek & Tugas

Aplikasi **TaskHub** adalah sistem manajemen proyek dan tugas berbasis web yang dirancang untuk mempermudah pelacakan pekerjaan. Studi kasus yang diangkat pada aplikasi ini mencakup pengelolaan proyek, daftar tugas, hingga fitur unggah lampiran file yang terintegrasi penuh. Aplikasi ini dibangun menggunakan *framework* Laravel 13, Tailwind CSS, dan Alpine.js untuk mendukung antarmuka yang modern, dinamis, dan responsif.

## 📊 Entity Relationship Diagram (ERD)

Aplikasi ini menggunakan beberapa tabel utama yang saling berelasi untuk mendukung operasi CRUD secara utuh:
*   **Users**: Menyimpan data autentikasi pengguna.
*   **Projects**: Menyimpan data proyek utama.
*   **Tasks**: Menyimpan detail tugas dari masing-masing proyek (berelasi dengan Projects).
*   **Task Attachments**: Menyimpan riwayat file lampiran tugas (berelasi dengan Tasks).

> *Hapus teks ini dan seret (drag & drop) gambar ERD Anda ke sini*

## 💻 Langkah Instalasi (Localhost)

Untuk menjalankan dan mengembangkan aplikasi TaskHub ini di komputer lokal, ikuti panduan instalasi berikut:
1. Lakukan *clone* repositori ini menggunakan perintah `git clone`.
2. Buka terminal pada folder proyek dan jalankan `composer install` untuk mengunduh seluruh dependensi.
3. Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi *database* MySQL/MariaDB Anda.
4. Jalankan `php artisan key:generate` untuk mengamankan sesi aplikasi.
5. Jalankan `php artisan migrate` untuk merakit seluruh struktur tabel di *database*.
6. Jalankan `npm install` dan `npm run build` (opsional jika menggunakan Vite).
7. Jalankan `php artisan serve` untuk menjalankan aplikasi secara lokal melalui *browser*.

## 📸 Screenshot Fitur & Akses Login

Berikut adalah dokumentasi visual untuk antarmuka fitur utama aplikasi TaskHub:

**1. Halaman Dashboard & List Data**
<img width="1886" height="843" alt="image" src="https://github.com/user-attachments/assets/d91eb728-12f8-4393-8073-a004a0ad12f4" />


**2. Halaman Tambah Data**
- Tambah Projeck Baru :
<img width="1476" height="837" alt="image" src="https://github.com/user-attachments/assets/56d435fd-956f-4aac-b078-f491c7f64f25" />

- Tambah Tugas Baru :
<img width="1630" height="911" alt="image" src="https://github.com/user-attachments/assets/66926ad4-ca72-4de0-bf59-3574d4f09024" />

**3. Halaman Edit Data**
- Edit Project :
<img width="1471" height="913" alt="image" src="https://github.com/user-attachments/assets/f1bbe8d2-55c5-4c62-94a0-ac979a688c69" />

- Edit Tugas :
<img width="1613" height="913" alt="image" src="https://github.com/user-attachments/assets/884226fc-6b8d-41a4-8153-4d6b6f37bc75" />

**4. Konfirmasi Hapus Data**
- Komfirmasi Hapus Project :
<img width="932" height="606" alt="image" src="https://github.com/user-attachments/assets/c95da46c-bd4f-4630-9bca-2132a4599984" />

- Konfirmasi Hapus Tugas :
<img width="786" height="487" alt="image" src="https://github.com/user-attachments/assets/6ae1118a-1657-4f5a-a070-cdc42b1c26d1" />

**5. Upload File**
<img width="1021" height="730" alt="image" src="https://github.com/user-attachments/assets/06ca318f-2a43-49b2-8ad9-04cebdf27385" />

**6. Checklist Tugas**
<img width="1480" height="241" alt="image" src="https://github.com/user-attachments/assets/ae1fe50e-eb9f-4c1b-adbb-02db57de3742" />

**7. Cetak PDF**
<img width="1170" height="551" alt="image" src="https://github.com/user-attachments/assets/f4286b1a-4d42-42d2-a003-8c480a0253e7" />

---

### 🔑 Kredensial Login Penguji
Aplikasi ini dilengkapi dengan fitur autentikasi. Silakan gunakan akses *dummy* berikut untuk masuk ke dalam dasbor dan menguji fitur:
<img width="552" height="687" alt="image" src="https://github.com/user-attachments/assets/b77126f3-6d99-418f-9630-e45b3e7173ab" />

*   **Email/Username:** demo@taskhub.com/demo
*   **Password:** password123!

Dan ini link untuk testing aplikasi Taskhub di server InfinityFree yang sudah saya upload : http://taskhub-anwar.freepage.cc
Silahkan di coba !

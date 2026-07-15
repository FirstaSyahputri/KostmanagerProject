## Sistem Manajemen Kost-Kostan

### 👥 Informasi Ujian
- **Durasi**: 3 jam (180 menit)
- **Kelompok**: 2 orang per kelompok
- **Framework**: Laravel 

---

## 📋 Deskripsi Kasus

Anda diminta untuk membuat Aplikasi Web Manajemen Kost-Kostan yang membantu pemilik kost mengelola bisnis mereka. Aplikasi ini harus mampu mengelola data kamar, penyewa, kontrak sewa, dan pembayaran bulanan.

### Skenario Bisnis:
Pak Budi memiliki 20 kamar kost di dekat kampus. Selama ini pencatatan masih manual menggunakan buku. Ia membutuhkan sistem digital untuk:
- Melihat kamar mana yang kosong/terisi
- Mencatat data penyewa 
- Membuat kontrak sewa dengan durasi tertentu
- Mencatat pembayaran bulanan dari setiap penyewa
- Melihat laporan keuangan sederhana

---

## 🗄️ Struktur Database yang Harus Dibuat

### 1. Tabel `kamar`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| nomor_kamar | string(10) | Unique, contoh: "A1", "B2" |
| tipe | enum | 'standard', 'deluxe', 'vip' |
| harga_bulanan | decimal(10,2) | Harga sewa per bulan |
| fasilitas | text | Deskripsi fasilitas (AC, WiFi, dll) |
| status | enum | 'tersedia', 'terisi' |
| timestamps | | created_at, updated_at |

### 2. Tabel `penyewa`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| nama_lengkap | string(100) | Nama penyewa |
| nomor_telepon | string(15) | Nomor HP/WA |
| nomor_ktp | string(20) | Unique |
| alamat_asal | text | Alamat KTP |
| pekerjaan | string(50) | Mahasiswa/Karyawan/dll |
| timestamps | | created_at, updated_at |

### 3. Tabel `kontrak_sewa`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| penyewa_id | bigint (FK) | Relasi ke tabel penyewa |
| kamar_id | bigint (FK) | Relasi ke tabel kamar |
| tanggal_mulai | date | Mulai kontrak |
| tanggal_selesai | date | Akhir kontrak |
| harga_bulanan | decimal(10,2) | Harga sewa per bulan |
| status | enum | 'aktif', 'selesai' |
| timestamps | | created_at, updated_at |

### 4. Tabel `pembayaran`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| kontrak_sewa_id | bigint (FK) | Relasi ke tabel kontrak_sewa |
| bulan | integer | 1-12 (Januari-Desember) |
| tahun | integer | Contoh: 2026 |
| jumlah_bayar | decimal(10,2) | Nominal yang dibayarkan |
| tanggal_bayar | date | Tanggal pembayaran |
| status | enum | 'lunas', 'tertunggak' |
| keterangan | text nullable | Catatan tambahan |
| timestamps | | created_at, updated_at |

---

## ✅ Fitur yang Harus Dibuat

### A. Manajemen Kamar (CRUD)
1. **List Kamar** - Tampilkan semua kamar dengan badge status (tersedia/terisi)
2. **Tambah Kamar** - Form input data kamar baru
3. **Edit Kamar** - Update informasi kamar
4. **Hapus Kamar** - Soft delete atau hard delete (hanya jika belum pernah disewa)
5. **Filter** - Filter kamar berdasarkan status atau tipe

### B. Manajemen Penyewa (CRUD)
1. **List Penyewa** - Tampilkan semua penyewa dengan info kamar yang disewa (jika ada)
2. **Tambah Penyewa** - Form registrasi penyewa baru
3. **Detail Penyewa** - Lihat info lengkap + riwayat kontrak
4. **Edit Penyewa** - Update data penyewa
5. **Hapus Penyewa** - Hapus data (jika tidak ada kontrak aktif)

### C. Manajemen Kontrak Sewa (CRUD)
1. **List Kontrak** - Tampilkan semua kontrak dengan info penyewa & kamar
2. **Buat Kontrak Baru** - Form pilih penyewa & kamar tersedia, set durasi
3. **Detail Kontrak** - Lihat info kontrak + riwayat pembayaran
4. **Update Status** - Ubah status kontrak (aktif/selesai)
5. **Logic**: Saat kontrak dibuat, status kamar otomatis jadi "terisi"

### D. Manajemen Pembayaran (CRUD)
1. **Catat Pembayaran** - Form input pembayaran untuk kontrak tertentu
2. **List Pembayaran** - Tampilkan riwayat pembayaran
3. **Edit Pembayaran** - Update data pembayaran (jika ada kesalahan)
4. **Hapus Pembayaran** - Hapus record pembayaran

### E. Dashboard/Halaman Utama
Tampilkan statistik sederhana:
- Total jumlah kamar
- Jumlah kamar terisi & tersedia
- Total pendapatan bulan ini (dari pembayaran)
- Jumlah pembayaran tertunggak
- Chart/grafik sederhana (opsional)

---

## 🛠️ Ketentuan Teknis

### 1. Database & Model
- ✅ Buat 4 migration files sesuai struktur di atas
- ✅ Buat 4 model dengan nama: `Kamar`, `Penyewa`, `KontrakSewa`, `Pembayaran`
- ✅ Definisikan relasi Eloquent:
  - `Penyewa` hasMany `KontrakSewa`
  - `Kamar` hasMany `KontrakSewa`
  - `KontrakSewa` belongsTo `Penyewa` dan `Kamar`
  - `KontrakSewa` hasMany `Pembayaran`
  - `Pembayaran` belongsTo `KontrakSewa`
- ✅ Gunakan `$fillable` atau `$guarded` pada setiap model

### 2. Controllers & Routes
- ✅ Buat minimal 4 controller: `KamarController`, `PenyewaController`, `KontrakSewaController`, `PembayaranController`
- ✅ Gunakan resource routes atau manual routes
- ✅ Implementasikan method: index, create, store, show, edit, update, destroy (sesuai kebutuhan)

### 3. Validation
Validasi form input minimal untuk:
- Nomor kamar harus unique
- Nomor KTP harus unique
- Harga harus angka positif
- Tanggal selesai harus lebih besar dari tanggal mulai
- Bulan harus 1-12, tahun harus 4 digit

### 4. Views (Blade + Tailwind CSS (terserah mau pake styling apa))
- ✅ Gunakan Tailwind CSS untuk styling (sudah terkonfigurasi)
- ✅ Buat layout utama dengan navbar (bisa menggunakan `@extends` dan `@section`)
- ✅ Tampilan harus responsive (mobile-friendly)
- ✅ Gunakan komponen Tailwind: cards, tables, forms, buttons, badges
- ✅ Form harus tampilkan error validation

### 5. Seeders (Opsional tapi Direkomendasikan)
Buat seeder untuk data dummy:
- 10-20 kamar
- 5-10 penyewa
- 5-8 kontrak (beberapa aktif, beberapa selesai)
- 15-20 pembayaran (lunas dan tertunggak)

---

## 🎁 Fitur Bonus (Opsional)

Implementasi fitur di bawah akan mendapat poin tambahan:

1. **Upload Bukti Transfer Pembayaran** 
   - Tambah kolom `bukti_transfer` (string, nullable) di tabel `pembayaran`
   - Form upload file gambar saat catat pembayaran
   - Simpan file di `storage/app/public/bukti_transfer`
   - Tampilkan preview foto di detail/list pembayaran
   - Validasi: image (jpg, jpeg, png), max 2MB
   - Jangan lupa: `php artisan storage:link`

2. **Search & Filter** 
   - Search penyewa by nama/telepon
   - Filter kamar by tipe/status
   
3. **Auto-generate Tagihan**
   - Sistem otomatis generate daftar pembayaran yang harus dibayar per bulan
   
4. **Export Laporan**
   - Export data pembayaran ke Excel/PDF
   
5. **Reminder Tunggakan**
   - Highlight/notifikasi penyewa yang belum bayar
   
6. **Chart/Grafik Dashboard**
   - Visualisasi data dengan chart

---

## 📤 Ketentuan Pengumpulan

### Yang Harus Dikumpulkan:
1. **Source Code** (GitHub repository)
   - Semua file Laravel project

2. **Screenshot**
   - Dashboard
   - Halaman list (kamar, penyewa, kontrak, pembayaran)
   - Form tambah/edit
   - Fitur yang sudah berfungsi

3. **Dokumentasi Kode**
   - Nama anggota kelompok
   - Daftar fitur yang sudah diimplementasi
   - Daftar routes yang tersedia
4. **(LAPORAN) berupa test-test aplikasinya**
   - Test-test aplikasinya fitur


### Format Nama File:
```
KUIS_LARAVEL_KELOMPOK[NOMOR]_[NAMA1]_[NAMA2].zip
Contoh: KUIS_LARAVEL_KELOMPOK1_BUDI_ANI.zip
```

### Deadline Pengumpulan:

---

## 🚀 Cara Memulai

1. **Setup Project** (sudah tersedia)
   ```bash
   # Pastikan di folder project
   cd XAMPP/htdocs/kuisbeforeuas
   cd laragon/www/kuisbeforeuas
   
   # Install dependencies (jika belum)
   composer install
   npm install
   ```

2. **Persiapan Database**

   # Jalankan migration
   php artisan migrate
   ```

3. **Jalankan Server**
   ```bash
   # Terminal 1: Laravel server
   php artisan serve
   
   # Terminal 2: Vite dev server (untuk Tailwind)
   npm run dev
   ```

4. **Mulai Coding!**
   - Buat migrations dulu
   - Lalu models
   - Kemudian controllers & routes
   - Terakhir views

---

## 💡 Tips & Hints

1. **Gunakan Resource Controller**
   ```bash
   php artisan make:controller KamarController --resource
   ```

2. **Gunakan Factory & Seeder untuk Data Dummy**
   ```bash
   php artisan make:factory KamarFactory
   php artisan make:seeder KamarSeeder
   php artisan db:seed
   ```

3. **Eager Loading untuk Performa**
   ```php
   $kontraks = KontrakSewa::with(['penyewa', 'kamar'])->get();
   ```

4. **Tailwind Components yang Berguna**
   - Tables: `table`, `table-auto`, `divide-y`
   - Badges: `inline-flex`, `rounded-full`, `px-3 py-1`
   - Cards: `bg-white`, `shadow-md`, `rounded-lg`, `p-6`
   - Buttons: `bg-blue-500`, `hover:bg-blue-700`, `text-white`

5. **Validation Example**
   ```php
   $request->validate([
       'nomor_kamar' => 'required|unique:kamar|max:10',
       'harga_bulanan' => 'required|numeric|min:0',
   ]);
   ```

---

## ❓ FAQ

**Q: Boleh menggunakan library tambahan?**  
A: Boleh, asalkan tidak mengubah stack utama (Laravel + Tailwind). Misal: Chart.js untuk grafik.

**Q: Apakah harus implement authentication?**  
A: Tidak wajib. Fokus ke fitur CRUD dan relasi database.

**Q: Bagaimana jika tidak selesai dalam 3 jam?**  
A: Prioritaskan fitur inti (CRUD basic). Fitur bonus diabaikan jika waktu tidak cukup.

**Q: Boleh googling atau buka dokumentasi Laravel?**  
A: Boleh! Gunakan dokumentasi Laravel dengan bijak.

---

## 📚 Referensi

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Laravel Eloquent Relationships](https://laravel.com/docs/12.x/eloquent-relationships)
- [Laravel Validation](https://laravel.com/docs/12.x/validation)

---

**Selamat Mengerjakan! Semoga Sukses! 🎉**

---


# 🧪 CARA TEST REGISTER & LOGIN

## ⚠️ PENTING: Perbaikan yang Sudah Dilakukan

1. ✅ Form register ditambah **validasi real-time**
2. ✅ **Visual feedback** untuk password match/unmatch
3. ✅ **Loading state** saat submit
4. ✅ **Error logging** di backend
5. ✅ **Auto-verify** email setelah register

---

## 🔧 LANGKAH PERSIAPAN

### 1. Pastikan Server Berjalan

**Terminal 1: Laravel Server**
```bash
php artisan serve
```
Harus tampil: `Server running on [http://127.0.0.1:8000]`

**Terminal 2: Vite Dev Server**
```bash
npm run dev
```
Harus tampil: `ready in xxx ms`

⚠️ **PENTING:** Kedua terminal harus tetap berjalan!

---

## 📝 CARA TEST REGISTER (Step by Step)

### Langkah 1: Buka Halaman Register
1. Buka browser (Chrome/Firefox)
2. Buka: `http://127.0.0.1:8000/register`
3. Pastikan form muncul dengan lengkap

### Langkah 2: Isi Form dengan Benar

**Contoh Pengisian:**
```
Nama Lengkap: Aqsa Pratama
Email: aqsa@gmail.com
Password: 12345678
Konfirmasi Password: 12345678
```

**PENTING:**
- ✅ Nama minimal 3 karakter
- ✅ Email harus format valid (@gmail.com, dll)
- ✅ Password minimal 8 karakter
- ✅ Konfirmasi password HARUS SAMA dengan password
- ✅ Tunggu sampai muncul "✓ Password cocok" (hijau)

### Langkah 3: Submit Form
1. Klik tombol **"Daftar"**
2. Tombol akan berubah jadi "Mendaftar..." (loading)
3. **TUNGGU** sampai redirect (jangan klik lagi!)

### Langkah 4: Verifikasi
Setelah klik "Daftar", akan:
- ✅ Otomatis login
- ✅ Redirect ke halaman home
- ✅ Lihat nama Anda di navbar (jika ada)

---

## 🔑 CARA TEST LOGIN

### Langkah 1: Logout (Jika Sudah Login)
1. Klik tombol Logout/Profile
2. Pilih Logout

### Langkah 2: Buka Halaman Login
```
http://127.0.0.1:8000/login
```

### Langkah 3: Login dengan Akun yang Baru Dibuat
```
Email: aqsa@gmail.com
Password: 12345678
```

### Langkah 4: Klik LOGIN
- ✅ Harus berhasil masuk
- ✅ Redirect ke home page

---

## ❌ TROUBLESHOOTING

### Masalah 1: "These credentials do not match our records"

**Kemungkinan Penyebab:**
1. ❌ Email salah ketik
2. ❌ Password salah ketik
3. ❌ Register belum berhasil (user tidak tersimpan)

**Solusi:**
```bash
# Cek apakah user ada di database
php check_users.php
```

Lihat apakah email Anda ada di list.

### Masalah 2: Form Register Tidak Submit

**Cek:**
1. ✅ Apakah `npm run dev` berjalan?
2. ✅ Apakah password dan konfirmasi password sama?
3. ✅ Buka Console Browser (F12) → Lihat error

**Solusi:**
- Refresh halaman (Ctrl + F5)
- Clear browser cache
- Pastikan tidak ada ad-blocker

### Masalah 3: Error Validasi "The email has already been taken"

**Artinya:** Email sudah terdaftar!

**Solusi:**
- Gunakan email lain, atau
- Login dengan email yang sudah terdaftar

### Masalah 4: Setelah Register Tidak Auto-Login

**Cek log:**
```bash
# Lihat log error
type storage\logs\laravel.log | select -Last 50
```

**Solusi:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 🧪 CARA CEK APAKAH USER BERHASIL TERDAFTAR

### Opsi 1: Menggunakan Script PHP
```bash
php check_users.php
```

Lihat apakah nama Anda muncul di list.

### Opsi 2: Cek Database Langsung
1. Buka phpMyAdmin
2. Database: `cheisya_shops`
3. Tabel: `users`
4. Cari email Anda

---

## 📊 EXPECTED RESULT

### Register Berhasil:
```
✅ Form submit → Loading → Redirect → Auto-login → Home page
✅ User tersimpan di database
✅ email_verified_at terisi otomatis
✅ Role = 'customer'
```

### Login Berhasil:
```
✅ Input email + password → LOGIN → Redirect → Home page
✅ Nama muncul di navbar
✅ Bisa akses fitur customer
```

---

## 🎯 CHECKLIST SEBELUM TEST

- [ ] Terminal 1: `php artisan serve` ✅ Running
- [ ] Terminal 2: `npm run dev` ✅ Running
- [ ] Browser console (F12) ✅ Tidak ada error merah
- [ ] Form register muncul dengan lengkap ✅
- [ ] Isi semua field (nama, email, password, konfirmasi) ✅
- [ ] Password dan konfirmasi sama ✅
- [ ] Klik "Daftar" hanya 1x ✅
- [ ] Tunggu sampai redirect ✅

---

## 📞 JIKA MASIH GAGAL

Lakukan langkah berikut dan screenshot errornya:

### 1. Buka Browser Console
- Tekan F12
- Tab "Console"
- Screenshot jika ada error merah

### 2. Cek Log Laravel
```bash
type storage\logs\laravel.log | select -Last 30
```

### 3. Cek Users di Database
```bash
php check_users.php
```

### 4. Reset Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 5. Restart Servers
```bash
# Stop semua server (Ctrl+C)
# Kemudian jalankan lagi:
php artisan serve
npm run dev
```

---

## ✅ AKUN DEMO (Jika Register Gagal)

Gunakan akun yang sudah dibuat:

```
Email: suwito@gmail.com
Password: 12345678
Role: Customer
```

atau

```
Email: admin@gmail.com
Password: 12345678
Role: Admin
```

---

**Selamat mencoba!** 🚀

Jika masih error, screenshot:
1. Form yang Anda isi
2. Error message yang muncul
3. Browser console (F12)

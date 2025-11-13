# 💳 Panduan Integrasi Midtrans Payment Gateway

## 📋 Daftar Isi
- [Pendaftaran Midtrans](#pendaftaran-midtrans)
- [Mendapatkan API Keys](#mendapatkan-api-keys)
- [Konfigurasi](#konfigurasi)
- [Testing Payment](#testing-payment)
- [Go Live (Production)](#go-live-production)
- [Troubleshooting](#troubleshooting)

---

## 🔐 Pendaftaran Midtrans

### Step 1: Buat Akun Midtrans Sandbox (Testing)
1. Buka [https://dashboard.sandbox.midtrans.com/register](https://dashboard.sandbox.midtrans.com/register)
2. Isi form pendaftaran:
   - Email
   - Password
   - Nama lengkap
   - Nomor telepon
3. Klik **"Sign Up"**
4. Verifikasi email Anda
5. Login ke dashboard

### Step 2: Lengkapi Data Bisnis
1. Setelah login, lengkapi informasi bisnis Anda
2. Pilih kategori bisnis: **E-commerce**
3. Isi detail toko/bisnis Anda

---

## 🔑 Mendapatkan API Keys

### Sandbox (Testing)
1. Login ke [https://dashboard.sandbox.midtrans.com/](https://dashboard.sandbox.midtrans.com/)
2. Klik menu **"Settings"** di sidebar
3. Pilih **"Access Keys"**
4. Anda akan melihat:
   - **Client Key**: `SB-Mid-client-xxxxxxxxxxxxx`
   - **Server Key**: `SB-Mid-server-xxxxxxxxxxxxx`

### Copy API Keys ke `.env`
```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY_HERE
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY_HERE
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**⚠️ PENTING**: 
- Jangan share Server Key ke siapapun!
- Jangan commit `.env` ke Git
- Server Key hanya untuk backend
- Client Key boleh di frontend

---

## ⚙️ Konfigurasi

### 1. Pastikan Instalasi Berhasil
```bash
composer show midtrans/midtrans-php
```
Harus menampilkan versi Midtrans SDK

### 2. Clear Config Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Configuration
Buat file test sederhana:
```bash
php artisan tinker
```
```php
config('midtrans.server_key')
config('midtrans.client_key')
```
Harus menampilkan API keys Anda

---

## 🧪 Testing Payment

### Test Cards (Sandbox)
Gunakan kartu kredit testing berikut:

| Card Number | CVV | Exp Date | Result |
|-------------|-----|----------|--------|
| 4811 1111 1111 1114 | 123 | 01/25 | ✅ Success |
| 4911 1111 1111 1113 | 123 | 01/25 | ❌ Denied |
| 4411 1111 1111 1118 | 123 | 01/25 | ⏳ Pending |

### Test Virtual Account
- **BCA VA**: 800000000[7 digit]
- **BNI VA**: 880000000[7 digit]
- **Mandiri VA**: 88888[10 digit]

### Test E-Wallet
- **GoPay**: Akan muncul simulator
- **ShopeePay**: Akan muncul simulator

### Langkah Testing:
1. Login sebagai customer
2. Tambah produk ke cart
3. Checkout, pilih **"Transfer Bank / E-Wallet"**
4. Isi form pengiriman
5. Klik **"Buat Pesanan"**
6. Akan redirect ke halaman Midtrans
7. Pilih metode pembayaran (Credit Card, VA, GoPay, dll)
8. Gunakan test card/VA di atas
9. Payment berhasil → redirect ke success page
10. Cek order status → harus jadi "Dibayar"

---

## 🚀 Go Live (Production)

### Step 1: Buat Akun Production
1. Buka [https://dashboard.midtrans.com/register](https://dashboard.midtrans.com/register)
2. Daftar dan verifikasi
3. **WAJIB** submit dokumen bisnis:
   - KTP/Identitas
   - NPWP (jika ada)
   - Dokumen legalitas bisnis
   - Screenshot toko/website

### Step 2: Approval Process
- Midtrans akan review dokumen Anda (1-3 hari kerja)
- Jika disetujui, akun production akan aktif
- Anda akan dapat production API keys

### Step 3: Update `.env` untuk Production
```env
# Midtrans Production
MIDTRANS_SERVER_KEY=Mid-server-PRODUCTION_KEY
MIDTRANS_CLIENT_KEY=Mid-client-PRODUCTION_KEY
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Step 4: Update Snap JS Script
Ganti di `resources/views/customer/payment/midtrans.blade.php`:
```html
<!-- Sandbox -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"></script>

<!-- Production -->
<script src="https://app.midtrans.com/snap/snap.js"></script>
```

### Step 5: Setup Payment Notification URL
Di Midtrans Dashboard:
1. Go to **Settings** → **Configuration**
2. Set **Payment Notification URL**: `https://yourdomain.com/payment/callback`
3. Set **Finish Redirect URL**: `https://yourdomain.com/payment/success`
4. Set **Error Redirect URL**: `https://yourdomain.com/payment/pending`
5. Save

---

## 🔄 Alur Pembayaran

```
1. Customer pilih "Transfer Bank / E-Wallet" di checkout
   ↓
2. Submit form checkout
   ↓
3. System create order di database
   ↓
4. System request Snap Token ke Midtrans API
   ↓
5. Redirect ke halaman payment dengan Snap Token
   ↓
6. Midtrans Snap popup muncul
   ↓
7. Customer pilih payment method (Credit Card, VA, GoPay, dll)
   ↓
8. Customer selesaikan pembayaran
   ↓
9. Midtrans kirim notifikasi ke /payment/callback
   ↓
10. System update order status jadi "Dibayar"
    ↓
11. Redirect customer ke success page
    ↓
12. Customer dapat melihat order dengan status "Dibayar"
```

---

## 📊 Payment Methods yang Tersedia

### 1. Credit Card
- Visa
- Mastercard
- JCB
- Amex

### 2. Virtual Account
- BCA Virtual Account
- BNI Virtual Account
- BRI Virtual Account
- Mandiri Bill Payment
- Permata Virtual Account
- Other Bank VA

### 3. E-Wallet
- GoPay
- ShopeePay
- QRIS

### 4. Retail Outlet
- Indomaret
- Alfamart

### 5. Cardless Credit
- Akulaku
- Kredivo

---

## 🎯 Fitur yang Sudah Diimplementasi

### ✅ Backend
- [x] Midtrans SDK installed
- [x] MidtransService untuk create transaction
- [x] PaymentController untuk handle callbacks
- [x] Order model updated dengan payment fields
- [x] Migration untuk payment columns
- [x] Config file untuk Midtrans

### ✅ Frontend
- [x] Payment method selection (COD vs Midtrans)
- [x] Midtrans payment page dengan Snap
- [x] Success page
- [x] Pending page
- [x] Payment status di order detail

### ✅ Routes
- [x] `/checkout` - Halaman checkout dengan pilihan payment
- [x] `/payment/success` - Success callback
- [x] `/payment/pending` - Pending callback
- [x] `/payment/callback` - Midtrans notification webhook

---

## 🐛 Troubleshooting

### Error: "Snap token is not valid"
**Solusi**:
- Pastikan Server Key benar di `.env`
- Clear config cache: `php artisan config:clear`
- Cek apakah menggunakan Sandbox key untuk testing

### Error: "Access forbidden"
**Solusi**:
- Pastikan API keys sudah di-copy dengan benar
- Tidak ada spasi/enter di `.env`
- Format: `MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx`

### Snap popup tidak muncul
**Solusi**:
- Cek browser console untuk error
- Pastikan Snap JS script loaded
- Pastikan Client Key benar
- Disable ad blocker/popup blocker

### Payment berhasil tapi status tidak update
**Solusi**:
- Cek apakah Payment Notification URL sudah di-set di Midtrans Dashboard
- Cek log di `storage/logs/laravel.log`
- Test callback manual dengan Postman

### "Transaction not found"
**Solusi**:
- Order ID format harus unik
- Format yang dipakai: `ORDER-{order_id}-{timestamp}`
- Cek di Midtrans Dashboard apakah transaksi tercatat

---

## 📞 Support & Resources

### Official Documentation
- Midtrans Docs: https://docs.midtrans.com/
- Snap API: https://snap-docs.midtrans.com/
- API Reference: https://api-docs.midtrans.com/

### Dashboard
- Sandbox: https://dashboard.sandbox.midtrans.com/
- Production: https://dashboard.midtrans.com/

### Support
- Email: support@midtrans.com
- Phone: 021-80644500
- WhatsApp Business: Available di dashboard

---

## 🔒 Security Best Practices

1. **Jangan Hardcode API Keys**
   - Selalu gunakan `.env`
   - Add `.env` ke `.gitignore`

2. **Validate Callback**
   - Selalu validasi signature key
   - Cek order ID dan amount

3. **Use HTTPS in Production**
   - Midtrans require HTTPS untuk production
   - Install SSL certificate

4. **Log Transactions**
   - Log semua payment callbacks
   - Berguna untuk debugging

5. **Handle Duplicate Notification**
   - Midtrans bisa kirim notification multiple times
   - Implement idempotency

---

## 📝 Checklist Sebelum Go Live

- [ ] Dokumen bisnis lengkap
- [ ] Akun production approved
- [ ] Production API keys configured
- [ ] Snap JS script updated ke production URL
- [ ] Payment Notification URL set di dashboard
- [ ] SSL/HTTPS aktif
- [ ] Test semua payment methods
- [ ] Log monitoring setup
- [ ] Backup strategy ready

---

**Selamat! Sistem pembayaran Midtrans sudah siap digunakan!** 💳✨

Untuk testing, gunakan Sandbox environment dulu. Setelah yakin semua berjalan baik, baru migrate ke Production.

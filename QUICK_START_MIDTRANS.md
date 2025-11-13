# 🚀 Quick Start - Midtrans Integration

## ✅ Status Instalasi
Midtrans payment gateway sudah berhasil diintegrasikan! Berikut yang sudah dikerjakan:

### 📦 Yang Sudah Diinstall
- ✅ Midtrans PHP SDK (`midtrans/midtrans-php`)
- ✅ Database migration untuk payment columns
- ✅ Midtrans Service class
- ✅ Payment Controller
- ✅ Payment views (success & pending)
- ✅ Routes untuk payment callbacks

---

## 🔧 Cara Menggunakan

### Step 1: Dapatkan API Keys dari Midtrans

1. **Daftar Akun Sandbox** (untuk testing):
   - Buka: https://dashboard.sandbox.midtrans.com/register
   - Daftar dengan email Anda
   - Verifikasi email

2. **Get API Keys**:
   - Login ke: https://dashboard.sandbox.midtrans.com/
   - Klik **Settings** → **Access Keys**
   - Copy:
     - **Server Key**: `SB-Mid-server-xxxxxxxxx`
     - **Client Key**: `SB-Mid-client-xxxxxxxxx`

### Step 2: Update File `.env`

Buka file `.env` dan update API keys:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-PASTE_YOUR_SERVER_KEY_HERE
MIDTRANS_CLIENT_KEY=SB-Mid-client-PASTE_YOUR_CLIENT_KEY_HERE
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**Contoh**:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-abc123def456
MIDTRANS_CLIENT_KEY=SB-Mid-client-xyz789uvw012
```

### Step 3: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test Payment!

1. **Login** sebagai customer (suwito@gmail.com / 12345678)
2. **Tambah produk** ke cart
3. **Checkout**, pilih payment method:
   - **COD** = Bayar saat barang sampai
   - **Transfer Bank / E-Wallet** = Pakai Midtrans
4. **Pilih Midtrans**, isi form pengiriman
5. **Klik "Buat Pesanan"**
6. **Popup Midtrans** akan muncul
7. **Pilih payment method** (Credit Card, VA, GoPay, dll)

---

## 💳 Test Payment Data (Sandbox)

### Credit Card Testing
```
Card Number: 4811 1111 1111 1114
CVV: 123
Exp Date: 01/25
Result: SUCCESS ✅
```

```
Card Number: 4911 1111 1111 1113
CVV: 123
Exp Date: 01/25
Result: FAILED ❌
```

### Virtual Account Testing
- **BCA VA**: Akan generate nomor VA otomatis
- **BNI VA**: Akan generate nomor VA otomatis
- **Mandiri**: Akan generate kode bayar

### E-Wallet Testing
- **GoPay**: Akan muncul QR code simulator
- **ShopeePay**: Akan muncul simulator

---

## 📁 File yang Dibuat/Diupdate

### 🆕 Files Baru
```
app/Services/
└── MidtransService.php                    # Service untuk Midtrans API

app/Http/Controllers/
└── PaymentController.php                  # Handle payment callbacks

resources/views/customer/payment/
├── midtrans.blade.php                     # Halaman payment Midtrans
├── success.blade.php                      # Success page
└── pending.blade.php                      # Pending page

config/
└── midtrans.php                           # Config Midtrans

database/migrations/
└── 2025_11_13_100316_add_payment_columns_to_orders_table.php

MIDTRANS_INTEGRATION_GUIDE.md              # Panduan lengkap
QUICK_START_MIDTRANS.md                    # Quick start guide (file ini)
```

### ✏️ Files yang Diupdate
```
.env                                       # + Midtrans config
app/Models/Order.php                       # + payment fields
app/Http/Controllers/CartController.php    # + payment method selection
resources/views/customer/cart/checkout.blade.php  # + payment method radio
routes/web.php                             # + payment routes
```

---

## 🎯 Alur Lengkap

```
1. Customer checkout → pilih "Transfer Bank / E-Wallet"
   ↓
2. System create order dengan payment_method = 'midtrans'
   ↓
3. System request Snap Token dari Midtrans API
   ↓
4. Redirect ke /payment/midtrans dengan Snap Token
   ↓
5. Midtrans Snap popup terbuka
   ↓
6. Customer pilih payment method & bayar
   ↓
7. Jika sukses:
   - Midtrans kirim notifikasi ke /payment/callback
   - Order status update jadi 'paid'
   - Redirect ke /payment/success
   ↓
8. Customer lihat success page & detail order
```

---

## 🧪 Checklist Testing

### Before Starting
- [ ] Midtrans account created
- [ ] API keys copied to `.env`
- [ ] Config cache cleared

### Payment Flow
- [ ] Can select payment method at checkout
- [ ] COD works normally
- [ ] Midtrans payment page opens
- [ ] Snap popup appears
- [ ] Can choose payment method (Credit Card/VA/GoPay)
- [ ] Test card payment succeeds
- [ ] Redirects to success page
- [ ] Order status updates to "Dibayar"
- [ ] Can view order details with payment info

### Error Handling
- [ ] Invalid card shows error
- [ ] Close popup shows message
- [ ] Pending payment shows pending page

---

## 🚨 Troubleshooting

### "Snap token is not valid"
```bash
# Clear config
php artisan config:clear

# Check .env
cat .env | grep MIDTRANS

# Make sure no spaces/newlines in API keys
```

### Popup tidak muncul
- Check browser console (F12)
- Disable ad blocker
- Check Client Key di `.env`

### Payment sukses tapi status tidak update
- Check `/payment/callback` route accessible
- Check logs: `tail -f storage/logs/laravel.log`

---

## 📞 Bantuan

Jika ada masalah, cek:
1. **MIDTRANS_INTEGRATION_GUIDE.md** - Panduan lengkap
2. **Midtrans Docs**: https://docs.midtrans.com/
3. **Dashboard**: https://dashboard.sandbox.midtrans.com/

---

## 🎉 Next Steps

### Untuk Development
1. Test semua payment methods
2. Test error scenarios
3. Check payment notification webhook

### Untuk Production
1. Register production account: https://dashboard.midtrans.com/register
2. Submit business documents
3. Wait for approval (1-3 days)
4. Get production API keys
5. Update `.env`:
   ```env
   MIDTRANS_IS_PRODUCTION=true
   MIDTRANS_SERVER_KEY=Mid-server-PRODUCTION_KEY
   MIDTRANS_CLIENT_KEY=Mid-client-PRODUCTION_KEY
   ```
6. Change Snap JS script to production URL
7. Set up payment notification URL di Midtrans Dashboard

---

**Ready to test! 🚀**

Silakan daftar di Midtrans Sandbox dan mulai testing payment gateway!

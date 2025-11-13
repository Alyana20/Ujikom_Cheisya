# 🛒 Panduan Keranjang Belanja & Pesanan

## 📋 Daftar Isi
- [Fitur Keranjang](#fitur-keranjang)
- [Proses Checkout](#proses-checkout)
- [Halaman Pesanan](#halaman-pesanan)
- [Detail Pesanan](#detail-pesanan)
- [Status Pesanan](#status-pesanan)

---

## 🛍️ Fitur Keranjang

### Mengakses Keranjang
- **URL**: `http://localhost:8000/cart`
- **Navigasi**: Klik ikon keranjang di navbar (dengan badge jumlah item)
- **Menu**: User Dropdown → "Keranjang"

### Fitur di Halaman Keranjang
1. **Tampilan Produk**
   - Gambar produk
   - Nama produk
   - Nama toko
   - Harga per unit
   
2. **Kontrol Quantity**
   - Input jumlah barang (min: 1, max: stok tersedia)
   - Tombol "Update" untuk menyimpan perubahan
   - Validasi stok otomatis
   
3. **Ringkasan**
   - Total item di keranjang
   - Subtotal per item
   - Total keseluruhan
   - Tombol "Checkout" (hijau)
   - Tombol "Lanjut Belanja"
   
4. **Hapus Item**
   - Tombol "Hapus" dengan konfirmasi
   - Item langsung terhapus dari keranjang

### Menambahkan ke Keranjang
1. Buka halaman detail produk
2. Pilih quantity yang diinginkan
3. Klik tombol "Tambahkan ke Keranjang"
4. Jika produk sudah ada, quantity akan ditambahkan
5. Jika stok tidak cukup, akan muncul pesan error

### Validasi
- ✅ Stok produk selalu dicek
- ✅ Quantity tidak boleh melebihi stok
- ✅ Harga disimpan saat item ditambahkan (tidak berubah jika harga produk berubah)
- ✅ Hanya user yang login bisa mengakses keranjang

---

## 💳 Proses Checkout

### Mengakses Checkout
- Dari halaman keranjang, klik tombol **"Checkout"**
- **URL**: `http://localhost:8000/checkout`

### Form Checkout
1. **Informasi Pengiriman**
   - Alamat pengiriman (required)
   - Nomor telepon (required)
   - Catatan untuk penjual (optional)

2. **Ringkasan Pesanan**
   - Daftar produk dengan gambar
   - Nama toko per item
   - Quantity × Harga
   - Subtotal per item
   - Total keseluruhan

3. **Informasi Pembayaran**
   - Metode: COD (Cash on Delivery)
   - Ongkir: Gratis

### Proses Setelah Checkout
1. Klik tombol **"Buat Pesanan"**
2. Sistem akan:
   - Memvalidasi stok
   - Membuat order baru
   - Mengelompokkan item berdasarkan toko
   - Mengurangi stok produk
   - Mengosongkan keranjang
3. Redirect ke halaman detail pesanan

---

## 📦 Halaman Pesanan

### Mengakses Daftar Pesanan
- **URL**: `http://localhost:8000/orders`
- **Navigasi**: User Dropdown → "Pesanan Saya"
- **Icon**: <i class="fas fa-receipt"></i> Pesanan Saya

### Tampilan Daftar Pesanan
Setiap pesanan menampilkan:
- **Order ID**: #123
- **Tanggal**: 13 Nov 2025
- **Total**: Rp 150.000
- **Status**: Badge berwarna
  - 🟡 **Pending** - Menunggu konfirmasi
  - 🔵 **Dibayar** - Pembayaran dikonfirmasi
  - 🟣 **Dikirim** - Sedang dalam pengiriman
  - 🟢 **Selesai** - Pesanan diterima
  - 🔴 **Dibatalkan** - Pesanan dibatalkan
- **Jumlah Item**: X item
- **Metode Pembayaran**: COD
- **Tombol "Detail"**: Untuk melihat detail pesanan

### Filter & Navigasi
- Pagination jika pesanan lebih dari 10
- Urutan: Pesanan terbaru di atas

### Jika Belum Ada Pesanan
- Icon keranjang kosong
- Pesan: "Belum Ada Pesanan"
- Tombol: "Mulai Belanja"

---

## 🔍 Detail Pesanan

### Mengakses Detail
- Dari daftar pesanan, klik tombol **"Detail"**
- **URL**: `http://localhost:8000/orders/{id}`

### Konten Halaman Detail

#### 1. Status Timeline
Progress pesanan dengan icon:
- ✅ **Pesanan Dibuat** - Timestamp
- ⏳/✅ **Pembayaran Dikonfirmasi** - Timestamp atau "Menunggu konfirmasi"
- ⏳/✅ **Dikirim** - Timestamp atau "Menunggu pengiriman"
- ⏳/✅ **Diterima** - Timestamp atau "Dalam perjalanan"

#### 2. Daftar Produk
Untuk setiap produk:
- Gambar produk
- Nama produk (klik untuk ke detail produk)
- Harga per unit
- Quantity
- Subtotal
- **Tombol Review** (hanya muncul jika status "Selesai")

#### 3. Informasi Pengiriman (Sidebar)
- Alamat pengiriman
- Nomor telepon
- Catatan (jika ada)

#### 4. Informasi Pembayaran (Sidebar)
- Metode pembayaran
- Status pembayaran
- Subtotal
- Ongkir
- **Total Pembayaran**

#### 5. Aksi yang Tersedia
- **Tombol "Batalkan Pesanan"** - Hanya jika status masih Pending
- **Tombol "Kembali ke Pesanan"** - Kembali ke daftar

---

## 📊 Status Pesanan

### 1. Pending (🟡)
- **Arti**: Pesanan baru dibuat, menunggu konfirmasi pembayaran
- **Aksi Customer**: 
  - ✅ **Bisa membatalkan pesanan**
  - Bisa lihat detail pesanan
- **Next Step**: Admin konfirmasi pembayaran → status jadi "Dibayar"

### 2. Dibayar (🔵)
- **Arti**: Pembayaran sudah dikonfirmasi
- **Aksi Customer**: 
  - ✅ **Bisa membatalkan pesanan** (jika belum dikirim)
  - Tunggu pengiriman
- **Next Step**: Admin kirim barang → status jadi "Dikirim"

### 3. Dikirim (🟣)
- **Arti**: Barang sedang dalam pengiriman
- **Aksi Customer**: 
  - ❌ Tidak bisa membatalkan
  - Tunggu penerimaan barang
- **Next Step**: Admin konfirmasi pengiriman → status jadi "Selesai"

### 4. Selesai (🟢)
- **Arti**: Barang sudah diterima customer
- **Aksi Customer**: 
  - Bisa menulis review produk
  - ❌ Tidak bisa batalkan pesanan
- **Next Step**: Transaksi selesai

### 5. Dibatalkan (🔴)
- **Arti**: Pesanan dibatalkan (oleh customer atau admin)
- **Aksi Customer**: Tidak ada aksi
- **Efek**: Stok produk dikembalikan otomatis
- **Next Step**: Transaksi selesai

---

## 🚫 Cara Membatalkan Pesanan

### Metode 1: Dari Halaman Daftar Pesanan
1. Buka `/orders` (Menu: Pesanan Saya)
2. Cari pesanan yang ingin dibatalkan
3. Pastikan ada label "Dapat dibatalkan" (warna kuning)
4. Klik tombol **"Batalkan"** (merah)
5. Konfirmasi pembatalan di popup
6. Pesanan akan dibatalkan, stok produk dikembalikan

### Metode 2: Dari Detail Pesanan
1. Buka detail pesanan (`/orders/{id}`)
2. Scroll ke sidebar kanan
3. Jika pesanan bisa dibatalkan, akan ada kotak merah dengan peringatan
4. Klik tombol **"Batalkan Pesanan"**
5. Konfirmasi pembatalan
6. Akan muncul notifikasi sukses hijau

### Syarat Pembatalan
✅ Status pesanan: **Pending** atau **Dibayar**
❌ Status pesanan: **Dikirim**, **Selesai**, atau **Dibatalkan**

### Efek Setelah Pembatalan
1. Status pesanan berubah jadi "Dibatalkan"
2. Stok produk dikembalikan otomatis
3. Timestamp `cancelled_at` tercatat
4. Notifikasi sukses muncul
5. Tombol "Batalkan" hilang, diganti status badge merah

### Pesan Konfirmasi
```
"Apakah Anda yakin ingin membatalkan pesanan ini? 
Stok produk akan dikembalikan."
```

### Pesan Sukses
```
"Pesanan berhasil dibatalkan. Stok produk telah dipulihkan."
```

### Pesan Error
```
"Pesanan tidak bisa dibatalkan."
```
(Muncul jika status sudah Dikirim/Selesai)

---

## 🔄 Alur Lengkap Belanja

```
1. Browse Produk
   ↓
2. Klik "Tambahkan ke Keranjang"
   ↓
3. Lihat Keranjang (update quantity jika perlu)
   ↓
4. Klik "Checkout"
   ↓
5. Isi form pengiriman
   ↓
6. Klik "Buat Pesanan"
   ↓
7. Pesanan dibuat (Status: Pending)
   ↓
8. Admin konfirmasi pembayaran (Status: Dibayar)
   ↓
9. Admin kirim barang (Status: Dikirim)
   ↓
10. Barang diterima (Status: Selesai)
    ↓
11. Tulis review produk
```

---

## 🎯 Fitur-Fitur Utama

### ✅ Keranjang
- Multi-vendor (bisa belanja dari berbagai toko)
- Update quantity
- Hapus item
- Validasi stok real-time
- Harga tersimpan (tidak berubah)
- Badge counter di navbar

### ✅ Checkout
- Form alamat pengiriman
- Catatan untuk penjual
- Ringkasan pesanan lengkap
- Validasi stok sebelum order
- Auto-grouping by store

### ✅ Pesanan
- Daftar semua pesanan
- Status badge berwarna
- Timeline progress
- Detail lengkap per pesanan
- Batalkan pesanan (jika eligible)
- Review produk (setelah selesai)

---

## 🛡️ Keamanan & Validasi

1. **Authentication**
   - Harus login untuk akses keranjang & checkout
   - Hanya bisa lihat pesanan sendiri
   
2. **Stok Management**
   - Validasi stok saat add to cart
   - Validasi stok saat update quantity
   - Validasi stok saat checkout
   - Auto-reduce stok setelah checkout
   
3. **Data Integrity**
   - Harga disimpan saat add to cart
   - Tidak terpengaruh perubahan harga produk
   - Transaction rollback jika error
   
4. **Authorization**
   - Customer hanya bisa akses pesanan sendiri
   - Tidak bisa edit pesanan yang sudah dibuat
   - Hanya bisa cancel jika status Pending

---

## 📱 Navigasi Cepat

### Dari Navbar
- **Icon Keranjang** → `/cart`
- **User Menu → Keranjang** → `/cart`
- **User Menu → Pesanan Saya** → `/orders`

### Dari Halaman Produk
- **Detail Produk** → Tombol "Tambahkan ke Keranjang"

### Dari Keranjang
- **Checkout** → `/checkout`
- **Lanjut Belanja** → `/products`

### Dari Checkout
- **Kembali ke Keranjang** → `/cart`

### Dari Daftar Pesanan
- **Detail** → `/orders/{id}`
- **Mulai Belanja** → `/products` (jika kosong)

### Dari Detail Pesanan
- **Kembali ke Pesanan** → `/orders`
- **Link Produk** → `/products/{id}`

---

## 💡 Tips Penggunaan

1. **Selalu cek stok** sebelum checkout
2. **Update quantity di keranjang** untuk belanja lebih banyak
3. **Isi alamat lengkap** agar pengiriman lancar
4. **Cek status pesanan** secara berkala
5. **Tulis review** setelah pesanan selesai untuk membantu pembeli lain

---

## 🐛 Troubleshooting

### Tidak bisa tambah ke keranjang?
- Pastikan sudah login
- Cek apakah stok masih tersedia
- Quantity tidak boleh melebihi stok

### Checkout gagal?
- Cek koneksi internet
- Pastikan stok masih tersedia
- Isi semua field yang required

### Pesanan tidak muncul?
- Refresh halaman
- Pastikan sudah klik "Buat Pesanan"
- Cek di `/orders`

---

## 📞 Support

Jika ada masalah:
1. Cek dokumentasi ini
2. Refresh browser (Ctrl+F5)
3. Clear cache browser
4. Hubungi admin

---

**Selamat Berbelanja! 🛒✨**

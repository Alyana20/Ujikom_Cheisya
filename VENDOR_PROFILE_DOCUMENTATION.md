# Fitur Profil Vendor - Dokumentasi

## 📋 Ringkasan
Halaman profil vendor yang memungkinkan vendor untuk mengelola informasi personal, informasi toko, dan mengubah password.

## 🎯 Fitur yang Tersedia

### 1. **Halaman Profil Vendor** (`/vendor/profile`)
Menampilkan informasi lengkap vendor:
- **Informasi Personal**
  - Nama lengkap
  - Email
  - Role (Vendor)
  - Tanggal bergabung
  - Status verifikasi email

- **Informasi Toko** (jika sudah memiliki toko)
  - Nama toko
  - No. telepon
  - Alamat toko
  - Deskripsi toko
  - Status toko (Approved/Pending/Rejected)
  - Tanggal terdaftar

### 2. **Halaman Edit Profil** (`/vendor/profile/edit`)
Formulir untuk mengupdate:

#### A. Informasi Personal
- Nama lengkap
- Email (dengan validasi unique)

#### B. Informasi Toko
- Nama toko
- No. telepon toko
- Alamat toko
- Deskripsi toko (maksimal 1000 karakter)

#### C. Ubah Password
- Password saat ini (validasi)
- Password baru (minimal 8 karakter)
- Konfirmasi password baru
- Real-time password match indicator

## 🔗 Routes

```php
GET    /vendor/profile              → vendor.profile.index
GET    /vendor/profile/edit         → vendor.profile.edit
PUT    /vendor/profile/personal     → vendor.profile.update-personal
PUT    /vendor/profile/store        → vendor.profile.update-store
PUT    /vendor/profile/password     → vendor.profile.update-password
```

## 📁 File yang Dibuat

### Controller
- `app/Http/Controllers/Vendor/VendorProfileController.php`
  - `index()` - Menampilkan profil vendor
  - `edit()` - Menampilkan form edit
  - `updatePersonal()` - Update info personal
  - `updateStore()` - Update info toko
  - `updatePassword()` - Update password

### Views
- `resources/views/vendor/profile/index.blade.php` - Halaman view profil
- `resources/views/vendor/profile/edit.blade.php` - Halaman edit profil
- `resources/views/layouts/vendor.blade.php` - Layout untuk vendor panel

### Routes
- Ditambahkan di `routes/web.php` dalam prefix `vendor`

## 🎨 Desain & UI

### Halaman Profil (View)
- **Layout**: 3 kolom (1 kolom profil card + 2 kolom konten)
- **Sections**:
  1. Profile Card (sidebar kiri)
     - Avatar dengan inisial
     - Nama & email
     - Badge vendor
     - Info bergabung & verifikasi
  
  2. Informasi Toko Card
     - Background gradient hijau
     - Form read-only (display data)
     - Badge status toko
  
  3. Informasi Personal Card
     - Background gradient biru
     - Form read-only (display data)
  
  4. Quick Actions Card
     - Tombol "Edit Profil & Toko"
     - Tombol "Kembali ke Dashboard"

### Halaman Edit (Form)
- **Layout**: Sidebar navigation + 2 kolom form
- **Navigation Sidebar**: Smooth scroll ke section
- **Forms**:
  1. Personal Information (gradient biru)
  2. Store Information (gradient hijau)
  3. Change Password (gradient merah/pink)
- **Features**:
  - Real-time validation
  - Password visibility toggle
  - Password match indicator
  - Loading states

## 🔒 Keamanan

1. **Middleware**: `auth` - Hanya user yang login
2. **Role Check**: Hanya user dengan role `vendor`
3. **Password Validation**:
   - Current password harus benar
   - Minimal 8 karakter
   - Confirmation required
4. **Email Normalization**: Case-insensitive (lowercase)
5. **CSRF Protection**: Semua forms

## ✅ Validasi

### Update Personal
```php
'name' => 'required|string|max:255'
'email' => 'required|email|unique:users,email,{id}'
```

### Update Store
```php
'name' => 'required|string|max:255'
'description' => 'nullable|string|max:1000'
'phone' => 'required|string|max:20'
'address' => 'required|string|max:500'
```

### Update Password
```php
'current_password' => 'required|current_password'
'password' => 'required|confirmed|min:8'
```

## 📱 Responsive Design
- Mobile-first approach
- Grid adapts dari 3 kolom → 1 kolom
- Sticky sidebar navigation
- Touch-friendly buttons

## 🚀 Testing

### Login sebagai Vendor
```
Email: vendor@gmail.com
Password: 12345678
```

### Akses Halaman
1. Login → Dashboard Vendor
2. Klik "Profil Vendor" di quick actions
3. Atau klik dropdown → "Profil Saya"

## 🔄 Flow Penggunaan

```
Login Vendor 
    ↓
Dashboard (/vendor/dashboard)
    ↓
Klik "Profil Vendor"
    ↓
View Profil (/vendor/profile)
    ↓
Klik "Edit Profil"
    ↓
Edit Form (/vendor/profile/edit)
    ↓
Update Personal / Store / Password
    ↓
Redirect → View Profil (dengan success message)
```

## 💡 Features Unggulan

1. ✨ **Modern UI**: Gradient colors, cards, shadows
2. 🔄 **Real-time Validation**: Password match indicator
3. 👁️ **Password Toggle**: Show/hide password
4. 📱 **Fully Responsive**: Mobile, tablet, desktop
5. 🎯 **Smooth Navigation**: Anchor links dengan smooth scroll
6. ✅ **Success Messages**: Flash messages setelah update
7. ❌ **Error Handling**: Validation errors dengan styling
8. 🔒 **Secure**: Current password validation, CSRF, role check

## 🎨 Color Scheme

- **Primary (Green)**: `#10b981` → Store info
- **Secondary (Blue)**: `#3b82f6` → Personal info
- **Danger (Red/Pink)**: `#ef4444` → Password change
- **Success**: `#22c55e` → Success messages
- **Warning**: `#f59e0b` → Warning/pending states

## 📸 Screenshots Sections

1. **Profile View**: Avatar card + Info grid
2. **Edit Personal**: Name + Email form
3. **Edit Store**: Store details (4 fields)
4. **Edit Password**: 3 password fields dengan toggle

## 🔧 Customization

Untuk mengubah maksimal karakter deskripsi:
```php
// VendorProfileController.php
'description' => ['nullable', 'string', 'max:1000'], // ubah 1000
```

Untuk menambah field baru:
1. Tambah di migration `stores` table
2. Tambah validasi di controller
3. Tambah input di view edit
4. Tambah display di view index

---

✅ **Status**: Complete & Ready to Use
🚀 **Version**: 1.0.0
📅 **Created**: {{ date('Y-m-d') }}

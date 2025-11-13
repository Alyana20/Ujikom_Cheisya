# Customer Registration - Optional Fields Documentation

## Overview
Form pendaftaran customer telah ditingkatkan dengan field informasi tambahan yang bersifat **opsional**. Field-field ini membantu dalam:
- Profiling customer yang lebih baik
- Pengiriman produk yang lebih akurat
- Personalisasi pengalaman belanja
- Kemudahan dalam menghubungi customer

## Field yang Tersedia

### 1. **Field Wajib (Required)**
- **Nama Lengkap** - Minimal 3 karakter
- **Email** - Format email yang valid dan unique
- **Password** - Minimal 8 karakter
- **Konfirmasi Password** - Harus sama dengan password

### 2. **Field Opsional (Optional)**

#### Nomor Telepon
- **Field Name:** `phone`
- **Type:** Tel input
- **Validation:** 10-13 digit angka
- **Pattern:** `[0-9]{10,13}`
- **Placeholder:** "Nomor Telepon (contoh: 081234567890)"
- **Icon:** 📱 Phone

#### Tanggal Lahir
- **Field Name:** `date_of_birth`
- **Type:** Date input
- **Validation:** Tanggal harus sebelum hari ini
- **Icon:** 📅 Calendar

#### Jenis Kelamin
- **Field Name:** `gender`
- **Type:** Select dropdown
- **Options:** 
  - Laki-laki (male)
  - Perempuan (female)
- **Icon:** ⚥ Venus-Mars

#### Alamat Lengkap
- **Field Name:** `address`
- **Type:** Text input
- **Max Length:** 255 karakter
- **Placeholder:** "Alamat Lengkap"
- **Icon:** 📍 Map Marker

#### Kota
- **Field Name:** `city`
- **Type:** Text input
- **Max Length:** 100 karakter
- **Placeholder:** "Kota"
- **Icon:** 🏙️ City

#### Kode Pos
- **Field Name:** `postal_code`
- **Type:** Text input
- **Validation:** Tepat 5 digit angka
- **Pattern:** `[0-9]{5}`
- **Max Length:** 5
- **Placeholder:** "Kode Pos"
- **Icon:** 📮 Mail

## Database Schema

### Migration
File: `2025_11_13_115125_add_customer_info_fields_to_users_table.php`

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('phone', 15)->nullable()->after('email');
    $table->date('date_of_birth')->nullable()->after('phone');
    $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');
    $table->string('address')->nullable()->after('gender');
    $table->string('city', 100)->nullable()->after('address');
    $table->string('postal_code', 5)->nullable()->after('city');
});
```

### Users Table Structure
```
users
├── id
├── name
├── email
├── phone (nullable)
├── date_of_birth (nullable)
├── gender (nullable)
├── address (nullable)
├── city (nullable)
├── postal_code (nullable)
├── email_verified_at
├── password
├── role
├── remember_token
├── created_at
└── updated_at
```

## Backend Implementation

### Controller: RegisteredUserController

**Validation Rules:**
```php
[
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    // Optional fields
    'phone' => ['nullable', 'string', 'regex:/^[0-9]{10,13}$/'],
    'date_of_birth' => ['nullable', 'date', 'before:today'],
    'gender' => ['nullable', 'in:male,female'],
    'address' => ['nullable', 'string', 'max:255'],
    'city' => ['nullable', 'string', 'max:100'],
    'postal_code' => ['nullable', 'string', 'regex:/^[0-9]{5}$/'],
]
```

**User Creation:**
```php
User::create([
    'name' => $request->name,
    'email' => $normalizedEmail,
    'password' => Hash::make($request->password),
    'role' => 'customer',
    'email_verified_at' => now(),
    // Optional fields
    'phone' => $request->phone,
    'date_of_birth' => $request->date_of_birth,
    'gender' => $request->gender,
    'address' => $request->address,
    'city' => $request->city,
    'postal_code' => $request->postal_code,
]);
```

### Model: User

**Fillable Fields:**
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone',
    'date_of_birth',
    'gender',
    'address',
    'city',
    'postal_code',
];
```

## Frontend UI

### Layout
File: `resources/views/layouts/guest.blade.php`

**Features:**
- Section terpisah dengan judul "Informasi Tambahan (Opsional)"
- Divider visual (dashed border) untuk membedakan dari field wajib
- Icon yang sesuai untuk setiap field
- Helper text untuk format input (phone, postal code)
- Responsive layout dengan `form-row` untuk field yang berdampingan
- Error message display untuk setiap field
- Old value preservation saat validation error

### Styling
- Konsisten dengan field wajib
- Select dropdown dengan custom arrow icon
- Input dengan icon di sebelah kiri
- Placeholder yang jelas dan informatif
- Focus state dengan border biru dan shadow
- Small helper text di bawah input untuk panduan format

## User Experience

### Benefits
1. **Tidak Menghambat Registrasi** - Semua field opsional, user bisa skip jika ingin cepat
2. **Profiling yang Lebih Baik** - Data lengkap membantu personalisasi
3. **Pengiriman Lebih Mudah** - Alamat, kota, kode pos sudah tersimpan
4. **Kontak Lebih Mudah** - Nomor telepon tersedia untuk konfirmasi pesanan
5. **Clear Visual Separation** - Divider dan label "Opsional" yang jelas

### User Flow
1. User mengisi field wajib (nama, email, password)
2. User melihat section "Informasi Tambahan (Opsional)"
3. User dapat memilih untuk mengisi atau skip field opsional
4. Jika diisi, data akan tervalidasi sesuai format
5. User dapat langsung register tanpa harus mengisi semua field

## Testing

### Test Cases

1. **Registrasi dengan semua field diisi:**
   - ✅ Semua field tersimpan ke database
   - ✅ Validation berjalan untuk semua field
   - ✅ User berhasil login setelah register

2. **Registrasi hanya dengan field wajib:**
   - ✅ Field opsional tersimpan sebagai NULL
   - ✅ Tidak ada error
   - ✅ User berhasil register dan login

3. **Validation Error Handling:**
   - ✅ Phone format salah (< 10 digit atau > 13 digit)
   - ✅ Postal code bukan 5 digit
   - ✅ Date of birth di masa depan
   - ✅ Gender selain 'male' atau 'female'
   - ✅ Old values preserved saat error

4. **Edge Cases:**
   - ✅ Alamat sangat panjang (max 255 karakter)
   - ✅ City name dengan karakter khusus
   - ✅ Phone dengan angka 0 di depan

## Future Enhancements

### Potential Additions
- [ ] Province/State dropdown
- [ ] Country selection for international customers
- [ ] Alternative phone number
- [ ] Profile picture upload during registration
- [ ] Email preferences (newsletter, promotions)
- [ ] Social media links
- [ ] Customer edit profile page to update optional fields
- [ ] Address book for multiple shipping addresses

### UX Improvements
- [ ] Auto-fill city based on postal code (API integration)
- [ ] Phone number formatting (auto add dash/space)
- [ ] Calendar widget for date of birth
- [ ] Address autocomplete (Google Maps API)

## Notes
- Semua field opsional **tidak** mempengaruhi proses checkout
- Field ini dapat diupdate nanti melalui profile customer (jika fitur sudah dibuat)
- Database support NULL values untuk semua field opsional
- Validation regex memastikan format data yang konsisten

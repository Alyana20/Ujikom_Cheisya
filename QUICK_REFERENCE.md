# OSS Healthcare - Quick Reference Guide

## 🔑 Default Credentials

### Admin Account
- **Email**: admin@healthcare.com
- **Password**: admin123
- **Access**: Admin dashboard at `/admin/orders`

### Vendor Account
- **Email**: vendor@healthcare.com
- **Password**: vendor123
- **Access**: Vendor dashboard at `/vendor/dashboard`

### Customer Test Account
- **Email**: test@example.com
- **Password**: password
- **Access**: Customer dashboard at `/dashboard`

### Create New Test Accounts
Visit `http://localhost:8000/register` to create new customer accounts. They automatically get `customer` role.

---

## 🗺️ Navigation Map

### For Visitors (Not Logged In)
```
Home (/)
├── Browse Products (/products)
├── Filter by Category (/products/category/{slug})
└── View Product Details (/products/{id})

Auth Pages
├── Register (/register)
└── Login (/login)
```

### For Customers (Logged In)
```
Dashboard (/dashboard)
├── Recent Orders
├── Profile Card → Edit Profile (/profile)
└── Become a Vendor Section
    └── Apply for Vendor (/shop-request/create)

Shopping
├── Browse Products (/products)
├── Add to Cart (/cart)
└── Checkout (/checkout)

Orders (/orders)
├── Order List (paginated)
└── Order Detail (/orders/{id})
    ├── View Items
    ├── Write Review (if delivered)
    └── Cancel Order (if eligible)

Shop Request
├── View Status (/shop-request)
└── Edit Application (/shop-request/edit) [if rejected]
```

### For Vendors (Vendor Role)
```
Vendor Dashboard (/vendor/dashboard)
├── View Applied Orders
├── Manage Products
└── Check Revenue
```

### For Admins
```
Order Management (/admin/orders)
├── Order List (filterable by status)
└── Order Detail (/admin/orders/{id})
    ├── View Items
    ├── Mark as Shipped
    └── Mark as Delivered

Vendor Applications (/admin/shop-requests)
├── Application List
└── Application Detail (/admin/shop-requests/{id})
    ├── Approve Vendor
    ├── Reject Vendor
    └── Reopen Vendor

Review Moderation
├── Approve Review
└── Reject Review
```

---

## 📊 Order Status Lifecycle

```
pending → paid → processing → shipped → delivered
    ↓
cancelled (if cancelled)
```

**Status Descriptions**:
- **pending**: Order created, awaiting payment
- **paid**: Payment received from customer
- **processing**: Admin preparing shipment
- **shipped**: Order sent to customer (shipped_at set)
- **delivered**: Order received by customer (delivered_at set)
- **cancelled**: Order cancelled by customer

---

## ⭐ Key Features Quick Access

| Feature | URL | Requires |
|---------|-----|----------|
| Home | `/` | None |
| Browse Products | `/products` | None |
| Filter by Category | `/products/category/{slug}` | None |
| View Product | `/products/{id}` | None |
| Shopping Cart | `/cart` | Login |
| Checkout | `/checkout` | Login |
| Order History | `/orders` | Login |
| Order Details | `/orders/{id}` | Login (own order) |
| Write Review | POST `/products/{id}/reviews` | Login (delivered order) |
| Apply for Vendor | `/shop-request/create` | Login (customer) |
| Admin Orders | `/admin/orders` | Login (admin) |
| Vendor Applications | `/admin/shop-requests` | Login (admin) |

---

## 🎨 Product Categories

The system comes pre-seeded with 6 healthcare categories:

1. **Alat Medis** - Medical Equipment (slug: `alat-medis`)
2. **Suplemen** - Supplements (slug: `suplemen`)
3. **Obat** - Medicines (slug: `obat`)
4. **Perawatan Kulit** - Skincare (slug: `perawatan-kulit`)
5. **Peralatan Olahraga** - Sports Equipment (slug: `peralatan-olahraga`)
6. **Masker** - Masks (slug: `masker`)

Browse by category: `/products/category/{slug}`

---

## 💾 Database Backup & Restore

### Backup current database
```bash
php artisan db:backup
# or
mysqldump -u root -p database_name > backup.sql
```

### Restore from backup
```bash
php artisan migrate:fresh --seed
# or
mysql -u root -p database_name < backup.sql
```

### Reset everything
```bash
php artisan migrate:fresh --seed
```

---

## 🧪 Running Tests

### All tests
```bash
php artisan test
```

### Auth tests only
```bash
php artisan test --filter Auth
```

### Feature tests
```bash
php artisan test --filter Feature
```

### Specific test file
```bash
php artisan test tests/Feature/Auth/RegistrationTest.php
```

**Current Status**: ✅ 19 tests passing

---

## 🔍 Debugging Tips

### Check last 10 log entries
```bash
tail -f storage/logs/laravel.log
```

### Enter Tinker shell
```bash
php artisan tinker
```

### Common Tinker queries
```php
# List all users
User::all()

# Get user by email
User::where('email', 'admin@healthcare.com')->first()

# Count orders
Order::count()

# Find pending reviews
Review::where('approved', false)->get()
```

### Database queries in app.php (in bootstrap/app.php)
```php
DB::listen(function ($query) {
    echo $query->sql . ' | ' . json_encode($query->bindings);
});
```

---

## 📱 API Response Formats

### Successful Response
```json
{
  "success": true,
  "message": "Operation completed",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

### Redirect Responses
All forms redirect with session flash messages (success/error)

---

## 🔒 Security Checklist

- ✅ Email normalized (lowercase + trimmed)
- ✅ Passwords hashed (bcrypt)
- ✅ CSRF tokens on all forms
- ✅ Role-based access control
- ✅ SQL injection prevention (Eloquent)
- ✅ Validation on all inputs
- ✅ Cascading deletes configured
- ⚠️ XSS prevention (Blade auto-escaping)
- ⚠️ Rate limiting (not yet implemented)
- ⚠️ 2FA (not yet implemented)

---

## 🐛 Common Issues & Solutions

### Issue: "SQLSTATE[HY000]: General error: 1030"
**Solution**: Reset database with `php artisan migrate:fresh --seed`

### Issue: "Column 'email' doesn't exist"
**Solution**: Run migrations: `php artisan migrate`

### Issue: "View not found"
**Solution**: Check view path in controller, run `php artisan cache:clear`

### Issue: "Undefined variable" in Blade
**Solution**: Verify controller is passing variable: `view('page', ['var' => $value])`

### Issue: "404 on route"
**Solution**: Verify route exists in `routes/web.php`, run `php artisan route:list`

### Issue: Cart items lost after logout
**Solution**: Normal behavior - cart is session-based. Encourage user to login first.

---

## 📈 Performance Optimization

### Cache database queries
```php
Product::with('category', 'reviews')->get();
```

### Paginate large datasets
```php
$orders = Order::paginate(15);
```

### Optimize images
Place images in `storage/app/public/` and use `Storage::url()`

### Queue long operations
```php
dispatch(new SendEmail($user));
```

---

## 🔗 Important File Locations

| File | Purpose |
|------|---------|
| `routes/web.php` | All route definitions |
| `app/Http/Controllers/` | Request handlers |
| `app/Models/` | Database models |
| `resources/views/` | HTML templates |
| `database/migrations/` | Database schema |
| `database/seeders/` | Sample data |
| `.env` | Environment config |
| `config/` | Application config |
| `storage/logs/` | Error logs |

---

## 🚀 Deployment Checklist

Before deploying to production:

- [ ] Set `.env` variables (DB_HOST, DB_PASSWORD, etc.)
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan optimize:clear`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure HTTPS/SSL
- [ ] Set up email service for notifications
- [ ] Configure payment gateway credentials
- [ ] Set up backup strategy
- [ ] Monitor logs and errors
- [ ] Set up caching (Redis recommended)
- [ ] Configure session storage

---

## 📞 Quick Help

**Laravel Docs**: https://laravel.com/docs/  
**Eloquent ORM**: https://laravel.com/docs/eloquent  
**Blade Templates**: https://laravel.com/docs/blade  
**Local Server**: `php artisan serve`  
**Routes List**: `php artisan route:list`  
**Database Tinker**: `php artisan tinker`  

---

**Last Updated**: November 2025  
**Version**: 1.0.0

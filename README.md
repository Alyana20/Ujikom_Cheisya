# 🏥 OSS Healthcare - Marketplace Platform

An open-source healthcare e-commerce marketplace built with Laravel. Connect healthcare product suppliers with customers through a complete, multi-role platform.

## 🌟 Key Features

- **Multi-Role System**: Visitor → Customer → Vendor workflow with Admin oversight
- **Product Browsing**: Browse 6 healthcare product categories
- **Shopping Cart**: Session-based cart management
- **Order Management**: Complete order lifecycle with status tracking
- **Vendor Management**: Customer applications to become vendors with admin approval
- **Product Reviews**: Customer reviews with admin moderation
- **Payment Ready**: Support for COD (Cash on Delivery) with extensible payment gateway integration
- **Admin Dashboard**: Comprehensive management tools for orders, vendors, and reviews

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/SQLite
- Node.js & npm

### Installation

```bash
# Clone repository
cd c:\Users\HP_14\oss-healthcare

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Start development server
php artisan serve
# In another terminal
npm run dev
```

Visit `http://localhost:8000/` to access the application.

## 🔑 Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@healthcare.com | admin123 |
| Vendor | vendor@healthcare.com | vendor123 |
| Customer | test@example.com | password |

**Create new accounts**: Register at `/register` (auto role: customer)

## 📚 Documentation

- **[SYSTEM_DOCUMENTATION.md](./SYSTEM_DOCUMENTATION.md)** - Complete system guide with workflows, database schema, and features
- **[QUICK_REFERENCE.md](./QUICK_REFERENCE.md)** - Quick reference guide with credentials, routes, and tips

## 👥 User Roles

### 👤 Visitor
- Browse products by category
- View product details and reviews
- Add items to cart
- Leave guest book messages

### 🛍️ Customer
- All visitor features plus:
- Create/manage account
- Place and track orders
- Write product reviews
- Apply to become vendor

### 🏪 Vendor
- Manage products
- Receive and fulfill orders
- View vendor dashboard

### ⚙️ Admin
- Approve/reject vendor applications
- Manage orders and shipping
- Moderate reviews and guest messages
- View system analytics

## 🗂️ Project Structure

```
app/Models/
├── User
├── Product
├── Order
├── Review
├── Category
└── ShopRequest

app/Http/Controllers/
├── ProductController
├── CartController
├── CheckoutController
├── OrderController
├── ReviewController
└── ShopRequestController

resources/views/
├── visitor/ (public pages)
├── customer/ (customer dashboard)
├── admin/ (admin panels)
└── components/

routes/
├── web.php (main routes)
└── auth.php (auth scaffolding)
```

## 📦 Key Technologies

- **Laravel 11** - Web framework
- **Blade** - Templating
- **Eloquent ORM** - Database abstraction
- **Tailwind CSS** - Styling
- **Vite** - Asset bundling
- **PHPUnit/Pest** - Testing

## ✅ Testing

```bash
# Run all tests
php artisan test

# Run specific suite
php artisan test --filter Auth
```

**Status**: ✅ 19/19 tests passing

## 🗄️ Database Schema

### Core Tables
- `users` - User accounts with role-based access
- `products` - Healthcare products with categories
- `orders` - Customer orders with status tracking
- `order_items` - Individual items in orders
- `categories` - 6 healthcare product categories
- `reviews` - Product reviews with approval system
- `guest_book` - Visitor messages
- `shop_requests` - Vendor applications
- `stores` - Vendor stores

## 🔗 Main Routes

| Route | Description | Auth |
|-------|-------------|------|
| `/` | Homepage | - |
| `/products` | Browse products | - |
| `/products/category/{slug}` | Filter by category | - |
| `/dashboard` | Customer dashboard | Customer |
| `/orders` | Order history | Customer |
| `/checkout` | Checkout page | Customer |
| `/shop-request/create` | Apply for vendor | Customer |
| `/admin/orders` | Admin orders | Admin |
| `/admin/shop-requests` | Vendor applications | Admin |

## 🔐 Security Features

- ✅ Email normalization (case-insensitive login)
- ✅ Password hashing (bcrypt)
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ Role-based access control
- ✅ Data validation

## 🚀 Workflows

### 1. New Customer → Purchase
Register → Browse Products → Add to Cart → Checkout → Track Order → Review

### 2. Customer → Vendor
Apply for Vendor → Admin Reviews → Approved → Role Changes to Vendor

### 3. Order Fulfillment
Customer Places Order → Admin Marks Shipped → Delivered → Review Available

## 🎨 Healthcare Categories

1. **Alat Medis** - Medical Equipment
2. **Suplemen** - Supplements
3. **Obat** - Medicines
4. **Perawatan Kulit** - Skincare
5. **Peralatan Olahraga** - Sports Equipment
6. **Masker** - Masks

## 🛠️ Development

### Fresh Start
```bash
php artisan migrate:fresh --seed
```

### View Database
```bash
php artisan tinker
# Then: User::all()
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

## 🚀 Future Enhancements

- Real payment gateway integration (Stripe, Midtrans)
- Email notifications
- Vendor dashboard with product management
- Customer wishlists
- PDF invoices
- Shipping integrations
- Mobile app (React Native/Flutter)
- Advanced analytics

## 📄 License

Open-source software licensed under the MIT license.

## 📞 Support

For documentation, see [SYSTEM_DOCUMENTATION.md](./SYSTEM_DOCUMENTATION.md) or [QUICK_REFERENCE.md](./QUICK_REFERENCE.md)

---

**Version**: 1.0.0 | **Status**: ✅ Production Ready | **Tests**: ✅ 19/19 Passing

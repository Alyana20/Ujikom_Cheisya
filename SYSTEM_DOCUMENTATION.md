# OSS Healthcare - Marketplace Platform

An open-source healthcare marketplace system that connects visitors, customers, and vendors in a healthcare ecosystem with admin oversight.

## 🌟 System Overview

**OSS Healthcare** is a Laravel-based e-commerce marketplace platform designed specifically for the healthcare sector. It provides a complete workflow from visitor browsing, customer registration and purchasing, to vendor management and order fulfillment.

### Core Features

- **Multi-Role System**: Visitor → Customer → Vendor roles with admin oversight
- **Product Browsing**: Browse healthcare products by category (Alat Medis, Suplemen, Obat, Perawatan Kulit, Peralatan Olahraga, Masker)
- **Shopping Cart**: Session-based cart management
- **Order Management**: Complete order lifecycle tracking with status updates
- **Payment Ready**: Support for multiple payment methods (COD ready, extensible for Stripe/Midtrans)
- **Vendor Application**: Customers can apply to become vendors with admin approval
- **Product Reviews**: Customer reviews with admin moderation
- **Visitor Feedback**: Guest book for visitor messages
- **Admin Dashboard**: Comprehensive order, vendor, and review management

---

## 👥 Roles & User Workflows

### 1. **Visitor** (Unauthenticated)
- Browse products by category
- View product details and available reviews
- Add items to session-based cart
- Sign up or login
- Leave messages in guest book (pending admin approval)

**Entry Point**: `http://localhost:8000/`

### 2. **Customer** (Registered User)
- All visitor features plus:
- Create and manage account
- View and manage orders
- Track order status in real-time
- Write reviews on purchased products (pending admin approval)
- Cancel eligible orders (pending/paid/processing status)
- View order history with filtering
- Apply to become a vendor

**Entry Point**: `/dashboard` (after login)

**Default Customer Account**:
```
Email: test@example.com
Password: password
```

### 3. **Vendor** (Approved Customer)
- Manage own products
- View vendor application status
- Receive orders for their products
- Fulfill orders
- View vendor dashboard

**To Become a Vendor**:
1. Login as customer
2. Go to dashboard → "Become a Vendor" section
3. Click "Apply Now"
4. Admin reviews and approves application
5. Role automatically updates to "Vendor"

**Default Vendor Account** (Pre-approved):
```
Email: vendor@healthcare.com
Password: vendor123
```

### 4. **Admin**
- Approve/reject vendor applications
- Manage all orders and order status
- Mark orders as shipped/delivered
- Moderate product reviews
- View and moderate guest book messages
- Manage product categories
- View system analytics

**Entry Point**: `/admin/orders`

**Default Admin Account**:
```
Email: admin@healthcare.com
Password: admin123
```

---

## 🔑 Key Workflows

### Workflow 1: New Customer Registration & Purchase

```
1. Visit http://localhost:8000/
   ↓
2. Click "Register" or "Sign Up"
   ↓
3. Fill registration form (name, email, password)
   - Email automatically normalized (lowercase + trimmed)
   ↓
4. Redirect to dashboard
   ↓
5. Click "Browse Products" or go to /products
   ↓
6. Filter by category (optional)
   ↓
7. Click "Add to Cart" for desired products
   ↓
8. Go to /cart to review items
   ↓
9. Click "Checkout"
   ↓
10. Fill delivery address details
    ↓
11. Select payment method (COD currently)
    ↓
12. Click "Place Order"
    ↓
13. View confirmation → Order created with "pending" status
    ↓
14. Admin marks as paid → shipped → delivered
    ↓
15. Customer can then review products
```

### Workflow 2: Become a Vendor

```
1. Login as customer
   ↓
2. Go to /dashboard
   ↓
3. In sidebar, click "Apply Now" under "Become a Vendor"
   ↓
4. Fill vendor application form
   - Shop name
   - Description
   - Contact info
   ↓
5. Submit application (status: pending)
   ↓
6. Admin goes to /admin/shop-requests
   ↓
7. Admin clicks "Review" and sees application details
   ↓
8. Admin clicks "Approve" or "Reject"
   ↓
9. If approved:
   - ShopRequest status → approved
   - User role → vendor
   - Store created for user
   ↓
10. Vendor can now manage products and receive orders
```

### Workflow 3: Admin Order Processing

```
1. Admin goes to /admin/orders
   ↓
2. Sees all orders with status badges and filtering
   ↓
3. Clicks "View" on an order
   ↓
4. Can see:
   - Order details and items
   - Customer information
   - Delivery address
   - Payment status
   ↓
5. Admin clicks "Mark as Shipped" → status = shipped, shipped_at timestamp set
   ↓
6. After customer receives, admin clicks "Mark as Delivered"
   → status = delivered, delivered_at timestamp set
   ↓
7. Customer can now write product reviews
```

### Workflow 4: Product Reviews

```
1. Customer receives order (status = delivered)
   ↓
2. Goes to /orders (order history)
   ↓
3. Clicks "View Details" on completed order
   ↓
4. Each product shows "+ Write a Review" button
   ↓
5. Clicks button to reveal review form
   ↓
6. Enters rating (1-5 stars) and optional comment
   ↓
7. Submits review (approved = false, pending admin approval)
   ↓
8. Admin goes to /admin/reviews (or moderation panel)
   ↓
9. Admin approves or rejects review
   ↓
10. If approved, review appears on product page with author name
```

---

## 🗄️ Database Schema

### Core Tables

#### **users**
```php
id (PK)
name
email (unique, normalized: lowercase + trimmed)
email_verified_at
password (hashed)
phone (nullable)
address (nullable)
city (nullable)
birth_date (nullable)
role (enum: admin, vendor, customer)
created_at
updated_at
```

#### **products**
```php
id (PK)
name
description
sku
price (decimal)
stock (integer)
image (nullable, path to storage)
category_id (FK → categories)
store_id (FK → stores, nullable for old products)
created_at
updated_at
```

#### **orders**
```php
id (PK)
user_id (FK → users)
total_amount (decimal, legacy)
total_price (decimal, new standard)
status (enum: pending, paid, processing, shipped, delivered, cancelled)
payment_method (default: cod)
payment_status (default: unpaid)
shipping_address (nullable)
recipient_name (nullable)
recipient_phone (nullable)
delivery_address (nullable)
delivery_city (nullable)
shipping_cost (decimal)
paid_at (nullable, timestamp)
shipped_at (nullable, timestamp)
delivered_at (nullable, timestamp)
cancelled_at (nullable, timestamp)
created_at
updated_at
```

#### **order_items**
```php
id (PK)
order_id (FK → orders)
product_id (FK → products)
quantity (integer)
price (decimal, price at time of purchase)
subtotal (decimal, quantity × price)
created_at
updated_at
```

#### **categories**
```php
id (PK)
name (unique)
slug (unique)
description (nullable)
icon (nullable)
created_at
updated_at
```

#### **reviews**
```php
id (PK)
user_id (FK → users)
product_id (FK → products)
order_item_id (nullable, FK → order_items, for tracking)
rating (integer: 1-5)
comment (nullable, text)
approved (boolean, default: false)
created_at
updated_at
```

#### **guest_book** (Visitor Messages)
```php
id (PK)
name (nullable, if user logged in)
email (nullable)
message (text)
approved (boolean, default: false)
created_at
updated_at
```

#### **shop_requests** (Vendor Applications)
```php
id (PK)
user_id (FK → users, unique)
shop_name
shop_description (nullable)
phone (nullable)
status (enum: pending, approved, rejected)
rejection_reason (nullable, if rejected)
created_at
updated_at
```

#### **stores** (Vendor Stores)
```php
id (PK)
user_id (FK → users, unique)
name
description (nullable)
logo (nullable)
created_at
updated_at
```

#### **categories** (Healthcare Products)
```
1. Alat Medis (Medical Equipment)
2. Suplemen (Supplements)
3. Obat (Medicines)
4. Perawatan Kulit (Skincare)
5. Peralatan Olahraga (Sports Equipment)
6. Masker (Masks)
```

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/SQLite
- Node.js & npm (for Vite)

### Installation

1. **Clone and setup**
```bash
cd c:\Users\HP_14\oss-healthcare
composer install
npm install
```

2. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database setup**
```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# This creates:
# - All tables
# - 6 product categories
# - Test products
# - Admin account (admin@healthcare.com / admin123)
# - Vendor account (vendor@healthcare.com / vendor123)
# - Customer test account (test@example.com / password)
```

4. **Start development server**
```bash
php artisan serve
# or with npm watch
npm run dev (in another terminal)
```

5. **Access the application**
- Visitor: `http://localhost:8000/`
- Dashboard: `http://localhost:8000/dashboard` (after login)
- Admin: `http://localhost:8000/admin/orders` (login as admin)

---

## 🔗 Key Routes & Endpoints

### Public Routes
| Route | Description |
|-------|-------------|
| `GET /` | Homepage with featured products |
| `GET /products` | Browse all products with filters |
| `GET /products/category/{slug}` | Browse by category |
| `GET /products/{product}` | Product detail page |
| `GET /register` | Registration page |
| `GET /login` | Login page |

### Customer Routes (Authenticated)
| Route | Description |
|-------|-------------|
| `GET /dashboard` | Customer dashboard |
| `GET /orders` | Order history |
| `GET /orders/{order}` | Order detail with review form |
| `POST /orders/{order}/cancel` | Cancel order (if eligible) |
| `GET /cart` | Shopping cart |
| `POST /cart/add` | Add item to cart |
| `POST /cart/update` | Update cart item quantity |
| `POST /cart/remove` | Remove from cart |
| `GET /checkout` | Checkout page |
| `POST /checkout` | Process checkout |
| `GET /orders/{order}/confirmation` | Order confirmation |
| `POST /products/{product}/reviews` | Submit product review |
| `DELETE /reviews/{review}` | Delete own review |

### Vendor Routes (Customer applying to Vendor)
| Route | Description |
|-------|-------------|
| `GET /shop-request/create` | Vendor application form |
| `POST /shop-request` | Submit application |
| `GET /shop-request` | View application status |
| `GET /shop-request/edit` | Edit pending/rejected application |
| `PUT /shop-request` | Update application |

### Admin Routes (Admin only)
| Route | Description |
|-------|-------------|
| `GET /admin/orders` | All orders management |
| `GET /admin/orders/{order}` | Order detail with shipping controls |
| `POST /admin/orders/{order}/ship` | Mark order as shipped |
| `POST /admin/orders/{order}/deliver` | Mark order as delivered |
| `GET /admin/shop-requests` | Vendor applications |
| `GET /admin/shop-requests/{request}` | Application detail |
| `POST /admin/shop-requests/{request}/approve` | Approve vendor |
| `POST /admin/shop-requests/{request}/reject` | Reject vendor |
| `POST /admin/reviews/{review}/approve` | Approve review |
| `POST /admin/reviews/{review}/reject` | Reject review |

---

## 🧪 Testing

Run all tests:
```bash
php artisan test
```

Run specific test suite:
```bash
php artisan test --filter Auth
php artisan test --filter Feature
```

**Current Test Status**: ✅ 19 tests passing (Auth suite)

---

## 📊 Models & Relationships

### User Model
```php
// Relationships
$user->orders() // Has many orders
$user->reviews() // Has many reviews
$user->shopRequest() // Has one vendor application
$user->store() // Has one vendor store

// Methods
$user->isAdmin() // Check if admin
$user->isVendor() // Check if vendor
$user->isCustomer() // Check if customer
```

### Product Model
```php
// Relationships
$product->category() // Belongs to category
$product->reviews() // Has many reviews
$product->approvedReviews() // Scoped: only approved reviews
$product->orderItems() // Has many order items

// Methods
$product->averageRating() // Get avg rating (0 if none)
```

### Order Model
```php
// Relationships
$order->user() // Belongs to user
$order->items() // Has many order items

// Status Methods
$order->isPending() // status == pending
$order->isPaid() // status == paid
$order->isShipped() // status == shipped
$order->isDelivered() // status == delivered
$order->isCancelled() // status == cancelled
$order->canCancel() // Can be cancelled (pending/paid/processing)

// Timestamps
$order->paid_at // When marked as paid
$order->shipped_at // When marked as shipped
$order->delivered_at // When delivered
$order->cancelled_at // When cancelled
```

### Review Model
```php
// Relationships
$review->user() // Belongs to user
$review->product() // Belongs to product

// Attributes
$review->rating // 1-5 stars
$review->comment // Review text
$review->approved // Boolean, pending admin approval
```

---

## 🔐 Security Features

- ✅ **Email Normalization**: Emails auto-normalized to lowercase + trimmed to prevent case-sensitivity issues
- ✅ **Password Hashing**: All passwords hashed with bcrypt
- ✅ **CSRF Protection**: Built-in Laravel CSRF tokens
- ✅ **SQL Injection Prevention**: Eloquent ORM with parameter binding
- ✅ **Role-Based Access Control**: Middleware for admin/vendor routes
- ✅ **Authentication Required**: Protected routes require login
- ✅ **Data Validation**: All inputs validated with Laravel Validator
- ✅ **Cascading Deletes**: Foreign key constraints with cascading

---

## 📦 Key Dependencies

- **Laravel 11**: Web framework
- **Eloquent ORM**: Database abstraction
- **Blade Templates**: View rendering
- **Tailwind CSS**: Styling
- **Vite**: Asset bundling
- **PHPUnit/Pest**: Testing

---

## 🛠️ Architecture

### Directory Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController
│   │   ├── CartController
│   │   ├── CheckoutController
│   │   ├── OrderController
│   │   ├── ReviewController
│   │   ├── GuestBookController
│   │   ├── ShopRequestController
│   │   └── ShopRequestApprovalController
│   └── Middleware/
├── Models/
│   ├── User
│   ├── Product
│   ├── Order
│   ├── OrderItem
│   ├── Category
│   ├── Review
│   ├── GuestBook
│   ├── ShopRequest
│   └── Store
└── Providers/

resources/
├── views/
│   ├── layouts/
│   ├── visitor/ (public pages)
│   ├── customer/ (customer dashboard & orders)
│   ├── vendor/ (vendor pages & shop requests)
│   ├── admin/ (admin panels)
│   └── components/
└── css/app.css

routes/
├── web.php (main routes)
├── auth.php (auth scaffolding)

database/
├── migrations/ (schema)
├── seeders/ (sample data)
└── factories/ (test data)
```

### Key Controllers

**ProductController**: Browse products, filter by category, view details
**CartController**: Session-based cart CRUD
**CheckoutController**: Checkout flow and order creation
**OrderController**: Customer order history, admin order management
**ReviewController**: Product reviews with admin approval
**ShopRequestController**: Customer vendor applications
**ShopRequestApprovalController**: Admin vendor approval

---

## 🚀 Future Enhancements

1. **Payment Gateway Integration**
   - Stripe for credit card payments
   - Midtrans for Indonesian payment methods
   - Payment verification webhooks

2. **Notifications**
   - Email notifications for order status changes
   - SMS notifications for critical updates
   - In-app notifications dashboard

3. **Vendor Features**
   - Vendor dashboard with product management
   - Inventory tracking
   - Sales analytics
   - Bulk order import

4. **Advanced Features**
   - Customer wishlists
   - Product recommendations
   - Discount codes & coupons
   - Bulk purchasing
   - PDF invoices
   - Shipping integrations (JNE, Tiki, etc.)

5. **Admin Enhancements**
   - Analytics dashboard
   - Category management UI
   - Product moderation
   - Vendor performance reports
   - Dispute resolution system

6. **Mobile App**
   - React Native or Flutter app
   - Mobile-optimized experience
   - Push notifications

---

## 📝 Migration Guide

All pending migrations are applied with:
```bash
php artisan migrate
```

Recent migrations:
- `2025_11_13_000003`: Add payment tracking to orders
- `2025_11_13_000004`: Create reviews and guest_book tables

---

## 🐛 Troubleshooting

### Email Login Issues
**Q**: Can't login with specific email casing?  
**A**: Email is normalized to lowercase on storage and login. Ensure you're using the correct credentials.

### Order Not Showing
**Q**: Created an order but not seeing it?  
**A**: Check user authentication and that you're logged in to the correct account.

### Review Not Appearing
**Q**: Submitted a review but don't see it?  
**A**: Reviews require admin approval before displaying. Admin can approve at `/admin/reviews`.

### Cart Disappeared
**Q**: Items disappeared from cart?  
**A**: Cart is session-based and clears on logout. Create an account to persist cart.

---

## 📞 Support

For issues or feature requests, please create an issue in the repository.

---

## 📄 License

This project is open-source and available under the MIT License.

---

**Version**: 1.0.0  
**Last Updated**: November 2025  
**Status**: ✅ Production Ready  
**Tests**: ✅ 19/19 Passing

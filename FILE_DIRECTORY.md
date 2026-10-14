# Delight Home E-Commerce - Complete File Directory

## 📁 Project Structure & File Descriptions

### 🏠 Root Level - Main Customer Pages

| File | Purpose | Features |
|------|---------|----------|
| `index.php` | Home page landing | Hero section, featured products, categories, testimonials, newsletter signup |
| `about.php` | About Us page | Company story, mission/vision, core values, why choose us |
| `categories.php` | Categories showcase | Display all product categories with featured products |
| `products.php` | Shop/browse page | Product grid with advanced filtering, search, sorting, pagination |
| `product-details.php` | Product detail page | Full product info, images, related products, add to cart |
| `cart.php` | Shopping cart | Cart items table, quantity management, total calculation |
| `checkout.php` | Checkout page | Shipping form, payment method, order summary |
| `contact.php` | Contact form | Contact form, contact info, social links, map placeholder |
| `login.php` | User login | Email/password authentication, demo credentials display |
| `signup.php` | User registration | Registration form with validation, password hashing |
| `logout.php` | Logout handler | Session destruction and redirect |
| `order-success.php` | Order confirmation | Order details, order items, confirmation message |
| `account.php` | User account | Account info, order history, logout button |
| `orders.php` | Order history | User's past orders with status and details |
| `wishlist.php` | Wishlist page | Saved products grid, add to cart, remove options |

### 🛠️ Admin Panel - Management Pages

| File | Purpose | Features |
|------|---------|----------|
| `admin/index.php` | Admin router | Redirects to appropriate page based on login status |
| `admin/login.php` | Admin login | Email/password authentication with is_admin check |
| `admin/dashboard.php` | Admin home | Statistics, recent orders, quick actions, sidebar menu |
| `admin/products.php` | Product management | List products, add new, edit existing, delete products |
| `admin/categories.php` | Category management | Add categories, list all, edit/delete via prompts |
| `admin/orders.php` | Order management | List/view orders, update status, customer info |
| `admin/users.php` | User management | List all registered customers with contact info |
| `admin/messages.php` | Contact messages | View form submissions, mark as read, delete |

### 📡 API Endpoints - AJAX Operations

| File | Purpose | Operations |
|------|---------|------------|
| `api/cart.php` | Shopping cart API | add_to_cart, remove_from_cart, update_quantity, get_count, clear_cart |
| `api/wishlist.php` | Wishlist API | toggle_wishlist (add/remove based on state) |
| `api/newsletter.php` | Newsletter API | subscribe (email subscription handling) |

### 📦 Includes - Reusable Components & Libraries

| File | Size | Purpose |
|------|------|---------|
| `includes/header.php` | ~50 lines | HTML document head, meta tags, CSS/Font Awesome links |
| `includes/navbar.php` | ~150 lines | Sticky navigation bar, responsive mobile toggle, cart badge |
| `includes/footer.php` | ~100 lines | Multi-section footer with links, contact info, social |
| `includes/db.php` | ~15 lines | MySQLi database connection initialization |
| `includes/functions.php` | ~450 lines | 30+ utility functions for products, cart, users, orders |

### 🎨 Styling & Scripts

| File | Size | Purpose |
|------|------|---------|
| `css/style.css` | ~1000 lines | Complete responsive stylesheet with CSS Grid/Flexbox |
| `js/script.js` | ~400 lines | Interactive functionality: cart, wishlist, forms, mobile nav |

### 💾 Database

| File | Size | Purpose |
|------|------|---------|
| `database/delight_home.sql` | ~300 lines | Complete MySQL schema with 8 tables and sample data |

### 📖 Documentation

| File | Purpose |
|------|---------|
| `README.md` | Comprehensive documentation and setup guide |
| `QUICK_START.md` | Quick start guide with checklists |

---

## 🔑 Key Files Explained

### Core Backend: `includes/functions.php`
**40+ Functions Organized By Category:**

**Session & Authentication (3 functions)**
- `getCurrentUser()` - Get logged-in user data
- `isLoggedIn()` - Check if user authenticated
- `isAdmin()` - Check if user is admin

**Products (5 functions)**
- `getProducts()` - Get products with filters/sorting/pagination
- `getProductsCount()` - Count products matching filters
- `getProduct()` - Get single product
- `getRelatedProducts()` - Get similar products in category
- `getCategories()` / `getCategory()` - Category retrieval

**Cart Management (7 functions)**
- `addToCart()` - Add item to cart (guest/auth)
- `removeFromCart()` - Remove cart item
- `updateCartQuantity()` - Change quantity
- `getCartItems()` - Get all cart items
- `getCartCount()` - Get total item count
- `getCartTotal()` - Calculate cart total
- `clearCart()` - Empty cart

**Wishlist (3 functions)**
- `addToWishlist()` - Add product to wishlist
- `removeFromWishlist()` - Remove from wishlist
- `isInWishlist()` - Check if product in wishlist

**Orders (3 functions)**
- `createOrder()` - Create new order from cart
- `getOrder()` - Get order details
- `getOrderItems()` - Get items in order
- `getUserOrders()` - Get user's order history

**Validation & Formatting (3 functions)**
- `isValidEmail()` - Email format validation
- `sanitize()` - SQL injection prevention
- `formatPrice()` - Format price with currency
- `getDiscountPercentage()` - Calculate discount %

### Database: `database/delight_home.sql`

**8 Tables:**
1. **users** (10 fields) - User accounts with admin flag
2. **categories** (4 fields) - Product categories
3. **products** (12 fields) - Product inventory
4. **cart** (6 fields) - Shopping cart items
5. **wishlist** (3 fields) - Saved products
6. **orders** (6 fields) - Customer orders
7. **order_items** (5 fields) - Items in orders
8. **contact_messages** (8 fields) - Contact form submissions

**Sample Data:**
- 9 product categories
- 15 sample products (featured/non-featured)
- 1 admin user (admin@delighthome.com / admin123)
- 3 sample contact messages

### Styling: `css/style.css`

**Key CSS Features:**
- **CSS Variables** for theming and consistency
- **Responsive Grid Systems** (grid-2, grid-3, grid-4)
- **Flexbox Layouts** for flexibility
- **Mobile-First Design** with breakpoints
- **Smooth Transitions** and animations
- **Hover Effects** on all interactive elements
- **Shadow Utilities** for depth
- **Utility Classes** for spacing and sizing

**Responsive Breakpoints:**
- 768px (tablet to mobile)
- 480px (small mobile)

### JavaScript: `js/script.js`

**Main Features:**
- **Mobile Navigation** - Hamburger toggle and close
- **Cart AJAX** - Add/remove/update items dynamically
- **Wishlist Toggle** - Add/remove from wishlist
- **Form Validation** - Email, phone, required fields
- **Notifications** - Auto-dismissing alerts
- **Quantity Controls** - +/- buttons for product quantity
- **Lazy Image Loading** - Intersection Observer API
- **Dynamic Cart Count** - Updates via API

---

## 📊 File Statistics

| Category | Count | Lines | Purpose |
|----------|-------|-------|---------|
| Customer Pages | 15 | ~3000 | Customer-facing functionality |
| Admin Pages | 8 | ~1500 | Admin management system |
| API Endpoints | 3 | ~200 | AJAX/API operations |
| Includes | 5 | ~700 | Shared components & logic |
| CSS | 1 | ~1000 | All styling |
| JavaScript | 1 | ~400 | All interactivity |
| Database | 1 | ~300 | Schema & sample data |
| **Total** | **34** | **~7100** | **Complete e-commerce site** |

---

## 🔄 File Dependencies

### Page Hierarchy

```
index.php
├── includes/header.php
├── includes/navbar.php (requires functions.php)
├── includes/footer.php
└── css/style.css + js/script.js

admin/dashboard.php
├── includes/header.php
├── includes/db.php
├── includes/functions.php
└── CSS styling

API endpoints
├── includes/db.php
├── includes/functions.php
└── JSON responses
```

### Key Dependencies

**All Pages Require:**
- `includes/header.php` - HTML structure
- `includes/navbar.php` - Navigation
- `includes/footer.php` - Footer
- `css/style.css` - Styling
- `js/script.js` - Interactivity

**Functions Pages Require:**
- `includes/db.php` - Database connection
- `includes/functions.php` - Business logic

**Admin Pages Require:**
- `includes/db.php` - Database access
- Admin login check (`isAdmin()`)

---

## 💾 Database Design

### Table Relationships

```
users (1) ──→ (Many) cart
users (1) ──→ (Many) wishlist
users (1) ──→ (Many) orders

products (1) ──→ (Many) cart
products (1) ──→ (Many) wishlist
products (1) ──→ (Many) order_items

categories (1) ──→ (Many) products

orders (1) ──→ (Many) order_items
```

### Key Columns

- **users.is_admin** - Flag for admin access
- **products.featured** - For homepage display
- **products.discount_price** - For sale pricing
- **orders.status** - Order state tracking
- **cart.session_id** - Guest cart support

---

## 🎯 File Access Flow

### Customer Journey

1. `index.php` (Browse home)
2. `categories.php` (View categories)
3. `products.php` (Shop with filters)
4. `product-details.php` (View product)
5. `cart.php` (Review cart)
6. `checkout.php` (Place order)
7. `order-success.php` (Confirmation)
8. `login.php` / `signup.php` (Create account)
9. `account.php` (View profile)
10. `orders.php` (View order history)
11. `wishlist.php` (View saved products)

### Admin Journey

1. `admin/login.php` (Login)
2. `admin/dashboard.php` (View dashboard)
3. Manage: `products.php`, `categories.php`, `orders.php`, `users.php`, `messages.php`

---

## 🚀 Quick Reference

### To Add a New Page
1. Create .php file in root directory
2. Include header, navbar, footer
3. Add content between them
4. Link from navbar.php

### To Add API Endpoint
1. Create .php file in api/ directory
2. Require db.php and functions.php
3. Set header('Content-Type: application/json')
4. Handle GET/POST actions
5. Echo JSON response

### To Add Database Table
1. Create table in database/delight_home.sql
2. Add function in includes/functions.php
3. Use in pages with queries

### To Modify Admin
1. Edit appropriate admin/*.php page
2. Update queries in functions.php if needed
3. Styling in css/style.css

---

## ✅ Implementation Status

**Completed:**
- ✅ All customer pages (15 files)
- ✅ Complete admin system (8 pages)
- ✅ All API endpoints (3 files)
- ✅ Database schema with sample data
- ✅ Responsive CSS styling
- ✅ JavaScript interactivity
- ✅ Documentation & guides

**Features:**
- ✅ Product browsing & filtering
- ✅ Shopping cart
- ✅ Wishlist
- ✅ Order management
- ✅ User accounts
- ✅ Admin dashboard
- ✅ Responsive design
- ✅ Security features

---

**Total Project Size: ~7100 lines of code + documentation**

**Status: COMPLETE & READY TO USE!** 🎉

# Delight Home - E-Commerce Website

A modern, responsive, and fully functional e-commerce website for a homeware and kitchenware brand built with PHP, MySQL, HTML5, CSS3, and JavaScript.

## Features

### Frontend Features
- **Responsive Design**: Mobile-first, fully responsive layout for desktop, tablet, and mobile
- **Modern UI/UX**: Clean, elegant design with neutral color palette (beige, cream, taupe, brown)
- **Smooth Animations**: Hover effects, transitions, and subtle animations throughout
- **Product Browsing**: Category browsing, product filtering, search, and sorting
- **Shopping Cart**: Add/remove items, update quantities, persistent cart
- **Wishlist**: Save favorite products for later
- **Product Details**: Detailed product information, related products, ratings
- **Checkout**: Multi-step checkout process with order summary
- **User Accounts**: Registration, login, logout, account dashboard
- **Contact Form**: Send messages directly to the store
- **Newsletter**: Email subscription

### Backend Features
- **PHP Sessions**: Cart management using sessions
- **MySQL Database**: Persistent data storage for products, users, orders, etc.
- **User Authentication**: Secure login and registration
- **Order Management**: Create, track, and manage orders
- **Admin Dashboard**: Complete admin panel to manage products, categories, orders, and users
- **API Endpoints**: RESTful API for AJAX operations (cart, wishlist)
- **Form Validation**: Server and client-side validation
- **Security**: SQL injection prevention, password hashing

### Admin Features
- Dashboard with statistics (total products, users, orders, sales)
- Product management (add, edit, delete)
- Category management
- Order management with status updates
- User management
- Contact message management
- Featured product management

## Project Structure

```
areesha/
├── index.php                 # Home page
├── about.php                 # About Us page
├── categories.php            # Categories page
├── products.php              # Shop/Products page with filtering
├── product-details.php       # Product details page
├── cart.php                  # Shopping cart
├── checkout.php              # Checkout process
├── contact.php               # Contact form
├── login.php                 # Login page
├── signup.php                # Registration page
├── logout.php                # Logout
├── order-success.php         # Order confirmation page
│
├── admin/
│   ├── index.php             # Admin redirect
│   ├── login.php             # Admin login
│   ├── dashboard.php         # Admin dashboard
│   ├── products.php          # Manage products
│   ├── categories.php        # Manage categories
│   ├── orders.php            # Manage orders
│   ├── users.php             # Manage users
│   └── messages.php          # Manage contact messages
│
├── api/
│   ├── cart.php              # Cart API (add, remove, update)
│   ├── wishlist.php          # Wishlist API
│   └── newsletter.php        # Newsletter subscription
│
├── includes/
│   ├── header.php            # HTML header
│   ├── navbar.php            # Navigation bar
│   ├── footer.php            # Footer
│   ├── db.php                # Database connection
│   └── functions.php         # Utility functions
│
├── css/
│   └── style.css             # Main stylesheet (responsive)
│
├── js/
│   └── script.js             # JavaScript functionality
│
├── images/                   # Product and category images
│
└── database/
    └── delight_home.sql      # Database schema and sample data
```

## Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP (includes Apache, PHP, MySQL)
- Web browser

### Installation Steps

1. **Start XAMPP/Apache and MySQL**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. **Import Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database or use existing
   - Import `database/delight_home.sql` file
   - The database will be created with tables and sample data

3. **Update Database Connection** (if needed)
   - Edit `includes/db.php`
   - Ensure database credentials match:
     ```php
     $db_host = 'localhost';
     $db_user = 'root';
     $db_pass = '';
     $db_name = 'delight_home';
     ```

4. **Access the Website**
   - Open browser and go to: `http://localhost/areesha/`
   - The website should load with the home page

5. **Access Admin Panel**
   - Go to: `http://localhost/areesha/admin/`
   - Login with:
     - **Email**: admin@delighthome.com
     - **Password**: admin123

## Usage

### For Customers

1. **Browse Products**
   - Click "Products" in navbar
   - Use filters (category, price range, search)
   - Sort by featured, newest, price

2. **Add to Cart**
   - Click "Add to Cart" on product card or view details
   - Choose quantity
   - Cart count updates in navbar

3. **Checkout**
   - Go to cart page
   - Click "Proceed to Checkout"
   - Fill shipping information
   - Select payment method
   - Complete order

4. **Create Account**
   - Click "Sign Up" 
   - Enter details and password
   - Automatic login after registration

### For Admins

1. **Dashboard**
   - View store statistics
   - See recent orders
   - Quick access to management sections

2. **Manage Products**
   - Add new products
   - Edit existing products
   - Delete products
   - Mark products as featured

3. **Manage Orders**
   - View all orders
   - Click order to see details
   - Update order status (Pending → Processing → Shipped → Delivered)

4. **Manage Messages**
   - View contact form submissions
   - Mark messages as read
   - Delete messages

## Design Features

### Color Palette
- Primary: Brown (#8b7355)
- Secondary: Taupe/Warm Gray (#a68070)
- Background: Off-white/Cream (#faf8f6)
- Text: Charcoal (#3a3a3a)
- Accents: Beige, Taupe

### Typography
- Modern sans-serif fonts (Segoe UI, system fonts)
- Clear hierarchy and readability
- Adequate spacing and whitespace

### Responsive Breakpoints
- Desktop: 1200px and above
- Tablet: 768px to 1199px
- Mobile: Below 768px

### Interactive Elements
- Smooth hover effects on products and buttons
- Dropdown menus for user account
- Mobile navigation toggle
- Smooth scroll behavior
- Hover zoom on product images

## Key Functionalities

### Cart System
- Add/remove items
- Update quantities
- Persistent across sessions (for logged-in users)
- Session-based storage for guests
- Automatic subtotal and total calculation
- Shipping cost calculation

### Product Filtering
- By category
- By price range
- By search keywords
- By rating (display only)
- Sorting options:
  - Featured (default)
  - Newest first
  - Price: Low to High
  - Price: High to Low

### Order Management
- Order creation with items
- Stock reduction on purchase
- Status tracking (5 statuses)
- Customer information storage
- Order history for users

### User System
- Registration with email verification (basic)
- Login/Logout
- Password hashing (bcrypt)
- User profile storage
- Order history tracking

### Admin Privileges
- Product CRUD operations
- Category management
- Order status updates
- User viewing
- Message management

## Security Considerations

- SQL injection prevention via parameterized queries
- Password hashing with bcrypt
- Session-based authentication
- HTML entity encoding for XSS prevention
- Input validation and sanitization

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements

- Payment gateway integration
- Email notifications
- Inventory management
- Product reviews and ratings
- Discount codes/coupons
- Wishlist sharing
- Social media integration
- Analytics dashboard
- Multi-language support
- Advanced search with faceted filters

## Notes

- This is a demonstration project
- Payment processing is simulated
- Images are referenced via URLs (ensure valid image paths)
- Database uses sample data
- Admin password for demo: use bcrypt($2y$10$...) format

## License

This project is created for educational and demonstration purposes.

## Support

For issues or questions, please contact:
- Email: info@delighthome.com
- Phone: +1 (800) 123-4567

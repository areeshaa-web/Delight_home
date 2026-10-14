# Installation & Configuration Checklist

## ✅ Pre-Installation Requirements
- [ ] XAMPP installed and running
- [ ] Apache web server started
- [ ] MySQL database service started
- [ ] phpMyAdmin accessible (http://localhost/phpmyadmin)
- [ ] Web browser (Chrome, Firefox, Edge, etc.)

---

## 🔧 INSTALLATION STEPS

### Step 1: Database Setup
```
1. Open http://localhost/phpmyadmin
2. Click "New" to create new database (optional)
3. Or select existing "delight_home" database
4. Go to "Import" tab
5. Choose file: database/delight_home.sql
6. Click "Go" to import
7. Verify tables created successfully (8 tables should appear)
```

### Step 2: Verify Database Connection
```
1. Navigate to http://localhost/areesha/
2. Should load home page without errors
3. If error, check includes/db.php credentials:
   - Host: localhost
   - User: root
   - Password: (usually blank)
   - Database: delight_home
```

### Step 3: Test Customer Features
```
[ ] Home page loads
[ ] Categories display
[ ] Product list shows (with filtering working)
[ ] Cart functionality works (add/remove items)
[ ] Wishlist toggle works
[ ] Contact form displays
[ ] Login/Signup pages accessible
[ ] Newsletter form appears
```

### Step 4: Test Admin Features
```
1. Go to http://localhost/areesha/admin/
2. Login with:
   - Email: admin@delighthome.com
   - Password: admin123
3. Test admin features:
   [ ] Dashboard displays stats
   [ ] Can view products
   [ ] Can add new product
   [ ] Can edit product
   [ ] Can delete product
   [ ] Can manage categories
   [ ] Can view orders
   [ ] Can view users
   [ ] Can view messages
```

---

## 🎨 CUSTOMIZATION GUIDE

### Change Brand Name
**File:** `includes/navbar.php` (line ~20)
```php
// Change from:
<i class="fas fa-home"></i> Delight Home

// To:
<i class="fas fa-home"></i> Your Brand Name
```

### Change Colors
**File:** `css/style.css` (lines 1-20)
```css
:root {
    --primary-bg: #faf8f6;      /* Background */
    --brown: #8b7355;            /* Primary color */
    --accent-brown: #a68070;     /* Accent color */
    /* ... edit other colors ... */
}
```

### Change Company Info
**File:** `includes/footer.php` (bottom section)
```php
// Update email, phone, address, hours
<!-- CONTACT INFO SECTION -->
```

### Update Welcome Text
**File:** `index.php` (hero section)
```php
// Change heading and subtitle
// Edit featured products display
```

---

## 📝 DATABASE CONFIGURATION

### Current Settings (includes/db.php)
```php
$db_host = 'localhost';    // Database host
$db_user = 'root';         // Database user
$db_pass = '';             // Database password
$db_name = 'delight_home'; // Database name
```

### To Change Database Credentials
1. Edit `includes/db.php`
2. Update variables above
3. Save file
4. Refresh website

### To Add New Database User
```sql
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON delight_home.* TO 'newuser'@'localhost';
FLUSH PRIVILEGES;
```

---

## 🚀 DEPLOYMENT PREPARATION

### Before Live Deployment
- [ ] Change admin password in database:
  ```sql
  UPDATE users SET password = PASSWORD_HASH('newpassword', PASSWORD_BCRYPT) 
  WHERE is_admin = 1;
  ```
- [ ] Update database credentials for production
- [ ] Add SSL certificate configuration
- [ ] Update company information
- [ ] Add real product images
- [ ] Set up email notifications
- [ ] Configure payment gateway (if using)
- [ ] Test all functionality on live server
- [ ] Set up database backups
- [ ] Configure error logging
- [ ] Review security settings

### Production Checklist
- [ ] PHP error display disabled
- [ ] Database credentials secured
- [ ] All test data removed
- [ ] SSL/HTTPS enabled
- [ ] Regular backups configured
- [ ] Security headers configured
- [ ] Rate limiting enabled
- [ ] Firewall rules configured
- [ ] Monitor logs regularly

---

## 🛠️ TROUBLESHOOTING

### Common Issues & Solutions

**Issue: "Access denied for user 'root'@'localhost'"**
- Solution: Check MySQL is running, verify password in db.php

**Issue: "The database doesn't exist"**
- Solution: Import database/delight_home.sql file

**Issue: "Images not displaying"**
- Solution: Add images to /images/ directory with proper names

**Issue: "Admin login not working"**
- Solution: Verify admin user exists in database, check password hash

**Issue: "Cart not saving between pages"**
- Solution: Ensure PHP sessions are enabled in php.ini

**Issue: "AJAX requests failing"**
- Solution: Check browser console for errors, verify API endpoint URLs

**Issue: "Product prices show as $0"**
- Solution: Check product prices in database, verify formatPrice function

**Issue: "Mobile menu not working"**
- Solution: Check js/script.js is loaded, verify CSS media queries

---

## 📊 PERFORMANCE OPTIMIZATION

### Database Optimization
```sql
-- Create indexes for faster queries
CREATE INDEX idx_category ON products(category_id);
CREATE INDEX idx_user ON cart(user_id);
CREATE INDEX idx_wishlist ON wishlist(user_id);
```

### Browser Cache
Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
</IfModule>
```

### CSS/JS Compression
- Use minified versions in production
- Enable GZIP compression

---

## 🔒 SECURITY HARDENING

### .htaccess Protection
```apache
# Prevent directory listing
Options -Indexes

# Enable mod_rewrite
RewriteEngine On

# Prevent access to sensitive files
<FilesMatch "\.(env|sql|json)$">
    Deny from all
</FilesMatch>
```

### PHP Configuration (php.ini)
```ini
; Disable dangerous functions
disable_functions = exec,passthru,shell_exec,system,proc_open

; Set session timeout
session.gc_maxlifetime = 3600

; Enable HTTPS redirect
# (requires SSL certificate)
```

### Update PHP Security Headers
Add to `includes/header.php`:
```php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
```

---

## 📈 MONITORING & MAINTENANCE

### Regular Tasks
- [ ] Check error logs weekly
- [ ] Monitor database size
- [ ] Review security logs
- [ ] Update PHP/MySQL versions
- [ ] Backup database daily
- [ ] Test backup restoration
- [ ] Monitor server performance
- [ ] Update dependencies

### Monthly Tasks
- [ ] Review user accounts
- [ ] Check disk space
- [ ] Update software patches
- [ ] Analyze traffic patterns
- [ ] Review admin logs
- [ ] Test disaster recovery

### Quarterly Tasks
- [ ] Security audit
- [ ] Performance review
- [ ] User feedback analysis
- [ ] Feature requests review
- [ ] Competitor analysis

---

## 📞 SUPPORT CONTACTS

**For Technical Issues:**
- PHP Documentation: https://www.php.net
- MySQL Documentation: https://dev.mysql.com
- XAMPP Support: https://www.apachefriends.org

**For Business:**
- Email: info@delighthome.com
- Phone: +1 (800) 123-4567

---

## 📋 QUICK REFERENCE

### Important Directories
```
c:\xampp\htdocs\areesha\
├── index.php (Start here)
├── includes/ (Core logic)
├── api/ (AJAX endpoints)
├── admin/ (Admin panel)
├── css/ (Styling)
├── js/ (Interactivity)
└── database/ (SQL schema)
```

### Key Files to Edit
1. `includes/footer.php` - Contact info
2. `includes/navbar.php` - Brand name
3. `css/style.css` - Colors/fonts
4. `index.php` - Welcome text
5. `about.php` - Company story

### Database Useful Commands
```sql
-- View all users
SELECT * FROM users;

-- Reset product stock
UPDATE products SET stock = 100;

-- View orders
SELECT * FROM orders ORDER BY created_at DESC;

-- Delete test data
DELETE FROM contact_messages;
```

---

## ✅ FINAL VERIFICATION

- [ ] Website loads at http://localhost/areesha/
- [ ] All pages accessible
- [ ] Admin panel works
- [ ] Shopping cart functions
- [ ] Database connected
- [ ] No console errors
- [ ] Responsive on mobile
- [ ] Forms submitting
- [ ] Images displaying
- [ ] Navigation working

---

**Installation & Configuration Complete!**

Your Delight Home e-commerce website is ready to use! 🎉

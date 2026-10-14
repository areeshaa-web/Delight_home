-- Delight Home E-commerce Database Schema
-- MySQL Database for homeware and kitchenware store

-- Create Database
CREATE DATABASE IF NOT EXISTS delight_home;
USE delight_home;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(50),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin INT DEFAULT 0
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    discount_price DECIMAL(10, 2),
    stock INT DEFAULT 0,
    rating DECIMAL(3, 2) DEFAULT 0,
    image_url VARCHAR(255),
    featured INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Cart Table
CREATE TABLE IF NOT EXISTS cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    session_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Wishlist Table
CREATE TABLE IF NOT EXISTS wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_cost DECIMAL(10, 2) DEFAULT 0,
    status ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Categories
INSERT INTO categories (name, description, image_url) VALUES
('Kitchenware', 'Essential kitchen tools and utensils', '/images/categories/kitchenware.jpg'),
('Cookware', 'High-quality pots, pans, and cooking sets', '/images/categories/cookware.jpg'),
('Dining & Tableware', 'Elegant dinnerware and table accessories', '/images/categories/dining.jpg'),
('Storage & Organization', 'Smart storage solutions for your kitchen', '/images/categories/storage.jpg'),
('Home Decor', 'Beautiful home decorative items', '/images/categories/decor.jpg'),
('Serving Essentials', 'Serving platters and utensils', '/images/categories/serving.jpg'),
('Bakeware', 'Professional baking tools and pans', '/images/categories/bakeware.jpg'),
('Kitchen Accessories', 'Small gadgets and accessories', '/images/categories/accessories.jpg'),
('Cleaning & Household Essentials', 'Cleaning supplies and household items', '/images/categories/cleaning.jpg');

-- Insert Sample Products
INSERT INTO products (category_id, name, description, price, discount_price, stock, rating, image_url, featured) VALUES
(1, 'Premium Knife Set', 'Professional chef knife set with ergonomic handles', 79.99, 59.99, 50, 4.8, '/images/products/knife-set.jpg', 1),
(2, 'Non-Stick Cookware Set', 'Complete cookware set with non-stick coating', 129.99, 99.99, 30, 4.6, '/images/products/cookware-set.jpg', 1),
(3, 'Ceramic Dinnerware Set', 'Beautiful ceramic dinner set for 6 people', 89.99, 74.99, 25, 4.7, '/images/products/dinnerware.jpg', 1),
(4, 'Pantry Storage Containers', 'Set of 5 airtight storage containers', 34.99, 24.99, 100, 4.5, '/images/products/storage.jpg', 1),
(5, 'Marble Serving Board', 'Elegant marble board for serving', 44.99, NULL, 40, 4.9, '/images/products/serving-board.jpg', 1),
(1, 'Wooden Spoon Set', 'Natural wooden utensil set', 19.99, 14.99, 150, 4.4, '/images/products/spoon-set.jpg', 0),
(2, 'Cast Iron Skillet', 'Traditional cast iron for perfect cooking', 34.99, 24.99, 45, 4.8, '/images/products/cast-iron.jpg', 0),
(3, 'Glass Serving Bowls', 'Set of 3 durable glass bowls', 29.99, 19.99, 60, 4.5, '/images/products/bowls.jpg', 0),
(6, 'Wine Glasses Set', 'Elegant crystal wine glass set for 6', 54.99, 44.99, 35, 4.7, '/images/products/wine-glasses.jpg', 0),
(7, 'Baking Pan Set', 'Non-stick baking pan collection', 39.99, 29.99, 80, 4.6, '/images/products/baking-pans.jpg', 0),
(4, 'Lazy Susan Organizer', 'Rotating organizer for easy access', 24.99, NULL, 55, 4.4, '/images/products/lazy-susan.jpg', 0),
(8, 'Electric Kettle', 'Fast heating electric kettle with temperature control', 49.99, 39.99, 70, 4.7, '/images/products/kettle.jpg', 0),
(9, 'Microfiber Cleaning Cloth', 'Pack of 10 microfiber cleaning cloths', 12.99, 9.99, 200, 4.3, '/images/products/cleaning-cloth.jpg', 0),
(1, 'Cutting Board Set', 'Bamboo cutting board set with multiple sizes', 27.99, 19.99, 90, 4.6, '/images/products/cutting-board.jpg', 0),
(5, 'Table Runners', 'Premium fabric table runners', 18.99, 14.99, 120, 4.5, '/images/products/table-runner.jpg', 0);

-- Insert Sample Admin User
-- Password: admin123
INSERT INTO users (name, email, password, phone, is_admin) VALUES
('Admin', 'admin@delighthome.com', '$2y$10$xXcjHR1U7Jz8VxCyD7xV0.7V8c7f5s5u5m5k5q5r5t5v5w5y5z5x', '1234567890', 1);

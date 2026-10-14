<?php
// Utility Functions for Delight Home

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Format price
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// Get current user
function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        global $conn;
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
        return $result->fetch_assoc();
    }
    return null;
}

// Check if user is logged in
function isLoggedIn() {
    global $conn;

    if (empty($_SESSION['user_id'])) {
        return false;
    }

    $user_id = intval($_SESSION['user_id']);

    $result = $conn->query("
        SELECT id
        FROM users
        WHERE id = $user_id
        LIMIT 1
    ");

    if ($result && $result->num_rows === 1) {
        return true;
    }

    // Invalid/stale user session: use guest cart instead.
    unset($_SESSION['user_id'], $_SESSION['is_admin']);

    return false;
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

// Get cart count
function getCartCount() {
    global $conn;

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
    } else {
        $session_id = session_id();
        $result = $conn->query("SELECT SUM(quantity) as total FROM cart WHERE session_id = '$session_id'");
    }

    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

// Get cart items
function getCartItems() {
    global $conn;

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT c.*, p.name, p.price, p.discount_price, p.image_url
                  FROM cart c
                  JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = $user_id
                  ORDER BY c.created_at DESC";
    } else {
        $session_id = session_id();
        $query = "SELECT c.*, p.name, p.price, p.discount_price, p.image_url
                  FROM cart c
                  JOIN products p ON c.product_id = p.id
                  WHERE c.session_id = '$session_id'
                  ORDER BY c.created_at DESC";
    }

    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Get cart total
function getCartTotal() {
    global $conn;
    $items = getCartItems();
    $total = 0;

    foreach ($items as $item) {
        $price = $item['discount_price'] ?? $item['price'];
        $total += $price * $item['quantity'];
    }

    return $total;
}

// Add to cart
function addToCart($product_id, $quantity = 1) {
    global $conn;

    $product_id = intval($product_id);
    $quantity = intval($quantity);

    // Check if product exists
    $result = $conn->query("SELECT id FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();

    if (!$product) {
        return false;
    }

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];

        // Check if product already in cart
        $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");

        if ($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_qty = $row['quantity'] + $quantity;
            $conn->query("UPDATE cart SET quantity = $new_qty WHERE id = {$row['id']}");
        } else {
            $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)");
        }
    } else {
        $session_id = session_id();

        // Check if product already in cart
        $check = $conn->query("SELECT id, quantity FROM cart WHERE session_id = '$session_id' AND product_id = $product_id");

        if ($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_qty = $row['quantity'] + $quantity;
            $conn->query("UPDATE cart SET quantity = $new_qty WHERE id = {$row['id']}");
        } else {
            $conn->query("INSERT INTO cart (session_id, product_id, quantity) VALUES ('$session_id', $product_id, $quantity)");
        }
    }

    return true;
}

// Remove from cart
function removeFromCart($cart_id) {
    global $conn;
    $cart_id = intval($cart_id);

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $conn->query("DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
    } else {
        $session_id = session_id();
        $conn->query("DELETE FROM cart WHERE id = $cart_id AND session_id = '$session_id'");
    }
}

// Update cart quantity
function updateCartQuantity($cart_id, $quantity) {
    global $conn;
    $cart_id = intval($cart_id);
    $quantity = intval($quantity);

    if ($quantity <= 0) {
        removeFromCart($cart_id);
        return;
    }

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $conn->query("UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id");
    } else {
        $session_id = session_id();
        $conn->query("UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND session_id = '$session_id'");
    }
}

// Clear cart
function clearCart() {
    global $conn;

    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
    } else {
        $session_id = session_id();
        $conn->query("DELETE FROM cart WHERE session_id = '$session_id'");
    }
}

// Get products
function getProducts($category_id = null, $search = null, $sort = 'featured', $price_min = 0, $price_max = 999999, $limit = 12, $offset = 0) {
    global $conn;

    $query = "SELECT * FROM products WHERE 1=1";

    if ($category_id) {
        $category_id = intval($category_id);
        $query .= " AND category_id = $category_id";
    }

    if ($search) {
        $search = $conn->real_escape_string(sanitize($search));
        $query .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
    }

    $price_min = floatval($price_min);
    $price_max = floatval($price_max);
    $query .= " AND (discount_price IS NOT NULL AND discount_price BETWEEN $price_min AND $price_max OR discount_price IS NULL AND price BETWEEN $price_min AND $price_max)";

    // Sorting
    switch ($sort) {
        case 'newest':
            $query .= " ORDER BY created_at DESC";
            break;
        case 'price_low':
            $query .= " ORDER BY COALESCE(discount_price, price) ASC";
            break;
        case 'price_high':
            $query .= " ORDER BY COALESCE(discount_price, price) DESC";
            break;
        case 'featured':
        default:
            $query .= " ORDER BY created_at DESC";
    }

    $query .= " LIMIT $offset, $limit";

    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Get total products count
function getProductsCount($category_id = null, $search = null, $price_min = 0, $price_max = 999999) {
    global $conn;

    $query = "SELECT COUNT(*) as total FROM products WHERE 1=1";

    if ($category_id) {
        $category_id = intval($category_id);
        $query .= " AND category_id = $category_id";
    }

    if ($search) {
        $search = $conn->real_escape_string(sanitize($search));
        $query .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
    }

    $price_min = floatval($price_min);
    $price_max = floatval($price_max);
    $query .= " AND (discount_price IS NOT NULL AND discount_price BETWEEN $price_min AND $price_max OR discount_price IS NULL AND price BETWEEN $price_min AND $price_max)";

    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

// Get single product
function getProduct($id) {
    global $conn;
    $id = intval($id);
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    return $result->fetch_assoc();
}

// Get categories
function getCategories() {
    global $conn;
    return $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
}

// Get single category
function getCategory($id) {
    global $conn;
    $id = intval($id);
    $result = $conn->query("SELECT * FROM categories WHERE id = $id");
    return $result->fetch_assoc();
}

// Get related products
function getRelatedProducts($product_id, $category_id, $limit = 4) {
    global $conn;
    $product_id = intval($product_id);
    $category_id = intval($category_id);

    return $conn->query("SELECT * FROM products WHERE category_id = $category_id AND id != $product_id LIMIT $limit")->fetch_all(MYSQLI_ASSOC);
}

// Add to wishlist
function addToWishlist($product_id) {
    global $conn;

    if (!isLoggedIn()) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($product_id);

    $result = $conn->query("SELECT id FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");

    if ($result->num_rows == 0) {
        $conn->query("INSERT INTO wishlist (user_id, product_id) VALUES ($user_id, $product_id)");
        return true;
    }

    return false;
}

// Remove from wishlist
function removeFromWishlist($product_id) {
    global $conn;

    if (!isLoggedIn()) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($product_id);

    $conn->query("DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    return true;
}

// Check if in wishlist
function isInWishlist($product_id) {
    global $conn;

    if (!isLoggedIn()) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($product_id);

    $result = $conn->query("SELECT id FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    return $result->num_rows > 0;
}

// Create order
function createOrder($user_id, $total_amount, $payment_method = 'Credit Card') {
    global $conn;

    $user_id = intval($user_id);
    $total_amount = floatval($total_amount);
    $payment_method = $conn->real_escape_string($payment_method);

    $conn->query("INSERT INTO orders (user_id, total_amount, payment_method) VALUES ($user_id, $total_amount, '$payment_method')");

    $order_id = $conn->insert_id;

    // Get cart items and add to order_items
    $cart_items = getCartItems();

    foreach ($cart_items as $item) {
        $product_id = intval($item['product_id']);
        $quantity = intval($item['quantity']);
        $price = floatval($item['discount_price'] ?? $item['price']);

        $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)");
    }

    // Clear cart
    clearCart();

    return $order_id;
}

// Get order details
function getOrder($order_id) {
    global $conn;

    $order_id = intval($order_id);
    $result = $conn->query("SELECT * FROM orders WHERE id = $order_id");
    return $result->fetch_assoc();
}

// Get order items
function getOrderItems($order_id) {
    global $conn;

    $order_id = intval($order_id);
    return $conn->query("SELECT oi.*, p.name, p.image_url FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id")->fetch_all(MYSQLI_ASSOC);
}

// Get user orders
function getUserOrders($user_id) {
    global $conn;

    $user_id = intval($user_id);
    return $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
}

// Validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Get discount percentage
function getDiscountPercentage($original_price, $discount_price) {
    if (!$discount_price) {
        return 0;
    }

    return round((($original_price - $discount_price) / $original_price) * 100);
}

// Get product image URL
function getProductImageUrl($product, $is_admin = false) {
    $prefix = $is_admin ? '../' : '';

    if (is_array($product)) {
        if (!empty($product['image_url'])) {
            $img = $product['image_url'];

            if (strpos($img, '/') === 0) {
                $img = substr($img, 1);
            }

            return $prefix . $img;
        }

        if (!empty($product['id'])) {
            return $prefix . 'images/products/' . $product['id'] . '.jpg';
        }
    }

    return $prefix . 'images/placeholder.jpg';
}

// Get category image URL
function getCategoryImageUrl($category, $is_admin = false) {
    $prefix = $is_admin ? '../' : '';

    if (is_array($category)) {
        if (!empty($category['image_url'])) {
            $img = ltrim($category['image_url'], '/');

            if (file_exists(__DIR__ . '/../' . $img)) {
                return $prefix . $img;
            }
        }

        if (!empty($category['name'])) {
            $slug = strtolower(str_replace(' & ', '-', str_replace(' ', '-', $category['name'])));
            $slug_file = 'images/categories/' . $slug . '.jpg';

            if (file_exists(__DIR__ . '/../' . $slug_file)) {
                return $prefix . $slug_file;
            }
        }
    }

    return $prefix . 'images/placeholder.jpg';
}
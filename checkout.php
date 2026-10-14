<?php
$page_title = "Checkout - Delight Home";

require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php?redirect=checkout.php&msg=login_required');
    exit;
}

$cart_items = getCartItems();
$cart_total = getCartTotal();

if (count($cart_items) === 0) {
    header('Location: cart.php');
    exit;
}

$shipping_cost = 10;
$grand_total = $cart_total + $shipping_cost;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $city = sanitize($_POST['city'] ?? '');
    $payment_method = sanitize($_POST['payment_method'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($payment_method)) {
        $error = 'Please fill in all required fields.';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        $user_id = $_SESSION['user_id'];
        
        $name_escaped = $conn->real_escape_string($name);
        $phone_escaped = $conn->real_escape_string($phone);
        $address_escaped = $conn->real_escape_string($address);
        $city_escaped = $conn->real_escape_string($city);

        // Update user profile in database
        $conn->query("UPDATE users SET name = '$name_escaped', phone = '$phone_escaped', address = '$address_escaped', city = '$city_escaped' WHERE id = $user_id");

        // Save order to database linked to user_id
        $order_id = createOrder($user_id, $grand_total, $payment_method);
        $_SESSION['order_id'] = $order_id;
        header('Location: order-success.php?order_id=' . $order_id);
        exit;
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">Checkout</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <span><?php echo htmlspecialchars($error); ?></span></div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem;">
            <form method="POST" class="card" style="padding: 2rem;">
                <h2 style="margin-bottom: 2rem; font-size: 1.5rem;">Shipping Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-input" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : (isLoggedIn() ? htmlspecialchars(getCurrentUser()['name']) : ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : (isLoggedIn() ? htmlspecialchars(getCurrentUser()['email']) : ''); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="tel" name="phone" class="form-input" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : (isLoggedIn() ? htmlspecialchars(getCurrentUser()['phone']) : ''); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Address *</label>
                    <input type="text" name="address" class="form-input" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : (isLoggedIn() ? htmlspecialchars(getCurrentUser()['address']) : ''); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input type="text" name="city" class="form-input" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : (isLoggedIn() ? htmlspecialchars(getCurrentUser()['city']) : ''); ?>" required>
                    </div>
                </div>

                <h2 style="margin-bottom: 1.5rem; margin-top: 2rem; font-size: 1.5rem;">Payment Method</h2>
                <div class="form-group">
                    <label class="form-label">Select Payment Method *</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="">-- Select Method --</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>

                <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> This is a demo checkout. Actual payment processing would be handled securely.
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 1rem 2rem;"><i class="fas fa-lock"></i> Complete Order</button>
                <a href="cart.php" class="btn btn-secondary" style="width: 100%; text-align: center; margin-top: 1rem;">Back to Cart</a>
            </form>

            <div>
                <div class="cart-summary">
                    <h3 style="margin-bottom: 1.5rem; font-size: 1.3rem;">Order Summary</h3>
                    <div style="max-height: 300px; overflow-y: auto; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                        <?php foreach ($cart_items as $item): ?>
                            <?php $price = !empty($item['discount_price']) ? $item['discount_price'] : $item['price']; ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 0.95rem;">
                                <div><strong><?php echo htmlspecialchars($item['name']); ?></strong><br><span style="color: var(--text-lighter);">Qty: <?php echo intval($item['quantity']); ?></span></div>
                                <span><?php echo formatPrice($price * $item['quantity']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="summary-row"><span>Subtotal:</span><span><?php echo formatPrice($cart_total); ?></span></div>
                    <div class="summary-row"><span>Shipping:</span><span><?php echo formatPrice($shipping_cost); ?></span></div>
                    <div class="summary-row total"><span>Total:</span><span><?php echo formatPrice($grand_total); ?></span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

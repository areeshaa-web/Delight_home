<?php
$page_title = "Order Confirmation - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if (!$order_id || !isset($_SESSION['order_id'])) {
    header('Location: /');
    exit;
}

$order = getOrder($order_id);
if (!$order) {
    header('Location: /');
    exit;
}

$order_items = getOrderItems($order_id);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Success Section -->
<section class="section">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; text-align: center;">
            
            <div style="background-color: var(--secondary-bg); padding: 3rem; border-radius: 12px; margin-bottom: 2rem;">
                <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--brown); margin-bottom: 1rem;"></i>
                <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">Order Confirmed!</h1>
                <p style="font-size: 1.1rem; color: var(--text-light); margin-bottom: 0.5rem;">Thank you for your purchase</p>
                <p style="color: var(--text-lighter);">Your order has been successfully placed</p>
            </div>
            
            <div class="card" style="padding: 2rem; text-align: left; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">Order Details</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-light);">Order Number:</span>
                    <strong>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-light);">Order Date:</span>
                    <strong><?php echo date('F d, Y', strtotime($order['created_at'])); ?></strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-light);">Status:</span>
                    <strong style="color: var(--brown);"><?php echo $order['status']; ?></strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 0; padding-bottom: 0;">
                    <span style="color: var(--text-light);">Payment Method:</span>
                    <strong><?php echo $order['payment_method']; ?></strong>
                </div>
            </div>
            
            <div class="card" style="padding: 2rem; text-align: left; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">Items Ordered</h3>
                
                <?php foreach ($order_items as $item): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <div style="flex: 1;">
                            <strong><?php echo $item['name']; ?></strong><br>
                            <span style="color: var(--text-lighter); font-size: 0.9rem;">Quantity: <?php echo $item['quantity']; ?> × <?php echo formatPrice($item['price']); ?></span>
                        </div>
                        <strong><?php echo formatPrice($item['price'] * $item['quantity']); ?></strong>
                    </div>
                <?php endforeach; ?>
                
                <div style="display: flex; justify-content: space-between; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <span style="font-weight: 600;">Total Amount:</span>
                    <span style="font-size: 1.3rem; font-weight: 700; color: var(--brown);"><?php echo formatPrice($order['total_amount']); ?></span>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-envelope"></i>
                <span>A confirmation email has been sent to your email address</span>
            </div>
            
            <div style="display: flex; gap: 1rem; flex-direction: column;">
              <a href="products.php" class="btn">Continue Shopping</a>

<a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

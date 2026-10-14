<?php
$page_title = "My Orders - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$orders = getUserOrders($user_id);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">My Orders</h1>
    </div>
</section>

<!-- Orders Content -->
<section class="section">
    <div class="container">
        <?php if (count($orders) > 0): ?>
            <div class="grid grid-1">
                <?php foreach ($orders as $order):
                    $order_items = getOrderItems($order['id']);
                    $status_class = 'status-' . strtolower($order['status']);
                ?>
                <div class="card" style="padding: 2rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                        <div>
                            <h3 style="margin: 0; color: var(--brown);">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h3>
                            <p style="margin: 0.5rem 0 0 0; color: var(--text-light); font-size: 0.9rem;">
                                Placed on <?php echo date('F d, Y', strtotime($order['created_at'])); ?>
                            </p>
                        </div>
                        <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; background-color: var(--secondary-bg); font-size: 0.9rem; font-weight: 600; color: var(--text-dark);">
                            <?php echo $order['status']; ?>
                        </span>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <h4 style="margin-bottom: 0.75rem; color: var(--text-dark);">Items:</h4>
                        <?php foreach ($order_items as $item): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                            <div>
                                <strong><?php echo $item['name']; ?></strong><br>
                                <span style="color: var(--text-lighter); font-size: 0.85rem;">Qty: <?php echo $item['quantity']; ?></span>
                            </div>
                            <div style="text-align: right;">
                                <div><?php echo formatPrice($item['price']); ?> each</div>
                                <strong><?php echo formatPrice($item['price'] * $item['quantity']); ?></strong>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="text-align: right; padding-top: 1rem; border-top: 2px solid var(--border-color);">
                        <h4 style="margin: 0.75rem 0 0 0; color: var(--brown);">
                            Total: <?php echo formatPrice($order['total_amount']); ?>
                        </h4>
                    </div>
                 <a href="/areeshaaaa/areesha/order-success.php?order_id=<?php echo $order['id']; ?>" 
   class="btn btn-secondary btn-small" 
   style="margin-top: 1rem;">
   View Details
</a>



                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-shopping-bag empty-state-icon"></i>
                <h3 class="empty-state-title">No Orders Yet</h3>
                <p class="empty-state-text">Start shopping to place your first order</p>
                <a href="/products.php" class="btn">Shop Now</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

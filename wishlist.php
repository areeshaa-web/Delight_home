<?php
$page_title = "My Wishlist - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php?redirect=wishlist.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$wishlist_items = $conn->query("SELECT p.* FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = $user_id ORDER BY w.created_at DESC")->fetch_all(MYSQLI_ASSOC);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 0.5rem;"><i class="fas fa-heart" style="color: #e74c3c;"></i> My Wishlist</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Saved items you love</p>
    </div>
</section>

<!-- Wishlist Content -->
<section class="section">
    <div class="container">
        <?php if (count($wishlist_items) > 0): ?>
            <div class="grid grid-4" id="wishlistGrid">
                <?php foreach ($wishlist_items as $product):
                    $discount_percent = getDiscountPercentage($product['price'], $product['discount_price']);
                    $final_price = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];
                ?>
                <div class="card product-card" id="wishlist-item-<?php echo $product['id']; ?>">
                    <?php if ($discount_percent > 0): ?>
                        <div class="product-badge">-<?php echo $discount_percent; ?>%</div>
                    <?php endif; ?>
                    
                    <button class="product-wishlist active" data-product-id="<?php echo $product['id']; ?>" title="Remove from wishlist" style="color: #e74c3c;">
                        <i class="fas fa-heart"></i>
                    </button>
                    
                    <div class="card-image">
                        <img src="<?php echo getProductImageUrl($product); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null; this.src='images/placeholder.jpg'">
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="card-description"><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...</p>
                        
                        <div class="product-rating">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <span class="star <?php echo $i < round($product['rating']) ? 'fas' : 'far'; ?> fa-star"></span>
                            <?php endfor; ?>
                            <span class="rating-value">(<?php echo round($product['rating'], 1); ?>)</span>
                        </div>
                        
                        <div class="card-footer">
                            <div>
                                <?php if ($product['discount_price']): ?>
                                    <span class="product-original-price"><?php echo formatPrice($product['price']); ?></span>
                                    <span class="product-price"><?php echo formatPrice($product['discount_price']); ?></span>
                                <?php else: ?>
                                    <span class="product-price"><?php echo formatPrice($product['price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="product-actions" style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 1rem;">
                            <form class="add-to-cart-form" data-product-id="<?php echo $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-small" style="width: 100%;"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                            
                            <button type="button" class="btn btn-small order-from-wishlist-btn" data-product-id="<?php echo $product['id']; ?>" style="width: 100%; background-color: var(--brown); color: white;">
                                <i class="fas fa-bolt"></i> Order Now
                            </button>
                        </div>
                        
                        <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary btn-small" style="width: 100%; text-align: center; margin-top: 0.5rem;">View Details</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
                <i class="fas fa-heart empty-state-icon" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>
                <h3 class="empty-state-title" style="font-size: 1.8rem; color: var(--brown);">Your Wishlist is Empty</h3>
                <p class="empty-state-text" style="color: var(--text-light); margin-bottom: 2rem;">Explore our store and save your favorite items for later!</p>
                <a href="products.php" class="btn"><i class="fas fa-store"></i> Explore Products</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Order directly from wishlist button
    document.querySelectorAll('.order-from-wishlist-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', productId);
            formData.append('quantity', 1);

            fetch('api/cart.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'checkout.php';
                    } else {
                        alert(data.message || 'Unable to proceed to checkout.');
                    }
                })
                .catch(err => console.error(err));
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>

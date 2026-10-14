<?php
$page_title = "Home - Delight Home | Premium Homeware & Kitchenware";
require_once 'includes/db.php';
require_once 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Hero Slider -->
<section class="hero dh-hero dh-hero-split" aria-label="Welcome to Delight Home">
    <div class="dh-hero-copy">
        <span class="dh-eyebrow">Welcome to Delight Home</span>
        <h1>Beautiful Essentials for Every Home</h1>
        <p>Discover premium kitchenware and accessories designed to make everyday living more beautiful.</p>
        <div class="dh-hero-actions">
            <a href="products.php" class="btn dh-hero-cta">
                <span>Shop Collection</span><i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="categories.php" class="btn btn-secondary dh-hero-secondary">
                <span>Explore Kitchenware</span>
            </a>
        </div>
    </div>

    <div class="dh-hero-slider" aria-label="Featured homeware imagery">
        <div class="dh-hero-slides">
        <article class="dh-hero-slide is-active" data-hero-slide aria-hidden="false">
            <img src="images/home1.jpg" alt="Warm, elegant homeware in a welcoming home"
                 onerror="this.onerror=null; this.src='images/home1.jpg'">
        </article>
        <article class="dh-hero-slide" data-hero-slide aria-hidden="true">
            <img src="images/home2.jpg" alt="Beautifully arranged kitchen essentials"
                 onerror="this.onerror=null; this.src='images/home2.jpg'">
        </article>
        <article class="dh-hero-slide" data-hero-slide aria-hidden="true">
            <img src="images/home3.jpg" alt="Premium kitchenware for everyday cooking"
                 onerror="this.onerror=null; this.src='images/home3.jpg'">
        </article>
        </div>
        <div class="dh-hero-shade" aria-hidden="true"></div>
        <button class="dh-hero-arrow dh-hero-previous" type="button" aria-label="Previous image">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
        </button>
        <button class="dh-hero-arrow dh-hero-next" type="button" aria-label="Next image">
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </button>
        <div class="dh-hero-dots" role="group" aria-label="Choose a featured image">
            <button class="dh-hero-dot is-active" type="button" aria-label="Show image 1" aria-current="true"></button>
            <button class="dh-hero-dot" type="button" aria-label="Show image 2"></button>
            <button class="dh-hero-dot" type="button" aria-label="Show image 3"></button>
        </div>
    </div>
</section>



<!-- Featured Categories Section -->
<section class="section dh-categories-section">
    <div class="container">
        <span class="dh-section-kicker">Find your favorites</span>
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-subtitle">Explore our premium collection of homeware and kitchenware</p>
        
        <div class="categories-grid">
            <?php
            $categories = getCategories();
            foreach ($categories as $category):
                $category_name = strtolower(trim($category['name']));
                if ($category_name !== 'kitchenware' && $category_name !== 'kitchen accessories') {
                    continue;
                }
            ?>
            <a href="products.php?category=<?php echo $category['id']; ?>" class="category-card dh-category-card">
                <img src="<?php echo getCategoryImageUrl($category); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" onerror="this.onerror=null; this.src='images/placeholder.jpg'">
                <div class="category-overlay">
                    <h3 class="category-name"><?php echo $category['name']; ?></h3>
                    <button class="btn btn-small">Explore Category</button>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section dh-featured-section" id="featured">
    <div class="container">
        <span class="dh-section-kicker">Selected for you</span>
        <h2 class="section-title">Made for Your Everyday</h2>
        <p class="section-subtitle">Customer favorites, thoughtfully chosen for the heart of your home.</p>
        
        <div class="grid grid-4 dh-featured-grid">
            <?php
            $featured_products = getProducts(null, null, 'featured', 0, 999999, 8);
            foreach ($featured_products as $product):
                $discount_percent = getDiscountPercentage($product['price'], $product['discount_price']);
            ?>
            <div class="card product-card dh-product-card dh-product-tile">
                <a class="dh-product-hit-area" href="product-details.php?id=<?php echo (int) $product['id']; ?>" aria-label="View <?php echo htmlspecialchars($product['name']); ?>"></a>
                <?php if ($discount_percent > 0): ?>
                    <div class="product-badge">-<?php echo $discount_percent; ?>%</div>
                <?php endif; ?>
                
                <?php $in_wishlist = isInWishlist($product['id']); ?>
                <button type="button" class="product-wishlist <?php echo $in_wishlist ? 'active' : ''; ?>" data-product-id="<?php echo $product['id']; ?>" title="Wishlist" aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to wishlist">
                    <i class="<?php echo $in_wishlist ? 'fas' : 'far'; ?> fa-heart" <?php echo $in_wishlist ? 'style="color: #e74c3c;"' : ''; ?>></i>
                </button>
                <form class="add-to-cart-form dh-card-cart-form" data-product-id="<?php echo (int) $product['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="dh-card-cart-action" title="Add to Cart" aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to cart">
                        <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                    </button>
                </form>
                
                <div class="card-image">
                    <img src="<?php echo getProductImageUrl($product); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null; this.src='images/placeholder.jpg'">
                </div>
                
                <div class="card-content">
                    <h3 class="card-title"><?php echo $product['name']; ?></h3>
                    <p class="card-description"><?php echo substr($product['description'], 0, 50); ?>...</p>
                    
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
                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Brand Story -->
<section class="section dh-story-section">
    <div class="container">
        <div class="dh-story">
            <div class="dh-story-image">
                <img src="images/kitchen.jpg" alt="A calm, carefully styled kitchen at home"
                     onerror="this.onerror=null; this.src='images/placeholder.jpg'">
            </div>
            <div class="dh-story-copy">
                <span class="dh-section-kicker">A little more delight</span>
                <h2>Beautiful things for everyday living.</h2>
                <p>Delight Home brings together practical kitchenware and considered home essentials to make daily rituals feel a little more special.</p>
                <a href="about.php" class="dh-text-link">Get to know us <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Promotional Banner -->
<section class="section dh-promo-section">
    <div class="container">
        <div class="dh-promo">
            <div class="dh-promo-copy">
                <span class="dh-eyebrow">Small details. A better everyday.</span>
                <h2>Upgrade Your Kitchen</h2>
                <p>Discover practical essentials designed to make everyday cooking better.</p>
                <a href="products.php" class="btn dh-promo-button">Shop Now <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="dh-promo-mark" aria-hidden="true"><i class="fas fa-leaf"></i></div>
        </div>
    </div>
</section>

<!-- Why Choose Delight Home -->
<section class="section dh-benefits-section">
    <div class="container">
        <span class="dh-section-kicker">The Delight Home difference</span>
        <h2 class="section-title">Thoughtful in every detail</h2>
        <div class="dh-benefits">
            <article class="dh-benefit">
                <span class="dh-benefit-icon"><i class="fas fa-gem" aria-hidden="true"></i></span>
                <h3>Premium Quality</h3>
                <p>Beautifully selected essentials made to be part of your everyday.</p>
            </article>
            <article class="dh-benefit">
                <span class="dh-benefit-icon"><i class="fas fa-truck" aria-hidden="true"></i></span>
                <h3>Fast Delivery</h3>
                <p>We make it simple to get your home favorites delivered to your door.</p>
            </article>
            <article class="dh-benefit">
                <span class="dh-benefit-icon"><i class="fas fa-shield-alt" aria-hidden="true"></i></span>
                <h3>Secure Shopping</h3>
                <p>Shop with confidence through our secure checkout experience.</p>
            </article>
            <article class="dh-benefit">
                <span class="dh-benefit-icon"><i class="fas fa-comment-dots" aria-hidden="true"></i></span>
                <h3>Customer Support</h3>
                <p>Our team is here to help with questions about your order or our collection.</p>
            </article>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

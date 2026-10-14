<?php
$page_title = "Categories - Delight Home";

require_once 'includes/db.php';
require_once 'includes/functions.php';

include 'includes/header.php';
include 'includes/navbar.php';

$base_url = '';
?>

<!-- Page Header -->
<section class="dh-category-page-hero">
    <div class="container">
        <span class="dh-section-kicker">Find your favorites</span>
        <h1>Shop by Category</h1>
        <p>
            Explore our premium collection of homeware and kitchenware
        </p>
    </div>
</section>

<!-- Categories Grid -->
<section class="section dh-category-page-grid">
    <div class="container">
        <div class="categories-grid">

            <?php
            $categories = getCategories();

            foreach ($categories as $category):
                $category_image = strtolower(
                    str_replace(
                        ' & ',
                        '-',
                        str_replace(' ', '-', $category['name'])
                    )
                );
            ?>
<div class="category-card dh-category-page-card">

    <img
        src="<?php echo getCategoryImageUrl($category); ?>"
        alt="<?php echo htmlspecialchars($category['name']); ?>"
        onerror="this.onerror=null; this.src='images/placeholder.jpg'"
    >

    <div class="category-overlay">
        <h3 class="category-name">
            <?php echo htmlspecialchars($category['name']); ?>
        </h3>

        <p style="color: white; margin-bottom: 1rem; font-size: 0.9rem;">
            <?php echo htmlspecialchars($category['description']); ?>
        </p>

        <button
            type="button"
            class="btn btn-small"
           onclick="window.location.href='products.php?category=<?php echo intval($category['id']); ?>'"
        >
            Explore Category
        </button>
    </div>

</div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- Category Highlights -->
<section class="section dh-category-products">
    <div class="container">
        <h2 class="section-title">Featured Category Products</h2>

        <div class="grid grid-4">

            <?php
            $products = getProducts(null, null, 'featured', 0, 999999, 8);

            foreach ($products as $product):
                $discount_percent = getDiscountPercentage(
                    $product['price'],
                    $product['discount_price']
                );
                $in_wishlist = isInWishlist($product['id']);

                $product_image = !empty($product['image'])
                    ? $product['image']
                    : $product['id'] . '.jpg';
            ?>

                <div class="card product-card dh-product-tile">
                    <a class="dh-product-hit-area" href="product-details.php?id=<?php echo (int) $product['id']; ?>" aria-label="View <?php echo htmlspecialchars($product['name']); ?>"></a>

                    <?php if ($discount_percent > 0): ?>
                        <div class="product-badge">
                            -<?php echo $discount_percent; ?>%
                        </div>
                    <?php endif; ?>

                    <button
                        type="button"
                        class="product-wishlist <?php echo $in_wishlist ? 'active' : ''; ?>"
                        data-product-id="<?php echo intval($product['id']); ?>"
                        title="Wishlist"
                        aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to wishlist"
                    >
                        <i class="<?php echo $in_wishlist ? 'fas' : 'far'; ?> fa-heart"></i>
                    </button>
                    <form class="add-to-cart-form dh-card-cart-form" data-product-id="<?php echo (int) $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="dh-card-cart-action" title="Add to Cart" aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to cart">
                            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div class="card-image">
                        <img
                            src="<?php echo getProductImageUrl($product); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                            onerror="this.onerror=null; this.src='images/placeholder.jpg'"
                        >
                    </div>

                    <div class="card-content">
                        <h3 class="card-title">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>

                        <p class="card-description">
                            <?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...
                        </p>

                        <div class="card-footer">
                            <div>
                                <?php if (!empty($product['discount_price'])): ?>
                                    <span class="product-original-price">
                                        <?php echo formatPrice($product['price']); ?>
                                    </span>

                                    <span class="product-price">
                                        <?php echo formatPrice($product['discount_price']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="product-price">
                                        <?php echo formatPrice($product['price']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php

// Database connection
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Shop - Delight Home";

include 'includes/header.php';
include 'includes/navbar.php';


// ==========================================
// GET FILTER PARAMETERS
// ==========================================

$category_id = isset($_GET['category'])
    ? intval($_GET['category'])
    : null;

$search = isset($_GET['search'])
    ? sanitize($_GET['search'])
    : null;

$sort = isset($_GET['sort'])
    ? $_GET['sort']
    : 'featured';

$price_min = isset($_GET['price_min'])
    ? floatval($_GET['price_min'])
    : 0;

$price_max = isset($_GET['price_max'])
    ? floatval($_GET['price_max'])
    : 999999;


// ==========================================
// PAGINATION
// ==========================================

$limit = 12;

$page = isset($_GET['page'])
    ? intval($_GET['page'])
    : 1;

// Prevent invalid page numbers
if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;


// ==========================================
// GET TOTAL PRODUCTS
// ==========================================

$total_products = getProductsCount(
    $category_id,
    $search,
    $price_min,
    $price_max
);

$total_pages = ceil($total_products / $limit);


// ==========================================
// GET PRODUCTS
// ==========================================

$products = getProducts(
    $category_id,
    $search,
    $sort,
    $price_min,
    $price_max,
    $limit,
    $offset
);


// ==========================================
// GET CATEGORIES
// ==========================================

$categories = getCategories();

?>



<!-- ==========================================
     PAGE HEADER
========================================== -->

<section
    class="dh-page-heading"
    style="
        background: linear-gradient(
            135deg,
            var(--secondary-bg) 0%,
            var(--tertiary-bg) 100%
        );
        padding: 60px 2rem;
        text-align: center;
    "
>

    <div class="container">

        <h1
            style="
                font-size: 2.5rem;
                color: var(--brown);
                margin-bottom: 1rem;
            "
        >
            Shop Our Collection
        </h1>

        <p
            style="
                font-size: 1.1rem;
                color: var(--text-light);
            "
        >
            Discover the perfect products for your home
        </p>

    </div>

</section>

<!-- ==========================================
     PRODUCTS SECTION
========================================== -->

<section class="section dh-products-section">

    <div class="container">

        <div class="products-layout">


            <!-- ==========================================
                 SIDEBAR FILTERS
            ========================================== -->

            <aside>

                <div
                    style="
                        MARGIN-TOP: 10px;
                        background-color: var(--cream, #fff9f1);
                        padding: 1.5rem;
                        border-radius: 20px;
                        box-shadow: var(--shadow);
                    "
                >

                    <h3
                        style="
                            margin-bottom: 1.5rem;
                            font-size: 1.2rem;
                        "
                    >
                        Filters
                    </h3>


                    <!-- SEARCH -->

                    <div style="margin-bottom: 2rem;" class="sidebar-search">

                        <label class="form-label">
                            Search
                        </label>

                        <form
                            method="GET"
                            class="form-group"
                        >

                            <input
                                type="text"
                                name="search"
                                class="form-input"
                                placeholder="Search products..."
                                value="<?php echo htmlspecialchars($search ?? ''); ?>"
                            >

                            <button
                                type="submit"
                                class="btn"
                                style="
                                    width: 100%;
                                    margin-top: 0.5rem;
                                "
                            >
                                Search
                            </button>

                        </form>

                    </div>



                    <!-- CATEGORY FILTER -->

                    <div style="margin-bottom: 2rem;">

                        <h4 style="margin-bottom: 1rem;">
                            Category
                        </h4>

                        <div
                            style="
                                display: flex;
                                flex-direction: column;
                                gap: 0.5rem;
                            "
                        >

                            <!-- ALL CATEGORIES -->

                            <a
                                href="products.php"
                                style="
                                    padding: 0.5rem 0;
                                    color: var(--text-dark);
                                    transition: var(--transition);
                                "
                                class="<?php echo !$category_id ? 'active' : ''; ?>"
                            >
                                All Categories
                            </a>


                            <!-- CATEGORY LIST -->

                            <?php foreach ($categories as $cat): ?>

                                <a
                                    href="products.php?category=<?php echo $cat['id']; ?>"
                                    style="
                                        padding: 0.5rem 0;
                                        color: var(--text-dark);
                                        transition: var(--transition);
                                    "
                                    class="<?php echo $category_id == $cat['id'] ? 'active' : ''; ?>"
                                >
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </a>

                            <?php endforeach; ?>

                        </div>

                    </div>



                    <!-- ==========================================
                         PRICE FILTER
                    ========================================== -->

                    <!--
                    <div style="margin-bottom: 2rem;">

                        <h4 style="margin-bottom: 1rem;">
                            Price Range
                        </h4>

                        <form method="GET">

                            <div class="form-group">

                                <label class="form-label">
                                    Min Price
                                </label>

                                <input
                                    type="number"
                                    name="price_min"
                                    class="form-input"
                                    value="<?php echo $price_min; ?>"
                                    step="0.01"
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Max Price
                                </label>

                                <input
                                    type="number"
                                    name="price_max"
                                    class="form-input"
                                    value="<?php echo $price_max == 999999 ? '' : $price_max; ?>"
                                    step="0.01"
                                >

                            </div>


                            <?php if ($category_id): ?>

                                <input
                                    type="hidden"
                                    name="category"
                                    value="<?php echo $category_id; ?>"
                                >

                            <?php endif; ?>


                            <?php if ($search): ?>

                                <input
                                    type="hidden"
                                    name="search"
                                    value="<?php echo htmlspecialchars($search); ?>"
                                >

                            <?php endif; ?>


                            <button
                                type="submit"
                                class="btn"
                                style="width: 100%;"
                            >
                                Apply Filter
                            </button>

                        </form>

                    </div>
                    -->


                    <!-- ==========================================
                         SORT
                    ========================================== -->

                    <!--
                    <div>

                        <h4 style="margin-bottom: 1rem;">
                            Sort By
                        </h4>

                        <form method="GET">

                            <select
                                name="sort"
                                class="form-select"
                                onchange="this.form.submit()"
                            >

                                <option
                                    value="featured"
                                    <?php echo $sort == 'featured' ? 'selected' : ''; ?>
                                >
                                    Featured
                                </option>

                                <option
                                    value="newest"
                                    <?php echo $sort == 'newest' ? 'selected' : ''; ?>
                                >
                                    Newest
                                </option>

                                <option
                                    value="price_low"
                                    <?php echo $sort == 'price_low' ? 'selected' : ''; ?>
                                >
                                    Price: Low to High
                                </option>

                                <option
                                    value="price_high"
                                    <?php echo $sort == 'price_high' ? 'selected' : ''; ?>
                                >
                                    Price: High to Low
                                </option>

                            </select>


                            <?php if ($category_id): ?>

                                <input
                                    type="hidden"
                                    name="category"
                                    value="<?php echo $category_id; ?>"
                                >

                            <?php endif; ?>


                            <?php if ($search): ?>

                                <input
                                    type="hidden"
                                    name="search"
                                    value="<?php echo htmlspecialchars($search); ?>"
                                >

                            <?php endif; ?>

                        </form>

                    </div>
                    -->

                </div>

            </aside>



            <!-- ==========================================
                 PRODUCTS GRID
            ========================================== -->

            <main>

                <?php if (count($products) > 0): ?>


                    <div
                        class="products-grid"
                        style="
                        TOP: 10px;

                            display: grid;
                            grid-template-columns:
                                repeat(
                                    auto-fill,
                                    minmax(220px, 1fr)
                            );
                            gap: 2.25rem;
                            row-gap: 2.5rem;
                            margin-bottom: 2rem;
                            align-items: stretch;
                        "
                    >


                        <?php foreach ($products as $product): ?>


                            <?php

                            $discount_percent = getDiscountPercentage(
                                $product['price'],
                                $product['discount_price']
                            );

                            ?>


                            <!-- PRODUCT CARD -->

                            <div class="card product-card dh-product-tile">
                                <a class="dh-product-hit-area" href="product-details.php?id=<?php echo (int) $product['id']; ?>" aria-label="View <?php echo htmlspecialchars($product['name']); ?>"></a>


                                <!-- DISCOUNT BADGE -->

                                <?php if ($discount_percent > 0): ?>

                                    <div class="product-badge">
                                        -<?php echo $discount_percent; ?>%
                                    </div>

                                <?php endif; ?>


                                <!-- WISHLIST -->
                                <?php $in_wishlist = isInWishlist($product['id']); ?>
                                <button
                                    type="button"
                                    class="product-wishlist <?php echo $in_wishlist ? 'active' : ''; ?>"
                                    data-product-id="<?php echo $product['id']; ?>"
                                    title="Wishlist"
                                    aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to wishlist"
                                >
                                    <i class="<?php echo $in_wishlist ? 'fas' : 'far'; ?> fa-heart" <?php echo $in_wishlist ? 'style="color: #e74c3c;"' : ''; ?>></i>
                                </button>
                                <form
                                    class="add-to-cart-form dh-card-cart-form"
                                    data-product-id="<?php echo (int) $product['id']; ?>"
                                >
                                    <input type="hidden" name="quantity" value="1">
                                    <button
                                        type="submit"
                                        class="dh-card-cart-action"
                                        title="Add to Cart"
                                        aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to cart"
                                    >
                                        <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                                    </button>
                                </form>


                                <!-- PRODUCT IMAGE -->
                                <div class="card-image">
                                    <img
                                        src="<?php echo htmlspecialchars(getProductImageUrl($product)); ?>"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        onerror="this.onerror=null; this.src='images/placeholder.jpg'"
                                    >
                                </div>


                                <!-- CARD CONTENT -->

                                <div class="card-content">


                                    <!-- PRODUCT NAME -->

                                    <h3 class="card-title">

                                        <?php
                                        echo htmlspecialchars(
                                            $product['name']
                                        );
                                        ?>

                                    </h3>


                                    <!-- DESCRIPTION -->

                                    <p class="card-description">

                                        <?php

                                        echo htmlspecialchars(
                                            substr(
                                                $product['description'],
                                                0,
                                                50
                                            )
                                        );

                                        ?>...

                                    </p>


                                    <!-- RATING -->

                                    <div class="product-rating">

                                        <?php for ($i = 0; $i < 5; $i++): ?>

                                            <span
                                                class="star <?php echo $i < round($product['rating']) ? 'fas' : 'far'; ?> fa-star"
                                            ></span>

                                        <?php endfor; ?>


                                        <span class="rating-value">

                                            (
                                            <?php
                                            echo round(
                                                $product['rating'],
                                                1
                                            );
                                            ?>
                                            )

                                        </span>

                                    </div>


                                    <!-- PRICE -->

                                    <div class="card-footer">

                                        <div>

                                            <?php if (!empty($product['discount_price'])): ?>

                                                <span class="product-original-price">

                                                    <?php
                                                    echo formatPrice(
                                                        $product['price']
                                                    );
                                                    ?>

                                                </span>


                                                <span class="product-price">

                                                    <?php
                                                    echo formatPrice(
                                                        $product['discount_price']
                                                    );
                                                    ?>

                                                </span>

                                            <?php else: ?>

                                                <span class="product-price">

                                                    <?php
                                                    echo formatPrice(
                                                        $product['price']
                                                    );
                                                    ?>

                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>


                                    <!-- ADD TO CART -->

                                </div>

                            </div>


                        <?php endforeach; ?>

                    </div>



                    <!-- ==========================================
                         PAGINATION
                    ========================================== -->

                    <?php if ($total_pages > 1): ?>

                        <div class="pagination">


                            <!-- FIRST + PREVIOUS -->

                            <!-- <?php if ($page > 1): ?>

                                <a
                                    href="products.php?page=1<?php echo $category_id ? '&category=' . $category_id : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                >
                                    First
                                </a>


                                <a
                                    href="products.php?page=<?php echo $page - 1; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                >
                                    Previous
                                </a>

                            <?php endif; ?> -->



                            <!-- PAGE NUMBERS -->

                            <?php

                            $start_page = max(
                                1,
                                $page - 2
                            );

                            $end_page = min(
                                $total_pages,
                                $page + 2
                            );

                            ?>


                            <?php for ($p = $start_page; $p <= $end_page; $p++): ?>


                                <?php if ($p == $page): ?>

                                    <span class="active">
                                        <?php echo $p; ?>
                                    </span>

                                <?php else: ?>

                                    <a
                                        href="products.php?page=<?php echo $p; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                    >
                                        <?php echo $p; ?>
                                    </a>

                                <?php endif; ?>


                            <?php endfor; ?>



                            <!-- NEXT + LAST -->

                            <!-- <?php if ($page < $total_pages): ?>

                                <a
                                    href="products.php?page=<?php echo $page + 1; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                >
                                    Next
                                </a>


                                <a
                                    href="products.php?page=<?php echo $total_pages; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                >
                                    Last
                                </a>

                            <?php endif; ?> -->


                        </div>

                    <?php endif; ?>


                <?php else: ?>


                    <!-- NO PRODUCTS -->

                    <div class="empty-state">

                        <i class="fas fa-box empty-state-icon"></i>

                        <h3 class="empty-state-title">
                            No Products Found
                        </h3>

                        <p class="empty-state-text">
                            Try adjusting your filters or search terms
                        </p>

                        <a
                            href="products.php"
                            class="btn"
                        >
                            View All Products
                        </a>

                    </div>


                <?php endif; ?>

            </main>

        </div>

    </div>

</section>



<!-- FOOTER -->

<?php include 'includes/footer.php'; ?>
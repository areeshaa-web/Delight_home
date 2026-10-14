<?php
$page_title = "Product Details - Delight Home";

require_once 'includes/db.php';
require_once 'includes/functions.php';

include 'includes/header.php';
include 'includes/navbar.php';

$base_url = '';
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = getProduct($product_id);

if (!$product) {
    echo "<div class='container section'><div class='alert alert-error'><i class='fas fa-exclamation-circle'></i> Product not found</div></div>";
    include 'includes/footer.php';
    exit;
}

$related_products = getRelatedProducts($product_id, $product['category_id']);
$category = getCategory($product['category_id']);
$discount_percent = getDiscountPercentage($product['price'], $product['discount_price']);
$product_price = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];

// Product Image
$product_image = getProductImageUrl($product);
?>

<section class="section">
    <div class="container">

        <div class="grid grid-2 dh-product-detail-grid" style="gap: 3rem; align-items: start;">

            <!-- ==================== PRODUCT IMAGE ==================== -->

            <div>

                <div class="dh-product-detail-image" style="
                    border-radius: 12px;
                    overflow: hidden;
                    margin-bottom: 1rem;
                    background-color: var(--secondary-bg);
                ">

                    <img
                        src="<?php echo htmlspecialchars($product_image); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        class="dh-product-detail-photo"
                        onerror="this.onerror=null; this.src='images/placeholder.jpg';"
                    >

                </div>


                <?php if ($discount_percent > 0): ?>

                    <div style="
                        background-color: var(--brown);
                        color: white;
                        padding: 1rem;
                        text-align: center;
                        border-radius: 8px;
                        margin-bottom: 1rem;
                    ">

                        <span style="
                            font-size: 1.5rem;
                            font-weight: 700;
                        ">
                            Save <?php echo $discount_percent; ?>%
                        </span>

                    </div>

                <?php endif; ?>

            </div>


            <!-- ==================== PRODUCT INFORMATION ==================== -->

            <div>

                <h1 style="
                    font-size: 2rem;
                    color: var(--text-dark);
                    margin-bottom: 1rem;
                ">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>


                <!-- Rating -->

                <div class="product-rating" style="margin-bottom: 1.5rem;">

                    <?php for ($i = 0; $i < 5; $i++): ?>

                        <span class="star <?php echo $i < round($product['rating']) ? 'fas' : 'far'; ?> fa-star"></span>

                    <?php endfor; ?>

                    <span class="rating-value">
                        (<?php echo round($product['rating'], 1); ?>) - 148 Reviews
                    </span>

                </div>


                <!-- Price -->

                <div style="
                    margin-bottom: 2rem;
                    padding: 1.5rem 0;
                    border-bottom: 1px solid var(--border-color);
                ">

                    <?php if (!empty($product['discount_price'])): ?>

                        <span style="
                            font-size: 1.3rem;
                            color: var(--text-light);
                            text-decoration: line-through;
                            margin-right: 1rem;
                        ">
                            <?php echo formatPrice($product['price']); ?>
                        </span>

                    <?php endif; ?>


                    <span style="
                        font-size: 2.5rem;
                        font-weight: 700;
                        color: var(--brown);
                    ">
                        <?php echo formatPrice($product_price); ?>
                    </span>

                </div>


                <!-- Description -->

                <p style="
                    color: var(--text-light);
                    line-height: 1.8;
                    margin-bottom: 2rem;
                ">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>


                <!-- Quantity -->

                <form id="addToCartForm" data-product-id="<?php echo intval($product['id']); ?>">

                    <div style="margin-bottom: 1.5rem;">

                        <label style="
                            display: block;
                            font-weight: 600;
                            margin-bottom: 0.5rem;
                        ">
                            Quantity
                        </label>


                        <div style="
                            display: flex;
                            align-items: center;
                            width: fit-content;
                            border: 1px solid var(--border-color);
                            border-radius: 8px;
                            overflow: hidden;
                        ">

                            <button
                                type="button"
                                id="qtyMinus"
                                style="
                                    width: 50px;
                                    height: 50px;
                                    border: none;
                                    background: white;
                                    font-size: 1.2rem;
                                    cursor: pointer;
                                "
                            >
                                −
                            </button>


                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                                max="99"
                                readonly
                                style="
                                    width: 60px;
                                    height: 50px;
                                    text-align: center;
                                    border: none;
                                    font-size: 1.1rem;
                                    font-weight: 600;
                                "
                            >


                            <button
                                type="button"
                                id="qtyPlus"
                                style="
                                    width: 50px;
                                    height: 50px;
                                    border: none;
                                    background: white;
                                    font-size: 1.2rem;
                                    cursor: pointer;
                                "
                            >
                                +
                            </button>

                        </div>

                    </div>


                    <!-- Total -->

                    <div style="
                        margin-bottom: 1.5rem;
                        padding: 1rem;
                        background: var(--secondary-bg);
                        border-radius: 8px;
                    ">

                        <strong>Total:</strong>

                        <span
                            id="quantityTotal"
                            style="
                                color: var(--brown);
                                font-size: 1.3rem;
                                font-weight: 700;
                                margin-left: 10px;
                            "
                        >
                            <?php echo formatPrice($product_price); ?>
                        </span>

                    </div>


                    <!-- Add To Cart -->

                    <button
                        type="submit"
                        id="addToCartBtn"
                        class="btn"
                        style="
                            width: 100%;
                            padding: 1rem 2rem;
                            margin-bottom: 1rem;
                        "
                    >
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>

                </form>


                <!-- Wishlist + Buy Now -->

                <div style="
                    display: flex;
                    gap: 1rem;
                ">

                    <button
                        type="button"
                        class="product-wishlist"
                        data-product-id="<?php echo intval($product['id']); ?>"
                        style="
                            width: 50px;
                            height: 50px;
                            padding: 0;
                        "
                    >
                        <i class="far fa-heart" style="font-size: 1.5rem;"></i>
                    </button>


                    <button
                        type="button"
                        id="buyNowBtn"
                        class="btn btn-secondary"
                        style="
                            flex: 1;
                            padding: 1rem;
                        "
                    >
                        <i class="fas fa-bolt"></i>
                        Buy Now
                    </button>

                </div>


                <!-- Features -->

                <div style="
                    margin-top: 2rem;
                    padding-top: 2rem;
                    border-top: 1px solid var(--border-color);
                ">

                    <div style="
                        display: flex;
                        gap: 1rem;
                        margin-bottom: 1rem;
                    ">
                        <i class="fas fa-check-circle" style="color: var(--brown);"></i>

                        <div>
                            <strong>Free Shipping</strong>
                            <br>
                            <span style="
                                color: var(--text-light);
                                font-size: 0.9rem;
                            ">
                                On orders over $50
                            </span>
                        </div>
                    </div>


                    <div style="
                        display: flex;
                        gap: 1rem;
                        margin-bottom: 1rem;
                    ">
                        <i class="fas fa-undo-alt" style="color: var(--brown);"></i>

                        <div>
                            <strong>Easy Returns</strong>
                            <br>
                            <span style="
                                color: var(--text-light);
                                font-size: 0.9rem;
                            ">
                                30-day return policy
                            </span>
                        </div>
                    </div>


                    <div style="
                        display: flex;
                        gap: 1rem;
                    ">
                        <i class="fas fa-lock" style="color: var(--brown);"></i>

                        <div>
                            <strong>Secure Payment</strong>
                            <br>
                            <span style="
                                color: var(--text-light);
                                font-size: 0.9rem;
                            ">
                                SSL encrypted checkout
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>


<!-- ==================== RELATED PRODUCTS ==================== -->

<?php if (count($related_products) > 0): ?>

<section class="section" style="background-color: var(--secondary-bg);">

    <div class="container">

        <h2 class="section-title">
            Related Products
        </h2>


        <div class="grid grid-4">

            <?php foreach ($related_products as $related):

                $related_image = getProductImageUrl($related);

                $rel_discount_percent = getDiscountPercentage(
                    $related['price'],
                    $related['discount_price']
                );

            ?>

                <div class="card product-card dh-product-tile">
                    <a class="dh-product-hit-area" href="product-details.php?id=<?php echo (int) $related['id']; ?>" aria-label="View <?php echo htmlspecialchars($related['name']); ?>"></a>

                    <?php if ($rel_discount_percent > 0): ?>

                        <div class="product-badge">
                            -<?php echo $rel_discount_percent; ?>%
                        </div>

                    <?php endif; ?>


                    <button
                        type="button"
                        class="product-wishlist"
                        data-product-id="<?php echo intval($related['id']); ?>"
                        title="Wishlist"
                        aria-label="Add <?php echo htmlspecialchars($related['name']); ?> to wishlist"
                    >
                        <i class="far fa-heart"></i>
                    </button>


                    <!-- Related Product Image -->

                    <div class="card-image">

                        <img
                            src="<?php echo htmlspecialchars($related_image); ?>"
                            alt="<?php echo htmlspecialchars($related['name']); ?>"
                            onerror="this.onerror=null; this.src='images/placeholder.jpg';"
                        >

                    </div>


                    <div class="card-content">

                        <h3 class="card-title">
                            <?php echo htmlspecialchars($related['name']); ?>
                        </h3>


                        <p class="card-description">
                            <?php echo htmlspecialchars(substr($related['description'], 0, 50)); ?>...
                        </p>


                        <div class="product-rating">

                            <?php for ($i = 0; $i < 5; $i++): ?>

                                <span class="star <?php echo $i < round($related['rating']) ? 'fas' : 'far'; ?> fa-star"></span>

                            <?php endfor; ?>

                            <span class="rating-value">
                                (<?php echo round($related['rating'], 1); ?>)
                            </span>

                        </div>


                        <div class="card-footer">

                            <div>

                                <?php if (!empty($related['discount_price'])): ?>

                                    <span class="product-original-price">
                                        <?php echo formatPrice($related['price']); ?>
                                    </span>

                                <?php endif; ?>


                                <span class="product-price">
                                    <?php
                                    echo formatPrice(
                                        !empty($related['discount_price'])
                                            ? $related['discount_price']
                                            : $related['price']
                                    );
                                    ?>
                                </span>

                            </div>

                        </div>


                    </div>

                    <button
                        type="button"
                        class="related-add-cart dh-card-cart-action"
                        data-product-id="<?php echo intval($related['id']); ?>"
                        title="Add to Cart"
                        aria-label="Add <?php echo htmlspecialchars($related['name']); ?> to cart"
                    >
                        <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                    </button>
                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<?php endif; ?>


<!-- ==================== JAVASCRIPT ==================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const apiUrl = 'api/cart.php';

    const form = document.getElementById('addToCartForm');

    const quantityInput = document.getElementById('quantity');

    const totalElement = document.getElementById('quantityTotal');

    const unitPrice = <?php echo json_encode((float) $product_price); ?>;


    /* ==================== UPDATE TOTAL ==================== */

    function updateTotal() {

        const quantity = parseInt(quantityInput.value, 10) || 1;

        totalElement.textContent =
            '$' + (unitPrice * quantity).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

    }


    /* ==================== ADD PRODUCT ==================== */

    function addProduct(productId, quantity, redirectUrl) {

        const formData = new FormData();

        formData.append('action', 'add_to_cart');

        formData.append('product_id', productId);

        formData.append('quantity', quantity);


        return fetch(apiUrl, {
            method: 'POST',
            body: formData
        })

        .then(function (response) {

            if (!response.ok) {
                throw new Error('API request failed');
            }

            return response.json();

        })

        .then(function (data) {

            if (!data.success) {
                throw new Error(
                    data.message || 'Unable to add product to cart.'
                );
            }

            window.location.assign(redirectUrl);

        });

    }


    /* ==================== QUANTITY BUTTONS ==================== */

    const qtyMinusBtn = document.getElementById('qtyMinus');

    const qtyPlusBtn = document.getElementById('qtyPlus');


    if (qtyMinusBtn) {

        qtyMinusBtn.addEventListener('click', function (e) {

            e.preventDefault();

            const minimum = 1;

            const current =
                parseInt(quantityInput.value, 10) || 1;

            quantityInput.value =
                Math.max(minimum, current - 1);

            updateTotal();

        });

    }


    if (qtyPlusBtn) {

        qtyPlusBtn.addEventListener('click', function (e) {

            e.preventDefault();

            const maximum = 99;

            const current =
                parseInt(quantityInput.value, 10) || 1;

            quantityInput.value =
                Math.min(maximum, current + 1);

            updateTotal();

        });

    }


    /* ==================== ADD TO CART ==================== */

    if (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            const button =
                document.getElementById('addToCartBtn');

            button.disabled = true;


            addProduct(
                form.dataset.productId,
                quantityInput.value,
                'cart.php'
            )

            .catch(function (error) {

                alert(error.message);

            })

            .finally(function () {

                button.disabled = false;

            });

        });

    }


    /* ==================== BUY NOW ==================== */

    const buyNowBtn =
        document.getElementById('buyNowBtn');


    if (buyNowBtn) {

        buyNowBtn.addEventListener('click', function () {

            addProduct(
                form.dataset.productId,
                quantityInput.value,
                'checkout.php'
            )

            .catch(function (error) {

                alert(error.message);

            });

        });

    }


    /* ==================== RELATED PRODUCTS ==================== */

    document.querySelectorAll('.related-add-cart').forEach(function (button) {

        button.addEventListener('click', function () {

            button.disabled = true;


            addProduct(
                button.dataset.productId,
                1,
                'cart.php'
            )

            .catch(function (error) {

                alert(error.message);

            })

            .finally(function () {

                button.disabled = false;

            });

        });

    });


    /* ==================== INITIAL TOTAL ==================== */

    updateTotal();

});

</script>


<?php include 'includes/footer.php'; ?>
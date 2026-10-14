<?php
session_start();

require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Shopping Cart - Delight Home";

include 'includes/header.php';
include 'includes/navbar.php';

$cart_items = getCartItems();
$cart_total = getCartTotal();

$shipping_cost = $cart_total > 0 ? 10 : 0;
$grand_total = $cart_total + $shipping_cost;
?>

<!-- Page Header -->
<section class="dh-page-heading" style="
    background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%);
    padding: 60px 2rem;
    text-align: center;
">
    <div class="container">
        <h1 style="
            font-size: 2.5rem;
            color: var(--brown);
            margin-bottom: 1rem;
        ">
            Shopping Cart
        </h1>
    </div>
</section>


<!-- Cart Content -->
<section class="section">
    <div class="container">

        <?php if (count($cart_items) > 0): ?>

            <div class="cart-content-scroll">

            <div class="cart-layout" style="
                display: grid;
                grid-template-columns: 1fr 350px;
                gap: 2rem;
            ">

                <!-- CART ITEMS -->
                <div>

                    <div class="cart-table-wrapper">

                    <table class="cart-table">

                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($cart_items as $item): ?>

                            <?php
                            $price = !empty($item['discount_price'])
                                ? $item['discount_price']
                                : $item['price'];

                            $subtotal = $price * $item['quantity'];
                            $image_path = getProductImageUrl($item);
                            ?>

                            <tr>

                                <!-- PRODUCT -->
                                <td data-label="Product">

                                    <div class="cart-product" style="
                                        display:flex;
                                        gap:1rem;
                                        align-items:center;
                                    ">

                                        <img
                                            src="<?php echo htmlspecialchars($image_path); ?>"
                                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                                            class="cart-item-image"
                                            onerror="this.onerror=null; this.src='images/placeholder.jpg';"
                                        >

                                        <div>

                                            <strong>
                                                <?php echo htmlspecialchars($item['name']); ?>
                                            </strong>

                                            <p style="
                                                font-size:0.85rem;
                                                color:var(--text-lighter);
                                            ">
                                                SKU:
                                                DH<?php echo str_pad(
                                                    $item['product_id'],
                                                    5,
                                                    '0',
                                                    STR_PAD_LEFT
                                                ); ?>
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- PRICE -->
                                <td data-label="Price">
                                    <?php echo formatPrice($price); ?>
                                </td>


                                <!-- QUANTITY -->
                                <td data-label="Quantity">

                                    <div class="quantity-control">

                                        <button
                                            type="button"
                                            class="qty-minus"
                                            onclick="updateQuantity(
                                                <?php echo $item['id']; ?>,
                                                <?php echo $item['quantity'] - 1; ?>
                                            )"
                                        >
                                            −
                                        </button>


                                        <input
                                            type="number"
                                            id="qty-<?php echo $item['id']; ?>"
                                            value="<?php echo $item['quantity']; ?>"
                                            min="1"
                                            max="999"
                                            readonly
                                        >


                                        <button
                                            type="button"
                                            class="qty-plus"
                                            onclick="updateQuantity(
                                                <?php echo $item['id']; ?>,
                                                <?php echo $item['quantity'] + 1; ?>
                                            )"
                                        >
                                            +
                                        </button>

                                    </div>

                                </td>


                                <!-- SUBTOTAL -->
                                <td data-label="Total">
                                    <strong>
                                        <?php echo formatPrice($subtotal); ?>
                                    </strong>
                                </td>


                                <!-- REMOVE -->
                                <td data-label="">

                                    <button
                                        type="button"
                                        class="btn-remove-cart"
                                        onclick="removeItem(<?php echo $item['id']; ?>)"
                                        style="
                                            background:none;
                                            border:none;
                                            color:#777;
                                            cursor:pointer;
                                            font-size:1.2rem;
                                        "
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                    </div>


                    <!-- CART BUTTONS -->
                    <div class="cart-actions" style="
                        margin-top:2rem;
                        display:flex;
                        gap:1rem;
                    ">

                        <a
                            href="products.php"
                            class="btn btn-secondary"
                        >
                            Continue Shopping
                        </a>


                        <button
                            type="button"
                            onclick="clearCart()"
                            class="btn btn-secondary"
                            style="
                                background-color:#f8d7da;
                                color:#721c24;
                                border-color:#f5c6cb;
                            "
                        >
                            Clear Cart
                        </button>

                    </div>

                </div>


                <!-- ORDER SUMMARY -->
                <div class="cart-summary">

                    <h3 style="
                        margin-bottom:1.5rem;
                        font-size:1.3rem;
                    ">
                        Order Summary
                    </h3>


                    <div class="summary-row">

                        <span>Subtotal:</span>

                        <span>
                            <?php echo formatPrice($cart_total); ?>
                        </span>

                    </div>


                    <div class="summary-row">

                        <span>Shipping:</span>

                        <span>
                            <?php echo formatPrice($shipping_cost); ?>
                        </span>

                    </div>


                    <div class="summary-row">

                        <span>Tax:</span>

                        <span>
                            <?php echo formatPrice(0); ?>
                        </span>

                    </div>


                    <div class="summary-row total">

                        <span>Total:</span>

                        <span>
                            <?php echo formatPrice($grand_total); ?>
                        </span>

                    </div>


                    <a
                        href="checkout.php"
                        class="btn"
                        style="
                            width:100%;
                            text-align:center;
                            margin-bottom:1rem;
                        "
                    >
                        <i class="Sas fa-lock"></i>
                        Proceed to Checkout
                    </a>


                    <div style="
                        background-color:var(--secondary-bg);
                        padding:1rem;
                        border-radius:8px;
                        font-size:0.9rem;
                    ">

                        <p style="margin-bottom:0.5rem;">
                            <i class="fas fa-truck"></i>
                            Fast & Reliable Delivery
                        </p>

                        <p style="margin-bottom:0.5rem;">
                            <i class="fas fa-undo-alt"></i>
                            30-day returns available
                        </p>

                        <p>
                            <i class="fas fa-lock"></i>
                            Secure checkout
                        </p>

                    </div>

                </div>

            </div>

            </div>


        <?php else: ?>

            <!-- EMPTY CART -->

            <div class="empty-state">

                <i class="fas fa-shopping-cart empty-state-icon"></i>

                <h3 class="empty-state-title">
                    Your Cart is Empty
                </h3>

                <p class="empty-state-text">
                    Start shopping and add items to your cart!
                </p>

                <a
                    href="products.php"
                    class="btn"
                >
                    Shop Now
                </a>

            </div>

        <?php endif; ?>

    </div>
</section>


<script>

/* ==========================================
   UPDATE QUANTITY
========================================== */

function updateQuantity(cartId, quantity) {

    if (quantity < 1) {
        quantity = 1;
    }

    const formData = new FormData();

    formData.append("action", "update_quantity");
    formData.append("cart_id", cartId);
    formData.append("quantity", quantity);


    fetch("api/cart.php", {
        method: "POST",
        body: formData
    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            // Refresh cart
            location.reload();

        } else {

            alert(data.message || "Unable to update quantity.");

        }

    })

    .catch(error => {

        console.error(error);

        alert("Something went wrong while updating quantity.");

    });

}


/* ==========================================
   REMOVE ITEM
========================================== */

function removeItem(cartId) {

    if (!confirm("Are you sure you want to remove this product?")) {
        return;
    }


    const formData = new FormData();

   formData.append("action", "remove_from_cart");
    formData.append("cart_id", cartId);


    fetch("api/cart.php", {
        method: "POST",
        body: formData
    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            location.reload();

        } else {

            alert(data.message || "Unable to remove item.");

        }

    })

    .catch(error => {

        console.error(error);

        alert("Something went wrong.");

    });

}


/* ==========================================
   CLEAR CART
========================================== */

function clearCart() {

    if (!confirm("Are you sure you want to clear your entire cart?")) {
        return;
    }


    const formData = new FormData();

    formData.append("action", "clear_cart");


    fetch("api/cart.php", {
        method: "POST",
        body: formData
    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            location.reload();

        } else {

            alert(data.message || "Unable to clear cart.");

        }

    })

    .catch(error => {

        console.error(error);

        alert("Something went wrong.");

    });

}

</script>


<?php include 'includes/footer.php'; ?>
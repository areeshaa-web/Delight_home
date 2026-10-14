<?php
ob_start();

require_once '../includes/db.php';
require_once '../includes/functions.php';

function sendJson($data) {
    ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {

        case 'add_to_cart':
            $product_id = intval($_POST['product_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 1);

            if ($product_id <= 0 || $quantity <= 0) {
                sendJson([
                    'success' => false,
                    'message' => 'Invalid product or quantity.'
                ]);
            }

            if (addToCart($product_id, $quantity)) {
                sendJson([
                    'success' => true,
                    'message' => 'Product added to cart.',
                    'count' => getCartCount()
                ]);
            }

            sendJson([
                'success' => false,
                'message' => 'Product is not available or there is not enough stock.'
            ]);
            break;

        case 'remove_from_cart':
        case 'remove':
            $cart_id = intval($_POST['cart_id'] ?? 0);

            if ($cart_id <= 0) {
                sendJson([
                    'success' => false,
                    'message' => 'Invalid cart item.'
                ]);
            }

            removeFromCart($cart_id);

            sendJson([
                'success' => true,
                'message' => 'Item removed.',
                'count' => getCartCount()
            ]);
            break;

        case 'update_quantity':
            $cart_id = intval($_POST['cart_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);

            if ($cart_id <= 0) {
                sendJson([
                    'success' => false,
                    'message' => 'Invalid cart item.'
                ]);
            }

            if ($quantity <= 0) {
                removeFromCart($cart_id);
            } else {
                updateCartQuantity($cart_id, $quantity);
            }

            sendJson([
                'success' => true,
                'message' => 'Cart updated.',
                'count' => getCartCount()
            ]);
            break;

        case 'get_count':
            sendJson([
                'success' => true,
                'count' => getCartCount()
            ]);
            break;

        case 'clear_cart':
            clearCart();

            sendJson([
                'success' => true,
                'message' => 'Cart cleared.',
                'count' => 0
            ]);
            break;

        default:
            sendJson([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
    }
} catch (Throwable $error) {
    sendJson([
        'success' => false,
        'message' => 'Server error: ' . $error->getMessage()
    ]);
}
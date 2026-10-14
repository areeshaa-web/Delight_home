<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'toggle_wishlist':
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please login']);
            break;
        }
        
        $product_id = intval($_POST['product_id'] ?? 0);
        
        if (isInWishlist($product_id)) {
            removeFromWishlist($product_id);
            echo json_encode(['success' => true, 'added' => false, 'message' => 'Removed from wishlist']);
        } else {
            addToWishlist($product_id);
            echo json_encode(['success' => true, 'added' => true, 'message' => 'Added to wishlist']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

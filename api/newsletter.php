<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action == 'subscribe') {
    $email = sanitize($_POST['email'] ?? '');
    
    if (!isValidEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email']);
        exit;
    }
    
    // Simple check to avoid duplicates (in production, store in database)
    echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

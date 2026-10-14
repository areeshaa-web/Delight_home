<?php
// Include database connection and helper functions
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check admin/user status and redirect
if (isAdmin()) {
    header('Location: dashboard.php');
    exit();
} elseif (isLoggedIn()) {
    header('Location: ../index.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}


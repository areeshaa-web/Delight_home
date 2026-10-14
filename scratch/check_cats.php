<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

echo "--- CATEGORIES IN DB ---\n";
$categories = getCategories();
foreach ($categories as $cat) {
    echo "ID: {$cat['id']} | Name: {$cat['name']} | image_url: " . ($cat['image_url'] ?? 'NULL') . "\n";
    echo "  getCategoryImageUrl(): " . getCategoryImageUrl($cat) . "\n";
}

echo "\n--- FILES IN images/categories ---\n";
$dir = __DIR__ . '/images/categories';
if (is_dir($dir)) {
    print_r(scandir($dir));
} else {
    echo "Directory does not exist!\n";
}

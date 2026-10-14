<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$cat_dir = __DIR__ . '/../images/categories';
if (!is_dir($cat_dir)) {
    mkdir($cat_dir, 0777, true);
    echo "Created directory: $cat_dir\n";
}

$placeholder_file = __DIR__ . '/../images/placeholder.jpg';
if (!file_exists($placeholder_file)) {
    echo "Placeholder.jpg not found!\n";
    exit;
}

$placeholder_data = file_get_contents($placeholder_file);

$categories = getCategories();
foreach ($categories as $cat) {
    if (!empty($cat['image_url'])) {
        $clean_path = ltrim($cat['image_url'], '/');
        $full_path = __DIR__ . '/../' . $clean_path;
        $dir = dirname($full_path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($full_path)) {
            file_put_contents($full_path, $placeholder_data);
            echo "Created image file for category '{$cat['name']}': $clean_path\n";
        } else {
            echo "File exists for '{$cat['name']}': $clean_path\n";
        }
    }
}

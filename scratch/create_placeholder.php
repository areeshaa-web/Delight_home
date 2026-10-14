<?php
$dir = __DIR__ . '/../images';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// Valid minimalist 1x1 / neutral JPEG image in base64
$b64 = '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=';

file_put_contents($dir . '/placeholder.jpg', base64_decode($b64));
echo "Placeholder JPEG written successfully!\n";

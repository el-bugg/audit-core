<?php
// Gunakan path ini karena vendor akan diinstal tepat di sebelah index.php
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    echo "Vendor autoload tidak ditemukan di: " . __DIR__ . '/vendor/autoload.php';
}
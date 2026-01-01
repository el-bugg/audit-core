<?php
// Cek beberapa kemungkinan lokasi vendor
// Sesuaikan dengan struktur folder di VS Code Anda
if (file_exists(__DIR__ . '/../coin-web/vendor/autoload.php')) {
    require __DIR__ . '/../coin-web/vendor/autoload.php';
} else {
    echo "Vendor autoload tidak ditemukan. Pastikan composer install sudah dijalankan.";
}
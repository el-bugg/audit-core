<?php
// Perbaikan logika path
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../coin-web/vendor/autoload.php')) {
    require __DIR__ . '/../coin-web/vendor/autoload.php';
} else {
    echo "Vendor autoload tidak ditemukan. Pastikan folder vendor sudah di-upload ke GitHub di dalam folder api atau coin-web.";
}
#!/bin/bash

echo "Memperbaiki struktur project Laravel..."

# Pindah ke parent directory
cd ..

# Buat project laravel baru di folder sementara
composer create-project laravel/laravel temp_laravel

# Copy semua file dari temp_laravel ke project kita (tanpa menimpa file yang sudah ada)
rsync -a --ignore-existing temp_laravel/ "AI Ads Optimization Advisor/"

# Hapus folder sementara
rm -rf temp_laravel

# Kembali ke folder project
cd "AI Ads Optimization Advisor"

# Install Breeze & Dependencies
echo "Menginstall Breeze dan dependensi..."
composer require laravel/breeze --dev
php artisan breeze:install blade -n

# Install frontend
npm install
npm run build

echo "✅ Perbaikan selesai! Coba jalankan 'php artisan serve' sekarang."

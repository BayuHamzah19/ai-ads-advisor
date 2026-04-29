#!/bin/bash

# Setup Script for AI Ads Optimization Advisor

echo "🚀 Memulai setup AI Ads Optimization Advisor..."

# 1. Install Dependencies
if [ ! -f "composer.json" ]; then
    echo "📦 Menginisialisasi Laravel project..."
    composer create-project laravel/laravel .
fi

# 2. Install Breeze
echo "✨ Menginstall Laravel Breeze..."
composer require laravel/breeze --dev
php artisan breeze:install blade

# 3. Environment Setup
if [ ! -f ".env" ]; then
    echo "📄 Menyalin .env..."
    cp .env.example .env
    php artisan key:generate
fi

# 4. Database Migration
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate

# 5. Frontend Assets
echo "🎨 Membangun aset frontend..."
npm install
npm run build

echo "✅ Setup Selesai! Silakan jalankan 'php artisan serve' untuk memulai."

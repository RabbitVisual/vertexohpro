#!/bin/bash

# Vertex Oh Pro! - Jules Setup Script
# Use this script in the "Setup script" configuration of Jules

echo "🚀 Starting Jules Environment Setup..."

# 1. Environment Configuration
if [ ! -f .env ]; then
    echo "📄 Copying .env.example to .env..."
    cp .env.example .env
else
    echo "✅ .env already exists."
fi

# 2. Install PHP Dependencies (Composer)
echo "📦 Installing Composer dependencies..."
composer install --prefer-dist --no-progress --no-interaction

# 3. generate key
echo "🔑 Generating Application Key..."
php artisan key:generate --force

# 4. Install Node Dependencies (NPM)
echo "📦 Installing NPM dependencies..."
npm install --no-audit --no-fund

# 5. Build Assets (Vite)
echo "🎨 Building frontend assets..."
npm run build

# 6. Database Setup (SQLite for testing environment is safer if MySQL is not guaranteed)
# Check if DB_CONNECTION is sqlite in .env, if so create the file
if grep -q "DB_CONNECTION=sqlite" .env; then
    echo "🗄️ Setting up SQLite database..."
    touch database/database.sqlite
    php artisan migrate:fresh --seed --force
else
    echo "⚠️ Skipping DB migration (MySQL configuration assumed). Ensure DB service is active."
fi

echo "✅ Jules Setup Completed Successfully!"
echo "Ready to accept PRs."

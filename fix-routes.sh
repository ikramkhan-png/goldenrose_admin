#!/bin/bash

echo "🔧 Fixing Golden Rose Admin Routes..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Find PHP binary
if command -v php &> /dev/null; then
    PHP_BIN="php"
elif command -v php8.3 &> /dev/null; then
    PHP_BIN="php8.3"
elif command -v php8.2 &> /dev/null; then
    PHP_BIN="php8.2"
elif command -v php8.1 &> /dev/null; then
    PHP_BIN="php8.1"
else
    echo "❌ PHP not found! Please install PHP first."
    exit 1
fi

echo "✓ Using PHP: $PHP_BIN"
echo ""

# Clear all caches
echo "1️⃣ Clearing application cache..."
$PHP_BIN artisan cache:clear

echo "2️⃣ Clearing route cache..."
$PHP_BIN artisan route:clear

echo "3️⃣ Clearing config cache..."
$PHP_BIN artisan config:clear

echo "4️⃣ Clearing view cache..."
$PHP_BIN artisan view:clear

echo "5️⃣ Clearing compiled files..."
$PHP_BIN artisan clear-compiled

echo "6️⃣ Optimizing application..."
$PHP_BIN artisan optimize:clear

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ All caches cleared successfully!"
echo ""
echo "📋 Next steps:"
echo "   1. Try logging in again"
echo "   2. If issue persists, run: $PHP_BIN artisan route:list | grep client"
echo "   3. Check logs: storage/logs/laravel.log"
echo ""

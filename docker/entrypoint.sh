#!/bin/sh

set -e

echo "========================================="
echo " Starting LaraShop container"
echo "========================================="

# ------------------------------------------------------------
# Generate Nginx configuration
# ------------------------------------------------------------
echo "Generating Nginx configuration..."

envsubst '${PORT}' \
    < /etc/nginx/templates/default.conf.template \
    > /etc/nginx/conf.d/default.conf


# ------------------------------------------------------------
# Laravel writable directories
# ------------------------------------------------------------
echo "Preparing Laravel storage..."

mkdir -p \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

chmod -R ug+rwx \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache


# ------------------------------------------------------------
# Laravel public storage link
# ------------------------------------------------------------
echo "Creating storage link..."

php artisan storage:link --force || true


# ------------------------------------------------------------
# Database migrations
# ------------------------------------------------------------
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."

    php artisan migrate --force
fi


# ------------------------------------------------------------
# Laravel caches
# ------------------------------------------------------------
echo "Clearing Laravel caches..."

php artisan optimize:clear

echo "Caching Laravel configuration..."

php artisan config:cache

echo "Caching Laravel routes..."

php artisan route:cache

echo "Caching Laravel views..."

php artisan view:cache


# ------------------------------------------------------------
# Start Supervisor
# ------------------------------------------------------------
echo "========================================="
echo " LaraShop is ready"
echo " Port: ${PORT}"
echo "========================================="

exec /usr/bin/supervisord \
    -c /etc/supervisor/conf.d/supervisord.conf
    
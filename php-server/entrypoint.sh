#!/bin/sh

cp -r /usr/src/cache/vendor/. /var/www/workspace/vendor/

# Start PHP-FPM in the foreground
exec php-fpm -F
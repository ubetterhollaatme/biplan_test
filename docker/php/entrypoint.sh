#!/bin/bash

composer install

cat ./.env.template > ./.env

php artisan key:generate
php artisan migrate

chown -R www-data:www-data /var/www/html

#dev

find /var/www/html -type d -exec chmod 777 {} \;
find /var/www/html -type f -exec chmod 777 {} \;

#prod

#find /var/www/html -type f -exec chmod 644 {} \;
#find /var/www/html -type d -exec chmod 755 {} \;

chmod -R o+w /var/www/html/storage

#php /var/www/html/vendor/bin/phpunit

php-fpm

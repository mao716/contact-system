php artisan tinker
exit
php artisan make:controller AdminController.php
exit
composer require laravel/fortify
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan migrate
php artisan make:provider FortifyServiceProvider
php artisan make:request Auth/LoginRequest
mkdir resources/views/auth
touch resources/views/auth/login.blade.php
php artisan optimize:clear
composer require laravel-lang/lang:~7.0 --dev
cp -r ./vendor/laravel-lang/lang/src/ja ./resources/lang/
php artisan optimize:clear
php artisan route:list | grep register
php artisan optimize:clear
php artisan route:list | grep register
php artisan route:list | grep -E 'login|logout'
touch public/css/login.css
exit
cd /var/www
composer install
composer show laravel/fortify
touch resources/views/auth/register.blade.php
mv public/css/login.css public/css/auth.css
php artisan config:clear
php artisan cache:clear
touch public/css/admin.css
exit

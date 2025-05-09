composer install --optimize-autoloader --no-dev
php-fpm
php artisan key:generate
php artisan session:table
php artisan migrate
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan livewire:discover

php artisan serve --host=0.0.0.0 --port=8000


 php artisan  make:livewire counter

# Model Creation
composer require doctrine/dbal
composer require reliese/laravel --dev
php artisan vendor:publish --tag=reliese-models

# Generate Model files
php artisan code:models <Table>


# USer Model to be extend class User extends Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
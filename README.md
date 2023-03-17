## Laravel web application for task management


# Installation 

1. Clone Project
````sh
git clone https://github.com/rdelgado/test-coalition
````
2. Composer install
````sh
composer install
````
3. Copy `.env.example` file and create `.env` file
4. Add Database Credential like yours in `.env`
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_coalition
DB_USERNAME=root
DB_PASSWORD=
```
5. Go to the project - 
```sh
cd task-management-laravel
```
6. Run Project inside that directory - 
````sh
php artisan serve
````
php artisan migrate
````
7. Open in Browser 
````sh
http://localhost:8000


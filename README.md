# Prerequisites:
- PHP version ^8.2.6
- Laravel version 9
- PostgreSQL 15

# Setup Instructions:
1. Clone repository, run command: git clone <repository-url>
2. Install Dependencies, run command: composer install
3. Create local configuration, run command: cp .env.example .env
4. Generate application key, run command: php artisan key:generate
5. Migrate database, run command: php artisan migrate
- this will create `postgres` database
6. Start the development server, run command: php artisan serve
- This will start server http://127.0.0.1:8000/ in your web browser

# OpenApi Specification:
1. Generate spec file, run command: php artisan l5-swagger:generate
2. Access OpenApi documentation
- You can access at http://127.0.0.1:8000/api/documentation#/ in your web browser

# PHPUnit:
1. Create test database `test`
2. Migrate test database, run command: php artisan migrate --env=testing
3. To run test, run command: vendor/bin/phpunit OR php artisan test
4. Check config on phpunit.xml

# Development Summary:
## Added user and order endpoints on routes\api.php
## Controllers <app\Http\Controllers>
1. Controller.php 
- created for OpenAPI spec header
2. UsersController.php
- controller for endpoints creating of new user, updating user by user ID, and fetching user
- added OpenAPI spec annotation on each methods
3. OrderController.php
- controller for endpoints creating of new order and fetch all user's orders
- added OpenAPI spec annotation on each methods
## Requests <app\Http\Requests>
1. UserRequest.php
- contains request validation that throws 403 if failed
2. OrderRequest.php
- contains request validation that throws 403 if failed
## Services <app\Services>
1. UserService.php
- coordinating repository interaction
2. OrderService.php
- coordinating repository interaction
## Repositories <app\Repositories>
1. UserRepository.php
- perform CRUD operations
2. OrderRepository.php
- perform CRUD operations
## Models <app\Models>
1. User.php
- database structure and relationship
2. Order.php
- database structure and relationship
## PHPUnit <tests>
1. Feature
- tests\Feature\Http\Controller\UsersControllerTest.php
- tests\Feature\Http\Controller\OrderControllerTest.php
2. Unit
- tests\Unit\Http\Controller\UsersControllerTest.php
- tests\Unit\Http\Controller\OrderControllerTest.php

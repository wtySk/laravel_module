## Laravel 11 Modular Development Demo

This is a modular development demo based on Laravel 11. All development work is done within the `module` directory.

### Preparation Steps:

```bash
cd laravel_module
cp .env.example .env
composer install --prefer-dist
php artisan key:generate
php artisan migrate
php artisan serve
```

Visit http://127.0.0.1:8000 to see the success page!

## Project Overview:
The main focus is on writing APIs, and there is an existing demo available at the /v1/users URL.

The Admin folder is the main directory where we write the backend API.
We create routes under modules/Admin/Basic/Routes.
The calling sequence of a module is:


### Controller Service Repository Model Transformer


If the project is simple enough, only Controller → Service → Model is required.

## Common Module:
The Common module is the shared module, mainly storing models to be used across various modules. If the Common module cannot meet the requirements of a specific module, the respective models or repositories can be created within that module.

## Core Module:
The Core module is used to store base classes, traits, and common methods.

## Configuration:
config/module.php is where project configuration options are stored. You can add relevant configurations here.

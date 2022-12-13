# Customer portal Project

This project is based on Laravel framework

## Installation

```shell
composer create-project esaticsas/customer-portal example-app
```

## Configuration

In **.env** file set your database configuration for app and your crm database access

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

DB_CRM_CONNECTION=mysql
DB_CRM_HOST=192.168.122.216
DB_CRM_PORT=3306
DB_CRM_DATABASE=crmdatabase
DB_CRM_USERNAME=root
DB_CRM_PASSWORD=
```

After configuration run:

```shell
php artisan migrate
php artisan passport:install
```

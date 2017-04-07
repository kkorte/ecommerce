## for package developer / kenny

in composer.json you need to add this:

"autoload": {
    "classmap": [
        "database"
    ],
    "psr-4": {
        "App\\": "app/",
        "Hideyo\\Backend\\": "packages/hideyo/backend/src"
    }
}

Because its not a live package and i have no fix for the dependencies writen in the package composer.json. So i load them in the root composer.json


## Installation

First install laravel: https://laravel.com/docs/5.4/installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require hideyo/backend
```

Now add the following to the `providers` array in your `config/app.php`
```php
Hideyo\Backend\BackendServiceProvider::class
```

Then you will need to run these commands in the terminal in order to copy the config and migration files
```bash
php artisan vendor:publish --provider="Hideyo\Backend\BackendServiceProvider"
```

Before you run the migration you may want to take a look at `config/hideyo.php` and change the `table` property to a table name that you would like to use. After that run the migration 
```bash
php artisan migrate

put in database/seeds/DatabaseSeerder.php this:

$this->call(ShopTableSeeder::class);
$this->call(UserTableSeeder::class);

after:

Model::unguard();

```

----

go to /resources/vendor/hideyobackend in command line and fire:

npm install
bower update
gulp 

---


Before you can login in the backend you need a user connected to a shop. Seeding will help you 
```bash
php artisan db:seed 
```

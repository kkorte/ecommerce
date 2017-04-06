## Installation

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

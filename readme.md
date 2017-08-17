[![Code Climate](https://codeclimate.com/github/hideyo/ecommerce.png)](https://codeclimate.com/github/hideyo/ecommerce)
<a href="https://packagist.org/packages/hideyo/ecommerce"><img src="https://poser.pugx.org/hideyo/ecommerce/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hideyo/ecommerce"><img src="https://poser.pugx.org/hideyo/ecommerce/license.svg" alt="License"></a>
# Hideyo e-commerce backend
Hideyo e-commerce is an open-source e-commerce solution built in Laravel.  Contact us at info@hideyo.io for questions or enterprise solutions. 

It's still beta. The code is not yet optimal and clean. In the next month we will improve it. 

Author: Matthijs Neijenhuijs


## System Requirements

Lavalite is designed to run on a  machine with PHP 5.5.9 and MySQL 5.5.

* PHP >= 5.5.9 with
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension
    * Elasticsearch
    * Bower & Gulp
    * Composer



## Installation

Please check the system requirements before installing Hideyo ecommerce.

1. You may install by cloning from github, or via composer.
  * Github:
    * `git clone git@github.com:hideyo/ecommerce.git`
    * From a command line open in the folder, run `composer install`.



## Database migration & seeding
Before you run the migration you may want to take a look at `config/hideyo.php` and change the `table` property to a table name that you would like to use. After that run the migration 
```bash
php artisan migrate


```

----

## Generate stylesheet and JavaScript

go to root in command line generate the stylesheet and javascript with:
```bash
npm install
bower update
gulp 
```

---

## Seeding database with User
Before you can login to the backend you need a default user. Laravel seeding will help you: 
```bash

php artisan optimize
php artisan db:seed 
```


---
## Login url

Login url for the backend is:
```bash

/admin
```

## License

GNU GENERAL PUBLIC LICENSE

Symfony test technique 
========================

Requirements
------------

* PHP 7.2.0 or higher;
* Apache and MySQL
* and the [usual Symfony application requirements].

Installation
------------
[Download Composer] and use the `composer` binary installed
on your computer to run these commands:

```bash
$ composer install
```
## Database
- Open file `.env` and insert your MySQL database credentials:
```
    APP_ENV=dev
    APP_SECRET=c0610358b55c64b7b1dbdd573500cff1
    DATABASE_URL="mysql://DB_NAME:DB_PASSWORD@127.0.0.1:3306/DB_NAME"
```

### Create and Apply migrations
This command will generate a new empty migration in the *my_project/migrations* folder.


```
symfony console make:migration
symfony console doctrine:migrations:migrate
```

Usage
-----
There's no need to configure anything before running the application. There are


```bash
$ cd my_project/
$ symfony server:start
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).


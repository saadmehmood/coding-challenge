[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ekomi-ltd/smart-forms/badges/quality-score.png?b=master&s=1f7d7b6b2ef60be541757d8a5a344ad4d2a51b0f)](https://scrutinizer-ci.com/g/ekomi-ltd/smart-forms/?branch=master)

# Challenge Backend

This project is a codding challenge for backend engineer at Mytheresa.

### Prerequisites

```
- Ubuntu 
- PHP > 8.1
- Apache 2.4.52 with mod_rewrite module
- mysql >= 5.6
- Git
- Composer
- Curl
- MCrypt
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
```

### Installation and Setup

1- Clone project by running the following command

    $ git clone path

2- Create a mysql database and use that database credentials in the next step

3- There is a file at project root named ".env.example", make a copy of this file with name ".env" and change the values in the following keys:

            DB_HOST = localhost
            DB_DATABASE = Database Name
            DB_USERNAME = Username
            DB_PASSWORD = Password

4- Following directories should be writable by your web server

    storage
    bootstrap/cache

5- Go to project's root directory and run the following command to install all package dependencies

    $ composer install
    $ php artisan migrate:refresh --seed

All Set!

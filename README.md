# Laravel Post Like/Dislike Demo

## Installation

### Prerequisites

-   To run this project, you must have PHP 7.4 installed.
-   You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet.

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
composer install
npm install && npm run dev
```

### Step 2

Copy .env.example to .env
Setup Database. <a href="https://laravel.com/docs/7.x/database">Read more</a>

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='DATABASE_NAME'
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3

Run Database Migration

```
php artisan migrate
```


### Step 4

Next, Generate Fake Data.

```
php artisan db:seed
```

### Step 5 (Optional)

Next, Test everything working ? (don't say, there is lots of duplicate code. it's just a demo.).

```
test is already written.
you just have run test in you system. (completely optional)
```


### Step 6

Next, boot up a server and visit your site.

```
php artisan serve
```

### Thank you !

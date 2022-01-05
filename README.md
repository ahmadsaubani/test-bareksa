# Programming Test | BE - Ahmad Saubani

## Requirements
- installed PHP ^7.2.5|^8.0 (tested on php7.4)
- Database (tested on mysql database)
- Installed Redis on local machine
- Dependencies and PHP extension needed by laravel

## How to install

- clone this project
- ``cp .env.example .env``
- setup your environtment in ``.env``

## Two option for install dependencies and migrations
### First Option (Automate with bash command) :
- ``sudo chmod +x ./prepare.sh`` in a root project
- run in terminal ``./prepare.sh``

### Second Option (Manual):
- composer install
- php artisan migrate
- composer dump-autoload -o
- php artisan db:seed
- php artisan key:generate

## Run
- run in terminal ``php artisan serve``
- download a collection postman in root project ``postman_colllection.json``

## Unit Test
- to running unit test please copy this ``./vendor/bin/phpunit``

## Have fun!!
<img width="580" alt="Screen Shot 2022-01-05 at 15 21 47" src="https://user-images.githubusercontent.com/43591727/148184339-32324227-aca3-4c4b-96cb-2aba0e60a0c5.png">


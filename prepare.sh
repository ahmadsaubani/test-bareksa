#!/bin/bash

#before run make sure u add permission to this file : like sudo chmod +x ./prepare.sh

composer install
php artisan migrate:fresh
composer dump-autoload -o
php artisan db:seed
php artisan key:generate
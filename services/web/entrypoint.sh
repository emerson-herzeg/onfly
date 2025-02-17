#!/bin/bash

# database migration
php artisan migrate

# database seed
php artisan db:seed

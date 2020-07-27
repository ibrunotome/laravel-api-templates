#!/bin/bash

php artisan optimize
php artisan view:cache
apache2-foreground

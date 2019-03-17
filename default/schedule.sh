#!/bin/bash

if [[ "$APP_ENV" = "production" ]]; then
    chmod -R 755 bootstrap/cache
    chmod -R 755 storage
    rm -r bootstrap/cache/*.php
    php artisan config:cache
    php artisan route:cache
    chown -R www-data.www-data ./
fi

loop() {
	local now;

	while true; do
		now=$(date "+%S")
		now=${now#0}

		if [[ "$now" -le 10 ]]; then
			"$@" &
		fi

		sleep $((61-now))
	done
}

loop php artisan schedule:run
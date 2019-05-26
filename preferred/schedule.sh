#!/bin/bash

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

if [[ "$APP_ENV" = "production" ]]; then
    php artisan config:cache
    php artisan route:cache
    chown -R www-data.www-data ./
    loop php artisan schedule:run
fi

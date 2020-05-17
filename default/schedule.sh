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

loop php artisan schedule:run >> /dev/null 2>&1

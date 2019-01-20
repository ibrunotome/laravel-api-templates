#!/bin/bash

topofminute() {
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

topofminute php artisan schedule:run

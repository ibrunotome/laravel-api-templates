<?php

return [
    'commands'                        => env('REGISTER_COMMANDS', true),
    'migrations'                      => env('REGISTER_MIGRATIONS', true),
    'translations'                    => env('REGISTER_TRANSLATIONS', true),
    'views'                           => env('REGISTER_VIEWS', true),
    'policies'                        => env('REGISTER_POLICIES', true),
    'api_routes'                      => env('REGISTER_API_ROUTES', true),
    'will_check_device_is_authorized' => env('WILL_CHECK_DEVICE_IS_AUTHORIZED', false),
];

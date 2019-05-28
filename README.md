# laravel-api-templates

A Laravel API starter kit collection for your projects

[![Build Status](https://semaphoreci.com/api/v1/ibrunotome/laravel-api-templates/branches/master/badge.svg)](https://semaphoreci.com/ibrunotome/laravel-api-templates)

<img width="100%" alt="Screen Shot 2019-05-26 at 18 17 08" src="https://user-images.githubusercontent.com/4256471/58387277-7b54c400-7fe2-11e9-8f1b-9e78e6cf3205.png">

<img width="100%" alt="Screenshot 2019-05-26 18 07 03" src="https://user-images.githubusercontent.com/4256471/58387178-177dcb80-7fe1-11e9-90ec-d1ec120ef4c4.png">

<img width="100%" alt="Screen Shot 2019-05-26 at 11 29 40" src="https://user-images.githubusercontent.com/4256471/58383155-8e976d80-7fa9-11e9-9241-9a1e098e91e6.png">

<img width="100%" alt="Screen Shot 2019-05-26 at 11 24 15" src="https://user-images.githubusercontent.com/4256471/58383105-ce118a00-7fa8-11e9-8f87-d783652e3310.png">

## Features

- 2FA
- ACL
- Anti Phishing Code on email
- Audit
- CORS
- Device authorization
- Etag
- Horizon
- Laravel 5.8
- Login
- Login history
- Multiple localizations
- Password reset
- Password must not be in one of the 4 million weak passwords
- PHPCS PSR2, phpinsights and sonarqube analysis
- Register
- Swoole
- Tests
- uuid

Soon:

- Job example
- Schedule example
- Websockets example
- Graphql example

The container used is created from Google Cloud Platform official php-docker + swoole and can be found here: https://github.com/ibrunotome/docker-laravel-appengine

- Set the .env variables
- Run the container with `docker-compose up`
- Run the migrations with `docker-compose run app bash -c "php artisan migrate:fresh"`

And it's up and running :)

The container with xdebug installed is in another Dockerfile, the `Dockerfile.testing`, you can get into this container using: `docker-compose -f docker-compose.testing.yml run app-tests bash` and then:

- Run tests with `composer test`
- Run "lint" (phpcs) with `composer lint`
- Run "lint and fix" (phpcbf) with `composer lint:fix`
- Run phpcpd with `composer phpcpd`
- Run php static analysis (level 5) with `composer static:analysis`
- Run nunomaduro/phpinsights with `php artisan insights`

To see sonarqube analysis, simple run `docker-compose -f docker-compose.sonarqube.yml up`, the quality profile used is PSR-2.

## Email layout

<img width="100%" alt="screenshot 2019-02-07 08 26 51" src="https://user-images.githubusercontent.com/4256471/52482466-72a5c280-2b98-11e9-9da6-35dbb791e157.png">

## Database structure

<img width="100%" alt="Screen Shot 2019-05-26 at 17 55 32" src="https://user-images.githubusercontent.com/4256471/58387059-76dadc00-7fdf-11e9-92d0-adc73c630e52.png">

## Routes

<img width="100%" alt="Screen Shot 2019-05-26 at 17 56 41" src="https://user-images.githubusercontent.com/4256471/58387071-9ffb6c80-7fdf-11e9-8bd3-0b0086df73c7.png">

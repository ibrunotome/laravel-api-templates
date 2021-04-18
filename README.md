<p align="center">
<img src="https://user-images.githubusercontent.com/4256471/115145753-888d5880-a029-11eb-9d26-37c8638823e7.png" width="400px">
<br>
A Laravel API starter kit collection using different structures.
</p>

![CI](https://github.com/ibrunotome/laravel-api-templates/workflows/CI/badge.svg)
[![Build Status](https://img.shields.io/github/stars/ibrunotome/laravel-api-templates.svg)](https://github.com/ibrunotome/laravel-api-templates)
[![Build Status](https://img.shields.io/github/forks/ibrunotome/laravel-api-templates.svg)](https://github.com/ibrunotome/laravel-api-templates)
[![License](https://img.shields.io/github/license/ibrunotome/laravel-api-templates.svg)](https://github.com/ibrunotome/laravel-api-templates)

<img width="100%" alt="Screen Shot 2020-09-05 at 21 38 49" src="https://user-images.githubusercontent.com/4256471/92316055-02a22d00-efc5-11ea-9eb4-0ee66fdcf76b.png">

<img width="100%" alt="Screen Shot 2020-09-05 at 22 12 44" src="https://user-images.githubusercontent.com/4256471/92316054-00d86980-efc5-11ea-9e54-8346074b03d3.png">

<img width="100%" alt="Screen Shot 2019-05-26 at 11 29 40" src="https://user-images.githubusercontent.com/4256471/88347604-7643ef80-cd21-11ea-8f4b-eecda9a6162d.png">

<img width="100%" alt="Screen Shot 2019-05-26 at 11 24 15" src="https://user-images.githubusercontent.com/4256471/88347704-c3c05c80-cd21-11ea-8ee8-baf05ab87c58.png">

## What is it

This is a starter kit for your next API using Laravel, implemented with more than one structure, all battle-tested with the same features listed below.

## Features

- 2FA
- ACL
- Anti Phishing Code on email
- Audit
- CORS
- Device authorization
- Etag
- Horizon
- Laravel [8.x](https://github.com/ibrunotome/laravel-api-templates/tree/v8.x), [7.x](https://github.com/ibrunotome/laravel-api-templates/tree/v7.x), [6.x](https://github.com/ibrunotome/laravel-api-templates/tree/v6.x), [5.8](https://github.com/ibrunotome/laravel-api-templates/tree/v5.8)
- Login
- Login history
- Multiple localizations, preconfigured with en_US and pt_BR
- Password reset
- Password must not be in one of the 4 million weak passwords
- PHPCS PSR2, phpinsights and sonarqube analysis
- Register
- Swoole
- Tests
- Transactional events: Listen to events and send notifications only if the transaction is commited
- uuid

Soon:

- Background job example

## Up and running

### Environment: develop

~~The container used is created from Google Cloud Platform official php-docker + swoole and can be found here: https://github.com/ibrunotome/docker-laravel-appengine~~

The oficial php image from Google Cloud Platform is updated once in a lifetime so I decided to manage my own php images at http://github.com/ibrunotome/php

- Set the .env variables, see .env.example that is already configured to point to pgsql and redis services
- Run the container with `docker-compose -f docker-compose.develop.yml up`.
  Alternatively, if you have an older laptop, try running remotely with
  [Blimp](https://kelda.io/blimp).
- Enter into app container with `docker exec -it default-structure-app bash`
- Run the migrations with `php artisan migrate:fresh`

And it's up and running :)

### Environment: testing

The container with xdebug is in the `Dockerfile.testing`, you can get into this container using: `docker-compose -f docker-compose.testing.yml up -d app` and then:

- Get into app container with `docker exec -it default-structure-app-testing bash` (off course, default-structure-app is for the default-structure) 
- Run tests with `composer test`
- Run "lint" (phpcs) with `composer lint`
- Run "lint and fix" (phpcbf) with `composer lint:fix`
- Run phpcpd with `composer phpcpd`
- Run php static analysis (level 5) with `composer static:analysis`
- Run nunomaduro/phpinsights with `php artisan insights`

To see sonarqube analysis, simple run `docker-compose -f docker-compose.sonarqube.yml up`, the quality profile used is PSR-2.

### Environment: production

See the contents of the `.k8s` folder :)

## Email layout

<img width="100%" alt="screenshot 2019-02-07 08 26 51" src="https://user-images.githubusercontent.com/4256471/52482466-72a5c280-2b98-11e9-9da6-35dbb791e157.png">

## Database structure

<img width="100%" alt="Screen Shot 2019-05-26 at 17 55 32" src="https://user-images.githubusercontent.com/4256471/88346965-02551780-cd20-11ea-8b35-3d4f8568ad74.png">

## Routes

<img width="100%" alt="Screen Shot 2019-05-26 at 17 56 41" src="https://user-images.githubusercontent.com/4256471/88347112-56f89280-cd20-11ea-867e-b8b11d0ee256.png">

## Author

<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        <a href="https://github.com/ibrunotome" target="_blank">
          <img width="115px" src="https://avatars3.githubusercontent.com/u/4256471?v=4" alt="ibrunotome"><br>@ibrunotome
        </a>
      </td>
    </tr>
  </tbody>
</table>

## Contributors

<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        <a href="https://github.com/crcms" target="_blank">
          <img width="115px" src="https://avatars1.githubusercontent.com/u/22486914?v=4" alt="crcms"><br>@crcms
        </a>
      </td>
      <td align="center" valign="middle">
        <a href="https://github.com/ejj" target="_blank">
          <img width="115px" src="https://avatars3.githubusercontent.com/u/620438?s=460&v=4" alt="ejj"><br>@ejj
        </a>
      </td>
    </tr>
  </tbody>
</table>
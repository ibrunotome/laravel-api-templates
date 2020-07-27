# Kubernetes Manifests

This is a proposal for manifests to be deployed in production using Kubernetes.

The instructions below will work for any chosen structure.

## Option 1: Using Nginx + php-fpm

The yaml files in this folder are ready to show you the way to publish your api using nginx and php-fpm. You can understand what each file does reading [this article](https://ibrunotome.github.io/multiplas-aplicacoes-em-um-cluster-kubernetes/).

## Option 2: Using Apache

You must drop all files starting with `nginx-` word and:

- replace `06-app-deployment.yaml` contents with contents of `./could-help-if-you-are-using-apache/06-app-deployment.yaml`
- update the port of `08-app-service.yaml` from 9000 to 8080 (the container port that you exposed in the `06-app-deployment.yaml`)
- update the all `nginx` references to `app` in `17-ingress.yaml` and the servicePort for the one selected above.

You're done :)

You can build the container with the Dockerfile located in the above mentioned folder or with your own container.

## Option 3: Using Nginx + Swoole or just Swoole

It's been a while since I used Swoole, [this package](https://github.com/swooletw/laravel-swoole) seems not regularly maintained and [this one](https://github.com/hhxsv5/laravel-s) could be an option, so I won't give too many details.

After choosing one of the packages above, you can directly expose `08-app-service.yaml` to the ingress just like the above apache example and you're done (with some limitations), or you can expose the service to be called by fastcgi of nginx (just like the fist option but using swoole instead of php-fpm).
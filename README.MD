RD Authentication Bundle
------------

![Packagist](https://img.shields.io/packagist/l/rd/authentication-bundle.svg?style=flat-square)
![PHP from Packagist](https://img.shields.io/packagist/php-v/rd/authentication-bundle.svg?style=flat-square)
![GitHub last commit](https://img.shields.io/github/last-commit/rdurica/authentication-bundle.svg?style=flat-square)
![GitHub release](https://img.shields.io/github/release/rdurica/authentication-bundle.svg?style=flat-square)

Requirements
------------

Requires Symfony  4.2.*


Installation
------------

Install bundle with 
[Composer](http://getcomposer.org/):

```sh
$ composer require rd/authentication-bundle
```
Update
<code>config/packages/security.yaml</code>
``` yaml
security:
    encoders:
        Rd\AuthenticationBundle\Entity\User:
            algorithm: bcrypt
    providers:
        database_provider:
            entity:
                class: Rd\AuthenticationBundle\Entity\User
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            anonymous: ~
            provider: database_provider
            form_login:
                login_path: rd_authentication_login
                check_path: rd_authentication_login
                csrf_token_generator: security.csrf.token_manager
            logout:
                path: rd_authentication_logout
                target: /
```

Update 
<code>config/packages/framework.yaml</code>
``` yaml
framework:
    secret: '%env(APP_SECRET)%'
    csrf_protection: true
```
Update 
<code>config/routes/annotation.yaml</code>
``` yaml
rd_authentication:
    resource: ../../vendor/rd/authentication-bundle/Controller/
    type: annotation
```
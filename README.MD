### Instalation
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
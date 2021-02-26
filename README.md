# Comment training project

Create basic symfony 5 application with comment form to push message in RabbitMQ,
this message is depiled by an symfony cli worker to send email.

## Stack

- Symfony 5
- RabbitMQ
- Docker

## Tools

- PHP CS Fixer
- PHPStan
- PHPUnit

## Languages

- PHP 8.0

## How to use

Clone repository

```shell
git clone git@github.com:sebtiz13/comment-training-project.git
```

Start docker containers

```shell
docker-compose up -d
```

Now you can access to:

- Website: http://localhost:8080
- RabbitMQ Management: http://localhost:15672
- MailDev: http://localhost:1080

## Commands

### PHPUnit test

```shell
docker-compose exec php bin/phpunit
```

### PHP-cs-fixer fix

```shell
docker-compose exec php vendor/bin/php-cs-fixer fix
```

### PHPstan analyse

```shell
docker-compose exec php vendor/bin/phpstan analyse
```

## For development

For development, you can use docker-compose-dev.yml to use local files instead files from container

```shell
docker-compose -f docker-compose-dev.yml up -d
```

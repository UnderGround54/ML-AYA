# ML-AYA
##[Symfony](https://symfony.com/doc/current/index.html)

## Prérequis

- PHP version > 8.1.0
- [Composer](https://getcomposer.org/)
- [symfony cli](https://symfony.com/download)
  
```bash
composer install
```

## Database configuration
Créez un fichier .env et ajoutez votre configuration de connexion à la base de données 

```bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```

## Create the base

```bash
php  bin/console doctrine:database:create
```

## Run migrations

```bash
php  bin/console doctrine:migrations:migrate
```

## Start the local server

```bash
php  -S localhost:8000 -t public

ou

symfony serve -d
```
## Open browser or postman
[api exemple](http://127.0.0.1:8000/api/categories)

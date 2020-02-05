## Simple B2B Transactions API

### Description
Basic implementation of B2B Transactions. Allows users to make transfers between two accounts

#### Features:
 - Symfony 5
 - Domain Driven Design
 - SOLID principles

#### Regular Install
```console
- git clone https://github.com/zenkinoleg/simple-b2b.git
- composer install
```

#### Clean Install
```console
- composer create-project symfony/skeleton .
- composer require symfony/orm-pack
- composer require symfony/maker-bundle --dev
- composer require --dev orm-fixtures
- composer require symfony/validator doctrine/annotations
- composer require annotations
- composer require symfony/expression-language
- composer require jms/serializer-bundle
```

#### Setup
- Setup MySQL credentials in `.env` file:
```console
 DATABASE_URL=mysql://dbuser:dbpassword@127.0.0.1:3306/dbname
```
- Run migrations:
```console
 php bin/console doctrine:migrations:migrate
```

#### Usage
Use [postman collection](https://www.getpostman.com/collections/4cb64d109a618534002d) to play with API calls

#### Upcoming Features

- Automated Unit Tests
- EntityId as Class to be more SOLID
- Database Seeders
- Soft-deletable Transactions
- Statuses

#
#
#
 
2020 &copy; Zenkin Oleg. All Rights Reserved.
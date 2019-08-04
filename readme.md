# About

HTTP API Lumen docker based implementaion with expressive, elegant syntax.

## Requirements
- PHP >= 7.2.*
- Lumen >= 5.8.*
- MySql >= 8.*
- docker >= 18.*

## Installation
Clone project through this github URL.
- git clone https://github.com/mbbhatti/nativeinstruments.git

Run docker composer file with following command
- docker-compose up -d

Laravel utilizes composer to manage its dependencies. So, before using Laravel, make sure you have composer installed on your machine. To download all required packages run these commands.
- docker-compose exec php sh
- composer install

## Database Setup
You need to set up your database credential in .env file as follows.

- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=homestead
- DB_USERNAME=homestead
- DB_PASSWORD=secret

Further, you can performe CRUD operations in mysql as per your provided csv file to run and test the API endpoints. I also added complete sql file in the docs folder at root. You may need to run below command for mysql interface.
- docker-compose exec mysql sh

## HTTP-Endpoints
Application implemented by Double-Opt-In process.

- GET /products
- POST /auth
- GET /user
- GET /user/products
- POST /user/products
- DELETE /user/products/{SKU}

Further, you can check APIS request and response from docs/api.docx file.

## Run project
Use the following application link to run at localhost
- http://localhost:8000

## Test
php_testability and PHPUnit used for code testability and performance. Alos, created a test/Config.php file to store authorization token for testing. You may need to run below command for testing within php interface.
- docker-compose exec php sh

Use this command for single file
- vendor/bin/phpunit --filter SubscribeTest

Use this command for all files tests
- vendor/bin/phpunit
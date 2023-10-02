# Installation guid

## Prerequisites

01. You needs to have apache server installed.
02. PHP - 8.1 or higher - [Installing PHP](https://www.digitalocean.com/community/tutorials/how-to-install-php-8-1-and-set-up-a-local-development-environment-on-ubuntu-22-04)
03. MairaDB - 10.3 or higher - [Installing MariaDB on Limux](https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-ubuntu-20-04)
04. NodeJS - 18.0.0 or higher - [Installing Node using NVM](https://medium.com/geekculture/how-to-install-node-js-by-nvm-61addf4ab1ba)



Clone the project from the github.

    git clone git@github.com:erangakapukotuwa/orangehrm_vue_symfony.git

got to the project directory 

    orangehrm_vue_symfony

There are two seperate directories for api(backend) and the client(frontend).



## How to setup the backend(api)
Let's first setup the backend.

go to the api folder

    cd api

First of all, create the `.env` file. You can quickly do that using the provided `.env.template` file. Create a copy of that and rename to `.env`. Don't forget to do the required changes in it. Changing of DATABASE_URL essentially will be enough.
    
    cp .env.template .env

run composer to install the packages.

    php composer.phar update

It will create a `vendor` folder. The vendor folder includes all the core and supportive packages.

Next you shold setup the database. Therefor you to create the database, run the required migrations scripts and the Fixtures for data seeding. 

First create a database in your MairaDB database using the CLI or your favorite db client. Don't forget to update the .env file with the respective db name. Makesure you have the mentioned MariaDB version installed in your computer, other wise the value of `serverVersion` is significutly different. 

    DATABASE_URL="mysql://<db_username>:<db_password>@<db_host>:<db_port>/<db_name>?serverVersion=<db_version>-MariaDB"

Next check for the available migrations,

    php bin/console doctrine:migrations:list

To execute the migrations and create the tables in the database.

    php bin/console doctrine:migrations:migrate


Now your tables are ready. Next you have to feed data to the database. There for you have to run the fixtures scripts using the below command

    php bin/console doctrine:fixtures:load


Now your api is ready. You can run the server using the following command

    symfony server:start


## Test Data.

We have already feeded the user data to the database. You can use them to verify the server

    username : john
    password : 123

You can simply run a post request using Postman to check the login endpoint. 

API Endpoing : 
    
        http://127.0.0.1:8000/api/login_check


Request body data(JSON)
    
    {
        "username" : "john"
        "password" : "123"
    }



## How to setup the frontend(client)

We have a vue app as the front end client. First go to the front end folder.

    cd client

Run an `npm install` to install the packages.

    npm install

Now you need to configure the backend url in the front-end configurations. Edit the file at `config/index.js`

    API_LOCATION: 'http://localhost:8000/api'

Now you can start the dev server using the below command.

    npm run dev

That's it. The frontend will available under the below url

    http://localhost:5174/

And this will be indicate on cli the after runninig the dev server.



## How to run UNIT TEST

First of all we we need to create a new `.env` file for our test environment. Create a `.env.test` file from our `.env.template` file.

    cp .env.template .env.test

Create a new database in your database. 

    ex: orangehrm_unit_test

Symfony UnitTesting library usually surfix the database name as `_test`. So please makesure, that you are mentioning the db name without `_test` sufix in your `.env.test` file.

    ex: orangehrm_unit

    DATABASE_URL="mysql://<db_username>:<db_password>@<db_host>:<db_port>/<db_name>?serverVersion=<db_version>-MariaDB"


Next run the migration scripts. This will create the required database tables on your test database. Don't forget to add the `--env=test` option when you are running this command.

    php bin/console doctrine:migrations:migrate --env=test


Next run the fixutes and feed test data to the database. Don't forget to add the `--env=test` option when you are running this command.


    php bin/console doctrine:fixtures:load --env=test


Next run the UNIT TEST command to execute the Unit test.

    php bin/phpunit

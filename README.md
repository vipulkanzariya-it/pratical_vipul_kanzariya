Project Setup Instructions
Prerequisites:
PHP Version: 8.1.9
Database: MySQL

Steps to Set Up the Project

1. Clone the repository:
   git clone https://github.com/vipulkanzariya-it/pratical_vipul_kanzariya.git

2.Navigate to the project directory:
cd pratical_vipul_kanzariya

3.Install dependencies:
composer install

4.Download the .env file from the email attachment and place it in the project root folder.
Update the database configuration in the .env file:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password

5. Ensure the database is created in MySQL.
   To create a database, run the following command in the SQL query section of phpMyAdmin:
   CREATE DATABASE your_database_name;
   For example:
   CREATE DATABASE pratical_vipul_kanzariya;

6.Run migrations to create the database structure:
php artisan migrate

7.The project setup is now complete.

8.The webhook URLs are as follows:

    1.http://127.0.0.1:8000/webhook
    2.http://pratical_vipul_kanzariya.test/webhook

Use the following sample data to test the webhook.
Post the data one by one using Postman or another tool to the above URLs.

Sample Webhook Data

1.  GitHub : Post the following data to check GitHub case:
    {
    "source": "github",
    "payload": {
    "commit_id": 3,
    "message": "Test Message",
    "author": "Vipul"
    }
    }
    For more details:
    https://prnt.sc/yOpTRyasO730
    https://prnt.sc/vm8rMkT0qwlT

2.  Stripe : Post the following data for Stripe case:

    {
    "source": "stripe",
    "payload": {
    "amount": 100,
    "currency": "INR",
    "status": "success"
    }
    }
    Payment status options: pending, success, failed.

    For more details:
    https://prnt.sc/C4paoFJVAZzr
    https://prnt.sc/-58PTlJ3zVQt

3.  Custom Webhook : Post the following data for custom webhook case:

    {
    "source": "custom",
    "payload": {
    "customer": {
    "name": "Vipul Kanzariya",
    "address": "Ahmedabad"
    }
    }
    }
    For more details:
    https://prnt.sc/VC8B7xdh-u3F
    https://prnt.sc/Nfbe1amoUdHH

Testing Webhooks
Unit Testing Steps

1.  Create a separate database for unit testing:

    CREATE DATABASE pratical_vipul_kanzariya_test;

2.  Update the database configuration in the .env.testing file:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pratical_vipul_kanzariya_test
    DB_USERNAME=root
    DB_PASSWORD=

3.  Update the relevant environment variables in phpunit.xml:

        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_HOST" value="127.0.0.1"/>
        <env name="DB_PORT" value="3306"/>
        <env name="DB_DATABASE" value="pratical_vipul_kanzariya_test"/>
        <env name="DB_USERNAME" value="root"/>
        <env name="DB_PASSWORD" value=""/>

4.  Create the database structure for testing:
    php artisan migrate --env=testing
5.  Run the test cases:
    php artisan test

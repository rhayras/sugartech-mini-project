# sugartech-mini-project

Set up the backend.

1. After cloning the project, type cd backend to the terminal.
2. Install composer and nmp dependencies using the following commands:
    - composer install
    - npm install
3. Create a copy of your .env file using the command:
    - cp .env.example .env
      then configure your database connection.
4. Generate an app encryption key using the command:
    - php artisan key:generate
5. Create an empty database for our application.
6. Add database information to your .env file to allow Laravel to connect to the database.
7. Execute database migration using:
    - php artisan migrate
8. Execute seeder to generate the username and password to be used to login to the system.
    - php artisan db:seed --class=CreateUsersSeeder
9. Then execute the command below to run the backend:
    - php artisan serve

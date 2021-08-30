## About LaraFilms Application
1) Run following commands for application setup
   - git clone <this repository link> larafilms
   - composer install
   - composer dump-autoload
   - php artisan config:clear
   - php artisan cache:clear
   - npm install
   - npm run dev
   
2) Run Following commands for Application database setup and seed
   - Update your database configuration as per your environment.Currently I have sent general local environment.
     - DB_HOST=127.0.0.1
	 - DB_PORT=3306
	 - DB_DATABASE=larafilms
	 - DB_USERNAME=root
	 - DB_PASSWORD=

   - php artisan migrate --seed
3) Run following command to start server.
   - php artisan serve
   
4) Run following command to run phpunit to check and show result of application's testcases.
   - php artisan test
   

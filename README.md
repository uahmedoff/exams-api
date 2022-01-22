<h1>Exams app</h1>

### Installation

 ##### Clone project
    https://github.com/uahmedoff/exams-api.git

 ##### Go to the folder application using cd command on your cmd or terminal
    cd exams-api
 
 ##### Run your cmd or terminal
    composer install
 
 ##### Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
    cp .env.example .env
    
 ##### Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration. By default, the username is root and you can leave the password field empty. (This is for Xampp) By default, the username is root and password is also root. (This is for Lamp)

 ##### Run
    php artisan key:generate

 ##### Run JWT Secret
    php artisan jwt:secret

 ##### Run Migrations 
    php artisan migrate
   
 ##### Database seeder run
    php artisan db:seed

 ##### Symlink to public folder
    php artisan storage:link
 






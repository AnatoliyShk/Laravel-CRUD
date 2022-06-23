<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Steps
- make .env
- docker-compose up
#### In php-fpm container
- composer install
- php artisan migrate
#### In browser
- Go to http://localhost:888/
#### If problem with front
- Go to node container and run npm isntall & npm run watch

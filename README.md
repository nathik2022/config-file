<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Docker Images to Deploy Laravel Project
 
 This repository provides you a development environment without requiring you to install PHP, a web server, and any other server software on your local machine. For this, it requires Docker and Docker Compose.

## Installation
Install docker and docker-compose ;

Go to the project root path, and edit it according to your needs ;

From your project directory, start up your application by running:


1.cp .env.example .env
Setting up the environment variables for Laravel

2.nano .env
We need to update the DB_HOST variable so that it points to the database service we will create in our Docker environment. In this guide, we’ll call our database service db. Go ahead and replace the listed value of DB_HOST with the database service name

3.docker-compose -f docker-compose.yaml up -d
Starting up the docker

4.docker-compose ps
List the docker services 

5.Through docker you can run composer or artisan through docker:

5a.docker-compose exec -T laravel-divido-config-app composer install
To install the application dependencies for Laravel 

5b.docker-compose exec -T  laravel-divido-config-app php artisan key:generate
To generate a unique application key with the artisan Laravel command-line tool. This key is used to encrypt user sessions and other sensitive data

5c.docker-compose exec -T laravel-divido-config-app php artisan migrate
To run the Laravel migration command that creates the tables

5d.docker-compose exec -T laravel-divido-config-app php artisan:storage:link
To create the symbolic links configured for the application.

5e.docker-compose exec -T laravel-divido-config-app php artisan config:cache
To clear config cache



To confirm that the Laravel app has been deployed and is running, visit your server’s public IP inside your browser (http://your_server_public_ip)

6.docker-compose exec laravel-divido-config-app down
To shut down your Docker Compose environment and remove all of its containers, networks, and volumes.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

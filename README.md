<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About

This is a web application built using Laravel 8.5.0 and utilizes a REST API and the YouTube Data API v3. The application allows the user to enter a search term and it then displays the associated videos. The user can navigate to a page of their choice using pagination bar at the bottom.

## Run

To run the application, perform the following commands using Git Bash or any other command tool inside the application folder and then copy and paste the link provided into a browser of your choice:
```
composer update
php artisan serve 
```

## Tests

To run the application, perform the following commands using Git Bash or any other command tool inside the application folder.
```
php artisan test
```

## Note

If you get a 403 Forbidden error, it is likely because the API has exceeded the daily quota limit, change the API key and everything should be fine.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

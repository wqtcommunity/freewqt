## Installation

The usual Laravel project installation:

0. Install your webserver (nginx / apache) and **PHP 8.0**
1. Clone the code: `git clone https://github.com/wqtcommunity/freewqt/`
2. Rename freewqt directory name to your liking
3. `cd` to installation directory and run: `composer install --no-dev`
4. Make sure file/directory permissions are correct, run these commands in the root app directory as well:
> sudo chown -R $USER:www-data storage
> 
> sudo chown -R $USER:www-data bootstrap/cache
> 
> chmod -R 775 storage
> 
> chmod -R 775 bootstrap/cache
5. Point your webserver to /public directory when domain is accessed
6. In your application root directory, create the .env file: `cp env_example .env`
7. Run command `php artisan key:generate`
8. Edit `.env` file and set all your database and other configurations (ADMIN_ROUTE_PREFIX is a prefix that applies to all admin routes)
9. Check the website

## IMPORTANT

Before going live:

1. Edit .env file and set APP_ENV to production (`APP_ENV=production`)
2. Run `php artisan optimize` (you'll also need to run this again later if you make any changes)


----

Suggestion:
Use Cloudflare for better performance and to prevent DDoS attacks.
# Simple RSS-reader app

This application uses redis for caching, so make sure that redis is installed.

## Setup

```
git clone https://github.com/nin9/simple-rss-reader-app.git
cd simple-rss-reader-app
composer install
cp .env.example .env
php artisan key:generate
php artisan config:cache
```

Adding a Cron entry to execute schedule run command
```
0 * * * * cd [/path-to-your-project] php artisan schedule:run >> /dev/null 2>&1
``` 

##### Note
If you might want to change the schedule for the rss task(eg. make it to run every minute) you can change it in the schedule function in **console/kernel.php**. 
Currently it runs every day at 6 am.
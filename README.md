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
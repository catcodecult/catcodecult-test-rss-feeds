# Simple RSS parser

## 1. Install Laravel Sail requirements
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

## 2. Start sail development server
```bash
sail up -d
```

## 3. Run the scheduler
```bash
sail artisan schedule:work
```

### or add CRON task
```cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 4. Migrate database
```bash
sail artisan migrate
```

## 5. Use Swagger to enjoy :)
```
/api/documentation
```

